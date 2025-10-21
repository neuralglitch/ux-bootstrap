import {Controller} from '@hotwired/stimulus';
import * as bootstrap from 'bootstrap';

/**
 * Universal Modal Controller
 *
 * Automatically initializes Bootstrap modals on elements.
 * Works with any component that has modal configuration.
 *
 * Usage:
 * 1. Automatic via component (recommended):
 *    <twig:bs:modal id="myModal">...</twig:bs:modal>
 *
 * 2. Manual on any element:
 *    <div data-controller="bs-modal" class="modal">
 *      <div class="modal-dialog">...</div>
 *    </div>
 *
 * Features:
 * - Auto-initialization of Bootstrap Modal instances
 * - Proper cleanup for Turbo compatibility
 * - Support for all Bootstrap modal options
 * - Debug logging when APP_DEBUG=1
 */
export default class extends Controller {
    static values = {
        backdrop: {type: String, default: 'true'},  // true|false|'static'
        keyboard: {type: Boolean, default: true},
        focus: {type: Boolean, default: true}
    };

    connect() {
        this.modal = null;
        this.initializeModal();
    }

    disconnect() {
        this.disposeModal();
    }

    initializeModal() {
        const Modal = window.bootstrap?.Modal ?? bootstrap.Modal;

        try {
            // Build options from values and data attributes
            const options = {
                backdrop: this.backdropValue === 'true' ? true :
                    this.backdropValue === 'false' ? false :
                        this.backdropValue,
                keyboard: this.keyboardValue,
                focus: this.focusValue
            };

            // Create modal instance
            this.modal = new Modal(this.element, options);
        } catch (error) {
            console.error('bs-modal failed to initialize:', error);
        }

    }

    disposeModal() {
        if (this.modal) {
            try {
                this.modal.hide();
                this.modal.dispose();
            } catch (error) {
                console.warn('bs-modal dispose error:', error);
            } finally {
                this.modal = null;
            }
        }
    }

    // Public API methods

    show() {
        if (this.modal) {
            this.modal.show();

            console.debug('bs-modal shown');
        }
    }

    hide() {
        if (this.modal) {
            this.modal.hide();

            console.debug('bs-modal hidden');
        }
    }

    toggle() {
        if (this.modal) {
            this.modal.toggle();

            console.debug('bs-modal toggled');
        }
    }
}

