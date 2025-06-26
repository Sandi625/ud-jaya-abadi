<script>
    // Menangani menu toggle
    const navToggle = document.getElementById('nav-toggle');
    const navMenu = document.getElementById('nav-menu');
    const navClose = document.getElementById('nav-close');

    // Menampilkan menu saat tombol toggle diklik
    if (navToggle) {
        navToggle.addEventListener('click', () => {
            navMenu.classList.add('show-menu');
        });
    }

    // Menyembunyikan menu saat tombol close diklik
    if (navClose) {
        navClose.addEventListener('click', () => {
            navMenu.classList.remove('show-menu');
        });
    }

    // Menyembunyikan menu saat link di-klik (opsional)
    const navLink = document.querySelectorAll('.nav__link');
    navLink.forEach(link => {
        link.addEventListener('click', () => {
            navMenu.classList.remove('show-menu');
        });
    });

    function redirectToWhatsApp(phoneNumber) {
        // Pesan prateks
        var message = encodeURIComponent('Hello, I want to book the Blue Fire Tour from Bali.');

        // Buka tautan ke WhatsApp dengan nomor dan pesan prateks
        window.open('https://wa.me/' + phoneNumber + '?text=' + message, '_blank');
    }
</script>
