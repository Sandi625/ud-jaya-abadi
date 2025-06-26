@extends('layout.master')

@section('content')
<div class="container">
    <h1 class="mb-4">Pilih Guide untuk Pesanan: {{ $pesanan->order_id }}</h1>

    <form action="{{ route('pilihguide.store', $pesanan->id) }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="guide_id">Pilih Guide Berdasarkan Rekomendasi:</label>
            <select name="guide_id" id="guide_id" class="form-control" required>
                <option value="" disabled selected>-- Pilih Guide --</option>
                @foreach($rekomendasi as $data)
                    <option value="{{ $data['guide']->id }}">
                        {{ $data['guide']->nama_guide }} - Rekomendasi (Total Nilai: {{ $data['nilai_total'] }})
                    </option>
                @endforeach
            </select>
            @error('guide_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    </form>
</div>
@endsection



