@extends('layout.master')
@section('title', 'Detail Pesanan')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Detail Pesanan</h4>
        </div>
        <div class="card-body">
            <a href="{{ route('pesanan.index') }}" class="btn btn-secondary mb-3">← Kembali</a>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Nama:</strong> {{ $pesanan->nama }}
                </div>
                <div class="col-md-6">
                    <strong>Email:</strong> {{ $pesanan->email }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>No. Telepon:</strong> {{ $pesanan->nomor_telp }}
                </div>
                <div class="col-md-6">
                    <strong>Negara:</strong> {{ $pesanan->negara }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Tanggal Pesan:</strong> {{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->format('d-m-Y') }}
                </div>
                <div class="col-md-6">
                    <strong>Tanggal Keberangkatan:</strong> {{ \Carbon\Carbon::parse($pesanan->tanggal_keberangkatan)->format('d-m-Y') }}
                </div>
            </div>

            <div class="mb-3">
                <strong>Jumlah Peserta:</strong> {{ $pesanan->jumlah_peserta }}
            </div>

            <div class="mb-3">
                <strong>Bahasa:</strong> {{ $pesanan->bahasa }}
            </div>

            <div class="mb-3">
                <strong>Riwayat Medis:</strong> <br>
                {{ $pesanan->riwayat_medis }}
            </div>

            <div class="mb-3">
                <strong>Kriteria:</strong>
                <ul>
                    @forelse($pesanan->detailPesanans as $detail)
                        <li>{{ $detail->kriteria->nama }} ({{ $detail->kriteria->bobot }}%)</li>
                    @empty
                        <li><em>Tidak ada kriteria dipilih</em></li>
                    @endforelse
                </ul>
            </div>

            <div class="mb-3">
                <strong>Permintaan Khusus:</strong> <br>
                {{ $pesanan->special_request ?? '-' }}
            </div>

            <div class="mb-3">
                <strong>Kebutuhan Guide:</strong> <br>
                {{ $pesanan->kebutuhan_guide ?? '-' }}
            </div>

            <div class="mb-3">
                <strong>Status:</strong>
                <span class="badge bg-{{ $pesanan->status ? 'success' : 'danger' }}">
                    {{ $pesanan->status ? 'Aktif' : 'Tidak Aktif' }}
                </span>
            </div>

            <div class="mb-3">
                <strong>Nama Paket:</strong> {{ $pesanan->paket->nama_paket ?? '-' }}
            </div>

            <div class="mb-3">
                <strong>Guide yang Ditugaskan:</strong> {{ $pesanan->guide->nama ?? '-' }}
            </div>

            <div class="mb-3">
                <strong>Paspor:</strong>
                @if ($pesanan->paspor)
                    <a href="{{ asset('storage/' . $pesanan->paspor) }}" target="_blank" class="btn btn-outline-primary btn-sm">Lihat Paspor</a>
                @else
                    <span class="text-muted">Tidak diunggah</span>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
