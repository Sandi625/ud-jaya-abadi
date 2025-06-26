{{-- @extends('layouts.app')

@section('title', 'Edit Galeri')

@section('content')
<div class="container-fluid min-vh-100 d-flex flex-column">
    <div class="bg-white shadow-md rounded-lg p-6 flex-grow-1 d-flex flex-column ml-6">
        <h1 class="text-4xl font-bold mb-6 text-gray-800">Edit Galeri</h1>

        <form action="{{ route('galeris.update', $galeri->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Judul Input -->
            <div class="mb-4">
                <label for="judul" class="block text-lg font-medium text-gray-700">Judul</label>
                <input type="text" id="judul" name="judul" value="{{ old('judul', $galeri->judul) }}" class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Masukkan judul galeri" required>
                @error('judul')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Deskripsi Input -->
            <div class="mb-4">
                <label for="deskripsi" class="block text-lg font-medium text-gray-700">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Masukkan deskripsi galeri">{{ old('deskripsi', $galeri->deskripsi) }}</textarea>
                @error('deskripsi')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Video Lokal Upload -->
            <div class="mb-4">
                <label for="videolokal" class="block text-lg font-medium text-gray-700">Video Lokal (Opsional)</label>
                <input type="file" id="videolokal" name="videolokal" class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @if ($galeri->video)
                    <div class="mt-2">
                        <video controls class="max-w-xs">
                            <source src="{{ asset('storage/galeri/videos/' . $galeri->video) }}" type="video/mp4">
                        </video>
                    </div>
                @endif
                @error('videolokal')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Video YouTube URL -->
            <div class="mb-4">
                <label for="videoyoutube" class="block text-lg font-medium text-gray-700">URL Video YouTube (Opsional)</label>
                <input type="url" id="videoyoutube" name="videoyoutube" value="{{ old('videoyoutube', $galeri->video) }}" class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Masukkan URL video YouTube">
                @error('videoyoutube')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Foto Upload -->
            <div class="mb-4">
                <label for="foto" class="block text-lg font-medium text-gray-700">Foto (Opsional)</label>
                <input type="file" id="foto" name="foto" class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @if ($galeri->foto)
                    <div class="mt-2">
                        <img src="{{ asset('storage/galeri/photos/' . $galeri->foto) }}" alt="Foto Galeri" class="max-w-xs h-auto rounded-md">
                    </div>
                @endif
                @error('foto')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="btn btn-success mt-8 px-8 py-3 rounded-md bg-green-500 text-white hover:bg-green-600 text-xl">Update Galeri</button>
            </div>
        </form>
    </div>
</div>
@endsection --}}
