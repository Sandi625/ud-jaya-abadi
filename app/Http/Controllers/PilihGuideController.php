<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use App\Jobs\SendNotifGuideJob;



use App\Models\Pesanan;
use App\Models\Notifikasi;
use App\Models\Subkriteria;
use Illuminate\Http\Request;
use App\Models\DetailPesanan;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Traits\ProfileMatchingTrait;
use Illuminate\Support\Facades\Http;
use App\Services\ProfileMatchingService;



class PilihGuideController extends Controller
{
    public function index()
    {
        $pesanans = Pesanan::with(['kriterias', 'detailPesanans.guide'])->get();
        return view('pilihguide.index', compact('pesanans'));
    }

    // Tampilkan form pilih guide untuk satu pesanan
    use ProfileMatchingTrait;

    protected $profileMatchingService;

    public function __construct(ProfileMatchingService $profileMatchingService)
    {
        $this->profileMatchingService = $profileMatchingService;
    }





    // Fungsi helper untuk cari guide terbaik
    protected function getBestGuideIdForPesanan(Pesanan $pesanan)
    {
        $guideScores = [];

        // Ambil standar nilai kriteria dari DetailPesanan jika diperlukan
        $kriteriaPesanan = [];
        foreach ($pesanan->detailPesanans as $detail) {
            if ($detail->kriteria && $detail->kriteria->subkriterias) {
                foreach ($detail->kriteria->subkriterias as $sub) {
                    if ($sub->profil_standar > 0) {
                        $kriteriaPesanan[$sub->id] = $sub->profil_standar;
                    }
                }
            }
        }

        // Ambil semua guide yang terlibat dalam pesanan ini
        $guideIds = $pesanan->detailPesanans->pluck('guide_id')->unique()->filter();

        foreach ($guideIds as $guideId) {
            $guide = Guide::find($guideId);
            if (!$guide) continue;

            $penilaian = $guide->penilaians->firstWhere('pesanan_id', $pesanan->id);
            if (!$penilaian) continue;

            $hasil = $this->hitungProfileMatching($penilaian, $kriteriaPesanan);
            $guideScores[$guideId] = $hasil['nilai_akhir'];
        }

        if (empty($guideScores)) {
            return null;
        }

        arsort($guideScores); // Urutkan dari yang tertinggi
        return key($guideScores); // Kembalikan guide_id dengan skor tertinggi
    }


    public function edit($pesananId)
    {
        $pesanan = Pesanan::with(['kriterias.subkriterias', 'detailPesanans.kriteria.subkriterias'])->findOrFail($pesananId);

        // Siapkan standar kriteria dari detail pesanan
        $kriteriaPesanan = [];
        $detailPesanans = $pesanan->detailPesanans->sortBy('prioritas');

        foreach ($detailPesanans as $detail) {
            if ($detail->kriteria && $detail->kriteria->subkriterias) {
                foreach ($detail->kriteria->subkriterias as $sub) {
                    if ($sub->profil_standar > 0) {
                        $kriteriaPesanan[$sub->id] = $sub->profil_standar;
                    }
                }
            }
        }

        // Ambil semua ID subkriteria yang menjadi acuan
        $subkriteriaIds = collect(array_keys($kriteriaPesanan));

        // Ambil semua guide beserta penilaian dan relasinya
        $rekomendasi = Guide::with('penilaians.detailPenilaians.subkriteria.kriteria')
            ->get()
            ->map(function ($guide) use ($subkriteriaIds, $kriteriaPesanan) {
                $nilaiTerbaik = 0;

                foreach ($guide->penilaians as $penilaian) {
                    // Filter detail penilaian agar hanya subkriteria yang relevan
                    $filteredDetail = $penilaian->detailPenilaians->filter(function ($detail) use ($subkriteriaIds) {
                        return $subkriteriaIds->contains($detail->subkriteria_id);
                    });

                    // Abaikan jika tidak ada detail yang sesuai
                    if ($filteredDetail->isEmpty()) continue;

                    // Clone penilaian dan set ulang relasi detail
                    $penilaianFiltered = clone $penilaian;
                    $penilaianFiltered->setRelation('detailPenilaians', $filteredDetail);

                    $hasil = $this->hitungProfileMatching($penilaianFiltered, $kriteriaPesanan);
                    $nilaiTerbaik = max($nilaiTerbaik, $hasil['nilai_akhir']);
                }

                return [
                    'guide' => $guide,
                    'nilai_total' => $nilaiTerbaik,
                ];
            })
            ->sortByDesc('nilai_total')
            ->values();

        return view('pilihguide.edit', [
            'pesanan' => $pesanan,
            'rekomendasi' => $rekomendasi,
        ]);
    }






   public function update(Request $request, $pesananId)
{
    $request->validate([
        'guide_id' => 'required|exists:guides,id',
    ]);

    try {
        $pesanan = Pesanan::with('kriterias')->findOrFail($pesananId);
        $tanggal = $pesanan->tanggal_keberangkatan;

        $bentrok = Pesanan::where('id_guide', $request->guide_id)
            ->where('tanggal_keberangkatan', $tanggal)
            ->where('id', '!=', $pesananId)
            ->exists();

        if ($bentrok) {
            Log::warning("Guide ID {$request->guide_id} sudah ada pesanan di tanggal {$tanggal}.");
            return back()->withErrors(['guide_id' => 'Guide sudah memiliki pesanan di tanggal ini.'])->withInput();
        }

        $minGapDays = 1;
        $dekat = Pesanan::where('id_guide', $request->guide_id)
            ->where('id', '!=', $pesananId)
            ->whereBetween('tanggal_keberangkatan', [
                Carbon::parse($tanggal)->subDays($minGapDays),
                Carbon::parse($tanggal)->addDays($minGapDays)
            ])->exists();

        if ($dekat) {
            Log::warning("Guide ID {$request->guide_id} memiliki pesanan terlalu dekat dengan tanggal {$tanggal} (±{$minGapDays} hari).");
            return back()->withErrors(['guide_id' => "Guide memiliki pesanan terlalu dekat (±{$minGapDays} hari)."])->withInput();
        }

        foreach ($pesanan->kriterias as $kriteria) {
            DetailPesanan::updateOrCreate(
                ['pesanan_id' => $pesananId, 'kriteria_id' => $kriteria->id],
                ['guide_id' => $request->guide_id]
            );
        }

        $pesanan->id_guide = $request->guide_id;
        $pesanan->save();

        // Dispatch job notifikasi dengan log
        try {
            SendNotifGuideJob::dispatch($request->guide_id)->delay(now()->addSeconds(15));
            Log::info("Job notifikasi untuk Guide ID {$request->guide_id} berhasil didispatch.");
        } catch (\Exception $e) {
            Log::error("Gagal dispatch job notifikasi untuk Guide ID {$request->guide_id}: " . $e->getMessage());
        }

        return redirect()->route('pilihguide.index')->with('success', 'Pilihan guide berhasil diperbarui.');

    } catch (\Exception $e) {
        Log::error("Error saat update pesanan ID {$pesananId}: " . $e->getMessage());
        return back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui pilihan guide.'])->withInput();
    }
}
}



//  public function sendNotifToGuide($id)
// {
//     $guide = Guide::findOrFail($id);
//     $phone = preg_replace('/^0/', '62', $guide->nomer_hp);

//     Carbon::setLocale('id');
//     $waktuIndonesia = Carbon::now()->translatedFormat('d F Y H:i');

//     $isiPesan = "Haloo {$guide->nama_guide}, Anda terpilih untuk melakukan guiding pada {$waktuIndonesia} WIB.\nSilakan login untuk melihat detailnya:\nhttp://localhost:8000/login";

//     // Simpan ke database
//     $notifikasi = Notifikasi::create([
//         'guide_id'      => $guide->id,
//         'isi'           => $isiPesan,
//         'tanggal_kirim' => now(),
//         'status'        => 'notif pending masih di proses',
//     ]);

//     // Kirim ke Fonnte
//     $response = Http::withHeaders([
//         'Authorization' => 'HbHggEjszXST3WxTchcd'
//     ])->post('https://api.fonnte.com/send', [
//         'target'  => $phone,
//         'message' => $isiPesan,
//     ]);

//     // Update status
//     if ($response->successful()) {
//         $notifikasi->update(['status' => 'notif sudah terkirim']);
//     } else {
//         $notifikasi->update(['status' => 'notif belum terkirim']);
//     }
// }


//  public function create($pesananId)
// {
//     $pesanan = Pesanan::with('kriterias.subkriterias')->findOrFail($pesananId);
//     $kriteriaIds = $pesanan->kriterias->pluck('id');

//     // Ambil semua subkriteria dari kriteria pesanan
//     $subkriteriaIds = Subkriteria::whereIn('kriteria_id', $kriteriaIds)->pluck('id');

//     // Siapkan array kriteriaPesanan (standar nilai dari pesanan, misal subkriteria_id => nilai)
//     // Kamu harus siapkan ini sesuai data pesanan, misal:
//     $kriteriaPesanan = [];
//     foreach ($pesanan->kriterias as $kriteria) {
//         foreach ($kriteria->subkriterias as $sub) {
//             // misal default nilai standar dari pesanan, kalau ada
//             $kriteriaPesanan[$sub->id] = $sub->profil_standar;
//         }
//     }

//     $rekomendasi = Guide::with('penilaians.detailPenilaians.subkriteria.kriteria')
//         ->get()
//         ->map(function ($guide) use ($subkriteriaIds, $kriteriaPesanan) {
//             $nilaiTerbaik = 0;

//             foreach ($guide->penilaians as $penilaian) {
//                 // Filter detailPenilaians hanya untuk subkriteria yang di pesanan
//                 $filteredDetailPenilaians = $penilaian->detailPenilaians->filter(function ($detail) use ($subkriteriaIds) {
//                     return $subkriteriaIds->contains($detail->subkriteria_id);
//                 });

//                 // Buat objek Penilaian sementara dengan detail yang sudah difilter
//                 $penilaianFiltered = clone $penilaian;
//                 $penilaianFiltered->setRelation('detailPenilaians', $filteredDetailPenilaians);

//                 // Hitung profile matching dari trait
//                 $hasil = $this->hitungProfileMatching($penilaianFiltered, $kriteriaPesanan);

//                 if ($hasil['nilai_akhir'] > $nilaiTerbaik) {
//                     $nilaiTerbaik = $hasil['nilai_akhir'];
//                 }
//             }

//             return [
//                 'guide' => $guide,
//                 'nilai_total' => $nilaiTerbaik,
//             ];
//         })
//         ->sortByDesc('nilai_total')
//         ->values();

//     return view('pilihguide.create', [
//         'pesanan' => $pesanan,
//         'rekomendasi' => $rekomendasi,
//     ]);
// }





// public function store(Request $request, $pesananId)
// {
//     $request->validate([
//         'guide_id' => 'required|exists:guides,id',
//     ]);

//     // Simpan pilihan guide di semua detail pesanan kriteria yang terkait
//     $pesanan = Pesanan::with('kriterias')->findOrFail($pesananId);

//     foreach ($pesanan->kriterias as $kriteria) {
//         DetailPesanan::updateOrCreate(
//             [
//                 'pesanan_id' => $pesananId,
//                 'kriteria_id' => $kriteria->id,
//             ],
//             [
//                 'guide_id' => $request->guide_id,
//             ]
//         );
//     }

//     // Update field id_guide di pesanan (pilihan guide utama)
//     $pesanan->id_guide = $request->guide_id;
//     $pesanan->save();

//     return redirect()->route('pilihguide.index')->with('success', 'Guide berhasil dipilih untuk semua kriteria.');
// }
