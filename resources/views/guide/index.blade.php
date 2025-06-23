@extends('layout.master')
@section('title', 'Daftar Guide')

@section('content')
    <div class="container py-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-0 text-dark">Daftar Guide</h3>
                    <a href="{{ route('guide.create') }}" class="btn btn-success">
                        <i class="fa fa-plus me-1"></i> Tambah Guide
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
                        <thead class="table-dark">
                            <tr class="text-center">
                                <th>No</th>
                                <th>Nama Guide</th>
                                <th>Email</th>
                                <th>Kriteria Unggulan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($guides as $index => $guide)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $guide->nama_guide }}</td>
                                    <td>{{ $guide->email }}</td>
                                    <td class="text-center">
                                        @if ($guide->kriteria_unggulan_id)
                                            <span class="badge bg-success">{{ $guide->kriteria_unggulan_nama }}</span>
                                        @else
                                            <span class="text-muted">Belum Dinilai</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('guide.show', $guide->id) }}" class="btn btn-sm btn-primary"
                                                title="Lihat">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('guide.edit', $guide->id) }}" class="btn btn-sm btn-warning"
                                                title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button type="button" onclick="confirmDelete({{ $guide->id }})"
                                                class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>

                                        <form id="delete-form-{{ $guide->id }}"
                                            action="{{ route('guide.destroy', $guide->id) }}" method="POST"
                                            class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada data guide.</td>
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
