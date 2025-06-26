<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Ijen Crater')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/2.5.0/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="review.css">
<style>
.nav__menu li.logout-item {
    margin-left: 5rem; /* Default jarak kiri */
    margin-top: 0;  /* Default jarak atas */
}

/* Untuk layar kecil (mobile) */
@media (max-width: 768px) {
    .nav__menu li.logout-item {
        margin-top: 2rem;   /* Jarak ke bawah lebih besar */
        margin-left: 0;     /* Reset margin kiri agar tidak geser ke samping */
    }
}


</style>

    {{-- @include('__js.review') --}}
</head>

<body>
    <header>
        <h1>Welcome to Ijen Crater Indonesia</h1>
        <h2></h2>
    </header>

    <nav class="nav">
    <div class="nav__logo">
        <img src="{{ asset('assets/img/logo.jpg') }}" alt="Brand Logo" style="height: 40px;" />
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
            <a href="{{ route('dashboard.pelanggan') }}" class="nav__link">Tours</a>
        </li>
        <li class="nav__item">
            <a href="{{ route('review.review') }}" class="nav__link">Review</a>
        </li>
        <li class="nav__item">
            <a href="{{ route('galeri') }}" class="nav__link">Gallery</a>
        </li>

      {{-- Logout --}}
@auth
<li class="nav__item logout-item">
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


    <main>
        @yield('content')
    </main>
</body>

</html>
