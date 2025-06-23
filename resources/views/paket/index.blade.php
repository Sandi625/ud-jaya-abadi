{{-- resources/views/paket/index.blade.php --}}
@extends('layout.master')

@section('title', 'Daftar Paket')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0 text-dark">Daftar Paket</h3>
                <a href="{{ route('paket.create') }}" class="btn btn-success">
                    <i class="fa fa-plus me-1"></i> Tambah Paket
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Paket</th>
                            <th>Harga</th>
                            <th>Durasi</th>
                            <th>Destinasi</th>
                            <th>Itinerary</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pakets as $index => $paket)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $paket->nama_paket }}</td>
                                <td>Rp {{ number_format($paket->harga, 0, ',', '.') }}</td>
                                <td>{{ $paket->durasi }}</td>
                                <td>{{ $paket->destinasi }}</td>
                                <td>{{ Str::limit($paket->itinerary, 50) }}</td>
                              <td class="text-center">
    @if ($paket->foto)
        <img src="{{ asset('storage/' . $paket->foto) }}"
             alt="Foto Paket"
             class="img-thumbnail"
             style="width: 80px; height: 80px; object-fit: cover;">
    @else
        <span class="text-muted">Tidak ada foto</span>
    @endif
</td>


                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('paket.show', $paket->id) }}" class="btn btn-sm btn-info">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('paket.edit', $paket->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button onclick="confirmDelete({{ $paket->id }})" class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                    <form id="delete-form-{{ $paket->id }}" action="{{ route('paket.destroy', $paket->id) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Belum ada data paket.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
            text: "Data ini akan dihapus secara permanen!",
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
