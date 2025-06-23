@extends('layout.master')
@section('title', 'Daftar Penilaian')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h1 class="h4 fw-bold mb-4">Daftar Penilaian</h1>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="mb-3">
                <a href="{{ route('penilaian.create') }}" class="btn btn-success me-2">
                    <i class="fa fa-plus me-1"></i> Tambah Penilaian
                </a>
                {{-- <a href="{{ route('penilaian.all') }}" class="btn btn-primary">
                    <i class="fa fa-list me-1"></i> Lihat Keseluruhan
                </a> --}}
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Guide</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penilaians as $p)
                            <tr>
                                <td>{{ optional($p->guide)->nama_guide ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('penilaian.show', $p->id) }}" class="btn btn-success btn-sm">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('penilaian.edit', $p->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fa fa-pen-to-square"></i>
                                        </a>
                                        <button type="button" onclick="confirmDelete({{ $p->id }})" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                    <form id="delete-form-{{ $p->id }}" action="{{ route('penilaian.destroy', $p->id) }}" method="POST" class="d-none">
                                        @csrf @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="text-center text-muted">Belum ada data.</td></tr>
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
function confirmDelete(id){
    Swal.fire({
        title:"Apakah Anda yakin?",
        text:"Data ini akan dihapus permanen!",
        icon:"warning",
        showCancelButton:true,
        confirmButtonColor:"#d33",
        cancelButtonColor:"#3085d6",
        confirmButtonText:"Ya, hapus!",
        cancelButtonText:"Batal"
    }).then(res=>{
        if(res.isConfirmed){
            document.getElementById('delete-form-'+id).submit();
        }
    });
}
</script>
@endsection
