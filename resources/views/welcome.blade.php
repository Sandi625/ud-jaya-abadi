<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="assets/img/logo.jpg" type="image/png">

    <!--=============== REMIXICONS ===============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

    <!--=============== SWIPER CSS ===============-->
    <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <!--=============== CSS ===============-->
    {{-- <link rel="stylesheet" href="../../public/css/styles.css"> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">




    <title>IJEN CREATER INDONESIA</title>

</head>

<body>
    <header class="header" id="header">
        <nav class="nav container">
            <a href="index.html" class="nav__logo">
                <img src="assets/img/logo.jpg" alt="IJEN CRATER TOUR INDONESIA">
            </a>

            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                    <li class="nav__item">
                        <a href="#home" class="nav__link active-link">Home</a>
                    </li>
                    <li class="nav__item">
                        <a href="#about" class="nav__link">About</a>
                    </li>
                    <li class="nav__item">
                        <a href="#discover" class="nav__link">Destination</a>
                    </li>
                    <li class="nav__item">
                        <a href="#tour-pakets" class="nav__link">Tours</a>
                    </li>
                    <li class="nav__item">
                        <a href="{{ route('galeri') }}" class="nav__link">Gallery</a>
                    </li>
                    <li class="nav__item">
                        @auth
                            <a href="{{ route('review.review') }}" class="nav__link">Review</a>
                        @else
                            <a href="#" class="nav__link" onclick="showLoginAlert()">Review</a>
                        @endauth
                    </li>

                    <li class="nav__item">
                        <a href="{{ route('blog.list') }}" class="nav__link">Blogs</a>
                    </li>
                    <li class="nav__item">
                        <a href="/login" class="nav__link">Login</a>
                    </li>

                    <!-- Add this block for login/logout button -->


                </ul>

                <!-- Theme change button -->
                <div class="nav__dark">
                    <span class="change-theme-name">Dark mode</span>
                    <i class="ri-moon-line change-theme" id="theme-button"></i>
                </div>

                <i class="ri-close-line nav__close" id="nav-close"></i>
            </div>

            <div class="nav__toggle" id="nav-toggle">
                <i class="ri-function-line"></i>
            </div>
        </nav>
    </header>

    <main class="main">
        <!--==================== HOME ====================-->
        <section class="home" id="home">
            <img src="{{ asset('assets/img/1ijen.jpg') }}" alt="" class="home__img">

            <div class="home__container container grid">
                <div class="home__data">
                    <span class="home__data-subtitle">Discover your place</span>
                    <h1 class="home__data-title">Explore The <br> Best <b>Beautiful <br> Mountain And Beaches </b></h1>
                    <a href="#about" class="button">Explore</a>
                </div>

                <div class="home__social">
                    <a href="https://www.facebook.com/profile.php?id=100090053510077" target="_blank"
                        class="home__social-link">
                        <i class="ri-facebook-box-fill"></i>
                    </a>
                    <a href="https://www.instagram.com/ijencratertour.indonesia/" target="_blank"
                        class="home__social-link">
                        <i class="ri-instagram-fill"></i>
                    </a>
                    {{-- <a href="https://twitter.com/" target="_blank" class="home__social-link">
                        <i class="ri-twitter-fill"></i>
                    </a> --}}
                </div>

                <div class="home__info">
                    <div>
                        <span class="home__info-title">3 best places to visit</span>
                        <a href="#discover" class="button button--flex button--link home__info-button">
                            More <i class="ri-arrow-right-line"></i>
                        </a>
                    </div>

                    <div class="home__info-overlay">
                        <img src="{{ asset('assets/img/48.jpg') }}" alt="" class="home__info-img">
                    </div>
                </div>
            </div>
        </section>

        <div class="whatsapp-logo" onclick="redirectToWhatsApp()">
            <i class="fab fa-whatsapp"></i>
        </div>

        <!--==================== ABOUT ====================-->
        <section class="about section" id="about">
            <div class="about__container container grid">
                <div class="about__data">
                    <h2 class="section__title about__title">IJEN CRATER TOUR INDONESIA</h2>
                    <p class="about__description">
                        Ijen Crater Tour Indonesia is your trusted partner in planning an unforgettable vacation. We
                        offer special services to help you explore your dream destination easily and comfortably. We’re
                        committed to providing travel solutions tailored to your needs and preferences, whether for a
                        family holiday, private trip, or backpacking adventure. We help you plan every detail of the
                        trip, from tourist destinations to exciting local activities. Contact us to plan an
                        unforgettable and fun trip!!
                    </p>
                    <p class="about__description">
                        <!-- Tour Village !! Provide an immersive experience of the life and culture of a village. This tour combines natural exploration, interaction with local residents, and participation in traditional activities. Exploring a tour village is an ideal way to experience authentic village life, learn from local culture, and enjoy the beauty of nature while interacting directly with the local community. -->
                    </p>
                    <a href="#tour-pakets" class="button">Reserve a place</a>
                </div>

                <div class="about__img">
                    <div class="about__img-overlay">
                        <img src="{{ asset('assets/img/15.jpg') }}" alt="Ijen Crater" class="about__img-one">
                    </div>

                    <div class="about__img-overlay">
                        <img src="{{ asset('assets/img/bali.jpg') }}" alt="Bali" class="about__img-two">
                    </div>
                </div>
            </div>
        </section>




        <!--==================== DISCOVER ====================-->
        <section class="discover section" id="discover">
            <h2 class="section__title">Discover the most <br> attractive places</h2>

            <div class="discover__container container swiper-container">
                <div class="swiper-wrapper">
                    <!--==================== DISCOVER 1 ====================-->
                    <div class="discover__card swiper-slide">
                        <img src="assets/img/tebing.jpg" alt="" class="discover__img">
                        <div class="discover__data">
                            <h2 class="discover__title">Bali</h2>
                            <span class="discover__description"> tours available</span>
                        </div>
                    </div>

                    <!--==================== DISCOVER 2 ====================-->
                    <div class="discover__card swiper-slide">
                        <img src="assets/img/ijentree.jpg" alt="" class="discover__img">
                        <div class="discover__data">
                            <h2 class="discover__title">Ijen</h2>
                            <span class="discover__description"> tours available</span>
                        </div>
                    </div>

                    <!--==================== DISCOVER 3 ====================-->
                    <div class="discover__card swiper-slide">
                        <img src="assets/img/bromo.jpg" alt="" class="discover__img">
                        <div class="discover__data">
                            <h2 class="discover__title">Bromo</h2>
                            <span class="discover__description"> tours available</span>
                        </div>
                    </div>

                    <!--==================== DISCOVER 4 ====================-->
                    <!-- <div class="discover__card swiper-slide">
                            <img src="assets/img/bromo.jpg" alt="" class="discover__img">
                            <div class="discover__data">
                                <h2 class="discover__title">Bromo</h2>
                                <span class="discover__description">32 tours available</span>
                            </div>
                        </div> -->

                </div>
            </div>
        </section>

        <!--==================== SHOP ====================-->

        <!--==================== SHOP ====================-->
        <section class="shop-section">
            <div class="container">
                <h2 class="section-title">Our Products</h2>
                <p class="section-description">Discover our exclusive range of high-quality products, carefully curated
                    to meet your needs and exceed your expectations. From stylish apparel to innovative gadgets, each
                    item in our collection is designed to offer both functionality and flair. Explore our selection and
                    find your next favorite product today!</p>
                <div class="shop">
                    <div class="swiper-container shop-swiper-container">
                        <div class="swiper-wrapper">
                            <!-- Swiper Slide 1 -->

                            <div class="swiper-slide">
                                <div class="shop-card" style="width: 18rem;">
                                    <img src="assets/img/jkl laguna.jpg" class="shop-card__img card-img-top"
                                        alt="Product image">
                                    <div class="shop-card__content card-body">
                                        <h5 class="shop-card__title card-title">Mountain Jacket</h5>
                                        <p class="shop-card__description">Stay warm and protected with our mountain
                                            jacket. Featuring a weather-resistant design, it’s ideal for rugged outdoor
                                            adventures.</p>
                                        {{-- <a href="#" class="shop-card__button btn btn-primary">Learn More</a> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="shop-card" style="width: 18rem;">
                                    <img src="assets/img/kupluk.jpeg" class="shop-card__img card-img-top"
                                        alt="Product image">
                                    <div class="shop-card__content card-body">
                                        <h5 class="shop-card__title card-title">Stylish Beanie</h5>
                                        <p class="shop-card__description">Keep warm and look stylish with our premium
                                            beanie. Made from soft, high-quality fabric, this beanie is perfect for any
                                            season.</p>
                                        {{-- <a href="#" class="shop-card__button btn btn-primary">Learn More</a> --}}
                                    </div>
                                </div>
                            </div>
                            <!-- Swiper Slide 2 -->
                            <div class="swiper-slide">
                                <div class="shop-card" style="width: 18rem;">
                                    <img src="assets/img/lutek.png" class="shop-card__img card-img-top"
                                        alt="Product image">
                                    <div class="shop-card__content card-body">
                                        <h5 class="shop-card__title card-title">Hiking Stick</h5>
                                        <p class="shop-card__description">Enhance your hiking experience with our
                                            durable hiking stick. Designed for comfort and support, it’s perfect for any
                                            trail.</p>
                                        {{-- <a href="#" class="shop-card__button btn btn-primary">Learn More</a> --}}
                                    </div>
                                </div>
                            </div>
                            <!-- Swiper Slide 3 -->

                            <!-- Swiper Slide 4 -->
                            <div class="swiper-slide">
                                <div class="shop-card" style="width: 18rem;">
                                    <img src="assets/img/download.jpeg" class="shop-card__img card-img-top"
                                        alt="Product image">
                                    <div class="shop-card__content card-body">
                                        <h5 class="shop-card__title card-title">Gas Mask</h5>
                                        <p class="shop-card__description">Stay safe in challenging environments with
                                            our high-quality gas mask. Designed for protection and comfort, it’s
                                            essential for any serious adventurer.</p>
                                        {{-- <a href="#" class="shop-card__button btn btn-primary">Learn More</a> --}}
                                    </div>
                                </div>
                            </div>
                            <!-- Add more slides as needed -->
                        </div>
                        <!-- Swiper Pagination -->
                        <div class="swiper-pagination"></div>
                        <!-- Swiper Navigation -->
                        <!-- <div class="swiper-button-next"></div> -->
                        <!-- <div class="swiper-button-prev"></div> -->
                    </div>

                </div>
            </div>
        </section>









        <!--==================== EXPERIENCE ====================-->
        <section class="experience section">
            <h2 class="section__title">With Our Experience <br> We Will Serve You</h2>

            <div class="experience__container container grid">
                <div class="experience__content grid">
                    <div class="experience__data">
                        <h2 class="experience__number">20</h2>
                        <span class="experience__description">Year <br> Experience</span>
                    </div>

                    <div class="experience__data">
                        <h2 class="experience__number">75</h2>
                        <span class="experience__description">Complete <br> tours</span>
                    </div>

                    <div class="experience__data">
                        <h2 class="experience__number">650+</h2>
                        <span class="experience__description">Tourist <br> Destination</span>
                    </div>
                </div>

                <div class="experience__img grid">
                    <div class="experience__overlay">
                        <img src="assets/img/26ww.jpg" alt="" class="experience__img-one">
                    </div>

                    <div class="experience__overlay">
                        <img src="assets/img/35.jpg" alt="" class="experience__img-two">
                    </div>
                </div>
            </div>
        </section>

        <!--==================== VIDEO ====================-->
  <section class="video section">
    <h2 class="section__title">Video Tour</h2>

    <div class="video__container container">
        <p class="video__description">
            Find out more with our video of the most beautiful and pleasant places for you and your family.
        </p>

        <div class="video__content">
            <div id="video-container"
                style="position: relative; width: 100%; height: 0; padding-bottom: 56.25%;">
                <iframe id="youtube-video"
                    src="https://www.youtube.com/embed/BFp5pZwccAE"
                    title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;">
                </iframe>
            </div>
        </div>
    </div>
</section>



        <!--==================== TOUR PAKETS ====================-->
        <section id="tour-pakets">
            <h2 class="section-title">Tour Pakets</h2>
            <div class="bd-container testimonials__container">
                @foreach ($pakets as $paket)
                    <div class="testimonials__card">
                        <div class="testimonials__image">
                            @if ($paket->foto)
                                @auth
                                    <a href="{{ route('login', ['id_paket' => $paket->id]) }}">
                                        <img src="{{ asset('storage/' . $paket->foto) }}" alt="Foto Paket"
                                            class="w-full h-40 object-cover rounded-lg hover:opacity-90 transition-opacity duration-300">
                                    </a>
                                @else
                                    <a href="#" onclick="showLoginAlert()">
                                        <img src="{{ asset('storage/' . $paket->foto) }}" alt="Foto Paket"
                                            class="w-full h-40 object-cover rounded-lg hover:opacity-90 transition-opacity duration-300">
                                    </a>
                                @endauth
                            @else
                                <p>Foto tidak tersedia</p>
                            @endif
                        </div>
                        <div class="testimonials__info">
                            <h3 class="testimonials__name">{{ $paket->nama_paket }}</h3>
                            <p class="testimonials__description">{{ Str::limit($paket->deskripsi_paket, 100) }}</p>
                            <p class="testimonials__duration">Durasi: {{ $paket->durasi }}</p>

                            @auth
                                <a href="{{ route('login', ['id_paket' => $paket->id]) }}"
                                    class="inline-block mt-4 px-6 py-2.5 bg-gradient-to-r from-green-500 to-green-700 text-white font-semibold text-sm rounded-full shadow-lg hover:from-green-600 hover:to-green-800 transition-all duration-300 ease-in-out">
                                    💼 Klik For More
                                </a>
                            @else
                                <a href="#" onclick="showLoginAlert()"
                                    class="inline-block mt-4 px-6 py-2.5 bg-gradient-to-r from-green-500 to-green-700 text-white font-semibold text-sm rounded-full shadow-lg hover:from-green-600 hover:to-green-800 transition-all duration-300 ease-in-out">
                                    💼 Klik For More
                                </a>
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        <!--==================== Review ====================-->



<section class="review-marquee">
    <div class="review-track">

        @foreach($reviews as $review)
            <div class="review-card">
                <img src="{{ $review->photo && $review->photo !== 'images/default-avatar.jpg' ? asset('storage/' . $review->photo) : asset('images/default-avatar.jpg') }}" alt="Photo of {{ $review->name }}">
                <h5>{{ $review->name }}</h5>

                <p>{{ $review->isi_testimoni }}</p>
                <div>Rating: ⭐ {{ $review->rating }}/5</div>
            </div>
        @endforeach


        @foreach($reviews as $review)
            <div class="review-card">
                <img src="{{ $review->photo && $review->photo !== 'images/default-avatar.jpg' ? asset('storage/' . $review->photo) : asset('images/default-avatar.jpg') }}" alt="Photo of {{ $review->name }}">
                <h5>{{ $review->name }}</h5>

                <p>{{ $review->isi_testimoni }}</p>
                <div>Rating: ⭐ {{ $review->rating }}/5</div>
            </div>
        @endforeach
    </div>
</section>








        <!-- SweetAlert2 CDN -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            function showLoginAlert() {
                Swal.fire({
                    title: 'Login Required',
                    text: 'You must login to make a acces more.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Login Now',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('login') }}";
                    }
                });
            }
        </script>






        <!-- In your welcome.blade.php -->





        {{-- <section class="blogs" id="blogs">
        <h1 class="heading">Our Daily Blogs</h1>

        <div class="swiper blogs-slider">
            <div class="swiper-wrapper">
                @foreach ($blogs as $blog)
                    <div class="swiper-slide slide">
                        <!-- Displaying the image -->
                        @if ($blog->image)
                            <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}">
                        @else
                            <img src="{{ asset('images/default.jpg') }}" alt="Default Image">
                        @endif

                        <div class="icons">
                            <a href="#"> <i class="fas fa-calendar"></i> {{ $blog->created_at->format('d F, Y') }}</a>
                            <a href="#"> <i class="fas fa-user"></i> by admin</a>
                        </div>
                        <h3>{{ $blog->title }}</h3>
                        <p>{{ Str::limit($blog->body, 100) }}</p>
                        <a href="{{ route('blogs.show', $blog->slug) }}" class="btn">Read More</a>
                    </div>
                @endforeach
            </div>
        </div>
    </section> --}}





        {{-- @if (session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        if (!sessionStorage.getItem('alertShown')) {
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
            sessionStorage.setItem('alertShown', 'true');
        }

        // Hapus flag setelah beberapa saat agar bisa muncul di pemesanan berikutnya
        setTimeout(() => {
            sessionStorage.removeItem('alertShown');
        }, 30000);
    </script>
@endif --}}



        <style>
            /* Basic styling */
            .section-title {
                text-align: center;
                font-size: 2rem;
                margin-bottom: 2rem;
                color: var(--primary-text-color);
            }

            /* Container flex dengan wrap */
            .bd-container {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 1.5rem;
                padding: 1rem;
            }

            /* Card styling */
            .testimonials__card {
                background-color: var(--card-bg-color);
                border-radius: 10px;
                box-shadow: 0 4px 8px var(--hover-effect-color);
                overflow: hidden;
                display: flex;
                flex-direction: column;
                text-align: center;
                padding: 1rem;
                transition: transform 0.3s ease-in-out;

                /* Ukuran untuk 3 per baris */
                width: calc(33.33% - 1rem);
                /* 3 per baris */
                max-width: 300px;
            }

            .testimonials__card:hover {
                transform: translateY(-10px);
                background-color: var(--card-hover-bg-color);
            }

            .testimonials__image {
                margin-bottom: 1rem;
                height: 200px;
            }

            .testimonials__image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 8px;
            }

            .testimonials__info {
                padding: 0.5rem;
            }

            .testimonials__name {
                font-size: 1.5rem;
                font-weight: bold;
                margin-bottom: 0.5rem;
                color: var(--primary-text-color);
            }

            .testimonials__description {
                font-size: 1rem;
                color: var(--secondary-text-color);
                margin-bottom: 0.5rem;
            }

            .testimonials__price,
            .testimonials__duration,
            .testimonials__destinasi,
            .testimonials__include,
            .testimonials__exclude {
                font-size: 0.9rem;
                margin: 0.2rem 0;
                color: var(--primary-text-color);
            }

            .testimonials__price {
                font-weight: bold;
            }

            .testimonials__include {
                color: var(--include-color);
                /* Warna hijau */
            }

            .testimonials__exclude {
                color: var(--exclude-color);
                /* Warna merah */
            }

            /* Responsive */
            @media screen and (max-width: 992px) {
                .testimonials__card {
                    width: calc(33.33% - 1rem);
                    /* 3 per baris (untuk ukuran layar PC) */
                }
            }

            @media screen and (max-width: 600px) {
                .testimonials__card {
                    width: 100%;
                    /* 1 per baris */
                }

                .testimonials__image {
                    height: 180px;
                }
            }
        </style>













        <!--==================== EMAIL ====================-->
        {{-- <section class="section">
    <div class="card email-card">
        <form method="post" action="https://formspree.io/f/xknlyagv">
            <h1 class="heading">Contact us via Email</h1>
            <p>Don't hesitate to get in touch with us if you need further details about our tour. We are fully equipped to offer you all the information necessary to create an unforgettable travel experience. Waste no time; reach out to us now and explore the thrilling adventure that awaits you!</p>
            <div class="mb-3">
                <label for="full-name" class="form-label">Full Name</label>
                <input type="text" name="full-name" class="form-control" id="full-name" placeholder="Enter Your Fullname">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Enter Your Email">
            </div>
            <div class="mb-3">
                <label for="subject" class="form-label">Subject</label>
                <input type="text" name="subject" class="form-control" id="subject" placeholder="Enter Your Subject">
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea name="message" class="form-control" id="message" rows="3" placeholder="Enter Your Message"></textarea>
            </div>
            <div class="mb-3">
                <input class="custom-submit-button" type="submit" value="Submit">
            </div>
        </form>
    </div>
</section> --}}





        <!--==================== SPONSORS ====================-->
        <section class="sponsor section">
            <div class="sponsor__container container grid">
                <div class="sponsor__content">
                    <img src="assets/img/sponsors1.png" alt="" class="sponsor__img">
                </div>
                {{-- <div class="sponsor__content">
                    <img src="assets/img/sponsors2.png" alt="" class="sponsor__img">
                </div>
                <div class="sponsor__content">
                    <img src="assets/img/sponsors3.png" alt="" class="sponsor__img">
                </div>
                <div class="sponsor__content">
                    <img src="assets/img/sponsors4.png" alt="" class="sponsor__img">
                </div>
                <div class="sponsor__content">
                    <img src="assets/img/sponsors5.png" alt="" class="sponsor__img">
                </div> --}}
                <!-- New TripAdvisor Sponsor -->
                <div class="sponsor__content">
                    <img src="assets/img/tt.png" alt="TripAdvisor" class="sponsor__img">
                </div>
            </div>
        </section>



        <!--==================== MAPS ====================-->
        <section class="maps section">
            <div class="maps__container container">
                <h2 class="section__title">Our Location</h2>
                <div class="maps__content">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d709.5816697941696!2d114.2573701416686!3d-8.205609772008037!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd14f6d1d6614bb%3A0xf9c55b4687931297!2sPT.%20IJEN%20CRATER%20TOUR%20INDONESIA!5e0!3m2!1sen!2sid!4v1724565411781!5m2!1sen!2sid"
                        width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </section>



    </main>

    <!--==================== FOOTER ====================-->
    <footer class="footer section">
        <div class="footer__container container grid">
            <div class="footer__content grid">
                <div class="footer__data">
                    <h3 class="footer__title">Travel</h3>
                    <p class="footer__description">Travel you choose the <br> destination,
                        we offer you the <br> experience.
                    </p>
                    <div>
                        <a href="https://www.facebook.com/profile.php?id=100090053510077" target="_blank"
                            class="footer__social">
                            <i class="ri-facebook-box-fill"></i>
                        </a>
                        <!-- <a href="https://twitter.com/" target="_blank" class="footer__social">
                                <i class="ri-twitter-fill"></i>
                            </a> -->
                        <a href="https://www.instagram.com/ijencratertour.indonesia/" target="_blank"
                            class="footer__social">
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
                        <li class="footer__item">
                            <a href="" class="footer__link">About Us</a>
                        </li>
                        <li class="footer__item">
                            <a href="" class="footer__link">Features</a>
                        </li>
                        <li class="footer__item">
                            <a href="" class="footer__link">New & Blog</a>
                        </li>
                    </ul>
                </div>

                <div class="footer__data">
                    <h3 class="footer__subtitle">Contact</h3>
                    <ul>
                        {{-- <li class="footer__item">
                            <a href="https://wa.me/+6282331489128?text=Hello!%20I%20would%20like%20to%20get%20in%20touch." target="_blank">
                                <i class="fab fa-whatsapp"></i> +6282331489128
                            </a>
                        </li> --}}
                        <li class="footer__item">
                            <a href="https://wa.me/+6282132662815?text=Hello!%20I%20would%20like%20to%20get%20in%20touch."
                                target="_blank">
                                <i class="fab fa-whatsapp"></i> +6282132662815
                            </a>
                        </li>
                        {{-- <li class="footer__item">
                            <a href="https://wa.me/+6281381117555?text=Hello!%20I%20would%20like%20to%20get%20in%20touch." target="_blank">
                                <i class="fab fa-whatsapp"></i> +6281381117555
                            </a>
                        </li> --}}

                        <li class="footer__item">
                            <a href="#"><i class="fas fa-envelope"></i>Ijencratertour.indonesia@gmail.com</a>
                        </li>
                        <li class="footer__item">
                            <a href="#"><i class="fas fa-map"></i> Licin, Banyuwangi - 68464</a>
                        </li>
                        <!-- <li class="footer__item">
                            <a href="#" class="footer__link">Team</a>
                        </li>
                        <li class="footer__item">
                            <a href="#" class="footer__link">Plan & Pricing</a>
                        </li>
                        <li class="footer__item">
                            <a href="#" class="footer__link">Become a member</a>
                        </li> -->
                    </ul>
                </div>


                <div class="footer__data">
                    <h3 class="footer__subtitle">Support</h3>
                    <ul>
                        <li class="footer__item">
                            <a href="" class="footer__link">FAQs</a>
                        </li>
                        <li class="footer__item">
                            <a href="" class="footer__link">Support Center</a>
                        </li>
                        <li class="footer__item">
                            <a href="" class="footer__link">Contact Us</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="footer__rights">
                <p class="footer__copy">&#169; Ijen Creater Indonesia All rigths reserved.</p>
                <div class="footer__terms">
                    <a href="#" class="footer__terms-link">Terms & Agreements</a>
                    <a href="#" class="footer__terms-link">Privacy Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <!--========== SCROLL UP ==========-->
    <!-- <a href="#" class="scrollup" id="scroll-up">
            <i class="ri-arrow-up-line scrollup__icon"></i>
        </a> -->

    <!--=============== SCROLL REVEAL===============-->
    <script src="assets/js/scrollreveal.min.js"></script>

    <!--=============== SWIPER JS ===============-->
    <script src="assets/js/swiper-bundle.min.js"></script>

    <!--=============== MAIN JS ===============-->
    <script src="{{ asset('assets/js2/main.js') }}?v={{ time() }}"></script>


</body>

</html>
