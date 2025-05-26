@extends('layout.master')
@section('title', 'Data Bahan')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Data Bahan</h4>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <a href="{{ route('bahan.create') }}" class="btn btn-primary mb-3">Tambah Bahan</a>

    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Bahan</th>
                        <th>Nama</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bahan as $item)
                    <tr>
                        <td>{{ $item->id_bahan }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->stok }}</td>
                        <td>
                            <a href="{{ route('bahan.edit', $item->id_bahan) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('bahan.destroy', $item->id_bahan) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus bahan ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Data bahan kosong.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
