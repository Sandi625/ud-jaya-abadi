<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use App\Models\Paket;
use App\Models\Pesanan;
use App\Models\Kriteria;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\OrderStoredMail;
use App\Models\DetailPesanan;
use App\Traits\KriteriaTrait;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Services\ProfileMatchingService;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderStoredNotification;
use App\Traits\ProfileMatchingTrait; // Pastikan sudah pakai trait ini di controller!




class PesananController extends Controller
{
  public function index(Request $request)
{
    $query = Pesanan::with(['detailPesanans.kriteria', 'paket', 'guide']);

    if ($request->filled('q')) {
        $search = $request->q;
        $query->where(function ($q) use ($search) {
            $q->where('order_id', 'like', '%' . $search . '%')
              ->orWhere('nama', 'like', '%' . $search . '%');
        });
    }

    $pesanans = $query->orderBy('created_at', 'desc')->paginate(5); // Ganti get() menjadi paginate()

    return view('pesanan.index', compact('pesanans'));
}




    public function show($id)
    {
        // Eager load relasi yang diperlukan, termasuk detailPesanans.kriteria
        $pesanan = Pesanan::with(['detailPesanans.kriteria', 'paket', 'guide'])->findOrFail($id);

        return view('pesanan.show', compact('pesanan'));
    }





   public function create()
{
    $kriterias = Kriteria::all();
    $pakets = Paket::all();

    $selectedPaketId = request()->query('id_paket'); // Ambil dari query string
    $paketDetail = null;

    if ($selectedPaketId) {
        $paketDetail = Paket::find($selectedPaketId); // Ambil detail paket dari ID
    }

    return view('pesanan.create', compact('kriterias', 'pakets', 'selectedPaketId', 'paketDetail'));
}










 public function store(Request $request)
{
    $validated = $request->validate([
        'nama' => 'required|string|max:100',
        'email' => 'required|email|max:100',
        'nomor_telp' => 'required|string|max:20',
        'id_kriteria' => 'required|array|min:1',
        'id_kriteria.*' => 'exists:kriterias,id',
        'id_paket' => 'required|exists:pakets,id',
        'tanggal_pesan' => 'required|date',
        'tanggal_keberangkatan' => 'required|date|after_or_equal:tanggal_pesan',
        'jumlah_peserta' => 'required|integer|min:1',
        'negara' => 'required|string|max:100',
        'bahasa' => 'required|string|max:100',
        'riwayat_medis' => 'required|string',
        'paspor' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        'special_request' => 'nullable|string',
        'kebutuhan_guide' => 'nullable|string', // ✅ Validasi kebutuhan_guide
        'status' => 'nullable|boolean',
        'id_guide' => 'nullable|exists:guides,id',
    ], [
        'tanggal_keberangkatan.after_or_equal' => 'The departure date must be the same as or after the booking date.',
    ]);

    // Simpan file paspor jika ada
    if ($request->hasFile('paspor')) {
        $pasporPath = $request->file('paspor')->store('paspor', 'public');
        $validated['paspor'] = $pasporPath;
    }

    // Ambil dan pisahkan kriteria dari input validasi
    $kriteriaList = $validated['id_kriteria'];
    unset($validated['id_kriteria']);

    // Tambahkan data tambahan sebelum insert
    $validated['user_id'] = Auth::id();
    $validated['order_id'] = 'ORD' . now()->format('ymd') . strtoupper(Str::random(4));

    // Simpan ke tabel pesanans
    $pesanan = Pesanan::create($validated);

    // Simpan ke tabel detail_pesanans
    foreach ($kriteriaList as $index => $kriteria_id) {
        DetailPesanan::create([
            'pesanan_id' => $pesanan->id,
            'kriteria_id' => $kriteria_id,
            'prioritas' => $index + 1,
        ]);
    }

    // Kirim email
    try {
        Mail::to('sandipermadi625@gmail.com')->send(new OrderStoredMail($pesanan));
    } catch (\Exception $e) {
        Log::error('Gagal mengirim email: ' . $e->getMessage());
    }

    return redirect()->route('pesanan.create', ['id_paket' => $request->id_paket])
        ->with('success', 'Order saved successfully!');
}
















    use KriteriaTrait;
    use ProfileMatchingTrait; // <-- pakai trait ini

    protected $profileMatchingService; // <-- property untuk service injection

    public function __construct(ProfileMatchingService $profileMatchingService)
    {
        $this->profileMatchingService = $profileMatchingService; // Inject service
    }

    public function edit($id)
    {
        $pesanan = Pesanan::with(['kriterias', 'guide.penilaians.detailPenilaians.subkriteria.kriteria'])->findOrFail($id);


        $kriterias = Kriteria::all();
        $pakets = Paket::all();

        $guides = Guide::with(['kriteria', 'penilaians.detailPenilaians.subkriteria.kriteria'])
            ->where('status', 'aktif')
            ->get();

        $filteredGuides = collect();

        foreach ($guides as $guide) {
            $penilaian = $guide->penilaians->first();

            if ($penilaian) {
                $hasil = $this->hitungProfileMatching($penilaian);
                $kriteriaUnggul = $this->tentukanKriteriaUnggulanshow($hasil);

                $guide->kriteria_unggulan_id = $kriteriaUnggul['id'];
                $guide->kriteria_unggulan_nama = $kriteriaUnggul['nama'];

                if (
                    $kriteriaUnggul['id'] == $pesanan->id_kriteria ||
                    $guide->id == $pesanan->id_guide
                ) {
                    $filteredGuides->push($guide);
                }
            } else {
                $guide->kriteria_unggulan_id = null;
                $guide->kriteria_unggulan_nama = 'Belum Dinilai';

                if ($guide->id == $pesanan->id_guide) {
                    $filteredGuides->push($guide);
                }
            }
        }

        if (!$filteredGuides->contains('id', $pesanan->id_guide)) {
            $currentGuide = Guide::with(['penilaians.detailPenilaians.subkriteria.kriteria'])
                ->find($pesanan->id_guide);

            if ($currentGuide) {
                $currentGuide->kriteria_unggulan_id = null;
                $currentGuide->kriteria_unggulan_nama = 'Dipilih tapi non-aktif';
                $filteredGuides->push($currentGuide); // ← Tambahkan baris ini
            }
        }


        return view('pesanan.edit', [
            'pesanan' => $pesanan,
            'kriterias' => $kriterias,
            'pakets' => $pakets,
            'guides' => $filteredGuides,
        ]);
    }









    public function update(Request $request, $id)
    {
        // Validasi input data
        $request->validate([
            'nama' => 'required|string|max:150',
            'email' => 'required|email|max:150',
            'nomor_telp' => 'required|string|max:20',
            'id_kriteria' => 'required|exists:kriterias,id',
            'id_paket' => 'required|exists:pakets,id',
            'tanggal_pesan' => 'required|date',
            'tanggal_keberangkatan' => 'required|date|after_or_equal:tanggal_pesan',
            'jumlah_peserta' => 'required|integer|min:1',
            'negara' => 'required|string|max:100',
            'bahasa' => 'required|string|max:100',
            'riwayat_medis' => 'required|string',
            'paspor' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // Maksimal 5MB
            'special_request' => 'nullable|string',
            'status' => 'nullable|boolean',
            'id_guide' => 'nullable|exists:guides,id',  // Validasi id_guide yang nullable
        ]);

        // Cari pesanan yang ingin diupdate
        $pesanan = Pesanan::findOrFail($id);
        // Cek apakah guide sudah memiliki pesanan lain di tanggal keberangkatan yang sama (selain pesanan ini)
        if ($request->id_guide) {
            $pesananSama = Pesanan::where('id_guide', $request->id_guide)
                ->where('tanggal_keberangkatan', $request->tanggal_keberangkatan)
                ->where('id', '!=', $id)
                ->exists();

            if ($pesananSama) {
                return redirect()->route('pesanan.index')->with('conflict', 'Guide ini sudah memiliki tamu pada tanggal keberangkatan "' . $request->tanggal_keberangkatan . '".');
            }
        }

        // Jika ada file paspor yang diupload, simpan file dan perbarui path-nya
        if ($request->hasFile('paspor')) {
            // Hapus paspor lama jika ada
            if ($pesanan->paspor && Storage::exists('public/' . $pesanan->paspor)) {
                Storage::delete('public/' . $pesanan->paspor);
            }

            // Simpan file paspor yang baru
            $pasporPath = $request->file('paspor')->store('paspor', 'public');
        } else {
            // Jika tidak ada file paspor baru, gunakan path lama
            $pasporPath = $pesanan->paspor;
        }

        // Update data pesanan
        $pesanan->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'nomor_telp' => $request->nomor_telp,
            'id_kriteria' => $request->id_kriteria,
            'id_paket' => $request->id_paket,
            'tanggal_pesan' => $request->tanggal_pesan,
            'tanggal_keberangkatan' => $request->tanggal_keberangkatan,
            'jumlah_peserta' => $request->jumlah_peserta,
            'negara' => $request->negara,
            'bahasa' => $request->bahasa,
            'riwayat_medis' => $request->riwayat_medis,
            'paspor' => $pasporPath,  // Mempertahankan file paspor yang lama atau menggantinya jika baru
            'special_request' => $request->special_request,
            'status' => $request->has('status') ? $request->status : 0,
            'id_guide' => $request->id_guide,  // Update id_guide jika ada
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil diperbarui.');
    }







    public function destroy($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        // Hapus data pesanan
        $pesanan->delete();

        return redirect()->route('pesanan.index', $id)->with('success', 'Pesanan berhasil dihapus');
    }
}
