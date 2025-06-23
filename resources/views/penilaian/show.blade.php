@extends('layout.master')

@section('title', 'Detail Penilaian')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">

            {{-- Judul --}}
            <h3 class="mb-4 fw-bold text-dark">
                Detail Penilaian: {{ optional($penilaian->guide)->nama_guide ?? 'Tidak Diketahui' }}
            </h3>

            {{-- Keunggulan --}}
            <h5 class="fw-semibold text-success">Keunggulan di Kriteria:</h5>
            <p class="mb-4 text-success">{{ $kriteriaUnggulan }}</p>

            {{-- Hasil Perhitungan Profile Matching --}}
            <h5 class="fw-bold text-primary">Hasil Perhitungan Profile Matching</h5>
            @foreach($hasil['detail'] as $kriteriaId => $detailKriteria)
                <div class="mb-3">
                    <h6 class="fw-semibold">{{ $detailKriteria['nama'] }}</h6>
                    <ul class="mb-0 ps-3">
                        <li>Nilai Core Factor: <strong>{{ number_format($detailKriteria['nilai_cf'], 2) }}</strong></li>
                        <li>Nilai Secondary Factor: <strong>{{ number_format($detailKriteria['nilai_sf'], 2) }}</strong></li>
                        <li>Nilai Total Kriteria: <strong>{{ number_format($detailKriteria['nilai_total'], 2) }}</strong></li>
                    </ul>
                </div>
            @endforeach

            <h5 class="fw-bold mt-4">Nilai Akhir: <span class="text-primary">{{ number_format($hasil['nilai_akhir'], 2) }}</span></h5>

            <a href="{{ route('penilaian.index') }}" class="btn btn-secondary mt-3">
                <i class="fa fa-arrow-left me-1"></i> Kembali
            </a>

            {{-- Detail Penilaian --}}
            <h5 class="fw-bold mt-5 mb-3">Tabel Detail Penilaian</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-sm align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Kriteria</th>
                            <th>Subkriteria</th>
                            <th>Nilai</th>
                            <th>Profil Standar</th>
                            <th>Gap</th>
                            <th>Bobot Nilai</th>
                            <th>Jenis Faktor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hasil['detail'] as $kriteriaId => $detailKriteria)
                            @foreach($detailKriteria['detail'] as $detail)
                                <tr>
                                    <td>{{ $detailKriteria['nama'] }}</td>
                                    <td>{{ $detail['nama_subkriteria'] }}</td>
                                    <td>{{ $detail['nilai'] }}</td>
                                    <td>{{ $detail['profil_standar'] }}</td>
                                    <td>{{ $detail['gap'] }}</td>
                                    <td>{{ number_format($detail['bobot_nilai'], 2) }}</td>
                                    <td>
                                        <span class="badge {{ $detail['is_core_factor'] ? 'bg-primary' : 'bg-secondary' }}">
                                            {{ $detail['is_core_factor'] ? 'Core Factor' : 'Secondary Factor' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
