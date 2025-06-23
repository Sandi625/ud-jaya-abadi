@extends('layout.master')
@section('title', 'Edit Guide')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h3 class="mb-4 text-dark fw-bold">Edit Guide</h3>

            <form action="{{ route('guide.update', $guide->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Nama Guide --}}
                <div class="mb-3">
                    <label for="nama_guide" class="form-label">Nama Guide</label>
                    <input type="text" id="nama_guide" name="nama_guide" class="form-control @error('nama_guide') is-invalid @enderror" value="{{ old('nama_guide', $guide->nama_guide) }}">
                    @error('nama_guide')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Salary --}}
               {{-- Salary Display (Tampilan untuk user) --}}
<div class="mb-3">
    <label for="salary_display" class="form-label">Gaji (Rp)</label>
    <input type="text" id="salary_display" class="form-control @error('salary') is-invalid @enderror" value="{{ old('salary', number_format($guide->salary, 0, ',', '.')) }}">

    {{-- Hidden input for submission --}}
    <input type="hidden" id="salary" name="salary" value="{{ old('salary', $guide->salary) }}">

    @error('salary')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


                {{-- Deskripsi --}}
                <div class="mb-3">
                    <label for="deskripsi_guide" class="form-label">Deskripsi</label>
                    <textarea id="deskripsi_guide" name="deskripsi_guide" rows="3" class="form-control @error('deskripsi_guide') is-invalid @enderror">{{ old('deskripsi_guide', $guide->deskripsi_guide) }}</textarea>
                    @error('deskripsi_guide')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- No HP --}}
                <div class="mb-3">
                    <label for="nomer_hp" class="form-label">Nomor HP</label>
                    <input type="text" id="nomer_hp" name="nomer_hp" class="form-control @error('nomer_hp') is-invalid @enderror" value="{{ old('nomer_hp', $guide->nomer_hp) }}">
                    @error('nomer_hp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Alamat --}}
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea id="alamat" name="alamat" rows="2" class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $guide->alamat) }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ $guide->email }}">

                </div>

                {{-- Bahasa --}}
                <div class="mb-3">
                    <label for="bahasa" class="form-label">Bahasa</label>
                    <input type="text" id="bahasa" name="bahasa" class="form-control @error('bahasa') is-invalid @enderror" value="{{ old('bahasa', $guide->bahasa) }}">
                    @error('bahasa')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Foto --}}
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto (Kosongkan jika tidak ingin diubah)</label>
                    <input type="file" id="foto" name="foto" class="form-control @error('foto') is-invalid @enderror">
                    @error('foto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @if ($guide->foto)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $guide->foto) }}" alt="Foto Guide" class="img-thumbnail" style="max-height: 150px;">
                        </div>
                    @endif
                </div>

                {{-- Status --}}
              <div class="mb-4">
    <label for="status" class="form-label">Status</label>
    <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
        <option disabled {{ old('status', $guide->status) === null ? 'selected' : '' }}>-- Pilih Status --</option>
        <option value="aktif" {{ old('status', $guide->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
        <option value="sedang_guiding" {{ old('status', $guide->status) == 'sedang_guiding' ? 'selected' : '' }}>Sedang Guiding</option>
        <option value="tidak_aktif" {{ old('status', $guide->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
    </select>
    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


                {{-- Buttons --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('guide.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left me-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save me-1"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    const display = document.getElementById('salary_display');
    const hidden = document.getElementById('salary');

    display.addEventListener('input', function () {
        let value = this.value.replace(/[^0-9]/g, '');
        hidden.value = value;
        this.value = formatRupiah(value);
    });

    function formatRupiah(value) {
        if (!value) return '';
        return 'Rp ' + value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }
</script>

@endsection
