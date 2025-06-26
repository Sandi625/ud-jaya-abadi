@extends('layout.master')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Detail Guide</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('guidesWithPesanan') }}">Notifikasi Guide</a></li>
        <li class="breadcrumb-item active">Detail Guide</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <i class="fas fa-user me-1"></i>
            Informasi Guide
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Nama</th>
                    <td>{{ $guide->nama_guide }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $guide->email }}</td>
                </tr>
                <tr>
                    <th>Bahasa</th>
                    <td>{{ $guide->bahasa }}</td>
                </tr>
                <tr>
                    <th>Nomor HP</th>
                    <td>{{ $guide->nomer_hp }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if ($guide->status === 'aktif')
                            <span class="badge bg-success">Aktif</span>
                        @elseif ($guide->status === 'sedang_guiding')
                            <span class="badge bg-warning text-dark">Sedang Guiding</span>
                        @else
                            <span class="badge bg-danger">Tidak Aktif</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            <i class="fas fa-bell me-1"></i>
            Notifikasi Terbaru
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Status Notif</th>
                    <td>{{ $guide->latest_notif->status_display }}</td>
                </tr>
                <tr>
                    <th>Tanggal Kirim</th>
                    <td>
                        {{ $guide->latest_notif->tanggal_kirim
                            ? \Carbon\Carbon::parse($guide->latest_notif->tanggal_kirim)->format('d M Y H:i')
                            : '-' }}
                    </td>
                </tr>
                <tr>
                    <th>Isi Notif</th>
                    <td>{{ $guide->latest_notif->isi }}</td>
                </tr>
            </table>
        </div>
    </div>

    <a href="{{ route('guidesWithPesanan') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>
@endsection
