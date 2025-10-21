import {Controller} from '@hotwired/stimulus';
import * as bootstrap from 'bootstrap';

/**
 * Universal Collapse Controller
 *
 * Automatically initializes Bootstrap collapse on elements.
 * Works with accordions, collapsible content, and any element with collapse functionality.
 *
 * Usage:
 * 1. Automatic via component (recommended):
 *    <twig:bs:collapse id="myCollapse">...</twig:bs:collapse>
 *
 * 2. Manual on any element:
 *    <div data-controller="bs-collapse" class="collapse">
 *      Collapsible content
 *    </div>
 *
 * Features:
 * - Auto-initialization of Bootstrap Collapse instances
 * - Proper cleanup for Turbo compatibility
 * - Support for parent accordion groups
 * - Debug logging when APP_DEBUG=1
 */
export default class extends Controller {
    static values = {
        parent: String,
        toggle: {type: Boolean, default: true}
    };

    connect() {
        this.collapse = null;
        this.initializeCollapse();
    }

    disconnect() {
        this.disposeCollapse();
    }

    initializeCollapse() {
        const Collapse = window.bootstrap?.Collapse ?? bootstrap.Collapse;

        try {
            // Build options from values
            const options = {
                toggle: this.toggleValue
            };

            if (this.hasParentValue && this.parentValue) {
                options.parent = this.parentValue;
            }

            // Create collapse instance
            this.collapse = new Collapse(this.element, options);
        } catch (error) {
            console.error('[bs-collapse] Failed to initialize:', error);
        }

    }

    disposeCollapse() {
        if (this.collapse) {
            try {
                this.collapse.hide();
                this.collapse.dispose();
            } catch (error) {
                console.warn('bs-collapse dispose error:', error);
            } finally {
                this.collapse = null;
            }
        }


// Public API methods

        show()
        {
            if (this.collapse) {
                this.collapse.show();
                console.debug('bs-collapse shown');
            }
        }

        hide()
        {
            if (this.collapse) {
                this.collapse.hide();

                console.debug('bs-collapse hidden');
            }
        }

        toggle()
        {
            if (this.collapse) {
                this.collapse.toggle();

                console.debug('bs-collapse toggled');
            }
        }
    }
}
