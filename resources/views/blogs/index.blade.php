@extends('layout.master')

@section('title', 'Daftar Blog')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between mb-3">
            <h2>Daftar Blog</h2>
            <a href="{{ route('blogs.create') }}" class="btn btn-primary">Tambah Blog</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Slug</th>
                        <th>Gambar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($blogs as $index => $blog)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $blog->title }}</td>
                            <td>{{ $blog->slug }}</td>
                            <td>
                                @if ($blog->image)
                                    <img src="{{ asset('storage/blogs/' . $blog->image) }}" alt="{{ $blog->title }}"
                                        width="80">
                                @else
                                    <span class="text-muted">Tidak ada gambar</span>
                                @endif
                            </td>
                            <td>
                                @if ($blog->status)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('blogs.show', $blog->slug) }}" class="btn btn-info btn-sm">Lihat</a>
                                <a href="{{ route('blogs.edit', $blog->slug) }}" class="btn btn-primary btn-sm">Edit</a>

                                <form id="delete-form-{{ $blog->slug }}"
                                    action="{{ route('blogs.destroy', $blog->slug) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="confirmDelete('{{ $blog->slug }}')">Hapus</button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data blog.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: "Yakin ingin menghapus?",
                text: "Data blog ini akan dihapus secara permanen!",
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
