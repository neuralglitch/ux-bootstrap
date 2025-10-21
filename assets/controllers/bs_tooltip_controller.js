import {Controller} from '@hotwired/stimulus';
import * as bootstrap from 'bootstrap';

/**
 * Universal Tooltip Controller
 *
 * Automatically initializes Bootstrap tooltips on elements.
 * Works with any component that has tooltip configuration.
 *
 * Usage:
 * 1. Automatic via component (recommended):
 *    <twig:bs:button :tooltip="{'text': 'Click me'}">Button</twig:bs:button>
 *
 * 2. Manual on any element:
 *    <div data-controller="bs-tooltip"
 *         data-bs-toggle="tooltip"
 *         data-bs-title="Tooltip text">
 *      Hover me
 *    </div>
 *
 * Supports all Bootstrap tooltip options via data attributes:
 * - data-bs-title: Tooltip text
 * - data-bs-placement: top|bottom|left|right
 * - data-bs-trigger: hover|click|focus
 * - data-bs-html: true|false
 * - data-bs-container: Selector for container
 * - data-bs-custom-class: Custom CSS class
 */
export default class extends Controller {
    connect() {
        this.tooltip = null;
        this.initializeTooltip();
    }

    disconnect() {
        this.disposeTooltip();
    }

    initializeTooltip() {
        const Tooltip = window.bootstrap?.Tooltip ?? bootstrap.Tooltip;

        // Check if element has tooltip data
        if (!this.element.hasAttribute('data-bs-toggle') ||
            this.element.getAttribute('data-bs-toggle') !== 'tooltip') {
            // No tooltip configured
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

            // Create tooltip instance
            this.tooltip = new Tooltip(this.element, options);
        } catch (error) {
            console.error('bs-tooltip failed to initialize:', error);
        }
    }

    disposeTooltip() {
        if (this.tooltip) {
            try {
                this.tooltip.hide();
                this.tooltip.dispose();
                console.debug('bs-tooltip disposed');
            } catch (error) {
                console.warn('bs-tooltip dispose error:', error);
            } finally {
                this.tooltip = null;
            }
        }
    }

    // Public API methods for programmatic control

    show() {
        if (this.tooltip) {
            this.tooltip.show();

            console.debug('bs-tooltip shown');
        }
    }

    hide() {
        if (this.tooltip) {
            this.tooltip.hide();

            console.debug('bs-tooltip hidden');
        }
    }

    toggle() {
        if (this.tooltip) {
            this.tooltip.toggle();

            console.debug('bs-tooltip toggled');
        }
    }
}
