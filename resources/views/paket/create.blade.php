@extends('layout.master')

@section('title', 'Tambah Paket')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Tambah Paket Baru</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan!</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('paket.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="nama_paket" class="form-label">Nama Paket</label>
            <input type="text" class="form-control" id="nama_paket" name="nama_paket" value="{{ old('nama_paket') }}" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi_paket" class="form-label">Deskripsi Paket</label>
            <textarea class="form-control" id="deskripsi_paket" name="deskripsi_paket" rows="3">{{ old('deskripsi_paket') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" class="form-control" id="harga" name="harga" value="{{ old('harga') }}" required>
        </div>

        <div class="mb-3">
            <label for="durasi" class="form-label">Durasi</label>
            <input type="text" class="form-control" id="durasi" name="durasi" value="{{ old('durasi') }}" required>
        </div>

        <div class="mb-3">
            <label for="destinasi" class="form-label">Destinasi</label>
            <input type="text" class="form-control" id="destinasi" name="destinasi" value="{{ old('destinasi') }}" required>
        </div>

        <div class="mb-3">
            <label for="include" class="form-label">Include</label>
            <textarea class="form-control" id="include" name="include" rows="2">{{ old('include') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="exclude" class="form-label">Exclude</label>
            <textarea class="form-control" id="exclude" name="exclude" rows="2">{{ old('exclude') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="information_trip" class="form-label">Informasi Trip</label>
            <textarea class="form-control" id="information_trip" name="information_trip" rows="2">{{ old('information_trip') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="itinerary" class="form-label">Itinerary (PDF)</label>
            <input type="file" class="form-control" id="itinerary" name="itinerary" accept="application/pdf">
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto (JPG/PNG)</label>
            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">
            <i class="fa-solid fa-floppy-disk"></i> Simpan
        </button>
        <a href="{{ route('paket.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
