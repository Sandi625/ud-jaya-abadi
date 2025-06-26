<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Tampilkan semua blog.
     */
    public function index()
    {
        $blogs = Blog::latest()->get();
        return view('blogs.index', compact('blogs'));
    }

    /**
     * Tampilkan detail blog.
     */
    public function show(Blog $blog)
    {
        return view('blogs.show', compact('blog'));
    }
    public function getRouteKeyName()
{
    return 'slug';
}



    /**
     * Tampilkan form tambah blog.
     */
    public function create()
    {
        return view('blogs.create');
    }

    /**
     * Simpan blog baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            // Menyimpan gambar di folder public/blogs
            $imageName = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/blogs', $imageName);
        }

        Blog::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'body' => $request->body,
            'image' => $imageName,
            'status' => $request->status ?? 0,
            'created_by' => null, // Ganti null dengan ID user jika diperlukan
        ]);

        return redirect()->route('blogs.index')->with('success', 'Blog berhasil dibuat.');
    }



    /**
     * Tampilkan form edit blog.
     */
    public function edit(Blog $blog)
    {
        return view('blogs.edit', compact('blog'));
    }

    /**
     * Update blog.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = $blog->image;  // Default to the current image name if no new image is uploaded.

        // Check if a new image is uploaded.
        if ($request->hasFile('image')) {
            // Delete the old image if it exists.
            if ($blog->image && file_exists(public_path('storage/blogs/' . $blog->image))) {
                unlink(public_path('storage/blogs/' . $blog->image));
            }

            // Generate a new image name and store it in the public/blogs directory.
            $imageName = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/blogs', $imageName);
        }

        // Update the blog with the new data.
        $blog->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'body' => $request->body,
            'image' => $imageName,
            'status' => $request->status ?? 0,  // Default to 0 if no status is provided
            'updated_by' =>  null,  // Set to the authenticated user's ID
        ]);

        // Redirect with success message.
        return redirect()->route('blogs.index')->with('success', 'Blog berhasil diperbarui.');
    }


    /**
     * Hapus blog.
     */
    public function destroy(Blog $blog)
    {
        if ($blog->image && file_exists(public_path('uploads/blogs/' . $blog->image))) {
            unlink(public_path('uploads/blogs/' . $blog->image));
        }

        $blog->delete();

        return redirect()->route('blogs.index')->with('success', 'Blog berhasil dihapus.');
    }



    // public function myblog()
    // {
    //     $blogs = Blog::latest()->limit(5)->get();  // Retrieve the latest 5 blogs
    //     return view('welcome', compact('blogs'));  // Pass the blogs variable to the view
    // }

    public function listBlogs()
    {
        // Fetch all blogs (you can add filters or pagination if needed)
        $blogs = Blog::all();  // Modify this as needed to fetch the correct data

        // Return the view and pass the blogs data
        return view('blogs.blog', compact('blogs'));
    }




}

