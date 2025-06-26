@extends('layout.master')

@section('title', 'Tambah Blog')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h3 class="mb-4 text-dark fw-bold">Tambah Blog</h3>

            <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- JUDUL --}}
                <div class="mb-3">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}"
                        class="form-control @error('title') is-invalid @enderror"
                        placeholder="Masukkan judul blog">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- SLUG (Readonly) --}}
                <div class="mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug') }}"
                        class="form-control @error('slug') is-invalid @enderror" readonly>
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- ISI BLOG --}}
                <div class="mb-3">
                    <label for="body" class="form-label">Isi</label>
                    <textarea id="body" name="body" rows="5"
                        class="form-control @error('body') is-invalid @enderror"
                        placeholder="Masukkan isi blog">{{ old('body') }}</textarea>
                    @error('body')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- GAMBAR --}}
                <div class="mb-3">
                    <label for="image" class="form-label">Gambar <small class="text-muted">(maks 2MB)</small></label>
                    <input type="file" id="image" name="image"
                        class="form-control @error('image') is-invalid @enderror">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- STATUS --}}
                <div class="mb-4 form-check">
                    <input type="checkbox" id="status" name="status" value="1"
                        class="form-check-input" {{ old('status') ? 'checked' : '' }}>
                    <label for="status" class="form-check-label">Aktifkan Blog</label>
                    @error('status')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- BUTTONS --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('blogs.index') }}" class="btn btn-secondary">
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

{{-- Auto-generate slug dari title --}}
<script>
    document.getElementById('title').addEventListener('input', function() {
        let title = this.value;
        let slug = title.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .trim()
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
        document.getElementById('slug').value = slug;
    });
</script>
@endsection
