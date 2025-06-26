<!-- Hanya sekali saja load Swiper -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<script>
    // === Swiper ===
    document.addEventListener('DOMContentLoaded', function () {
        const swiper = new Swiper('.swiper-container', {
            slidesPerView: 1,
            spaceBetween: 10,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 40,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 50,
                },
            }
        });

        // === Navbar Toggle ===
        const navToggle = document.getElementById('nav-toggle');
        const navMenu = document.getElementById('nav-menu');
        const navClose = document.getElementById('nav-close');

        if (navToggle) {
            navToggle.addEventListener('click', () => {
                navMenu.classList.add('show-menu');
            });
        }

        if (navClose) {
            navClose.addEventListener('click', () => {
                navMenu.classList.remove('show-menu');
            });
        }

        document.querySelectorAll('.nav__link').forEach(link => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('show-menu');
            });
        });

        // === Form Validation ===
        const reviewForm = document.getElementById('review-form');
        if (reviewForm) {
            reviewForm.addEventListener('submit', function (event) {
                const name = document.getElementById('name').value;
                const email = document.getElementById('email').value;
                const rating = document.getElementById('rating').value;
                const review = document.getElementById('review').value;

                if (!name || !email || !rating || !review) {
                    event.preventDefault();
                    alert('Please fill in all the fields.');
                }
            });
        }
    });
</script>
