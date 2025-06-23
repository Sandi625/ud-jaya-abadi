<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Guide;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Services\ProfileMatchingService; // kalau butuh inject service
use App\Traits\KriteriaTrait;
use App\Traits\ProfileMatchingTrait;


class GuideController extends Controller
{
    use KriteriaTrait;
    use ProfileMatchingTrait; // <--- pakai trait ini

    protected $profileMatchingService; // <--- tambah ini

    public function __construct(ProfileMatchingService $profileMatchingService)
    {
        $this->profileMatchingService = $profileMatchingService; // inject service
    }

    public function index()
    {
        $guides = Guide::with(['kriteria', 'penilaians.detailPenilaians.subkriteria.kriteria'])->get();

        foreach ($guides as $guide) {
            // Ambil penilaian terbaru berdasarkan created_at
            $penilaian = $guide->penilaians
                ->sortByDesc(fn($p) => $p->created_at)
                ->first();

            if ($penilaian && $penilaian->detailPenilaians->count() > 0) {
                $hasil = $this->hitungProfileMatching($penilaian);
                $kriteriaUnggul = $this->tentukanKriteriaUnggulanshow($hasil);

                $guide->kriteria_unggulan_id = $kriteriaUnggul['id'];
                $guide->kriteria_unggulan_nama = $kriteriaUnggul['nama'];
            } else {
                $guide->kriteria_unggulan_id = null;
                $guide->kriteria_unggulan_nama = 'Belum Dinilai';
            }
        }

        return view('guide.index', compact('guides'));
    }


    public function show($id)
    {
        $guide = Guide::with(['kriteria', 'penilaians.detailPenilaians.subkriteria.kriteria'])->findOrFail($id);

        // Ambil penilaian terbaru berdasarkan created_at (atau sesuaikan jika mau yang paling lengkap)
        $penilaian = $guide->penilaians
            ->sortByDesc(fn($p) => $p->created_at)
            ->first();

        if ($penilaian && $penilaian->detailPenilaians->count() > 0) {
            $hasil = $this->hitungProfileMatching($penilaian);
            $kriteriaUnggul = $this->tentukanKriteriaUnggulanshow($hasil);
        } else {
            $kriteriaUnggul = [
                'id' => null,
                'nama' => 'Belum Dinilai'
            ];
        }

        // Simpan ke properti guide agar bisa dipakai di view
        $guide->kriteria_unggulan_id = $kriteriaUnggul['id'];
        $guide->kriteria_unggulan_nama = $kriteriaUnggul['nama'];

        return view('guide.show', compact('guide'));
    }









    public function create()
    {
        return view('guide.create');
    }

    public function store(Request $request)
    {
        // Bersihkan salary dari 'Rp', titik, dan spasi
        $salaryRaw = $request->input('salary');
        $salaryClean = preg_replace('/[^\d]/', '', $salaryRaw);

        $request->merge(['salary' => $salaryClean]);

        // Validasi input
        $request->validate([
            'nama_guide' => 'required|string|max:100',
            'salary' => 'required|numeric|min:0',
            'deskripsi_guide' => 'required|string',
            'nomer_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'email' => 'required|email|unique:guides,email|unique:users,email',
            'bahasa' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:aktif,sedang_guiding,tidak_aktif',
        ]);

        // Buat user baru untuk login guide
        $user = User::create([
            'name' => $request->nama_guide,
            'email' => $request->email,
            'password' => Hash::make('password123'), // Bisa diganti sesuai inputan
            'level' => 'guide',
        ]);

        // Simpan foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('guides', 'public');
        }

        // Simpan data guide
        Guide::create([
            'nama_guide' => $request->nama_guide,
            'salary' => $salaryClean,
            'deskripsi_guide' => $request->deskripsi_guide,
            'nomer_hp' => $request->nomer_hp,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'bahasa' => $request->bahasa,
            'foto' => $fotoPath,
            'status' => $request->status,
            'user_id' => $user->id, // <-- hubungan guide ke user
        ]);

        return redirect()->route('guide.index')->with('success', 'Guide berhasil ditambahkan!');
    }












    public function edit($id)
    {
        $guide = Guide::findOrFail($id);
        return view('guide.edit', compact('guide'));
    }









    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_guide' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'deskripsi_guide' => 'nullable|string',
            'nomer_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'email' => 'required|email|unique:guides,email,' . $id . ',id',
            'bahasa' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:aktif,sedang_guiding,tidak_aktif',
        ]);

        $guide = Guide::findOrFail($id);


        if ($request->hasFile('foto')) {

            if ($guide->foto) {
                Storage::disk('public')->delete($guide->foto);
            }

            $fotoPath = $request->file('foto')->store('guides', 'public');
            $guide->foto = $fotoPath;
        }


        $guide->update([
            'nama_guide' => $request->nama_guide,
            'salary' => $request->salary,
            'deskripsi_guide' => $request->deskripsi_guide,
            'nomer_hp' => $request->nomer_hp,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'bahasa' => $request->bahasa,
            'status' => $request->status,
        ]);

        return redirect()->route('guide.index')->with('success', 'Guide berhasil diperbarui.');
    }





    public function destroy($id)
    {
        $guide = Guide::findOrFail($id);


        if ($guide->foto) {
            Storage::disk('public')->delete($guide->foto);
        }

        $guide->delete();

        return redirect()->route('guide.index')->with('success', 'Guide berhasil dihapus.');
    }
}
