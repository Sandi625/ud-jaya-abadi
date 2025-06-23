@extends('layout.master')

@section('title', 'Edit Paket')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Edit Paket: {{ $paket->nama_paket }}</h1>

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

    <form action="{{ route('paket.update', $paket->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama_paket" class="form-label">Nama Paket</label>
            <input type="text" class="form-control" id="nama_paket" name="nama_paket" value="{{ old('nama_paket', $paket->nama_paket) }}" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi_paket" class="form-label">Deskripsi Paket</label>
            <textarea class="form-control" id="deskripsi_paket" name="deskripsi_paket" rows="3">{{ old('deskripsi_paket', $paket->deskripsi_paket) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" class="form-control" id="harga" name="harga" value="{{ old('harga', $paket->harga) }}" required>
        </div>

        <div class="mb-3">
            <label for="durasi" class="form-label">Durasi</label>
            <input type="text" class="form-control" id="durasi" name="durasi" value="{{ old('durasi', $paket->durasi) }}" required>
        </div>

        <div class="mb-3">
            <label for="destinasi" class="form-label">Destinasi</label>
            <input type="text" class="form-control" id="destinasi" name="destinasi" value="{{ old('destinasi', $paket->destinasi) }}" required>
        </div>

        <div class="mb-3">
            <label for="include" class="form-label">Include</label>
            <textarea class="form-control" id="include" name="include" rows="2">{{ old('include', $paket->include) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="exclude" class="form-label">Exclude</label>
            <textarea class="form-control" id="exclude" name="exclude" rows="2">{{ old('exclude', $paket->exclude) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="information_trip" class="form-label">Informasi Trip</label>
            <textarea class="form-control" id="information_trip" name="information_trip" rows="2">{{ old('information_trip', $paket->information_trip) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="itinerary" class="form-label">Itinerary (PDF)</label>
            @if ($paket->itinerary)
                <p><a href="{{ asset('storage/' . $paket->itinerary) }}" target="_blank">Lihat file saat ini</a></p>
            @endif
            <input type="file" class="form-control" id="itinerary" name="itinerary" accept="application/pdf">
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto</label>
            @if ($paket->foto)
                <p><img src="{{ asset('storage/' . $paket->foto) }}" alt="Foto Paket" width="150"></p>
            @endif
            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-save"></i> Update
        </button>
        <a href="{{ route('paket.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
