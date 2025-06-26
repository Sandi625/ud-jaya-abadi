@extends('layout.master')

@section('title', 'Edit Review')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Edit Review</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('review.update', $review->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="guide_id" class="form-label">Nama Guide</label>
                    <select name="guide_id" class="form-control" required>
                        <option value="">-- Pilih Guide --</option>
                        @foreach ($guides as $guide)
                            <option value="{{ $guide->id }}" {{ $review->guide_id == $guide->id ? 'selected' : '' }}>
                                {{ $guide->nama_guide }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $review->name) }}" class="form-control"
                        required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $review->email) }}" class="form-control"
                        required>
                </div>

                <div class="mb-3">
                    <label for="rating" class="form-label">Rating</label>
                    <select name="rating" class="form-control" required>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ $review->rating == $i ? 'selected' : '' }}>
                                {{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="mb-3">
                    <label for="isi_testimoni" class="form-label">Isi Testimoni</label>
                    <textarea name="isi_testimoni" class="form-control" rows="4" required>{{ old('isi_testimoni', $review->isi_testimoni) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="photo" class="form-label">
                        Foto
                        <span class="text-red-500">(Maksimal 2MB)</span>
                    </label><br>
                    @if ($review->photo)
                        <img src="{{ asset('storage/' . $review->photo) }}" alt="Photo" width="100" class="mb-2">
                    @endif
                    <input type="file" name="photo" class="form-control">
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                </div>


                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ $review->status ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ !$review->status ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

                <a href="{{ route('review.all') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
@endsection
