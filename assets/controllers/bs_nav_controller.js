import { Controller } from '@hotwired/stimulus';

/**
 * Nav Controller
 * 
 * Provides enhanced navigation functionality:
 * - Active state management
 * - Tab switching
 * - Navigation tracking
 */
export default class extends Controller {
    static targets = ['link'];

    connect() {
        this.updateActiveState();
    }

    disconnect() {
    }

    updateActiveState() {
        const currentPath = window.location.pathname;
        
        this.linkTargets.forEach(link => {
            const href = link.getAttribute('href');
            if (href && href === currentPath) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
    }

    select(event) {
        const link = event.currentTarget;
        
        // Remove active from all
        this.linkTargets.forEach(l => l.classList.remove('active'));
        
        // Add active to clicked
        link.classList.add('active');
        
        console.debug('bs-nav selected:', link.textContent.trim());
        
        // Dispatch custom event
        this.element.dispatchEvent(new CustomEvent('bs-nav:change', {
            detail: { link: link }
        }));
    }
}

