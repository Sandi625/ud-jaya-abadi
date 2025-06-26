@extends('layout.pelanggan')




@section('content')
    <style>

:root {
    --header-height: 4rem;
    --white-color: #fff;
    --body-color: #f4f4f9;
    --text-color-light: #666;
    --text-color: #333;
    --title-color: #e67e22;
    --font-semi-bold: 600;
}

body {
    margin: 0;
    font-family: 'Arial', sans-serif;
    background-color: var(--body-color);
    color: var(--text-color);
    line-height: 1.6;
}

/* Header banner (atas navbar) */
header {
    background: #082a2b;
    color: var(--white-color);
    padding: 10px 0;
    text-align: center;
}

header h1 {
    margin: 0;
    font-size: 24px;
}

/* Container halaman */
.container {
    width: 80%;
    margin: 0 auto;
    padding: 20px 0;
}

/* Navbar utama */
.nav {
    height: var(--header-height);
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 30px;
    background-color: var(--body-color);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    position: sticky;
    top: 0;
    z-index: 1000;
}

/* Logo dan tombol toggle */
.nav__logo,
.nav__toggle {
    color: var(--text-color);
    cursor: pointer;
    font-weight: var(--font-semi-bold);
}

.nav__logo {
    font-size: 1.5rem;
}

.nav__toggle {
    display: none;
    font-size: 1.8rem;
}

/* Menu */
.nav__menu {
    display: flex;
    align-items: center;
}

.nav__list {
    display: flex;
    gap: 3rem;
    list-style: none;
    margin: 0;
    padding: 0;
}

.nav__item {
    list-style: none;
}

.nav__link {
    color: var(--text-color-light);
    font-weight: var(--font-semi-bold);
    text-transform: uppercase;
    text-decoration: none;
    transition: color 0.3s;
    padding: 10px 15px;
    position: relative;
}

/* Hover & Fokus */
.nav__link:hover,
.nav__link:focus {
    color: var(--title-color);
}

/* Active Link */
.active-link {
    color: var(--title-color);
}

.active-link::before {
    content: '';
    position: absolute;
    width: 100%;
    height: 2px;
    background-color: var(--title-color);
    bottom: -5px;
    left: 0;
}

/* Tombol close di mobile */
.nav__close {
    position: absolute;
    top: 1rem;
    right: 1.5rem;
    font-size: 1.5rem;
    color: var(--title-color);
    cursor: pointer;
    display: none;
}

/* Responsive: Mobile */
@media screen and (max-width: 767px) {
    .nav__menu {
        position: fixed;
        top: 0;
        right: -100%;
        width: 70%;
        height: 100%;
        background-color: var(--body-color);
        box-shadow: -1px 0 4px rgba(14, 55, 63, 0.15);
        padding: 2rem;
        transition: 0.4s;
        display: flex;
        flex-direction: column;
        gap: 2.5rem;
        z-index: 99;
    }

    .nav__toggle {
        display: block;
    }

    .nav__close {
        display: block;
    }

    .show-menu {
        right: 0;
    }

    .nav__list {
        flex-direction: column;
        gap: 1.5rem;
    }
}

/* Scroll Effect */
.scroll-header {
    background-color: var(--body-color);
    box-shadow: 0 0 4px rgba(14, 55, 63, 0.15);
}

.scroll-header .nav__logo,
.scroll-header .nav__toggle {
    color: var(--title-color);
}




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
    <section id="tour-pakets">
        <h2 class="section-title">Tour Pakets</h2>
        <div class="bd-container testimonials__container">
            @foreach ($pakets as $paket)
                <div class="testimonials__card">
                    <div class="testimonials__image">
                        @if ($paket->foto)
                            <a href="{{ route('pesanan.create', ['id_paket' => $paket->id]) }}">
                                <img src="{{ asset('storage/' . $paket->foto) }}" alt="Foto Paket"
                                    class="w-full h-40 object-cover rounded-lg hover:opacity-90 transition-opacity duration-300">
                            </a>
                        @else
                            <p>Foto tidak tersedia</p>
                        @endif
                    </div>
                    <div class="testimonials__info">
                        <h3 class="testimonials__name">{{ $paket->nama_paket }}</h3>
                        <p class="testimonials__description">{{ Str::limit($paket->deskripsi_paket, 100) }}</p>
                        <p class="testimonials__duration">Durasi: {{ $paket->durasi }}</p>

                        <!-- Tombol Detail -->
                        <a href="{{ route('pesanan.create', ['id_paket' => $paket->id]) }}"
                            class="inline-block mt-4 px-6 py-2.5 bg-gradient-to-r from-green-500 to-green-700 text-blue-500 font-semibold text-sm rounded-full shadow-lg hover:from-green-600 hover:to-green-800 transition-all duration-300 ease-in-out">
                            💼 Klik For More
                        </a>


                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
