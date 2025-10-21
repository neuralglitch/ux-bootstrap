import { Controller } from '@hotwired/stimulus';

/**
 * Button Controller
 * 
 * Provides enhanced button functionality:
 * - Loading states
 * - Click debouncing
 * - Disabled state management
 */
export default class extends Controller {
    static values = {
        loading: { type: Boolean, default: false },
        debounce: { type: Number, default: 0 }
    };

    debounceTimer = null;

    connect() {
    }

    disconnect() {
        if (this.debounceTimer) {
            clearTimeout(this.debounceTimer);
        }
    }

    setLoading(state) {
        this.loadingValue = state;
        this.element.disabled = state;
        
        if (state) {
            this.element.classList.add('loading');
        } else {
            this.element.classList.remove('loading');
        }
        
        console.debug('bs-button loading state:', state);
    }

    click(event) {
        if (this.debounceValue > 0) {
            if (this.debounceTimer) {
                event.preventDefault();
                return;
            }
            
            this.debounceTimer = setTimeout(() => {
                this.debounceTimer = null;
            }, this.debounceValue);
        }
    }
}

