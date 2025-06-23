<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Guide;
use App\Models\Kriteria;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use App\Models\DetailPenilaian;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use App\Services\ProfileMatchingService;

class PenilaianController extends Controller
{

    protected $profileMatchingService;

    public function __construct(ProfileMatchingService $profileMatchingService)
    {
        $this->profileMatchingService = $profileMatchingService;
    }

    public function index()
    {
        $penilaians = Penilaian::with(['guide', 'detail_penilaians' => function ($query) {
            $query->where('sumber', 'admin');
        }])
            ->whereHas('detail_penilaians', function ($query) {
                $query->where('sumber', 'admin');
            })
            ->get();

        return view('penilaian.index', compact('penilaians'));
    }


    public function create()
    {
        $kriterias = Kriteria::with('subkriterias')->get();
        $guides = Guide::all(); // Ambil semua guide dari database
        return view('penilaian.create', compact('kriterias', 'guides'));
    }

    public function store(Request $request)
    {
        // Validasi inputan
        $request->validate([
            'guide_id' => 'required|exists:guides,id',
            'nilai' => 'required|array',
            'nilai.*' => 'required|integer|min:1|max:5',
        ]);

        // Buat penilaian baru
        $penilaian = Penilaian::create([
            'guide_id' => $request->guide_id,
        ]);

        // Simpan detail penilaian dengan sumber 'admin'
        foreach ($request->nilai as $subkriteriaId => $nilai) {
            $penilaian->detailPenilaians()->create([
                'subkriteria_id' => $subkriteriaId,
                'nilai' => $nilai,
                'sumber' => 'admin', // tanda sumber dari admin
            ]);
        }

        return redirect()->route('penilaian.index')->with('success', 'Penilaian berhasil ditambahkan.');
    }




    public function show(Penilaian $penilaian)
    {
        $penilaian->load([
            'guide',
            'detailPenilaians' => function ($query) {
                $query->where('sumber', 'admin');
            },
            'detailPenilaians.subkriteria.kriteria'
        ]);

        $hasil = $this->hitungProfileMatching($penilaian);

        $kriteriaUnggulan = $this->tentukanKriteriaUnggulanshow($hasil);

        return view('penilaian.show', compact('penilaian', 'hasil', 'kriteriaUnggulan'));
    }


    public function showPenilaianGuide($guideId)
    {
        // Ambil semua penilaian guide, bisa lebih dari 1
        $penilaians = Penilaian::with(['guide', 'pesanan.user'])
            ->where('guide_id', $guideId)
            ->get();

        if ($penilaians->isEmpty()) {
            return redirect()->route('penilaian.customerList')->with('error', 'Penilaian untuk guide ini tidak ditemukan.');
        }

        // Ambil semua detail penilaian pelanggan dengan sumber 'pelanggan' dan group by penilaian_id
        $detailPelangganAll = DetailPenilaian::with(['subkriteria.kriteria', 'penilaian.pesanan.user'])
            ->whereIn('penilaian_id', $penilaians->pluck('id'))
            ->where('sumber', 'pelanggan')
            ->get()
            ->groupBy('penilaian_id');

        return view('penilaiancustomer.show', compact('penilaians', 'detailPelangganAll'));
    }







    public function daftarGuide()
    {
        $guides = \App\Models\Guide::all(); // Ambil semua guide dari database
        return view('penilaiancustomer.daftar', compact('guides'));
    }






private function hitungProfileMatching(Penilaian $penilaian)
{
    $hasilPerhitungan = [];
    $nilaiTotalKriteria = [];
    $totalBobot = 0;

    foreach ($penilaian->detailPenilaians as $detail) {
        $subkriteria = $detail->subkriteria;
        $kriteria = $subkriteria->kriteria;

        if (!$subkriteria || !$kriteria) {
            continue;
        }

        $gap = $this->profileMatchingService->hitungGap($detail->nilai, $subkriteria->profil_standar);
        $bobotNilai = $this->profileMatchingService->konversiGap($gap);

        if (!isset($hasilPerhitungan[$kriteria->id])) {
            $hasilPerhitungan[$kriteria->id] = [
                'nama' => $kriteria->nama,
                'bobot_kriteria' => $kriteria->bobot ?? 0,  // Ambil bobot dari tabel kriteria
                'core_factor' => [],
                'secondary_factor' => [],
                'detail' => []
            ];
        }

        $isCore = filter_var($subkriteria->is_core_factor, FILTER_VALIDATE_BOOLEAN);
        $faktorKey = $isCore ? 'core_factor' : 'secondary_factor';

        $hasilPerhitungan[$kriteria->id][$faktorKey][] = $bobotNilai;

        $hasilPerhitungan[$kriteria->id]['detail'][] = [
            'subkriteria_id' => $subkriteria->id,
            'nama_subkriteria' => $subkriteria->nama,
            'nilai' => $detail->nilai,
            'profil_standar' => $subkriteria->profil_standar,
            'gap' => $gap,
            'bobot_nilai' => $bobotNilai,
            'is_core_factor' => $isCore
        ];
    }

    foreach ($hasilPerhitungan as $kriteriaId => &$hasil) {
        $coreValues = $hasil['core_factor'];
        $secondaryValues = $hasil['secondary_factor'];

        $nilaiCF = count($coreValues) > 0 ? array_sum($coreValues) / count($coreValues) : 0;
        $nilaiSF = count($secondaryValues) > 0 ? array_sum($secondaryValues) / count($secondaryValues) : 0;

        $hasil['nilai_cf'] = round($nilaiCF, 2);
        $hasil['nilai_sf'] = round($nilaiSF, 2);

        $hasil['nilai_total'] = round($this->profileMatchingService->hitungNilaiTotalKriteria($nilaiCF, $nilaiSF), 2);

        // Kalikan nilai_total dengan bobot kriteria (misalnya bobot = 40 maka dikali 0.4)
        $bobot = $hasil['bobot_kriteria'] ?? 0;
        $nilaiBobot = $hasil['nilai_total'] * ($bobot / 100);

        $hasil['nilai_bobot'] = round($nilaiBobot, 2);

        $nilaiTotalKriteria[$kriteriaId] = $nilaiBobot;
        $totalBobot += $bobot;
    }

    // Hitung nilai akhir dengan menjumlahkan nilai total yang sudah dikali bobot
    $nilaiAkhir = count($nilaiTotalKriteria) > 0
        ? round(array_sum($nilaiTotalKriteria), 2)
        : 0;

    return [
        'detail' => $hasilPerhitungan,
        'nilai_akhir' => $nilaiAkhir
    ];
}






    public function edit(Penilaian $penilaian)
    {
        $kriterias = Kriteria::with('subkriterias')->get();
        $guides = Guide::all(); // Ambil daftar guide
        $penilaian->load('detailPenilaians', 'guide'); // Tambahkan relasi guide
        return view('penilaian.edit', compact('penilaian', 'kriterias', 'guides'));
    }


    public function update(Request $request, Penilaian $penilaian)
    {
        $request->validate([
            // 'nama_kandidat' => 'required',
            'nilai' => 'required|array',
            'nilai.*' => 'required|integer|min:1|max:5',
        ]);



        foreach ($request->nilai as $subkriteriaId => $nilai) {
            $penilaian->detailPenilaians()->updateOrCreate(
                ['subkriteria_id' => $subkriteriaId],
                ['nilai' => $nilai]
            );
        }

        return redirect()->route('penilaian.index')->with('success', 'Penilaian berhasil diperbarui.');
    }

    public function destroy(Penilaian $penilaian)
    {
        $penilaian->delete();
        return redirect()->route('penilaian.index')->with('success', 'Penilaian berhasil dihapus.');
    }

public function all()
{
    // Ambil semua penilaian dengan relasi terkait
    $penilaians = Penilaian::with(['detailPenilaians.subkriteria.kriteria', 'guide', 'pesanan.user'])->get();

    $kriterias = Kriteria::with('subkriterias')->get();

    // Filter penilaian yang punya detail
    $penilaiansValid = $penilaians->filter(fn($p) => $p->detailPenilaians && $p->detailPenilaians->count() > 0);

    // Hitung profile matching untuk penilaian valid
    $hasilPenilaians = $penilaiansValid->map(function ($penilaian) use ($kriterias) {
        $hasil = $this->hitungProfileMatching($penilaian);
        return [
            'penilaian' => $penilaian,
            'hasil' => $hasil,
            'kriteria_unggulan' => $this->tentukanKriteriaUnggulan(['penilaian' => $penilaian, 'hasil' => $hasil], $kriterias)
        ];
    });

    $hasilPerKriteria = $this->groupHasilByKriteria($hasilPenilaians, $kriterias);

    // 1. Ranking dari admin (tidak difilter, semua muncul)
    $rankingAdmin = $hasilPenilaians
        ->filter(function ($item) {
            return $item['penilaian']->detailPenilaians->where('sumber', 'admin')->count() > 0;
        })
        ->sortByDesc(fn($item) => $item['hasil']['nilai_akhir'] ?? 0)
        ->values();

    // 2. Ranking dari pelanggan (filter: 1 penilaian per pelanggan per guide)
    $rankingPelanggan = $hasilPenilaians
        ->filter(function ($item) {
            return $item['penilaian']->detailPenilaians->where('sumber', 'pelanggan')->count() > 0;
        })
        // Ambil hanya 1 penilaian per kombinasi pelanggan & guide
        ->unique(function ($item) {
            $userId = optional(optional($item['penilaian']->pesanan)->user)->id ?? null;
            $guideId = optional($item['penilaian']->guide)->id_guide ?? null;
            return $userId . '-' . $guideId;
        })
        ->sortByDesc(fn($item) => $item['hasil']['nilai_akhir'] ?? 0)
        ->values();

    return view('penilaian.all', compact(
        'hasilPerKriteria',
        'rankingAdmin',
        'rankingPelanggan',
        'kriterias',
    ));
}











    private function groupHasilByKriteria(Collection $hasilPenilaians, Collection $kriterias)
    {
        $hasilPerKriteria = [];

        foreach ($kriterias as $kriteria) {
            $hasilPerKriteria[$kriteria->id] = [
                'nama_kriteria' => $kriteria->nama,
                'subkriterias' => $kriteria->subkriterias,
                'kandidat_results' => []
            ];

            foreach ($hasilPenilaians as $hasil) {
                $kriteriaResult = $hasil['hasil']['detail'][$kriteria->id] ?? null;
                if ($kriteriaResult) {
                    $hasilPerKriteria[$kriteria->id]['kandidat_results'][] = [
                        'nama_guide' => $hasil['penilaian']->guide->nama_guide ?? 'Tidak Diketahui',
                        'nilai_cf' => $kriteriaResult['nilai_cf'],
                        'nilai_sf' => $kriteriaResult['nilai_sf'],
                        'nilai_total' => $kriteriaResult['nilai_total'],
                        'detail' => $kriteriaResult['detail']
                    ];
                }
            }
        }

        return $hasilPerKriteria;
    }



    // public function generateCandidatesReport()
    // {
    //     // Retrieve all candidates from the penilaian table
    //     $penilaians = Penilaian::with('detailPenilaians.subkriteria.kriteria')->get();

    //     $hasilPenilaians = $penilaians->map(function ($penilaian) {
    //         return [
    //             'penilaian' => $penilaian,
    //             'hasil' => $this->hitungProfileMatching($penilaian)
    //         ];
    //     });

    //     $rankingKandidat = $hasilPenilaians->sortByDesc(function ($item) {
    //         return $item['hasil']['nilai_akhir'];
    //     })->values();

    //     // Generate filename based on current date and time
    //     $filename = 'laporan_kandidat_' . Carbon::now()->format('d-m-Y_His') . '.pdf';

    //     // Load the view and pass the candidates data
    //     $pdf = Pdf::loadView('pdf.candidates', compact('rankingKandidat'));

    //     // Download the PDF with the timestamped filename
    //     return $pdf->download($filename);
    // }

    // public function generatePenilaianPdf($status = 'all')
    // {
    //     $penilaians = Penilaian::with('detailPenilaians.subkriteria.kriteria')->get();
    //     $kriterias = Kriteria::with('subkriterias')->get();

    //     $hasilPenilaians = $penilaians->map(function ($penilaian) {
    //         return [
    //             'penilaian' => $penilaian,
    //             'hasil' => $this->hitungProfileMatching($penilaian)
    //         ];
    //     });

    //     $rankingKandidat = $hasilPenilaians->sortByDesc(function ($item) {
    //         return $item['hasil']['nilai_akhir'];
    //     })->values();

    //     // Filter results based on status
    //     if ($status === 'accepted') {
    //         $rankingKandidat = $rankingKandidat->take(1); // Only the top candidate
    //     } elseif ($status === 'rejected') {
    //         $rankingKandidat = $rankingKandidat->slice(1); // All except the top candidate
    //     }

    //     $hasilPerKriteria = $this->groupHasilByKriteria($rankingKandidat, $kriterias);

    //     // Generate filename based on current date and time and status
    //     $filename = 'laporan_penilaian_' . $status . '_' . Carbon::now()->format('d-m-Y_His') . '.pdf';

    //     // Load the view and pass the candidates data
    //     $pdf = Pdf::loadView('pdf.penilaian', compact('hasilPerKriteria', 'rankingKandidat', 'kriterias'));

    //     return $pdf->download($filename);
    // }


    // private function tentukanKriteriaUnggulanshow($hasil)
    // {
    //     $max = null;
    //     $kriteriaUnggul = null;

    //     foreach ($hasil['detail'] as $kriteriaId => $kriteriaDetail) {
    //         $nilai = $kriteriaDetail['nilai_total'] ?? null;
    //         if ($nilai !== null && ($max === null || $nilai > $max)) {
    //             $max = $nilai;
    //             $kriteriaUnggul = $kriteriaDetail['nama_kriteria'] ?? 'Tidak Diketahui';
    //         }
    //     }

    //     return $kriteriaUnggul;
    // }

    public function tentukanKriteriaUnggulan($hasil, $kriterias)
    {
        $max = null;
        $kriteriaUnggul = null;

        foreach ($kriterias as $kriteria) {
            $nilai = $hasil['hasil']['detail'][$kriteria->id]['nilai_total'] ?? null;
            if ($nilai !== null && ($max === null || $nilai > $max)) {
                $max = $nilai;
                $kriteriaUnggul = $kriteria->nama;
            }
        }

        return $kriteriaUnggul;
    }

    public function tentukanKriteriaUnggulanshow($hasil)
    {
        $max = null;
        $kriteriaUnggul = 'Tidak Diketahui';

        foreach ($hasil['detail'] as $detail) {
            $nilai = $detail['nilai_total'] ?? null;
            if ($nilai !== null && ($max === null || $nilai > $max)) {
                $max = $nilai;
                $kriteriaUnggul = $detail['nama']; // langsung ambil nama dari detail
            }
        }

        return $kriteriaUnggul;
    }
}
