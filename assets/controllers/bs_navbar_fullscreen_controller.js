import { Controller } from '@hotwired/stimulus';

/**
 * Fullscreen Navbar Controller
 * 
 * Handles fullscreen overlay navigation with various animation types
 * 
 * Values:
 *   - animation: 'fade' | 'slide-down' | 'scale'
 * 
 * Targets:
 *   - overlay: The fullscreen overlay element
 * 
 * Actions:
 *   - toggle: Toggle the overlay
 *   - open: Open the overlay
 *   - close: Close the overlay
 */
export default class extends Controller {
    static targets = ['overlay'];
    static values = {
        animation: { type: String, default: 'fade' }
    };

    connect() {
        this.isOpen = false;
        
        // Add animation class to overlay
        if (this.hasOverlayTarget) {
            this.overlayTarget.classList.add(`navbar-fullscreen-${this.animationValue}`);
            
            // Initially hidden
            this.overlayTarget.style.display = 'none';
            this.overlayTarget.setAttribute('aria-hidden', 'true');
        }

        // Close on Escape key
        this.escapeHandler = this.handleEscape.bind(this);
        document.addEventListener('keydown', this.escapeHandler);
    }

    disconnect() {
        document.removeEventListener('keydown', this.escapeHandler);
    }

    toggle(event) {
        event?.preventDefault();
        
        if (this.isOpen) {
            this.close();
        } else {
            this.open();
        }
    }

    open(event) {
        event?.preventDefault();
        
        if (!this.hasOverlayTarget || this.isOpen) return;
        
        this.isOpen = true;
        
        // Prevent body scroll
        document.body.style.overflow = 'hidden';
        
        // Show overlay
        this.overlayTarget.style.display = 'flex';
        
        // Trigger reflow for animation
        this.overlayTarget.offsetHeight;
        
        // Add active class for animation
        this.overlayTarget.classList.add('active');
        this.overlayTarget.setAttribute('aria-hidden', 'false');
        
        // Update toggler button
        this.updateTogglerState(true);
        
        // Dispatch event
        this.dispatch('opened', { detail: { overlay: this.overlayTarget } });
    }

    close(event) {
        event?.preventDefault();
        
        if (!this.hasOverlayTarget || !this.isOpen) return;
        
        this.isOpen = false;
        
        // Remove active class
        this.overlayTarget.classList.remove('active');
        this.overlayTarget.setAttribute('aria-hidden', 'true');
        
        // Wait for animation to finish before hiding
        const animationDuration = parseFloat(
            getComputedStyle(this.overlayTarget).transitionDuration
        ) * 1000;
        
        setTimeout(() => {
            if (!this.isOpen) {
                this.overlayTarget.style.display = 'none';
                document.body.style.overflow = '';
            }
        }, animationDuration || 300);
        
        // Update toggler button
        this.updateTogglerState(false);
        
        // Dispatch event
        this.dispatch('closed', { detail: { overlay: this.overlayTarget } });
    }

    handleEscape(event) {
        if (event.key === 'Escape' && this.isOpen) {
            this.close();
        }
    }

    updateTogglerState(isExpanded) {
        // Find the toggler button
        const toggler = this.element.querySelector('.navbar-toggler');
        if (toggler) {
            toggler.setAttribute('aria-expanded', isExpanded.toString());
        }
    }
}

