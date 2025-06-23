@extends('layout.master')
@section('title', 'Edit Penilaian Guide')

@section('content')
    <div class="container py-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">

                {{-- ===== Judul Halaman ===== --}}
                <h3 class="mb-4 text-dark fw-bold">
                    Edit Penilaian Guide – {{ $penilaian->guide->nama_guide }}
                </h3>

                <form action="{{ route('penilaian.update', $penilaian->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- ===== Field Guide (readonly) ===== --}}
                    <div class="mb-3">
                        <label class="form-label">Guide</label>
                        <input type="text" class="form-control" value="{{ $penilaian->guide->nama_guide }}" readonly>
                        <input type="hidden" name="guide_id" value="{{ $penilaian->guide_id }}">
                    </div>

                    {{-- ===== Loop Kriteria & Subkriteria ===== --}}
                    @foreach ($kriterias as $kriteria)
                        <h5 class="mt-4 mb-3 text-primary fw-bold">{{ $kriteria->nama }}</h5>

                        @foreach ($kriteria->subkriterias as $subkriteria)
                            @php
                                // Ambil nilai lama (jika ada)
                                $nilaiLama = $penilaian->detailPenilaians
                                            ->firstWhere('subkriteria_id', $subkriteria->id)
                                            ->nilai ?? null;

                                /**
                                 * Format deskripsi:
                                 * - Hilangkan spasi setelah angka “1. ”
                                 * - Pecah jadi list vertikal 1.Teks, 2.Teks, dst.
                                 */
                                $clean = preg_replace('/(\d+)\.\s+/', '$1.', $subkriteria->deskripsi);
                                $deskripsiList = preg_split('/(?=\d+\.)/', trim($clean));
                                if (isset($deskripsiList[0]) && $deskripsiList[0] === '') {
                                    array_shift($deskripsiList);
                                }
                            @endphp

                            <div class="mb-4">
                                {{-- Nama Subkriteria --}}
                                <label for="nilai_{{ $subkriteria->id }}" class="form-label fw-semibold">
                                    {{ $subkriteria->nama }}
                                </label>

                                {{-- Deskripsi vertikal --}}
                                <div class="text-muted small">
                                    <ul class="mb-1 ps-3">
                                        @foreach ($deskripsiList as $item)
                                            <li>{{ trim($item) }}</li>
                                        @endforeach
                                    </ul>
                                </div>

                                {{-- Badge nilai lama --}}
                                {{-- @if ($nilaiLama !== null)
                                    <span class="badge bg-info text-dark mb-2">
                                        Nilai sebelumnya: {{ $nilaiLama }}
                                    </span>
                                @endif --}}

                                {{-- Dropdown nilai --}}
                                <select name="nilai[{{ $subkriteria->id }}]"
                                        id="nilai_{{ $subkriteria->id }}"
                                        class="form-select {{ $errors->has('nilai.'.$subkriteria->id) ? 'is-invalid' : '' }}"
                                        required>
                                    <option value="">-- Pilih Nilai --</option>
                                    @for ($i = 1; $i <= 4; $i++)
                                        <option value="{{ $i }}"
                                            {{ old('nilai.'.$subkriteria->id, $nilaiLama) == $i ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>

                                @error('nilai.'.$subkriteria->id)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endforeach
                    @endforeach

                    {{-- ===== Tombol Aksi ===== --}}
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('penilaian.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save me-1"></i> Update Penilaian
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
