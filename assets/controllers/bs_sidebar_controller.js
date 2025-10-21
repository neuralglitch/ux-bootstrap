import {Controller} from '@hotwired/stimulus';

/**
 * Sidebar Controller
 *
 * Handles sidebar toggle, collapse, and mobile behavior
 * Supports: fixed, collapsible, overlay, push, and mini variants
 */
export default class extends Controller {
    static targets = ['header', 'body', 'footer', 'backdrop', 'toggleBtn', 'navItem'];

    static values = {
        variant: {type: String, default: 'fixed'},
        position: {type: String, default: 'left'},
        collapsed: {type: Boolean, default: false},
        collapsible: {type: Boolean, default: true},
        overlay: {type: Boolean, default: false},
        backdropClose: {type: Boolean, default: true},
        mobileBreakpoint: {type: String, default: 'lg'},
        mobileBehavior: {type: String, default: 'overlay'},
        width: {type: String, default: '280px'},
        miniWidth: {type: String, default: '80px'},
        transition: {type: String, default: 'slide'},
        transitionDuration: {type: Number, default: 300}
    };

    connect() {
        // Set initial collapsed state
        this.updateCollapsedState();

        // Handle mobile behavior
        this.handleMobileBehavior();

        // Add resize listener for responsive behavior
        this.resizeHandler = this.handleResize.bind(this);
        window.addEventListener('resize', this.resizeHandler);

        // Listen for escape key to close
        this.escapeHandler = this.handleEscape.bind(this);
        document.addEventListener('keydown', this.escapeHandler);

        // Store body push state
        this.bodyPushClass = `sidebar-push-${this.positionValue}`;
    }

    disconnect() {
        window.removeEventListener('resize', this.resizeHandler);
        document.removeEventListener('keydown', this.escapeHandler);

        // Cleanup body push class
        if (this.variantValue === 'push') {
            document.body.classList.remove(this.bodyPushClass);
        }
    }

    /**
     * Toggle sidebar open/close
     */
    toggle() {
        if (this.collapsedValue) {
            this.open();
        } else {
            this.close();
        }
    }

    /**
     * Open sidebar
     */
    open() {
        if (!this.collapsibleValue) return;

        this.collapsedValue = false;
        this.updateCollapsedState();

        // Dispatch custom event
        this.dispatch('opened', {detail: {sidebar: this.element}});
    }

    /**
     * Close sidebar
     */
    close() {
        if (!this.collapsibleValue) return;

        this.collapsedValue = true;
        this.updateCollapsedState();

        // Dispatch custom event
        this.dispatch('closed', {detail: {sidebar: this.element}});
    }

    /**
     * Update collapsed state on element and backdrop
     */
    updateCollapsedState() {
        if (this.collapsedValue) {
            this.element.classList.add('ux-sidebar--collapsed');

            // Hide backdrop
            if (this.hasBackdropTarget) {
                this.backdropTarget.classList.remove('show');
                setTimeout(() => {
                    this.backdropTarget.style.display = 'none';
                }, this.transitionDurationValue);
            }

            // Remove body push class
            if (this.variantValue === 'push') {
                document.body.classList.remove(this.bodyPushClass);
            }
        } else {
            this.element.classList.remove('ux-sidebar--collapsed');

            // Show backdrop
            if (this.hasBackdropTarget && (this.overlayValue || this.isMobile())) {
                this.backdropTarget.style.display = 'block';
                setTimeout(() => {
                    this.backdropTarget.classList.add('show');
                }, 10);
            }

            // Add body push class
            if (this.variantValue === 'push' && !this.isMobile()) {
                document.body.classList.add(this.bodyPushClass);
                document.body.style.setProperty('--sidebar-width', this.widthValue);
            }
        }

        // Update toggle button aria state
        if (this.hasToggleBtnTarget) {
            this.toggleBtnTarget.setAttribute('aria-expanded', !this.collapsedValue);
        }
    }

    /**
     * Handle mobile responsive behavior
     */
    handleMobileBehavior() {
        if (this.isMobile()) {
            // Force collapsed on mobile by default
            if (!this.element.hasAttribute('data-mobile-open')) {
                this.collapsedValue = true;
                this.updateCollapsedState();
            }

            // Apply mobile behavior
            this.element.classList.add(`ux-sidebar--mobile-${this.mobileBehaviorValue}`);
        } else {
            this.element.classList.remove(`ux-sidebar--mobile-${this.mobileBehaviorValue}`);
        }
    }

    /**
     * Handle window resize
     */
    handleResize() {
        this.handleMobileBehavior();
    }

    /**
     * Handle escape key press
     */
    handleEscape(event) {
        if (event.key === 'Escape' && !this.collapsedValue && this.collapsibleValue) {
            this.close();
        }
    }

    /**
     * Check if current viewport is mobile
     */
    isMobile() {
        const breakpoints = {
            'sm': 576,
            'md': 768,
            'lg': 992,
            'xl': 1200,
            'xxl': 1400
        };

        const breakpoint = breakpoints[this.mobileBreakpointValue] || 992;
        return window.innerWidth < breakpoint;
    }

    /**
     * Handle nav item click (for collapsible menu items)
     */
    handleNavItemClick(event) {
        const target = event.currentTarget;
        const parent = target.closest('.nav-item');

        // Check if item has submenu
        const submenu = parent?.querySelector('.ux-sidebar__submenu');
        if (submenu) {
            event.preventDefault();

            // Toggle submenu
            const isOpen = parent.classList.contains('open');

            // Close other submenus (optional - accordion behavior)
            if (!isOpen) {
                this.navItemTargets.forEach(item => {
                    const itemParent = item.closest('.nav-item');
                    if (itemParent !== parent) {
                        itemParent?.classList.remove('open');
                    }
                });
            }

            parent.classList.toggle('open');
        }

        // Close sidebar on mobile when nav item clicked (if no submenu)
        if (this.isMobile() && !submenu) {
            this.close();
        }
    }

    /**
     * Value changed callbacks
     */
    collapsedValueChanged() {
        this.updateCollapsedState();
    }

    variantValueChanged() {
        // Update variant class
        const variantClasses = ['fixed', 'collapsible', 'overlay', 'push', 'mini'];
        variantClasses.forEach(variant => {
            this.element.classList.remove(`ux-sidebar--${variant}`);
        });
        this.element.classList.add(`ux-sidebar--${this.variantValue}`);
    }

    positionValueChanged() {
        // Update position class
        this.element.classList.remove('ux-sidebar--left', 'ux-sidebar--right');
        this.element.classList.add(`ux-sidebar--${this.positionValue}`);
    }
}

