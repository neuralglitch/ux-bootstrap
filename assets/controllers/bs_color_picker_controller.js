import { Controller } from '@hotwired/stimulus';

/**
 * Color Picker Controller
 * 
 * Handles color selection from presets and custom color input
 * Synchronizes between preset swatches, hex input, and native color picker
 */
export default class extends Controller {
    static targets = ['input', 'picker', 'hiddenInput', 'presets'];
    
    static values = {
        value: String,
        showHex: Boolean,
        allowCustom: Boolean
    };

    connect() {
        this.updateUI(this.valueValue);
    }

    /**
     * Handle color selection from preset swatches
     */
    selectColor(event) {
        event.preventDefault();
        const color = event.currentTarget.dataset.color;
        this.setValue(color);
    }

    /**
     * Handle input from hex text field
     */
    updateFromInput(event) {
        let value = event.target.value.trim();
        
        // Remove # if present
        if (value.startsWith('#')) {
            value = value.substring(1);
        }
        
        // Validate hex format
        if (this.isValidHex(value)) {
            this.setValue('#' + value.toUpperCase());
        }
    }

    /**
     * Handle input from native color picker
     */
    updateFromPicker(event) {
        const color = event.target.value;
        this.setValue(color.toUpperCase());
    }

    /**
     * Set the color value and update all UI elements
     */
    setValue(color) {
        this.valueValue = color;
        this.updateUI(color);
        
        // Dispatch custom event for external listeners
        this.dispatch('change', { detail: { color } });
    }

    /**
     * Update all UI elements to reflect the current color
     */
    updateUI(color) {
        // Update hidden input (for form submission)
        if (this.hasHiddenInputTarget) {
            this.hiddenInputTarget.value = color || '';
        }

        // Update text input
        if (this.hasInputTarget) {
            if (this.showHexValue && color) {
                // Remove # for display in hex input
                this.inputTarget.value = color.replace('#', '');
            } else {
                this.inputTarget.value = color || '';
            }
        }

        // Update native color picker
        if (this.hasPickerTarget && color) {
            this.pickerTarget.value = color;
        }

        // Update preset swatches
        if (this.hasPresetsTarget) {
            const swatches = this.presetsTarget.querySelectorAll('.color-picker-swatch');
            swatches.forEach(swatch => {
                const swatchColor = swatch.dataset.color;
                if (swatchColor === color) {
                    swatch.classList.add('active');
                    // Add checkmark if not present
                    if (!swatch.querySelector('svg')) {
                        this.addCheckmark(swatch);
                    }
                } else {
                    swatch.classList.remove('active');
                    // Remove checkmark
                    const svg = swatch.querySelector('svg');
                    if (svg) {
                        svg.remove();
                    }
                }
            });
        }
    }

    /**
     * Add checkmark SVG to swatch
     */
    addCheckmark(swatch) {
        const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
        svg.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
        svg.setAttribute('width', '16');
        svg.setAttribute('height', '16');
        svg.setAttribute('fill', 'currentColor');
        svg.setAttribute('class', 'bi bi-check2');
        svg.setAttribute('viewBox', '0 0 16 16');
        
        const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
        path.setAttribute('d', 'M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z');
        
        svg.appendChild(path);
        swatch.appendChild(svg);
    }

    /**
     * Validate hex color format
     */
    isValidHex(hex) {
        return /^[0-9A-Fa-f]{6}$/.test(hex);
    }

    /**
     * Called when value changes
     */
    valueValueChanged(value) {
        this.updateUI(value);
    }
}

