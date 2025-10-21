import {Controller} from '@hotwired/stimulus';
import * as bootstrap from 'bootstrap';

/**
 * Universal Dropdown Controller
 *
 * Automatically initializes Bootstrap dropdowns on elements.
 * Works with any component that has dropdown configuration.
 *
 * Usage:
 * 1. Automatic via component (recommended):
 *    <twig:bs:dropdown>...</twig:bs:dropdown>
 *
 * 2. Manual on any element:
 *    <div data-controller="bs-dropdown">
 *      <button data-bs-toggle="dropdown">Toggle</button>
 *      <ul class="dropdown-menu">...</ul>
 *    </div>
 *
 * Features:
 * - Auto-initialization of Bootstrap Dropdown instances
 * - Proper cleanup for Turbo compatibility
 * - Debug logging when APP_DEBUG=1
 */
export default class extends Controller {
    connect() {
        this.dropdown = null;
        this.initializeDropdown();
    }

    disconnect() {
        this.disposeDropdown();
    }

    initializeDropdown() {
        const Dropdown = window.bootstrap?.Dropdown ?? bootstrap.Dropdown;

        // Find dropdown toggle button
        const toggle = this.element.querySelector('[data-bs-toggle="dropdown"]');

        if (!toggle) {
            console.warn('[bs-dropdown] No toggle button found');
        }

        try {
            // Create dropdown instance on the toggle button
            this.dropdown = new Dropdown(toggle);

            console
                .log(
                    '[bs-Initialized'
                )

        } catch
            (error) {
            console.error('[bs-dropdown] Failed to initialize:', error);
        }

    }

    disposeDropdown() {
        if (this.dropdown) {
            try {
                this.dropdown.hide();
                this.dropdown.dispose();
            } catch (error) {
                console.warn('bs-dropdown dispose error:', error);
            } finally {
                this.dropdown = null;
            }
        }
    }


    // Public API methods

    show() {
        if (this.dropdown) {
            this.dropdown.show();

            console.debug('bs-dropdown shown');
        }
    }

    hide() {
        if (this.dropdown) {
            this.dropdown.hide();

            console.debug('bs-dropdown hidden');
        }
    }

    toggle() {
        if (this.dropdown) {
            this.dropdown.toggle();

            console.debug('bs-dropdown toggled');
        }
    }
}

