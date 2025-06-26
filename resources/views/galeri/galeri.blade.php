<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <link rel="stylesheet" href="galeri.css">
    <link rel="stylesheet" href="https://unpkg.com/remixicon/fonts/remixicon.css">

    @include('__js.galeri')
    <style>
        .gallery-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); /* Membuat kolom otomatis */
    gap: 15px; /* Mengatur jarak antar gambar */
    padding: 20px;
}

.discover__card {
    position: relative;
    overflow: hidden;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.myImg {
    width: 100%;
    height: auto;
    object-fit: cover;
}



    </style>

    <!-- <link rel="stylesheet" href="bali.css"> -->
</head>
<body>
    <!-- Header -->
    <header>
        <h1>Welcome to the Gallery</h1>
        <!-- <h2>2 Day 1 Night</h2> -->
    </header>

    <!-- Navigation -->
    <nav class="nav">
        <div class="nav__logo">
            <img src="{{ asset('assets/img/logo.jpg') }}" alt="Brand Logo" style="height: 40px;">
        </div>
        <div class="nav__toggle" id="nav-toggle">&#9776;</div>
         <ul class="nav__menu" id="nav-menu">
        <li class="nav__item">
            <a href="{{ route('home') }}" class="nav__link active-link">Home</a>
        </li>
        <li class="nav__item">
            <a href="{{ route('home') }}#about" class="nav__link">About</a>
        </li>
        <li class="nav__item">
            <a href="{{ route('home') }}#discover" class="nav__link">Destination</a>
        </li>
        <li class="nav__item">
            <a href="{{ route('customer.packages') }}" class="nav__link">Tours</a>
        </li>
        <li class="nav__item">
            <a href="{{ route('galeri') }}" class="nav__link">Gallery</a>
        </li>
        <li class="nav__item">
            <a href="{{ route('review.review') }}" class="nav__link">Review</a>
        </li>

        {{-- Logout --}}
        @auth
        <li class="nav__item">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav__link" style="background:none; border:none; padding:0; cursor:pointer; color:inherit;">
                    Logout
                </button>
            </form>
        </li>
        @endauth

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

        <!-- Gallery Images -->
        <section class="gallery-container" id="image-gallery">
            @foreach ($galeris as $galeri)
                @if ($galeri->foto && file_exists(public_path('storage/' . $galeri->foto)))
                    <div class="discover__card image-item">
                        <img class="myImg" src="{{ asset('storage/' . $galeri->foto) }}" alt="{{ $galeri->judul }}" style="width:100%;max-width:300px">
                    </div>
                @endif
            @endforeach
        </section>

    </main>

    <!-- Footer -->
    <footer class="footer section">
        <div class="footer__container container grid">
            <div class="footer__content grid">
                <div class="footer__data">
                    <h3 class="footer__title">Travel</h3>
                    <p class="footer__description">Travel you choose the <br> destination, we offer you the <br> experience.</p>
                    <div>
                        <a href="https://www.facebook.com/profile.php?id=100090053510077" target="_blank" class="footer__social">
                            <i class="ri-facebook-box-fill"></i>
                        </a>
                        <a href="https://www.instagram.com/ijencratertour.indonesia/" target="_blank" class="footer__social">
                            <i class="ri-instagram-fill"></i>
                        </a>
                        <a href="https://www.youtube.com/@E__AHMADDHANIIRJA" target="_blank" class="footer__social">
                            <i class="ri-youtube-fill"></i>
                        </a>
                    </div>
                </div>

                <div class="footer__data">
                    <h3 class="footer__subtitle">About</h3>
                    <ul>
                        <li class="footer__item"><a href="" class="footer__link">About Us</a></li>
                        <li class="footer__item"><a href="" class="footer__link">Features</a></li>
                        <li class="footer__item"><a href="" class="footer__link">New & Blog</a></li>
                    </ul>
                </div>

                <div class="footer__data">
                    <h3 class="footer__subtitle">Company</h3>
                    <ul>
                        <li class="footer__item">
                            <a href="https://wa.me/+6282331489128?text=Hello!%20I%20would%20like%20to%20get%20in%20touch." target="_blank">
                                <i class="fab fa-whatsapp"></i> +6282331489128
                            </a>
                        </li>
                        <li class="footer__item">
                            <a href="https://wa.me/+6282132662815?text=Hello!%20I%20would%20like%20to%20get%20in%20touch." target="_blank">
                                <i class="fab fa-whatsapp"></i> +6282132662815
                            </a>
                        </li>
                        <li class="footer__item">
                            <a href="https://wa.me/+6281381117555?text=Hello!%20I%20would%20like%20to%20get%20in%20touch." target="_blank">
                                <i class="fab fa-whatsapp"></i> +6281381117555
                            </a>
                        </li>
                        <li class="footer__item">
                            <a href="#"><i class="fas fa-envelope"></i>Ijencratertour.indonesia@gmail.com</a>
                        </li>
                        <li class="footer__item">
                            <a href="#"><i class="fas fa-map"></i> Licin, Banyuwangi - 68464</a>
                        </li>
                    </ul>
                </div>

                <div class="footer__data">
                    <h3 class="footer__subtitle">Support</h3>
                    <ul>
                        <li class="footer__item"><a href="" class="footer__link">FAQs</a></li>
                        <li class="footer__item"><a href="" class="footer__link">Support Center</a></li>
                        <li class="footer__item"><a href="" class="footer__link">Contact Us</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer__rights">
                <p class="footer__copy">&#169; Ijen Creater Indonesia. All rights reserved.</p>
                <div class="footer__terms">
                    <a href="#" class="footer__terms-link">Terms & Agreements</a>
                    <a href="#" class="footer__terms-link">Privacy Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="bali.js"></script>

</body>

</html>
