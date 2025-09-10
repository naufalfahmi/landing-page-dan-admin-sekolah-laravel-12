// Initialize GLightbox for galleries
document.addEventListener('DOMContentLoaded', function() {
    // Function to force image reload and prevent cache
    function forceImageReload(img) {
        if (!img) return;
        
        const originalSrc = img.src.split('?')[0];
        const timestamp = Date.now();
        img.src = originalSrc + '?nocache=' + timestamp;
        
        // Add loading indicator
        img.style.opacity = '0.5';
        img.onload = function() {
            img.style.opacity = '1';
        };
        img.onerror = function() {
            img.style.opacity = '1';
            console.error('Failed to reload image:', originalSrc);
        };
    }

    // Function to initialize GLightbox
    function initGLightbox() {
        if (typeof GLightbox === 'undefined') {
            setTimeout(initGLightbox, 500);
            return;
        }

        // Destroy existing lightbox if any
        if (window.glightboxInstance) {
            try {
                window.glightboxInstance.destroy();
            } catch (e) {}
        }

        // Initialize separate GLightbox instances for each gallery group
        const galleryElements = document.querySelectorAll('.glightbox');
        const galleryGroups = {};
        
        // Group elements by data-gallery attribute
        galleryElements.forEach(element => {
            const galleryName = element.getAttribute('data-gallery') || 'default';
            if (!galleryGroups[galleryName]) {
                galleryGroups[galleryName] = [];
            }
            galleryGroups[galleryName].push(element);
        });
        
        
        
        // Initialize separate GLightbox instances for each gallery group
        Object.keys(galleryGroups).forEach(galleryName => {
            // Remove duplicate elements from this gallery group
            const uniqueElements = [];
            const seenHrefs = new Set();
            const elementsToRemove = [];
            
            galleryGroups[galleryName].forEach((element, index) => {
                if (!seenHrefs.has(element.href)) {
                    seenHrefs.add(element.href);
                    uniqueElements.push(element);
                } else {
                    // Mark duplicate elements for removal
                    elementsToRemove.push(element);
                }
            });
            
            // Remove duplicate elements from DOM
            elementsToRemove.forEach(element => {
                element.remove();
            });
            
            
            
            // Update the gallery group with unique elements only
            galleryGroups[galleryName] = uniqueElements;
            
            // Initialize GLightbox without selector first
            const lightboxInstance = GLightbox({
                touchNavigation: true,
                loop: false, // Disable loop to prevent duplication
                autoplayVideos: false,
                width: '90vw',
                height: '90vh',
                zoomable: true,
                draggable: true,
                dragToleranceX: 40,
                dragToleranceY: 65,
                // Disable preload to prevent cache issues
                preload: false,
                // Ensure proper navigation between images
                openEffect: 'fade',
                closeEffect: 'fade',
                slideEffect: 'slide',
                // Enable keyboard navigation
                keyboardNavigation: true,
                // Enable mouse wheel navigation
                mousewheelNavigation: true,
                // Auto close after inactivity (optional)
                autoClose: false,
                // Show counter
                showCounter: true,
                // Show controls
                showControls: true,
                // Additional options for better navigation
                moreText: 'Lihat lebih banyak',
                moreLength: 60,
                closeOnOutsideClick: true,
                startAt: 0,
                // Force reload images on slide change
                cssEfects: {
                    fade: { in: 'fadeIn', out: 'fadeOut' },
                    slide: { in: 'slideInRight', out: 'slideOutLeft' }
                },
                // Force image to use original size and prevent caching
                onSlideChange: function(data) {
                    // Force reload the image to prevent cache issues
                    const currentSlide = this.slides[data.index];
                    if (currentSlide && currentSlide.href) {
                        const timestamp = Date.now();
                        const separator = currentSlide.href.includes('?') ? '&' : '?';
                        currentSlide.href = currentSlide.href.split('?')[0] + separator + 'nocache=' + timestamp;
                    }
                },
                // Ensure images are displayed at full size and perfectly centered
                onOpen: function(data) {
                    // Force the image to display at full size and center it
                    setTimeout(() => {
                        const lightboxImg = document.querySelector('.glightbox-image img');
                        const lightboxContainer = document.querySelector('.glightbox-image');
                        const lightboxContent = document.querySelector('.glightbox-content');
                        
                        if (lightboxImg) {
                            lightboxImg.style.maxWidth = 'none';
                            lightboxImg.style.maxHeight = 'none';
                            lightboxImg.style.width = 'auto';
                            lightboxImg.style.height = 'auto';
                            lightboxImg.style.objectFit = 'contain';
                            lightboxImg.style.display = 'block';
                            lightboxImg.style.margin = '0 auto';
                        }
                        
                        if (lightboxContainer) {
                            lightboxContainer.style.display = 'flex';
                            lightboxContainer.style.alignItems = 'center';
                            lightboxContainer.style.justifyContent = 'center';
                            lightboxContainer.style.textAlign = 'center';
                        }
                        
                        if (lightboxContent) {
                            lightboxContent.style.display = 'flex';
                            lightboxContent.style.alignItems = 'center';
                            lightboxContent.style.justifyContent = 'center';
                        }
                    }, 100);
                }
            });
            
            // Store instance for cleanup
            window[`glightboxInstance_${galleryName}`] = lightboxInstance;
            
            // Add click event listeners to each gallery element
            const galleryElements = document.querySelectorAll(`[data-gallery="${galleryName}"]`);
            galleryElements.forEach((element, index) => {
                element.addEventListener('click', (e) => {
                    e.preventDefault();
                    
                    // Create slides array with only the clicked element
                    const slides = [{
                        href: element.href,
                        type: 'image',
                        title: element.getAttribute('data-title'),
                        description: element.getAttribute('data-description')
                    }];
                    
                    // Open GLightbox with only the clicked element
                    lightboxInstance.setElements(slides);
                    lightboxInstance.openAt(0);
                });
            });
        });
        
        // Set main instance for backward compatibility
        window.glightboxInstance = window.glightboxInstance_gallery_widget || window.glightboxInstance_gallery_main || window.glightboxInstance_default;
        
        
        // Debug: Log gallery elements after cleanup
        const remainingElements = document.querySelectorAll('.glightbox');
        
        // Check for duplicate elements after cleanup
        const allHrefs = Array.from(remainingElements).map(el => el.href);
        const uniqueHrefs = [...new Set(allHrefs)];
        if (allHrefs.length !== uniqueHrefs.length) {
            const duplicates = allHrefs.filter((href, index) => allHrefs.indexOf(href) !== index);
            // Optionally handle duplicates silently
        }

        // Enhanced event listeners with ID tracking
        Object.keys(galleryGroups).forEach(galleryName => {
            const instance = window[`glightboxInstance_${galleryName}`];
            if (instance) {
                instance.on('open', (data) => {
                    // no-op
                });

                instance.on('close', () => {
                    // no-op
                });
            }
        });
    }

    // Initialize GLightbox
    initGLightbox();

    // Re-initialize when new content is loaded (for dynamic content)
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList') {
                const addedNodes = Array.from(mutation.addedNodes);
                const hasGalleryElements = addedNodes.some(node => {
                    if (node.nodeType === Node.ELEMENT_NODE) {
                        return node.querySelector && node.querySelector('.glightbox');
                    }
                    return false;
                });
                
                if (hasGalleryElements) {
                    setTimeout(initGLightbox, 100);
                }
            }
        });
    });

    // Start observing
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });

    // Store observer for cleanup
    window.glightboxObserver = observer;
});
