@extends('layout.master')
@section('title', 'Daftar Subkriteria')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0 text-dark">Daftar Subkriteria</h3>
                <a href="{{ route('subkriteria.create') }}" class="btn btn-success">
                    <i class="fa fa-plus me-1"></i> Tambah Subkriteria
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>#</th>
                            <th>Kriteria</th>
                            <th>Nama</th>
                            {{-- <th>Deskripsi</th> --}}
                            <th>Core Factor</th>
                            <th>Profil Standar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($subkriterias as $i => $sub)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>{{ $sub->kriteria->nama ?? '-' }}</td>
                                <td>{{ $sub->nama }}</td>
                                {{-- <td>{{ $sub->deskripsi ?? '-' }}</td> --}}
                                <td class="text-center">{{ $sub->is_core_factor ? 'Ya' : 'Tidak' }}</td>
                                <td class="text-center">{{ $sub->profil_standar }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('subkriteria.edit', $sub->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button onclick="confirmDelete({{ $sub->id }})" class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                    <form id="delete-form-{{ $sub->id }}" action="{{ route('subkriteria.destroy', $sub->id) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada data subkriteria.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection
