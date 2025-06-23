@extends('layout.master')
@section('title', 'Edit Pesanan')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h3 class="mb-4 text-dark">Edit Pesanan</h3>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('pesanan.update', $pesanan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="hidden" name="id_paket" value="{{ $pesanan->id_paket }}">

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama', $pesanan->nama) }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $pesanan->email) }}" required>
                </div>

                <div class="mb-3">
                    <label for="nomor_telp" class="form-label">Nomor Telepon</label>
                    <input type="text" name="nomor_telp" class="form-control" value="{{ old('nomor_telp', $pesanan->nomor_telp) }}" required>
                </div>

                <div class="mb-3">
                    <label for="tanggal_pesan" class="form-label">Tanggal Pesan</label>
                    <input type="date" name="tanggal_pesan" class="form-control" value="{{ old('tanggal_pesan', $pesanan->tanggal_pesan->format('Y-m-d')) }}" required>
                </div>

                <div class="mb-3">
                    <label for="tanggal_keberangkatan" class="form-label">Tanggal Keberangkatan</label>
                    <input type="date" name="tanggal_keberangkatan" class="form-control" value="{{ old('tanggal_keberangkatan', $pesanan->tanggal_keberangkatan->format('Y-m-d')) }}" required>
                </div>

                <div class="mb-3">
                    <label for="jumlah_peserta" class="form-label">Jumlah Peserta</label>
                    <input type="number" name="jumlah_peserta" class="form-control" min="1" value="{{ old('jumlah_peserta', $pesanan->jumlah_peserta) }}" required>
                </div>

                <div class="mb-3">
                    <label for="negara" class="form-label">Negara</label>
                    <input type="text" name="negara" class="form-control" value="{{ old('negara', $pesanan->negara) }}" required>
                </div>

                <div class="mb-3">
                    <label for="bahasa" class="form-label">Bahasa</label>
                    <input type="text" name="bahasa" class="form-control" value="{{ old('bahasa', $pesanan->bahasa) }}" required>
                </div>

                <div class="mb-3">
                    <label for="riwayat_medis" class="form-label">Riwayat Medis</label>
                    <textarea name="riwayat_medis" class="form-control" required>{{ old('riwayat_medis', $pesanan->riwayat_medis) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="id_kriteria" class="form-label">Pilih Kriteria</label>
                    <select name="id_kriteria[]" class="form-select" multiple required>
                        @foreach($kriterias as $kriteria)
                            <option value="{{ $kriteria->id }}"
                                {{ in_array($kriteria->id, $selectedKriterias) ? 'selected' : '' }}>
                                {{ $kriteria->nama }} ({{ $kriteria->bobot }}%)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="paspor" class="form-label">Paspor (Opsional)</label>
                    <input type="file" name="paspor" class="form-control">
                    @if($pesanan->paspor)
                        <small class="d-block mt-1">File saat ini: <a href="{{ asset('storage/' . $pesanan->paspor) }}" target="_blank">Lihat Paspor</a></small>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="special_request" class="form-label">Permintaan Khusus</label>
                    <textarea name="special_request" class="form-control">{{ old('special_request', $pesanan->special_request) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="kebutuhan_guide" class="form-label">Kebutuhan Guide</label>
                    <input type="text" name="kebutuhan_guide" class="form-control" value="{{ old('kebutuhan_guide', $pesanan->kebutuhan_guide) }}">
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="1" {{ $pesanan->status == 1 ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ $pesanan->status == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">Update Pesanan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
