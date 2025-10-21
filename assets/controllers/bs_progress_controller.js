import { Controller } from '@hotwired/stimulus';

/**
 * Progress Controller
 * 
 * Provides animated progress bar updates:
 * - Smooth animations
 * - Value updates
 * - Color changes based on progress
 */
export default class extends Controller {
    static targets = ['bar'];
    
    static values = {
        value: { type: Number, default: 0 },
        animated: { type: Boolean, default: true }
    };

    connect() {
        console.log('[bs-progress] Connected', this.element);
        this.updateProgress();
    }

    disconnect() {
        console.log('[bs-progress] Disconnected');
    }

    valueValueChanged() {
        this.updateProgress();
    }

    updateProgress() {
        if (this.hasBarTarget) {
            const value = Math.max(0, Math.min(100, this.valueValue));
            this.barTarget.style.width = `${value}%`;
            this.barTarget.setAttribute('aria-valuenow', value);
            
            console.log('[bs-progress] Updated to:', value + '%');
        }
    }

    setValue(value) {
        this.valueValue = value;
    }

    increment(amount = 1) {
        this.valueValue = Math.min(100, this.valueValue + amount);
    }

    decrement(amount = 1) {
        this.valueValue = Math.max(0, this.valueValue - amount);
    }
}

