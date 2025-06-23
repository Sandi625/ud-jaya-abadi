<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class PaketController extends Controller
{
    public function index()
    {
        // Mengambil semua data paket dari database
        $pakets = Paket::all();

        // Mengirim data 'pakets' ke view 'paket.index'
        return view('paket.index', compact('pakets'));
    }

    public function show($id)
{
    // Cari data paket berdasarkan ID
    $paket = Paket::findOrFail($id);

    // Kirim data paket ke view 'paket.show'
    return view('paket.show', compact('paket'));
}



    // public function showPakets()
    // {
    //     // Ambil semua data paket dari database
    //     $pakets = Paket::all();

    //     // Return directly to 'welcome' view with 'pakets' data
    //     return view('welcome', compact('pakets'));
    // }









    public function create()
    {
        return view('paket.create');
    }

    public function store(Request $request)
    {


        // Validasi input
        $request->validate([
            'nama_paket' => 'required|string|max:150',
            'deskripsi_paket' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'durasi' => 'required|string|min:1',
            'destinasi' => 'required|string|max:255',
            'include' => 'nullable|string',
            'exclude' => 'nullable|string',
            'itinerary' => 'nullable|file|mimes:pdf|max:2048', // Validasi file PDF (maks 2MB)
            'information_trip' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        // Proses upload foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('paket_fotos', 'public');
        }

        // Proses upload itinerary jika ada
        $itineraryPath = null;
        if ($request->hasFile('itinerary')) {
            // Mendapatkan file yang diupload
            $file = $request->file('itinerary');

            // Membuat nama file yang lebih pendek menggunakan Str::random() dan ekstensi asli
            $fileName = Str::random(10) . '.' . $file->getClientOriginalExtension();

            // Menyimpan file dengan nama baru di direktori 'paket_itineraries' pada storage publik
            $itineraryPath = $file->storeAs('paket_itineraries', $fileName, 'public');
        }


        // Simpan ke database
        Paket::create([
            'nama_paket' => $request->nama_paket,
            'deskripsi_paket' => $request->deskripsi_paket,
            'harga' => $request->harga,
            'durasi' => $request->durasi,
            'destinasi' => $request->destinasi,
            'include' => $request->include,
            'exclude' => $request->exclude,
            'itinerary' => $itineraryPath, // Menyimpan path file itinerary
            'information_trip' => $request->information_trip,
            'foto' => $fotoPath,
        ]);


        // Redirect dengan pesan sukses
        return redirect()->route('paket.index')->with('success', 'Paket berhasil ditambahkan!');
    }





    public function edit($id)
    {
        $paket = Paket::findOrFail($id);
        return view('paket.edit', compact('paket'));
    }

   public function update(Request $request, $id)
{
    $paket = Paket::findOrFail($id);

    // Validasi data
    $request->validate([
        'nama_paket'      => 'required|string|max:150',
        'deskripsi_paket' => 'nullable|string',
        'harga'           => 'required|numeric|max:1000000000', // Harga tidak boleh lebih dari 1 milyar
        'durasi'          => 'required|string|min:1',
        'destinasi'       => 'required|string|max:255',
        'include'         => 'nullable|string',
        'exclude'         => 'nullable|string',
        'itinerary'       => 'nullable|file|mimes:pdf|max:10240', // Pastikan file PDF dan tidak lebih dari 10MB
        'information_trip' => 'nullable|string',
        'foto'            => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ], [
        'harga.max' => 'Harga tidak boleh lebih dari 1 milyar.', // Pesan khusus jika harga melebihi 1 milyar
    ]);

    // Update data
    $paket->nama_paket = $request->nama_paket;
    $paket->deskripsi_paket = $request->deskripsi_paket;
    $paket->harga = $request->harga;
    $paket->durasi = $request->durasi;
    $paket->destinasi = $request->destinasi;
    $paket->include = $request->include;
    $paket->exclude = $request->exclude;
    $paket->information_trip = $request->information_trip;

    // Handle itinerary file upload (if a new file is uploaded)
    if ($request->hasFile('itinerary')) {
        // Delete old itinerary if exists
        if ($paket->itinerary) {
            Storage::delete('public/' . $paket->itinerary);
        }

        // Store the new itinerary file
        $itineraryPath = $request->file('itinerary')->store('itinerary', 'public');
        $paket->itinerary = $itineraryPath;
    }

    // Handle foto upload (if a new file is uploaded)
    if ($request->hasFile('foto')) {
        // Delete old photo if exists
        if ($paket->foto) {
            Storage::delete('public/' . $paket->foto);
        }

        // Store the new photo
        $fotoPath = $request->file('foto')->store('paket', 'public');
        $paket->foto = $fotoPath;
    }

    $paket->save();

    return redirect()->route('paket.index')->with('success', 'Paket berhasil diperbarui!');
}





    public function destroy($id)
    {
        $paket = Paket::findOrFail($id);

        // Hapus foto jika ada
        if ($paket->foto) {
            Storage::delete('public/' . $paket->foto);
        }

        // Hapus data paket
        $paket->delete();

        return redirect()->route('paket.index')->with('success', 'Paket berhasil dihapus!');
    }
}
