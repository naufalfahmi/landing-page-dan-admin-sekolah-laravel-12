// Initialize GLightbox for galleries
document.addEventListener('DOMContentLoaded', function() {
    // Wait for GLightbox to be available
    if (typeof GLightbox !== 'undefined') {
        // Initialize GLightbox for all galleries
        const lightbox = GLightbox({
            selector: '.glightbox',
            touchNavigation: true,
            loop: true,
            autoplayVideos: false,
            width: '90vw',
            height: '90vh',
            zoomable: true,
            draggable: true,
            dragToleranceX: 40,
            dragToleranceY: 65,
            preload: true
        });
        
        console.log('GLightbox initialized successfully');
    } else {
        console.log('GLightbox not available, retrying...');
        setTimeout(() => {
            if (typeof GLightbox !== 'undefined') {
                // Retry initialization
                location.reload();
            }
        }, 1000);
    }
});
