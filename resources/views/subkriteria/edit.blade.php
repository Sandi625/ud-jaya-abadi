@extends('layout.master')
@section('title', 'Edit Subkriteria')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h3 class="mb-4 text-dark fw-bold">Edit Subkriteria</h3>

            <form action="{{ route('subkriteria.update', $subkriteria->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Kriteria --}}
                <div class="mb-3">
                    <label for="kriteria_id" class="form-label">Kriteria</label>
                    <select id="kriteria_id" name="kriteria_id" class="form-select @error('kriteria_id') is-invalid @enderror">
                        <option value="">-- Pilih Kriteria --</option>
                        @foreach ($kriterias as $kriteria)
                            <option value="{{ $kriteria->id }}" {{ (old('kriteria_id', $subkriteria->kriteria_id) == $kriteria->id) ? 'selected' : '' }}>
                                {{ $kriteria->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kriteria_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nama --}}
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Subkriteria</label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama', $subkriteria->nama) }}" class="form-control @error('nama') is-invalid @enderror">
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="3" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $subkriteria->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Core Factor --}}
                <div class="mb-3">
                    <label class="form-label d-block">Core Factor</label>
                    <div class="form-check">
                        <input type="checkbox" name="is_core_factor" value="1" class="form-check-input" id="is_core_factor"
                            {{ old('is_core_factor', $subkriteria->is_core_factor) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_core_factor">Ya</label>
                    </div>
                    @error('is_core_factor')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Profil Standar --}}
                <div class="mb-4">
                    <label for="profil_standar" class="form-label">Profil Standar (1-4)</label>
                    <input type="number" id="profil_standar" name="profil_standar" value="{{ old('profil_standar', $subkriteria->profil_standar) }}"
                        min="1" max="4" class="form-control @error('profil_standar') is-invalid @enderror">
                    @error('profil_standar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('subkriteria.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left me-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save me-1"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
