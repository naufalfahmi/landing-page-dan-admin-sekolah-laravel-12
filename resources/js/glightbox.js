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
            console.log('Image reloaded successfully:', originalSrc);
        };
        img.onerror = function() {
            img.style.opacity = '1';
            console.error('Failed to reload image:', originalSrc);
        };
    }

    // Function to initialize GLightbox
    function initGLightbox() {
        if (typeof GLightbox === 'undefined') {
            console.log('GLightbox not available, retrying...');
            setTimeout(initGLightbox, 500);
            return;
        }

        // Destroy existing lightbox if any
        if (window.glightboxInstance) {
            try {
                window.glightboxInstance.destroy();
            } catch (e) {
                console.log('Error destroying instance:', e);
            }
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
        
        console.log('Found gallery groups:', Object.keys(galleryGroups));
        
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
                    console.log(`Removing duplicate element ${index}: ${element.href}`);
                }
            });
            
            // Remove duplicate elements from DOM
            elementsToRemove.forEach(element => {
                element.remove();
            });
            
            console.log(`Gallery "${galleryName}": ${galleryGroups[galleryName].length} total, ${uniqueElements.length} unique elements, ${elementsToRemove.length} duplicates removed`);
            
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
                }
            });
            
            // Store instance for cleanup
            window[`glightboxInstance_${galleryName}`] = lightboxInstance;
            
            // Add click event listeners to each gallery element
            const galleryElements = document.querySelectorAll(`[data-gallery="${galleryName}"]`);
            galleryElements.forEach((element, index) => {
                element.addEventListener('click', (e) => {
                    e.preventDefault();
                    
                    console.log(`Clicked element ${index} in ${galleryName}:`, element.href);
                    console.log(`Element ID:`, element.id);
                    
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
        
        console.log('GLightbox initialized successfully');
        
        // Debug: Log gallery elements after cleanup
        const remainingElements = document.querySelectorAll('.glightbox');
        console.log('Found gallery elements after cleanup:', remainingElements.length);
        
        // Log each group separately with detailed info
        Object.keys(galleryGroups).forEach(galleryName => {
            console.log(`Gallery "${galleryName}" has ${galleryGroups[galleryName].length} items:`);
            galleryGroups[galleryName].forEach((element, index) => {
                console.log(`  ${index}: ${element.href} - ${element.getAttribute('data-title')}`);
            });
        });
        
        // Check for duplicate elements after cleanup
        const allHrefs = Array.from(remainingElements).map(el => el.href);
        const uniqueHrefs = [...new Set(allHrefs)];
        console.log('Total elements after cleanup:', allHrefs.length);
        console.log('Unique elements after cleanup:', uniqueHrefs.length);
        if (allHrefs.length !== uniqueHrefs.length) {
            console.warn('DUPLICATE ELEMENTS STILL DETECTED AFTER CLEANUP!');
            const duplicates = allHrefs.filter((href, index) => allHrefs.indexOf(href) !== index);
            console.log('Remaining duplicate URLs:', [...new Set(duplicates)]);
        } else {
            console.log('✅ No duplicate elements found - cleanup successful!');
        }

        // Enhanced event listeners with ID tracking
        Object.keys(galleryGroups).forEach(galleryName => {
            const instance = window[`glightboxInstance_${galleryName}`];
            if (instance) {
                instance.on('open', (data) => {
                    console.log(`Lightbox opened in ${galleryName} at index:`, data.index);
                    
                    // Get the clicked element ID for verification
                    const galleryElements = document.querySelectorAll(`[data-gallery="${galleryName}"]`);
                    if (galleryElements[data.index]) {
                        const clickedElement = galleryElements[data.index];
                        console.log(`Clicked element ID:`, clickedElement.id);
                        console.log(`Clicked element href:`, clickedElement.href);
                        console.log(`Clicked element title:`, clickedElement.getAttribute('data-title'));
                    }
                });

                instance.on('close', () => {
                    console.log(`Lightbox closed in ${galleryName}`);
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
                    console.log('New gallery elements detected, re-initializing GLightbox...');
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
