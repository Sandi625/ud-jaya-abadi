@extends('layout.master')
@section('title', 'Form Penilaian Guide')

@section('content')
    <div class="container py-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h3 class="mb-4 text-dark fw-bold">Form Penilaian Guide oleh Admin</h3>

                <form action="{{ route('penilaian.store') }}" method="POST">
                    @csrf

                    {{-- PILIH GUIDE --}}
                    <div class="mb-3">
                        <label for="guide_id" class="form-label">Pilih Guide</label>
                        <select name="guide_id" id="guide_id" class="form-select @error('guide_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Guide --</option>
                            @foreach ($guides as $guide)
                                <option value="{{ $guide->id }}" {{ old('guide_id') == $guide->id ? 'selected' : '' }}>
                                    {{ $guide->nama_guide }}
                                </option>
                            @endforeach
                        </select>
                        @error('guide_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- KRITERIA DAN SUBKRITERIA --}}
                    @foreach ($kriterias as $kriteria)
                        <h5 class="mt-4 mb-3 text-primary fw-bold">{{ $kriteria->nama }}</h5>

                        @foreach ($kriteria->subkriterias as $subkriteria)
                            @php
                                // Bersihkan deskripsi: ubah "1. Tidak bisa" jadi "1.Tidak bisa"
                                $cleaned = preg_replace('/(\d+)\.\s+/', '$1.', $subkriteria->deskripsi);
                                $deskripsiList = preg_split('/(?=\d+\.)/', trim($cleaned));
                                if (isset($deskripsiList[0]) && $deskripsiList[0] === '') {
                                    array_shift($deskripsiList);
                                }
                            @endphp

                            <div class="mb-4">
                                <label for="nilai_{{ $subkriteria->id }}" class="form-label fw-semibold">
                                    {{ $subkriteria->nama }}
                                </label>

                                <div class="text-muted small">
                                    <ul class="mb-1 ps-3">
                                        @foreach ($deskripsiList as $item)
                                            <li>{{ trim($item) }}</li>
                                        @endforeach
                                    </ul>
                                </div>

                                <select name="nilai[{{ $subkriteria->id }}]" id="nilai_{{ $subkriteria->id }}"
                                    class="form-select @error("nilai.{$subkriteria->id}") is-invalid @enderror" required>
                                    <option value="">-- Pilih Nilai --</option>
                                    @for ($i = 1; $i <= 4; $i++)
                                        <option value="{{ $i }}"
                                            {{ old("nilai.{$subkriteria->id}") == $i ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>

                                @error("nilai.{$subkriteria->id}")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endforeach
                    @endforeach

                    {{-- BUTTONS --}}
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('penilaian.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save me-1"></i> Simpan Penilaian
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
