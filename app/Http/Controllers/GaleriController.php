<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index()
    {
        // Mengambil data galeri dengan pagination, menampilkan 9 galeri per halaman
        $galeris = Galeri::paginate(8); // Menampilkan 9 galeri per halaman
        return view('galeri.index', compact('galeris'));
    }



public function create()
{
    return view('galeri.create');
}


public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'videolokal' => 'nullable|file|mimes:mp4,mkv,avi|max:51200', // 50MB max for video
            'videoyoutube' => 'nullable|string|url',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048', // 2MB max for image
        ]);



        try {
            // Start creating the gallery item
            $galeri = new Galeri();

            // Assign values to the fields
            $galeri->judul = $validated['judul'];
            $galeri->deskripsi = $validated['deskripsi'] ?? null;

            // Handle the local video upload if present
            if ($request->hasFile('videolokal')) {
                $galeri->videolokal = $request->file('videolokal')->store('videos', 'public');
            }

            // Assign the YouTube video URL if provided
            $galeri->videoyoutube = $validated['videoyoutube'] ?? null;

            // Handle the image upload if present
            if ($request->hasFile('foto')) {
                $galeri->foto = $request->file('foto')->store('images', 'public');
            }

            // Save the gallery item to the database
            $galeri->save();

            // Return a success response (you can use redirects or return JSON if needed)
            return redirect()->route('galeris.index')->with('success', 'Galeri berhasil disimpan!');
        } catch (\Exception $e) {
            // If there's an error, return a response with an error message
            return redirect()->route('galeris.create')->with('error', 'Terjadi kesalahan saat menyimpan galeri: ' . $e->getMessage());
        }
    }







// public function edit($id)
// {
//     $galeri = Galeri::findOrFail($id);
//     return view('galeri.edit', compact('galeri'));
// }

// public function update(Request $request, $id)
// {
//     // Validate the input data
//     $request->validate([
//         'judul' => 'required|string|max:255',
//         'deskripsi' => 'nullable|string',
//         'videolokal' => 'nullable|mimes:mp4,mov,avi|max:51200', // Max 10MB video
//         'videoyoutube' => 'nullable|url',
//         'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240', // Max 10MB image
//     ]);

//     // Find the Galeri by ID
//     $galeri = Galeri::findOrFail($id);

//     // Update the fields with the new values
//     $galeri->judul = $request->input('judul');
//     $galeri->deskripsi = $request->input('deskripsi');
//     $galeri->videoyoutube = $request->input('videoyoutube'); // Update YouTube URL if provided

//     // Handle video upload if provided and delete the old video
//     if ($request->hasFile('videolokal')) {
//         // Delete the old video if it exists
//         if ($galeri->videolokal) {
//             Storage::delete('public/' . $galeri->videolokal);
//         }

//         // Store the new video
//         $videoPath = $request->file('videolokal')->store('galeri/videos', 'public');
//         $galeri->videolokal = $videoPath;
//     }

//     // Handle photo upload if provided and delete the old photo
//     if ($request->hasFile('foto')) {
//         // Delete the old photo if it exists
//         if ($galeri->foto) {
//             Storage::delete('public/' . $galeri->foto);
//         }

//         // Store the new photo
//         $fotoPath = $request->file('foto')->store('galeri/photos', 'public');
//         $galeri->foto = $fotoPath;
//     }

//     // Save the updated Galeri record
//     $galeri->save();

//     // Redirect with a success message
//     return redirect()->route('galeris.index')->with('success', 'Galeri has been updated successfully.');
// }




public function destroy($id)
{
    $galeri = Galeri::findOrFail($id);

    // Delete the associated files (video and image)
    if ($galeri->foto) {
        Storage::disk('public')->delete($galeri->foto);
    }

    if ($galeri->video) {
        Storage::disk('public')->delete($galeri->video);
    }

    $galeri->delete();

    return redirect()->route('galeris.index')->with('success', 'Galeri berhasil dihapus.');
}

public function showGaleri()
{
    // Mengambil semua data galeri tanpa pagination
    $galeris = Galeri::all(); // Mengambil semua data galeri
    return view('galeri.galeri', compact('galeris'));
}

public function showVideo()
{
    // Ambil semua data galeri yang hanya punya video tanpa pagination
    $galeris = Galeri::whereNotNull('videoyoutube')
                    ->orWhereNotNull('videolokal')
                    ->get(); // Mengambil semua video tanpa pagination

    return view('galeri.video', compact('galeris'));
}







}
