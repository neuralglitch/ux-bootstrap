import {Controller} from '@hotwired/stimulus';
import * as bootstrap from 'bootstrap';

/**
 * Universal Popover Controller
 *
 * Automatically initializes Bootstrap popovers on elements.
 * Works with any component that has popover configuration.
 *
 * Usage:
 * 1. Automatic via component (recommended):
 *    <twig:bs:button :popover="{'title': 'Title', 'content': 'Content'}">Button</twig:bs:button>
 *
 * 2. Manual on any element:
 *    <div data-controller="bs-popover"
 *         data-bs-toggle="popover"
 *         data-bs-title="Popover title"
 *         data-bs-content="Popover content">
 *      Click me
 *    </div>
 *
 * Supports all Bootstrap popover options via data attributes:
 * - data-bs-title: Popover title
 * - data-bs-content: Popover content
 * - data-bs-placement: top|bottom|left|right
 * - data-bs-trigger: click|hover|focus
 * - data-bs-html: true|false
 * - data-bs-container: Selector for container
 * - data-bs-custom-class: Custom CSS class
 */
export default class extends Controller {
    connect() {
        this.popover = null;
        this.initializePopover();
    }

    disconnect() {
        this.disposePopover();
    }

    initializePopover() {
        const Popover = window.bootstrap?.Popover ?? bootstrap.Popover;

        // Check if element has popover data
        if (!this.element.hasAttribute('data-bs-toggle') ||
            this.element.getAttribute('data-bs-toggle') !== 'popover') {
            // No popover configured
            return;
        }

        try {
            // Build options from data attributes
            const options = {};

            if (this.element.dataset.bsHtml) {
                options.html = this.element.dataset.bsHtml === 'true';
            }
            if (this.element.dataset.bsPlacement) {
                options.placement = this.element.dataset.bsPlacement;
            }
            if (this.element.dataset.bsTrigger) {
                options.trigger = this.element.dataset.bsTrigger;
            }
            if (this.element.dataset.bsContainer) {
                options.container = this.element.dataset.bsContainer;
            }
            if (this.element.dataset.bsCustomClass) {
                options.customClass = this.element.dataset.bsCustomClass;
            }
            if (this.element.dataset.bsDelay) {
                options.delay = parseInt(this.element.dataset.bsDelay, 10);
            }
            if (this.element.dataset.bsAnimation !== undefined) {
                options.animation = this.element.dataset.bsAnimation === 'true';
            }
            if (this.element.dataset.bsBoundary) {
                options.boundary = this.element.dataset.bsBoundary;
            }
            if (this.element.dataset.bsSanitize !== undefined) {
                options.sanitize = this.element.dataset.bsSanitize === 'true';
            }

            // Create popover instance
            this.popover = new Popover(this.element, options);

        } catch (error) {
            console.error('[bs-popover] Failed to initialize:', error);
        }

    }

    disposePopover() {
        if (this.popover) {
            try {
                this.popover.hide();
                this.popover.dispose();
            } catch (error) {
                console.warn('[bs-popover] Dispose error:', error);
            } finally {
                this.popover = null;
            }
        }
    }

    // Public API methods for programmatic control

    show() {
        if (this.popover) {
            this.popover.show();

            console.debug('bs-popover shown');
        }
    }

    hide() {
        if (this.popover) {
            this.popover.hide();

            console.debug('bs-popover hidden');
        }
    }

    toggle() {
        if (this.popover) {
            this.popover.toggle();

            console.debug('bs-popover toggled');
        }
    }
}
