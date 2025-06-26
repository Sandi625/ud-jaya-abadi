<script>
document.addEventListener('DOMContentLoaded', function () {
    // Menu toggle functionality
    const navToggle = document.getElementById('nav-toggle');
    const navMenu = document.getElementById('nav-menu');
    const navClose = document.getElementById('nav-close');

    if (navToggle && navMenu) {
        navToggle.addEventListener('click', () => {
            navMenu.classList.add('show-menu');
        });
    }

    if (navClose && navMenu) {
        navClose.addEventListener('click', () => {
            navMenu.classList.remove('show-menu');
        });
    }

    // Hide menu on link click (optional)
    const navLinks = document.querySelectorAll('.nav__link');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            if(navMenu) navMenu.classList.remove('show-menu');
        });
    });

    // Toggle between images and videos
    function showImages() {
        const imageItems = document.querySelectorAll('.image-item');
        const videoItems = document.querySelectorAll('.video-item');

        imageItems.forEach(item => item.style.display = 'block');
        videoItems.forEach(item => item.style.display = 'none');
    }

    function showVideos() {
        const imageItems = document.querySelectorAll('.image-item');
        const videoItems = document.querySelectorAll('.video-item');

        imageItems.forEach(item => item.style.display = 'none');
        videoItems.forEach(item => item.style.display = 'block');
    }

    // ✅ Default to showing images ONLY on image page
    if (window.location.href.includes('/galeri') && !window.location.href.includes('/galeri/video')) {
        showImages();
    }

    // Modal Image View
    const modal = document.getElementById("myModal");
    const modalImg = document.getElementById("img01");
    const captionText = document.getElementById("caption");
    const images = document.querySelectorAll('.myImg');

    if(modal && modalImg && captionText && images.length > 0){
        images.forEach(function(img) {
            img.addEventListener('click', function() {
                modal.style.display = "block";
                modalImg.src = this.src;
                captionText.innerHTML = this.alt || '';
            });
        });

        // Close modal button
        const span = document.querySelector(".close");
        if(span) {
            span.addEventListener('click', () => {
                modal.style.display = "none";
            });
        }

        // Close modal when clicking outside
        window.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        });
    }
});
</script>

