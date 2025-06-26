@extends('layout.master')

@section('title', 'Detail Review')

@section('content')
    <div class="container py-4">
        <div class="bg-white shadow rounded p-4">
            <h2 class="text-center mb-4">Detail Review</h2>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Detail</th>
                        <th>Informasi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Nama</td>
                        <td>{{ $review->name }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{ $review->email }}</td>
                    </tr>
                    <tr>
                        <td>Rating</td>
                        <td>{{ $review->rating }}/5</td>
                    </tr>
                    <tr>
                        <td>Isi Testimoni</td>
                        <td>{{ $review->isi_testimoni }}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>{{ $review->status ? 'Aktif' : 'Nonaktif' }}</td>
                    </tr>
                    <tr>
                        <td>Photo</td>
                        <td>
                            @if ($review->photo)
                                <a href="{{ asset('storage/' . $review->photo) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $review->photo) }}" alt="Foto" style="max-width: 100px; max-height: 100px;">
                                </a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Dibuat Pada</td>
                        <td>{{ $review->created_at }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="text-center mt-4">
                <a href="{{ route('review.all') }}" class="btn btn-secondary">Kembali ke Daftar Review</a>
            </div>
        </div>
    </div>
@endsection
