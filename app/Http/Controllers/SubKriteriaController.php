<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Subkriteria;
use Illuminate\Http\Request;

class SubKriteriaController extends Controller
{
    public function index()
    {
        $subkriterias = Subkriteria::with('kriteria')->get();
        return view('subkriteria.index', compact('subkriterias'));
    }

    public function create()
    {
        $kriterias = Kriteria::all();
        return view('subkriteria.create', compact('kriterias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kriteria_id' => 'required|exists:kriterias,id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'is_core_factor' => 'boolean',
            'profil_standar' => 'required|min:1|max:5',
        ]);

        Subkriteria::create($request->all());

        return redirect()->route('subkriteria.index')->with('success', 'Subkriteria berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $subkriteria = Subkriteria::findOrFail($id);
        $kriterias = Kriteria::all();
        return view('subkriteria.edit', compact('subkriteria', 'kriterias'));
    }

  public function update(Request $request, $id)
{
    $request->validate([
        'kriteria_id' => 'required|exists:kriterias,id',
        'nama' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'profil_standar' => 'required|integer|min:1|max:5',
    ]);

    $subkriteria = Subkriteria::findOrFail($id);

    // Ambil semua input kecuali is_core_factor
    $data = $request->except('is_core_factor');

    // Set is_core_factor secara eksplisit: 1 jika dicentang, 0 jika tidak
    $data['is_core_factor'] = $request->has('is_core_factor') ? 1 : 0;

    $subkriteria->update($data);

    return redirect()->route('subkriteria.index')->with('success', 'Subkriteria berhasil diperbarui.');
}


    public function destroy($id)
    {
        $subkriteria = Subkriteria::findOrFail($id);
        $subkriteria->delete();
        return redirect()->route('subkriteria.index')->with('success', 'Subkriteria berhasil dihapus.');
    }
}
