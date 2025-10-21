import {Controller} from '@hotwired/stimulus';
import * as bootstrap from 'bootstrap';

/**
 * Universal Offcanvas Controller
 *
 * Automatically initializes Bootstrap offcanvas on elements.
 * Works with sidebars, slide-out menus, and off-canvas panels.
 *
 * Usage:
 * 1. Automatic via component (recommended):
 *    <twig:bs:offcanvas id="mySidebar">...</twig:bs:offcanvas>
 *
 * 2. Manual on any element:
 *    <div data-controller="bs-offcanvas" class="offcanvas">
 *      Offcanvas content
 *    </div>
 *
 * Features:
 * - Auto-initialization of Bootstrap Offcanvas instances
 * - Proper cleanup for Turbo compatibility
 * - Support for all offcanvas options
 * - Debug logging when APP_DEBUG=1
 */
export default class extends Controller {
    static values = {
        backdrop: {type: Boolean, default: true},
        keyboard: {type: Boolean, default: true},
        scroll: {type: Boolean, default: false}
    };

    connect() {
        this.offcanvas = null;
        this.initializeOffcanvas();
    }

    disconnect() {
        this.disposeOffcanvas();
    }

    initializeOffcanvas() {
        const Offcanvas = window.bootstrap?.Offcanvas ?? bootstrap.Offcanvas;

        try {
            // Build options from values
            const options = {
                backdrop: this.backdropValue,
                keyboard: this.keyboardValue,
                scroll: this.scrollValue
            };

            // Create offcanvas instance
            this.offcanvas = new Offcanvas(this.element, options);
        } catch (error) {
            console.error('bs-offcanvas failed to initialize:', error);
        }

    }

    disposeOffcanvas() {
        if (this.offcanvas) {
            try {
                this.offcanvas.hide();
                this.offcanvas.dispose();
            } catch (error) {
                console.warn('bs-offcanvas Dispose error:', error);
            } finally {
                this.offcanvas = null;
            }
        }
    }

    // Public API methods

    show() {
        if (this.offcanvas) {
            this.offcanvas.show();

            console.debug('bs-offcanvas shown');
        }
    }

    hide() {
        if (this.offcanvas) {
            this.offcanvas.hide();

            console.debug('bs-offcanvas hidden');
        }
    }

    toggle() {
        if (this.offcanvas) {
            this.offcanvas.toggle();

            console.debug('bs-offcanvas toggled');
        }
    }
}

