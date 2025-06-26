@extends('layout.master')

@section('title', 'Tambah Review')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Tambah Review</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('review.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>

                {{-- Dropdown Guide --}}
                <div class="mb-3">
                    <label for="guide_id" class="form-label">Guide</label>
                    <select name="guide_id" class="form-control" required>
                        <option value="">Pilih Guide</option>
                        @foreach ($guides as $guide)
                            <option value="{{ $guide->id }}" {{ old('guide_id') == $guide->id ? 'selected' : '' }}>
                                {{ $guide->nama_guide }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="rating" class="form-label">Rating</label>
                    <select name="rating" class="form-control" required>
                        <option value="">Pilih rating</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
                                {{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="mb-3">
                    <label for="pesanan_id" class="form-label">Pesanan</label>
                    <select name="pesanan_id" class="form-control" required>
                        <option value="">Pilih Pesanan</option>
                        @foreach ($pesanans as $pesanan)
                            <option value="{{ $pesanan->id }}" {{ old('pesanan_id') == $pesanan->id ? 'selected' : '' }}>
                                {{ $pesanan->kode_pesanan ?? 'Pesanan #' . $pesanan->id }}
                                - {{ $pesanan->user->name ?? ($pesanan->customer->name ?? 'Nama pemesan tidak tersedia') }}
                                - {{ $pesanan->paket->nama_paket ?? 'Paket tidak tersedia' }}
                            </option>
                        @endforeach
                    </select>
                </div>




                <div class="mb-3">
                    <label for="isi_testimoni" class="form-label">Isi Testimoni</label>
                    <textarea name="isi_testimoni" class="form-control" rows="4" required>{{ old('isi_testimoni') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="photo" class="form-label">
                        Foto
                        <span class="text-red-500">(Maksimal 2MB)</span>
                    </label>
                    <input type="file" name="photo" class="form-control" accept="image/*">
                    <small class="text-muted">Opsional. Jika tidak diisi, akan menggunakan avatar default.</small>
                </div>




                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

                <a href="{{ route('review.all') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
@endsection
