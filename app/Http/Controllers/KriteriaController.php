<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    // Menampilkan daftar kriteria
 public function index()
{
    $kriterias = Kriteria::all();
    $totalBobot = Kriteria::sum('bobot');
    return view('kriteria.index', compact('kriterias', 'totalBobot'));
}


    // Menampilkan form untuk menambah kriteria baru
 public function create()
{
    $totalBobot = Kriteria::sum('bobot');
    return view('kriteria.create', compact('totalBobot'));
}


    // Menyimpan kriteria baru
 public function store(Request $request)
{
    $request->validate([
        'nama' => 'required',
        'deskripsi' => 'nullable',
        'bobot' => 'required|numeric|min:1|max:100',
    ]);

    // Hitung total bobot yang sudah ada
    $totalBobot = Kriteria::sum('bobot');

    // Cek apakah bobot baru melebihi total 100
    if ($totalBobot + $request->bobot > 100) {
        return redirect()->back()->withErrors(['bobot' => 'Total bobot kriteria tidak boleh melebihi 100.'])->withInput();
    }

    // Mendapatkan kode kriteria terakhir
    $lastKriteria = Kriteria::orderBy('kode', 'desc')->first();
    $newNumber = $lastKriteria ? intval(substr($lastKriteria->kode, 1)) + 1 : 1;
    $newKode = 'K' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

    // Buat kriteria baru
    Kriteria::create([
        'kode' => $newKode,
        'nama' => $request->nama,
        'deskripsi' => $request->deskripsi,
        'bobot' => $request->bobot,
    ]);

    return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil ditambahkan.');
}


    // Menampilkan form untuk mengedit kriteria
    public function edit($id)
    {
        $kriteria = Kriteria::find($id);
        return view('kriteria.edit', compact('kriteria'));
    }

    // Memperbarui kriteria
  public function update(Request $request, $id)
{
    $request->validate([
        'kode' => 'required|unique:kriterias,kode,' . $id,
        'nama' => 'required',
        'deskripsi' => 'nullable',
        'bobot' => 'required|numeric|min:0|max:100',
    ]);

    $kriteria = Kriteria::findOrFail($id);

    $kriteria->update([
        'kode' => $request->kode,
        'nama' => $request->nama,
        'deskripsi' => $request->deskripsi,
        'bobot' => $request->bobot,
    ]);

    return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil diperbarui.');
}


    // Menghapus kriteria
    public function destroy($id)
    {

        $kriteriaFind = Kriteria::findOrFail($id);
        $kriteriaFind->delete();

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil dihapus.');
    }
}
