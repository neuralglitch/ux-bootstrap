import {Controller} from '@hotwired/stimulus';
import * as bootstrap from 'bootstrap';

/**
 * Universal Carousel Controller
 *
 * Automatically initializes Bootstrap carousel on elements.
 * Works with image carousels, sliders, and slideshow components.
 *
 * Usage:
 * 1. Automatic via component (recommended):
 *    <twig:bs:carousel>...</twig:bs:carousel>
 *
 * 2. Manual on any element:
 *    <div data-controller="bs-carousel" class="carousel">
 *      <div class="carousel-inner">...</div>
 *    </div>
 *
 * Features:
 * - Auto-initialization of Bootstrap Carousel instances
 * - Proper cleanup for Turbo compatibility
 * - Support for all carousel options
 * - Debug logging when APP_DEBUG=1
 */
export default class extends Controller {
    static values = {
        interval: {type: Number, default: 5000},
        keyboard: {type: Boolean, default: true},
        pause: {type: String, default: 'hover'},  // 'hover'|false
        ride: {type: String, default: 'false'},   // false|'carousel'
        wrap: {type: Boolean, default: true},
        touch: {type: Boolean, default: true}
    };

    connect() {
        this.carousel = null;
        this.initializeCarousel();
    }

    disconnect() {
        this.disposeCarousel();
    }

    initializeCarousel() {
        const Carousel = window.bootstrap?.Carousel ?? bootstrap.Carousel;

        try {
            // Build options from values
            const options = {
                interval: this.intervalValue,
                keyboard: this.keyboardValue,
                pause: this.pauseValue === 'false' ? false : this.pauseValue,
                ride: this.rideValue === 'false' ? false : this.rideValue,
                wrap: this.wrapValue,
                touch: this.touchValue
            };

            // Create carousel instance
            this.carousel = new Carousel(this.element, options);
        } catch (error) {
            console.error('bs-carousel Failed to initialize:', error);
        }

    }

    disposeCarousel() {
        if (this.carousel) {
            try {
                this.carousel.dispose();
            } catch (error) {
                console.warn('[bs-carousel] Dispose error:', error);
            } finally {
                this.carousel = null;
            }
        }
    }

    // Public API methods

    cycle() {
        if (this.carousel) {
            this.carousel.cycle();

            console.debug('bs-carousel cycling');
        }
    }

    pause() {
        if (this.carousel) {
            this.carousel.pause();

            console.debug('bs-carousel paused');
        }
    }

    next() {
        if (this.carousel) {
            this.carousel.next();

            console.debug('bs-carousel next slide');
        }
    }

    prev() {
        if (this.carousel) {
            this.carousel.prev();

            console.debug('bs-carousel previous slide');
        }
    }

    to(index) {
        if (this.carousel) {
            this.carousel.to(parseInt(index, 10));

            console.debug('bs-carousel go to slide:', index);
        }
    }
}

