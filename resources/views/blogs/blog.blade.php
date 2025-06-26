<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog List</title>
    <link rel="stylesheet" href="galeri.css">
    <link rel="stylesheet" href="https://unpkg.com/remixicon/fonts/remixicon.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .blog-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            background: #fff;
            transition: transform 0.3s;
        }

        .blog-card:hover {
            transform: translateY(-5px);
        }

        .blog-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .blog-card-body {
            padding: 20px;
        }

        .blog-card-title {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 10px;
            color: #222;
        }

        .blog-card-text {
            font-size: 0.95rem;
            color: #555;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <h1>Blog List</h1>
    </header>

    <!-- Navigation -->
    <nav class="nav">
        <div class="nav__logo">
            <img src="{{ asset('assets/img/logo.jpg') }}" alt="Brand Logo" style="height: 40px;">
        </div>
        <ul class="nav__menu">
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
                <a href="{{ route('home') }}#tour-pakets" class="nav__link">Tours</a>
            </li>
            </li>
            {{-- <li class="nav__item">
                <a href="{{ route('galeri') }}" class="nav__link">Gallery</a>
            </li> --}}
            <li class="nav__item">
                <a href="{{ route('review.review') }}" class="nav__link">Review</a>
            </li>
            <li class="nav__item">
                <a href="{{ route('blog.list') }}" class="nav__link">Blogs</a>
            </li>
            <div class="nav__close" id="nav-close">&times;</div>
        </ul>
    </nav>

    <!-- Blog List Section -->
    <section class="blog-list">
        <div class="container">
            @if ($blogs->isEmpty())
                <p>No blogs found.</p>
            @else
                <div class="row">
                    @foreach ($blogs as $blog)
                        <div class="col-md-4">
                            <div class="blog-card mb-4">
                                <!-- Card Image -->
                                @if ($blog->image)
                                    <img src="{{ asset('storage/blogs/' . $blog->image) }}" alt="{{ $blog->title }}">
                                @else
                                    <img src="{{ asset('assets/img/default-image.jpg') }}" alt="Default Image">
                                @endif

                                <!-- Card Body -->
                                <div class="blog-card-body">
                                    <div class="blog-card-title">{{ $blog->title }}</div>
                                    <div class="blog-card-text">{{ Str::limit(strip_tags($blog->content), 100) }}</div>

                                    <a href="{{ route('blogs.show', $blog) }}" class="btn btn-primary mt-3">Read
                                        More</a>
                                </div>

                                <div class="text-muted text-center py-2" style="font-size: 0.85rem;">
                                    Posted on {{ $blog->created_at->format('F d, Y') }}
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>







    <!-- Footer -->
    <footer class="footer section">
        <div class="footer__container container grid">
            <div class="footer__content grid">
                <div class="footer__data">
                    <h3 class="footer__title">Travel</h3>
                    <p class="footer__description">Travel you choose the <br> destination, we offer you the <br>
                        experience.</p>
                    <div>
                        <a href="https://www.facebook.com/profile.php?id=100090053510077" target="_blank"
                            class="footer__social">
                            <i class="ri-facebook-box-fill"></i>
                        </a>
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
                        <li class="footer__item"><a href="" class="footer__link">About Us</a></li>
                        <li class="footer__item"><a href="" class="footer__link">Features</a></li>
                        <li class="footer__item"><a href="" class="footer__link">New & Blog</a></li>
                    </ul>
                </div>
                <div class="footer__data">
                    <h3 class="footer__subtitle">Company</h3>
                    <ul>
                        <li class="footer__item">
                            <a href="https://wa.me/+6282331489128?text=Hello!%20I%20would%20like%20to%20get%20in%20touch."
                                target="_blank">
                                <i class="fab fa-whatsapp"></i> +6282331489128
                            </a>
                        </li>
                        <li class="footer__item">
                            <a href="https://wa.me/+6282132662815?text=Hello!%20I%20would%20like%20to%20get%20in%20touch."
                                target="_blank">
                                <i class="fab fa-whatsapp"></i> +6282132662815
                            </a>
                        </li>
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
    <script src="{{ asset('assets/js/bali.js') }}"></script>
</body>

</html>
