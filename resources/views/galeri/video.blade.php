<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery Videos</title>
    <link rel="stylesheet" href="{{ asset('galeri.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/remixicon/fonts/remixicon.css">

    @include('__js.galeri')

</head>
<body>
    <!-- Header -->
    <header>
        <h1>Welcome to the Video Gallery</h1>
    </header>

    <!-- Navigation -->
    <nav class="nav">
        <div class="nav__logo">
            <img src="{{ asset('assets/img/logo.jpg') }}" alt="Brand Logo" style="height: 40px;">
        </div>
        <div class="nav__toggle" id="nav-toggle">&#9776;</div>
        <ul class="nav__menu" id="nav-menu">
            <li class="nav__item"><a href="{{ route('home') }}" class="nav__link">Home</a></li>
            <li class="nav__item"><a href="{{ route('home') }}#about" class="nav__link">About</a></li>
            <li class="nav__item"><a href="{{ route('home') }}#discover" class="nav__link">Destination</a></li>
            <li class="nav__item"><a href="{{ route('home') }}#place" class="nav__link">Tours</a></li>
            <li class="nav__item"><a href="{{ route('galeri') }}" class="nav__link">Gallery</a></li>
              <li class="nav__item">
            <a href="{{ route('review.review') }}" class="nav__link">Review</a>
        </li>


            <div class="nav__close" id="nav-close">&times;</div>
        </ul>
    </nav>

    <!-- Main Section -->
    <main class="main">
        <!-- Gallery Options -->
        <section class="section">
            <h2 class="section__title">Video Gallery</h2>
            <div class="gallery-options">
                <a href="{{ route('galeri') }}">
                    <button>Images</button>
                </a>
                <a href="{{ route('galeri.video') }}">
                    <button>Videos</button>
                </a>
            </div>
        </section>

        <!-- Gallery Videos -->
        <section class="gallery-container" id="video-gallery">
            @foreach ($galeris as $galeri)
                @if ($galeri->videoyoutube)
                    <div class="video-card">
                        <div class="video-item">
                            {{-- Cek apakah videoyoutube adalah URL lengkap atau hanya ID --}}
                            @php
                                $videoId = $galeri->videoyoutube;
                                // Jika videoyoutube mengandung URL lengkap, ekstrak ID video dari URL
                                if (preg_match('/youtu.be\/([a-zA-Z0-9_-]+)/', $galeri->videoyoutube, $matches)) {
                                    $videoId = $matches[1];  // ambil ID dari URL "youtu.be"
                                } elseif (preg_match('/youtube.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed))\/|(?:watch\?v=))([^"&?\/\s]{11})/', $galeri->videoyoutube, $matches)) {
                                    $videoId = $matches[1];  // ambil ID dari URL "youtube.com"
                                }
                            @endphp
                            <iframe src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allowfullscreen></iframe>
                        </div>
                        <div class="card-body">
                            <h3>{{ $galeri->judul ?? 'Video Title' }}</h3>
                            <p>{{ $galeri->deskripsi ?? 'Video description goes here.' }}</p>
                        </div>
                    </div>
                @elseif ($galeri->videolokal && file_exists(public_path('storage/' . $galeri->videolokal)))
                    <div class="video-card">
                        <div class="video-item">
                            <video controls>
                                <source src="{{ asset('storage/' . $galeri->videolokal) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                        <div class="card-body">
                            <h3>{{ $galeri->judul ?? 'Local Video Title' }}</h3>
                            <p>{{ $galeri->deskripsi ?? 'Local video description goes here.' }}</p>
                        </div>
                    </div>
                @endif
            @endforeach
        </section>

    </main>

    <!-- Footer -->
    {{-- <footer class="footer section">
        @include('layouts.footer') <!-- Kalau footer panjang, enak dipisah partial -->
    </footer> --}}

    <!-- JavaScript -->
    <script src="{{ asset('bali.js') }}"></script>
</body>

</html>
