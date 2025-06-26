@extends('layout.master')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Guide untuk Pesanan: {{ $pesanan->order_id }}</h1>

    <form action="{{ route('pilihguide.update', $pesanan->id) }}" method="POST">
        @csrf
        @method('PUT') {{-- penting untuk method update --}}

        <div class="form-group mb-3">
            <label for="guide_id">Pilih Guide Berdasarkan Rekomendasi:</label>
            <select name="guide_id" id="guide_id" class="form-control" required>
                <option value="" disabled>-- Pilih Guide --</option>
                @foreach($rekomendasi as $data)
                    <option value="{{ $data['guide']->id }}"
                        {{ $pesanan->id_guide == $data['guide']->id ? 'selected' : '' }}>
                        {{ $data['guide']->nama_guide }} - Rekomendasi (Total Nilai: {{ $data['nilai_total'] }})
                    </option>
                @endforeach
            </select>
            @error('guide_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
@endif

@if ($errors->has('guide_id'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ $errors->first('guide_id') }}',
            showConfirmButton: true,
        });
    </script>
@endif

@endsection
