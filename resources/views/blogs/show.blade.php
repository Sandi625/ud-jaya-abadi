@extends('layout.app')

@section('title', $blog->title)

@section('content')
<div class="container mx-auto py-12 px-4 min-h-screen">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <!-- Judul Blog -->
        <h1 class="text-4xl font-bold mb-6 text-gray-800 leading-tight text-center">{{ $blog->title }}</h1>

        <!-- Gambar Blog -->
        <div class="mb-8">
            @if ($blog->image)
                <img src="{{ asset('storage/blogs/' . $blog->image) }}" alt="Blog Image" class="w-full h-96 object-cover rounded-lg">
            @else
                <img src="{{ asset('storage/default-image.jpg') }}" alt="Default Image" class="w-full h-96 object-cover rounded-lg">
            @endif
        </div>

        <!-- Isi Blog -->
        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
            {!! nl2br(e($blog->body)) !!}
        </div>

        <!-- Tanggal Dibuat -->
        <div class="mt-10 text-sm text-gray-500 text-center">
            <strong>Dibuat pada:</strong> {{ $blog->created_at->format('d M Y, H:i') }}
        </div>

        <!-- Tombol Kembali -->
        {{-- <div class="mt-10 text-center">
            <a href="{{ route('blogs.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-300">Kembali ke Daftar Blog</a>
        </div> --}}
    </div>
</div>
@endsection
