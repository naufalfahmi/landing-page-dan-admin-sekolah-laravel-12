// Hero Slider JavaScript
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('heroCarousel');
    
    if (carousel && window.bootstrap) {
        // Initialize carousel with custom settings
        const bsCarousel = new window.bootstrap.Carousel(carousel, {
            interval: 5000, // 5 seconds autoplay
            wrap: true,
            touch: true,
            keyboard: true
        });

        // Pause autoplay on hover
        carousel.addEventListener('mouseenter', function() {
            bsCarousel.pause();
        });

        // Resume autoplay when mouse leaves
        carousel.addEventListener('mouseleave', function() {
            bsCarousel.cycle();
        });

        // Add smooth transition effects
        carousel.addEventListener('slide.bs.carousel', function(e) {
            const activeItem = e.target.querySelector('.carousel-item.active');
            const nextItem = e.relatedTarget;
            
            // Add fade effect
            if (activeItem) {
                activeItem.style.opacity = '0.8';
            }
            if (nextItem) {
                nextItem.style.opacity = '0';
                setTimeout(() => {
                    nextItem.style.opacity = '1';
                }, 50);
            }
        });

        // Button click tracking removed - no buttons in image-only slider

        // Add keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft') {
                bsCarousel.prev();
            } else if (e.key === 'ArrowRight') {
                bsCarousel.next();
            }
        });

        // Add touch/swipe support for mobile
        let startX = 0;
        let endX = 0;

        carousel.addEventListener('touchstart', function(e) {
            startX = e.touches[0].clientX;
        });

        carousel.addEventListener('touchend', function(e) {
            endX = e.changedTouches[0].clientX;
            handleSwipe();
        });

        function handleSwipe() {
            const threshold = 50;
            const diff = startX - endX;

            if (Math.abs(diff) > threshold) {
                if (diff > 0) {
                    bsCarousel.next();
                } else {
                    bsCarousel.prev();
                }
            }
        }

        // Add loading animation for images
        const carouselImages = carousel.querySelectorAll('img');
        carouselImages.forEach(img => {
            // Check if image is already loaded
            if (img.complete && img.naturalHeight !== 0) {
                img.style.opacity = '1';
            } else {
                img.addEventListener('load', function() {
                    this.style.opacity = '1';
                });
                
                img.addEventListener('error', function() {
                    console.error('Failed to load image:', this.src);
                    this.style.opacity = '1'; // Show even if failed to load
                });
            }
            
            // Set initial opacity
            img.style.opacity = '0';
            img.style.transition = 'opacity 0.5s ease';
        });
    } else if (carousel) {
        // Fallback: Simple carousel without Bootstrap
        console.log('Bootstrap not available, using fallback carousel');
        initSimpleCarousel(carousel);
    }
});

// Simple carousel fallback
function initSimpleCarousel(carousel) {
    const items = carousel.querySelectorAll('.carousel-item');
    const prevBtn = carousel.querySelector('.carousel-control-prev');
    const nextBtn = carousel.querySelector('.carousel-control-next');
    
    let currentIndex = 0;
    let autoplayInterval;
    
    function showSlide(index) {
        // Hide all slides
        items.forEach((item, i) => {
            item.classList.toggle('active', i === index);
        });
        
        currentIndex = index;
    }
    
    function nextSlide() {
        const nextIndex = (currentIndex + 1) % items.length;
        showSlide(nextIndex);
    }
    
    function prevSlide() {
        const prevIndex = (currentIndex - 1 + items.length) % items.length;
        showSlide(prevIndex);
    }
    
    function startAutoplay() {
        autoplayInterval = setInterval(nextSlide, 5000);
    }
    
    function stopAutoplay() {
        clearInterval(autoplayInterval);
    }
    
    // Event listeners
    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            nextSlide();
            stopAutoplay();
            startAutoplay();
        });
    }
    
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            prevSlide();
            stopAutoplay();
            startAutoplay();
        });
    }
    
    // Indicators removed - no longer needed
    
    // Pause on hover
    carousel.addEventListener('mouseenter', stopAutoplay);
    carousel.addEventListener('mouseleave', startAutoplay);
    
    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
            prevSlide();
            stopAutoplay();
            startAutoplay();
        } else if (e.key === 'ArrowRight') {
            nextSlide();
            stopAutoplay();
            startAutoplay();
        }
    });
    
    // Start autoplay
    startAutoplay();
}

// Ripple effect CSS removed - no buttons in image-only slider
