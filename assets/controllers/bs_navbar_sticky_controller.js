import {Controller} from '@hotwired/stimulus';

/**
 * Sticky Navbar Controller
 *
 * Handles scroll behaviors for navbar including:
 * - Shrink on scroll
 * - Auto-hide (hide on scroll down, show on scroll up)
 * - Shadow on scroll
 * - Transparent until scroll
 *
 * Values:
 *   - shrink: boolean (shrink navbar height on scroll)
 *   - autoHide: boolean (auto-hide on scroll down)
 *   - shadow: boolean (add shadow when scrolled)
 *   - transparent: boolean (transparent until scrolled)
 */
export default class extends Controller {
    static values = {
        shrink: {type: Boolean, default: false},
        autoHide: {type: Boolean, default: false},
        shadow: {type: Boolean, default: false},
        transparent: {type: Boolean, default: false}
    };

    connect() {
        this.lastScrollTop = 0;
        this.scrollThreshold = 10; // Minimum scroll to trigger changes
        this.navbarHeight = this.element.offsetHeight;

        // Set initial transparent state if enabled
        if (this.transparentValue) {
            this.element.classList.add('navbar-transparent-active');
        }

        // Throttle scroll handler
        this.throttledScroll = this.throttle(this.handleScroll.bind(this), 16); // ~60fps
        window.addEventListener('scroll', this.throttledScroll, {passive: true});

        // Initial state
        this.handleScroll();
    }

    // Stimulus value change callbacks
    shrinkValueChanged() {
        this.handleScroll();
        console.debug('bs-navbar-sticky shrink value changed to:', this.shrinkValue);
    }

    autoHideValueChanged() {
        if (!this.autoHideValue) {
            this.element.classList.remove('navbar-hidden');
        }
        console.debug('bs-navbar-sticky autoHide value changed to:', this.autoHideValue);
        this.handleScroll();
    }

    shadowValueChanged() {
        if (!this.shadowValue) {
            this.element.classList.remove('navbar-shadow');
        }
        console.debug('bs-navbar-sticky shadow value changed to:', this.shadowValue);
        this.handleScroll();
    }

    transparentValueChanged() {
        if (this.transparentValue) {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            if (scrollTop <= this.scrollThreshold) {
                this.element.classList.add('navbar-transparent-active');
            }
        } else {
            this.element.classList.remove('navbar-transparent-active', 'navbar-opaque');
        }
        console.debug('bs-navbar-sticky transparent value changed to:', this.transparentValue);
        this.handleScroll();
    }

    disconnect() {
        window.removeEventListener('scroll', this.throttledScroll);
    }

    handleScroll() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const scrollingDown = scrollTop > this.lastScrollTop;
        const scrollingUp = scrollTop < this.lastScrollTop;

        // Shrink behavior
        if (this.shrinkValue) {
            if (scrollTop > this.scrollThreshold) {
                this.element.classList.add('navbar-scrolled', 'navbar-shrunk');
            } else {
                this.element.classList.remove('navbar-scrolled', 'navbar-shrunk');
            }
        }

        // Auto-hide behavior
        if (this.autoHideValue) {
            if (scrollTop > this.navbarHeight && scrollingDown) {
                this.element.classList.add('navbar-hidden');
            } else if (scrollingUp) {
                this.element.classList.remove('navbar-hidden');
            }
        }

        // Shadow behavior
        if (this.shadowValue) {
            if (scrollTop > this.scrollThreshold) {
                this.element.classList.add('navbar-shadow');
            } else {
                this.element.classList.remove('navbar-shadow');
            }
        }

        // Transparent behavior
        if (this.transparentValue) {
            if (scrollTop > this.scrollThreshold) {
                this.element.classList.add('navbar-opaque');
                this.element.classList.remove('navbar-transparent-active');
            } else {
                this.element.classList.remove('navbar-opaque');
                this.element.classList.add('navbar-transparent-active');
            }
        }

        this.lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
    }

    /**
     * Throttle function to limit execution rate
     */
    throttle(func, delay) {
        let lastCall = 0;
        return function (...args) {
            const now = Date.now();
            if (now - lastCall >= delay) {
                lastCall = now;
                return func(...args);
            }
        };
    }
}

