@extends('layout.pelanggan')
@php
    use Illuminate\Support\Facades\Auth;
@endphp
@section('content')
    <section id="add-review" class="review-section">
        <div class="container">
            <h2>Add Your Review</h2>
            <form id="review-form" action="{{ route('review.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Your Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your name"
                        value="{{ old('name', Auth::user()->name ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Your Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email"
                        value="{{ old('email', Auth::user()->email ?? '') }}" required>
                </div>
              <div class="form-group guide-select-wrapper">
    <label for="guide_id">Your Guide is</label>
    <select id="guide_id" class="form-control" disabled>
        <option value="" disabled {{ empty($selectedGuideId) ? 'selected' : '' }}>-- Pilih Guide --</option>
        @foreach ($guides as $guide)
            <option value="{{ $guide->id }}" {{ $selectedGuideId == $guide->id ? 'selected' : '' }}>
                {{ $guide->nama_guide }}
            </option>
        @endforeach
    </select>

    {{-- Hidden input supaya id tetap dikirim meskipun select-nya disabled --}}
    @if(!empty($selectedGuideId))
        <input type="hidden" name="guide_id" value="{{ $selectedGuideId }}">
    @endif
</div>

    @if(!empty($selectedGuideId))
        <input type="hidden" name="guide_id" value="{{ $selectedGuideId }}">
    @endif

    @if (!empty($pesanan))
        <input type="hidden" name="pesanan_id" value="{{ $pesanan->id }}">
    @endif












                <div class="form-group">
                    <label for="rating">Rating</label>
                    <select id="rating" name="rating" required>
                        <option value="" disabled selected>Select your rating</option>
                        <option value="5">5 - Excellent</option>
                        <option value="4">4 - Very Good</option>
                        <option value="3">3 - Good</option>
                        <option value="2">2 - Fair</option>
                        <option value="1">1 - Poor</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="isi_testimoni">Your Review</label>
                    <textarea id="isi_testimoni" name="isi_testimoni" rows="4" placeholder="Share your experience" required></textarea>
                </div>
                <div class="form-group">
                    <label for="photo">Upload a Photo (optional)</label>
                    <input type="file" id="photo" name="photo" accept="image/*">
                </div>
                <button type="submit" class="btn-submit">Submit Review</button>
            </form>
        </div>
    </section>

    @if (session('success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Succeed!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    @if ($errors->any())
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ $errors->first() }}',
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    <section class="testimonials section">
        <h2 class="section-title">Testimoni</h2>
        <div class="bd-container testimonials__container">
            @if (isset($reviews) && $reviews->count())
                @foreach ($reviews as $review)
                    <div class="testimonials__card">
                        <div class="testimonials__header">
                            <div class="testimonials__image">
                                <img src="{{ $review->photo && $review->photo !== 'images/default-avatar.jpg' ? asset('storage/' . $review->photo) : asset('images/default-avatar.jpg') }}"
                                    alt="{{ $review->name }}">
                            </div>
                            <div>
                                <div class="testimonials__name">{{ $review->name }}</div>
                                <div class="testimonials__rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span class="star">{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <p class="testimonials__description">
                            "{{ $review->isi_testimoni }}"
                        </p>
                    </div>
                @endforeach
            @else
                <p class="text-center">Belum ada testimoni tersedia.</p>
            @endif
        </div>
    </section>
@endsection

@push('styles')
    <!-- Add Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
@endpush

@push('scripts')
    <!-- Add Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="{{ asset('js/bali.js') }}"></script>
@endpush
