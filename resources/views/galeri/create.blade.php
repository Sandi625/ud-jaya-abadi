@extends('layout.master')

@section('title', 'Tambah Galeri')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h3 class="mb-4 text-dark fw-bold">Tambah Galeri</h3>

            <form action="{{ route('galeris.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- JUDUL --}}
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul</label>
                    <input type="text" id="judul" name="judul" value="{{ old('judul') }}"
                        class="form-control @error('judul') is-invalid @enderror" placeholder="Masukkan judul galeri">
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- DESKRIPSI --}}
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4"
                        class="form-control @error('deskripsi') is-invalid @enderror"
                        placeholder="Masukkan deskripsi galeri">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- PESAN PERINGATAN --}}
                <div class="mb-3 text-danger small fst-italic">
                    <p>Pilih dan upload salah satu di bawah ini, jangan upload semua file sekaligus.</p>
                </div>

                {{-- VIDEO LOKAL --}}
                <div class="mb-3">
                    <label for="videolokal" class="form-label">Video Lokal <small class="text-muted">(maks 50MB)</small></label>
                    <input type="file" id="videolokal" name="videolokal"
                        class="form-control @error('videolokal') is-invalid @enderror">
                    @error('videolokal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- YOUTUBE URL --}}
                <div class="mb-3">
                    <label for="videoyoutube" class="form-label">URL Video YouTube</label>
                    <input type="url" id="videoyoutube" name="videoyoutube" value="{{ old('videoyoutube') }}"
                        class="form-control @error('videoyoutube') is-invalid @enderror"
                        placeholder="Masukkan URL video YouTube">
                    @error('videoyoutube')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- FOTO --}}
                <div class="mb-4">
                    <label for="foto" class="form-label">Foto <small class="text-muted">(maks 2MB)</small></label>
                    <input type="file" id="foto" name="foto"
                        class="form-control @error('foto') is-invalid @enderror">
                    @error('foto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- BUTTON --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('galeris.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left me-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
