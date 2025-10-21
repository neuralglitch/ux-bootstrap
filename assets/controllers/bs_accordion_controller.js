import { Controller } from '@hotwired/stimulus';

/**
 * Accordion Controller
 * 
 * Provides enhanced accordion functionality:
 * - Expand all / Collapse all
 * - Keyboard navigation
 * - State management
 */
export default class extends Controller {
    static targets = ['item'];

    connect() {
    }

    disconnect() {
    }

    expandAll() {
        this.itemTargets.forEach(item => {
            const button = item.querySelector('.accordion-button.collapsed');
            if (button) {
                button.click();
            }
        });
        console.debug('bs-accordion expanded all items');
    }

    collapseAll() {
        this.itemTargets.forEach(item => {
            const button = item.querySelector('.accordion-button:not(.collapsed)');
            if (button) {
                button.click();
            }
        });
        console.debug('bs-accordion collapsed all items');
    }
}

