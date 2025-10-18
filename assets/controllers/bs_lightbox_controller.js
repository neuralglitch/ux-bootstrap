import { Controller } from '@hotwired/stimulus';

/**
 * Lightbox controller for image galleries.
 *
 * Handles:
 * - Image display and navigation
 * - Keyboard controls (arrows, escape)
 * - Touch/swipe gestures
 * - Zoom functionality
 * - Fullscreen mode
 * - Autoplay slideshow
 */
export default class extends Controller {
    static targets = [
        'modal',
        'backdrop',
        'content',
        'image',
        'imageContainer',
        'caption',
        'counter',
        'currentIndex',
        'thumbnails',
        'spinner',
        'prevBtn',
        'nextBtn',
        'fullscreenBtn',
        'trigger'
    ];

    static values = {
        startIndex: { type: Number, default: 0 },
        enableZoom: { type: Boolean, default: true },
        enableKeyboard: { type: Boolean, default: true },
        enableSwipe: { type: Boolean, default: true },
        closeOnBackdrop: { type: Boolean, default: true },
        transition: { type: String, default: 'fade' },
        transitionDuration: { type: Number, default: 300 },
        autoplay: { type: Boolean, default: false },
        autoplayInterval: { type: Number, default: 3000 }
    };

    connect() {
        this.currentIndex = this.startIndexValue;
        this.images = this.extractImages();
        this.isOpen = false;
        this.isZoomed = false;
        this.isFullscreen = false;
        this.autoplayTimer = null;
        this.touchStartX = 0;
        this.touchEndX = 0;
        this.zoomLevel = 1;
        this.panX = 0;
        this.panY = 0;

        // Bind event listeners
        if (this.enableKeyboardValue) {
            this.boundKeyHandler = this.handleKeyboard.bind(this);
        }

        if (this.enableSwipeValue && this.hasImageContainerTarget) {
            this.boundTouchStart = this.handleTouchStart.bind(this);
            this.boundTouchMove = this.handleTouchMove.bind(this);
            this.boundTouchEnd = this.handleTouchEnd.bind(this);
        }

        if (this.enableZoomValue && this.hasImageTarget) {
            this.boundImageClick = this.handleImageClick.bind(this);
            this.boundWheel = this.handleWheel.bind(this);
        }

        // Auto-open if trigger is clicked
        this.element.style.display = 'none';
    }

    disconnect() {
        this.stopAutoplay();
        this.removeEventListeners();
    }

    /**
     * Extract image data from triggers
     */
    extractImages() {
        const images = [];

        if (this.hasTriggerTarget) {
            this.triggerTargets.forEach((trigger) => {
                images.push({
                    src: trigger.href || trigger.dataset.src,
                    alt: trigger.dataset.alt || trigger.querySelector('img')?.alt || '',
                    caption: trigger.dataset.caption || '',
                    thumbnail: trigger.dataset.thumbnail || trigger.querySelector('img')?.src || ''
                });
            });
        }

        return images;
    }

    /**
     * Open lightbox
     */
    open(event) {
        if (event) {
            event.preventDefault();
            // Find index of clicked trigger
            if (this.hasTriggerTarget) {
                const index = this.triggerTargets.indexOf(event.currentTarget);
                if (index >= 0) {
                    this.currentIndex = index;
                }
            }
        }

        this.isOpen = true;
        this.showImage(this.currentIndex);
        this.showModal();
        this.addEventListeners();

        if (this.autoplayValue) {
            this.startAutoplay();
        }

        // Dispatch custom event
        this.element.dispatchEvent(new CustomEvent('lightbox:opened', {
            detail: { index: this.currentIndex }
        }));
    }

    /**
     * Close lightbox
     */
    close(event) {
        if (event) {
            event.preventDefault();
        }

        this.isOpen = false;
        this.hideModal();
        this.removeEventListeners();
        this.stopAutoplay();
        this.resetZoom();

        if (this.isFullscreen) {
            this.exitFullscreen();
        }

        // Dispatch custom event
        this.element.dispatchEvent(new CustomEvent('lightbox:closed'));
    }

    /**
     * Show next image
     */
    next(event) {
        if (event) {
            event.preventDefault();
        }

        this.stopAutoplay();
        this.currentIndex = (this.currentIndex + 1) % this.images.length;
        this.showImage(this.currentIndex);

        if (this.autoplayValue) {
            this.startAutoplay();
        }
    }

    /**
     * Show previous image
     */
    prev(event) {
        if (event) {
            event.preventDefault();
        }

        this.stopAutoplay();
        this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
        this.showImage(this.currentIndex);

        if (this.autoplayValue) {
            this.startAutoplay();
        }
    }

    /**
     * Go to specific image
     */
    goto(event) {
        if (event) {
            event.preventDefault();
            const index = parseInt(event.currentTarget.dataset.index, 10);
            if (!isNaN(index) && index >= 0 && index < this.images.length) {
                this.stopAutoplay();
                this.currentIndex = index;
                this.showImage(this.currentIndex);

                if (this.autoplayValue) {
                    this.startAutoplay();
                }
            }
        }
    }

    /**
     * Show image at index
     */
    showImage(index) {
        if (!this.images[index]) return;

        const image = this.images[index];
        this.resetZoom();

        // Show spinner
        if (this.hasSpinnerTarget) {
            this.spinnerTarget.style.display = 'flex';
        }

        // Update image
        if (this.hasImageTarget) {
            const img = new Image();
            img.onload = () => {
                this.imageTarget.src = image.src;
                this.imageTarget.alt = image.alt;

                // Hide spinner
                if (this.hasSpinnerTarget) {
                    this.spinnerTarget.style.display = 'none';
                }

                // Apply transition
                this.applyTransition();
            };
            img.onerror = () => {
                console.error('Failed to load image:', image.src);
                if (this.hasSpinnerTarget) {
                    this.spinnerTarget.style.display = 'none';
                }
            };
            img.src = image.src;
        }

        // Update caption
        if (this.hasCaptionTarget) {
            this.captionTarget.textContent = image.caption;
            this.captionTarget.style.display = image.caption ? 'block' : 'none';
        }

        // Update counter
        if (this.hasCurrentIndexTarget) {
            this.currentIndexTarget.textContent = (index + 1).toString();
        }

        // Update thumbnails
        if (this.hasThumbnailsTarget) {
            const buttons = this.thumbnailsTarget.querySelectorAll('.lightbox-thumbnail-btn');
            buttons.forEach((btn, i) => {
                btn.classList.toggle('active', i === index);
            });
        }

        // Update navigation buttons
        if (this.images.length === 1) {
            if (this.hasPrevBtnTarget) this.prevBtnTarget.style.display = 'none';
            if (this.hasNextBtnTarget) this.nextBtnTarget.style.display = 'none';
        }

        // Dispatch custom event
        this.element.dispatchEvent(new CustomEvent('lightbox:changed', {
            detail: { index, image }
        }));
    }

    /**
     * Apply transition effect
     */
    applyTransition() {
        if (!this.hasImageContainerTarget) return;

        const container = this.imageContainerTarget;
        const duration = this.transitionDurationValue;

        switch (this.transitionValue) {
            case 'fade':
                container.style.opacity = '0';
                setTimeout(() => {
                    container.style.transition = `opacity ${duration}ms`;
                    container.style.opacity = '1';
                }, 10);
                break;

            case 'slide':
                container.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    container.style.transition = `transform ${duration}ms`;
                    container.style.transform = 'translateX(0)';
                }, 10);
                break;

            case 'zoom':
                container.style.transform = 'scale(0.8)';
                container.style.opacity = '0';
                setTimeout(() => {
                    container.style.transition = `transform ${duration}ms, opacity ${duration}ms`;
                    container.style.transform = 'scale(1)';
                    container.style.opacity = '1';
                }, 10);
                break;

            case 'none':
            default:
                // No transition
                break;
        }
    }

    /**
     * Download current image
     */
    download(event) {
        if (event) {
            event.preventDefault();
        }

        const image = this.images[this.currentIndex];
        if (!image) return;

        const link = document.createElement('a');
        link.href = image.src;
        link.download = image.src.split('/').pop() || 'image.jpg';
        link.click();
    }

    /**
     * Toggle fullscreen
     */
    toggleFullscreen(event) {
        if (event) {
            event.preventDefault();
        }

        if (this.isFullscreen) {
            this.exitFullscreen();
        } else {
            this.enterFullscreen();
        }
    }

    /**
     * Enter fullscreen
     */
    enterFullscreen() {
        const elem = this.hasModalTarget ? this.modalTarget : this.element;

        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.webkitRequestFullscreen) {
            elem.webkitRequestFullscreen();
        } else if (elem.msRequestFullscreen) {
            elem.msRequestFullscreen();
        }

        this.isFullscreen = true;
    }

    /**
     * Exit fullscreen
     */
    exitFullscreen() {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }

        this.isFullscreen = false;
    }

    /**
     * Handle keyboard events
     */
    handleKeyboard(event) {
        if (!this.isOpen) return;

        switch (event.key) {
            case 'Escape':
                this.close();
                break;
            case 'ArrowLeft':
                event.preventDefault();
                this.prev();
                break;
            case 'ArrowRight':
                event.preventDefault();
                this.next();
                break;
        }
    }

    /**
     * Handle touch start
     */
    handleTouchStart(event) {
        this.touchStartX = event.touches[0].clientX;
    }

    /**
     * Handle touch move
     */
    handleTouchMove(event) {
        this.touchEndX = event.touches[0].clientX;
    }

    /**
     * Handle touch end
     */
    handleTouchEnd() {
        const swipeThreshold = 50;
        const diff = this.touchStartX - this.touchEndX;

        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                this.next();
            } else {
                this.prev();
            }
        }
    }

    /**
     * Handle image click (zoom)
     */
    handleImageClick(event) {
        if (!this.enableZoomValue) return;

        if (this.isZoomed) {
            this.resetZoom();
        } else {
            this.zoomIn();
        }
    }

    /**
     * Handle mouse wheel (zoom)
     */
    handleWheel(event) {
        if (!this.enableZoomValue) return;

        event.preventDefault();
        const delta = event.deltaY > 0 ? -0.1 : 0.1;
        this.zoomLevel = Math.max(1, Math.min(3, this.zoomLevel + delta));
        this.applyZoom();
    }

    /**
     * Zoom in
     */
    zoomIn() {
        this.isZoomed = true;
        this.zoomLevel = 2;
        this.applyZoom();
    }

    /**
     * Reset zoom
     */
    resetZoom() {
        this.isZoomed = false;
        this.zoomLevel = 1;
        this.panX = 0;
        this.panY = 0;
        this.applyZoom();
    }

    /**
     * Apply zoom transformation
     */
    applyZoom() {
        if (!this.hasImageTarget) return;

        this.imageTarget.style.transform = `scale(${this.zoomLevel}) translate(${this.panX}px, ${this.panY}px)`;
        this.imageTarget.style.cursor = this.isZoomed ? 'zoom-out' : 'zoom-in';
    }

    /**
     * Start autoplay
     */
    startAutoplay() {
        this.stopAutoplay();
        this.autoplayTimer = setInterval(() => {
            this.next();
        }, this.autoplayIntervalValue);
    }

    /**
     * Stop autoplay
     */
    stopAutoplay() {
        if (this.autoplayTimer) {
            clearInterval(this.autoplayTimer);
            this.autoplayTimer = null;
        }
    }

    /**
     * Show modal
     */
    showModal() {
        if (this.hasModalTarget) {
            this.modalTarget.style.display = 'flex';
            document.body.style.overflow = 'hidden';

            // Animate in
            setTimeout(() => {
                this.modalTarget.classList.add('show');
            }, 10);
        }
    }

    /**
     * Hide modal
     */
    hideModal() {
        if (this.hasModalTarget) {
            this.modalTarget.classList.remove('show');

            setTimeout(() => {
                this.modalTarget.style.display = 'none';
                document.body.style.overflow = '';
            }, this.transitionDurationValue);
        }
    }

    /**
     * Add event listeners
     */
    addEventListeners() {
        if (this.enableKeyboardValue && this.boundKeyHandler) {
            document.addEventListener('keydown', this.boundKeyHandler);
        }

        if (this.enableSwipeValue && this.hasImageContainerTarget) {
            this.imageContainerTarget.addEventListener('touchstart', this.boundTouchStart);
            this.imageContainerTarget.addEventListener('touchmove', this.boundTouchMove);
            this.imageContainerTarget.addEventListener('touchend', this.boundTouchEnd);
        }

        if (this.enableZoomValue && this.hasImageTarget) {
            this.imageTarget.addEventListener('click', this.boundImageClick);
            this.imageContainerTarget.addEventListener('wheel', this.boundWheel);
        }
    }

    /**
     * Remove event listeners
     */
    removeEventListeners() {
        if (this.boundKeyHandler) {
            document.removeEventListener('keydown', this.boundKeyHandler);
        }

        if (this.hasImageContainerTarget) {
            this.imageContainerTarget.removeEventListener('touchstart', this.boundTouchStart);
            this.imageContainerTarget.removeEventListener('touchmove', this.boundTouchMove);
            this.imageContainerTarget.removeEventListener('touchend', this.boundTouchEnd);
            this.imageContainerTarget.removeEventListener('wheel', this.boundWheel);
        }

        if (this.hasImageTarget) {
            this.imageTarget.removeEventListener('click', this.boundImageClick);
        }
    }
}

