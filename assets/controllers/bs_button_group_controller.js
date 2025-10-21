import { Controller } from '@hotwired/stimulus';

/**
 * Button Group Controller
 * 
 * Provides toggle group functionality:
 * - Radio-style selection (single select)
 * - Checkbox-style selection (multi select)
 * - Active state management
 */
export default class extends Controller {
    static targets = ['button'];
    
    static values = {
        mode: { type: String, default: 'radio' }, // 'radio' or 'checkbox'
        required: { type: Boolean, default: false }
    };

    connect() {
    }

    disconnect() {
    }

    toggle(event) {
        const button = event.currentTarget;
        const isActive = button.classList.contains('active');

        if (this.modeValue === 'radio') {
            // Radio mode - only one active
            if (this.requiredValue && isActive) {
                // Can't deselect if required
                return;
            }
            
            this.buttonTargets.forEach(btn => btn.classList.remove('active'));
            if (!isActive) {
                button.classList.add('active');
            }
        } else {
            // Checkbox mode - multiple active
            button.classList.toggle('active');
        }

        console.debug('bs-button-group toggled:', button.textContent.trim());
        
        // Dispatch custom event
        this.element.dispatchEvent(new CustomEvent('bs-button-group:change', {
            detail: {
                button: button,
                active: button.classList.contains('active'),
                mode: this.modeValue
            }
        }));
    }
}

