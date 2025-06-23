@extends('layout.master')
@section('title', 'Daftar Pesanan')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0 text-dark">Daftar Pesanan</h3>
                {{-- Tambahkan tombol atau fitur lain jika perlu --}}
            </div>

            {{-- Notifikasi sukses --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            @endif

            {{-- Form Pencarian --}}
            <form method="GET" action="{{ route('pesanan.index') }}" class="mb-3">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Cari Order ID atau Nama" value="{{ request('q') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="fa fa-search me-1"></i> Cari
                    </button>
                </div>
            </form>

            <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0 text-dark">Daftar Pesanan</h3>
    <a href="{{ route('pesanan.create') }}" class="btn btn-success">
        <i class="fa fa-plus me-1"></i> Tambah Pesanan
    </a>
</div>


            {{-- Tabel --}}
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Order ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No. Telp</th>
                            <th>Paket</th>
                            <th>Guide</th>
                            <th>Tgl Keberangkatan</th>
                            <th>Jumlah Peserta</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesanans as $index => $pesanan)
                            <tr>
                                <td class="text-center">{{ $pesanans->firstItem() + $index }}</td>
                                <td>{{ $pesanan->order_id }}</td>
                                <td>{{ $pesanan->nama }}</td>
                                <td>{{ $pesanan->email }}</td>
                                <td>{{ $pesanan->nomor_telp }}</td>
                                <td>{{ $pesanan->paket->nama_paket ?? '-'}}</td>
                                <td>{{ $pesanan->guide->nama ?? '-' }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($pesanan->tanggal_keberangkatan)->format('d-m-Y') }}</td>
                                <td class="text-center">{{ $pesanan->jumlah_peserta }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('pesanan.show', $pesanan->id) }}" class="btn btn-sm btn-info">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('pesanan.edit', $pesanan->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button onclick="confirmDelete({{ $pesanan->id }})" class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                    <form id="delete-form-{{ $pesanan->id }}" action="{{ route('pesanan.destroy', $pesanan->id) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted">Tidak ada data pesanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginasi --}}
            <div class="mt-3">
                {{ $pesanans->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

{{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Pesanan ini akan dihapus secara permanen!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection
