/* ============================================================
   KIJURA TOWN COUNCIL — Public JS
   ============================================================ */

document.addEventListener('DOMContentLoaded', function () {

    // ── Hero Slider auto-play (Bootstrap carousel already handles this)
    var heroCarousel = document.getElementById('heroCarousel');
    if (heroCarousel) {
        // Already configured via data-bs-ride="carousel"
    }

    // ── Lazy-load images
    if ('IntersectionObserver' in window) {
        var lazyImgs = document.querySelectorAll('img[data-src]');
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    var img = entry.target;
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    observer.unobserve(img);
                }
            });
        }, { rootMargin: '200px' });
        lazyImgs.forEach(function (img) { observer.observe(img); });
    }

    // ── Gallery Lightbox (simple Bootstrap modal-based)
    var galleryThumbs = document.querySelectorAll('.gallery-thumb[data-full]');
    var lightboxModal = document.getElementById('lightboxModal');
    if (lightboxModal && galleryThumbs.length) {
        var lightboxImg   = document.getElementById('lightboxImg');
        var lightboxCaption = document.getElementById('lightboxCaption');
        galleryThumbs.forEach(function (thumb) {
            thumb.addEventListener('click', function () {
                lightboxImg.src        = thumb.dataset.full;
                lightboxCaption.textContent = thumb.dataset.caption || '';
                var modal = new bootstrap.Modal(lightboxModal);
                modal.show();
            });
        });
    }

    // ── Animate number counters (facts section)
    var counters = document.querySelectorAll('[data-counter]');
    if (counters.length && 'IntersectionObserver' in window) {
        var counterObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        counters.forEach(function (el) { counterObserver.observe(el); });
    }

    function animateCounter(el) {
        var target = parseInt(el.dataset.counter, 10);
        var duration = 1200;
        var step = target / (duration / 16);
        var current = 0;
        var timer = setInterval(function () {
            current += step;
            if (current >= target) { current = target; clearInterval(timer); }
            el.textContent = Math.floor(current).toLocaleString();
        }, 16);
    }

    // ── Back to top button
    var backToTop = document.getElementById('backToTop');
    if (backToTop) {
        window.addEventListener('scroll', function () {
            backToTop.style.display = window.scrollY > 400 ? 'block' : 'none';
        });
        backToTop.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // ── Dismiss alerts after 5 s
    document.querySelectorAll('.alert-auto-dismiss').forEach(function (el) {
        setTimeout(function () {
            var bsAlert = bootstrap.Alert.getOrCreateInstance(el);
            bsAlert.close();
        }, 5000);
    });
});
