@extends('layout.master')

@section('title', 'Detail Guide')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Detail Guide</h2>

    <div class="card mb-4">
        <div class="row g-0">
            <div class="col-md-4">
                @if ($guide->foto)
                    <img src="{{ asset('storage/' . $guide->foto) }}" class="img-fluid rounded-start" alt="{{ $guide->nama_guide }}">
                @else
                    <img src="https://via.placeholder.com/300x200?text=No+Image" class="img-fluid rounded-start" alt="No Image">
                @endif
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">{{ $guide->nama_guide }}</h5>
                    <p class="card-text"><strong>Email:</strong> {{ $guide->email }}</p>
                    <p class="card-text"><strong>No HP:</strong> {{ $guide->nomer_hp }}</p>
                    <p class="card-text"><strong>Alamat:</strong> {{ $guide->alamat }}</p>
                    <p class="card-text"><strong>Bahasa:</strong> {{ $guide->bahasa }}</p>
                    <p class="card-text"><strong>Gaji:</strong> Rp {{ number_format($guide->salary, 0, ',', '.') }}</p>
                    <p class="card-text"><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $guide->status)) }}</p>
                    <p class="card-text"><strong>Kriteria:</strong> {{ $guide->kriteria->nama ?? '-' }}</p>
                    <p class="card-text"><strong>Kriteria Unggulan:</strong> {{ $guide->kriteria_unggulan_nama ?? '-' }}</p>
                    <p class="card-text"><strong>Deskripsi:</strong> {!! nl2br(e($guide->deskripsi_guide)) !!}</p>
                </div>
            </div>
        </div>
    </div>

    @if ($guide->penilaians->count() > 0)
        <h4>Penilaian Terbaru</h4>
        <div class="card mb-4">
            <div class="card-body">
                @php
                    $penilaian = $guide->penilaians->sortByDesc('created_at')->first();
                @endphp

                <p><strong>Tanggal Penilaian:</strong> {{ $penilaian->created_at->format('d M Y') }}</p>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kriteria</th>
                            <th>Subkriteria</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penilaian->detailPenilaians as $detail)
                            <tr>
                                <td>{{ $detail->subkriteria->kriteria->nama ?? '-' }}</td>
                                <td>{{ $detail->subkriteria->nama ?? '-' }}</td>
                                <td>{{ $detail->nilai }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            Guide ini belum memiliki penilaian.
        </div>
    @endif

    <a href="{{ route('guide.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
