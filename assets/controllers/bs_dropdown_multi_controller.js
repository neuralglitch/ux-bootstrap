import {Controller} from '@hotwired/stimulus';

/**
 * Multi-select dropdown controller
 *
 * Handles:
 * - Multiple checkbox selections
 * - Select all / Clear all functionality
 * - Search/filter options
 * - Dynamic button label updates
 * - Apply button behavior (close on apply vs. auto-update)
 */
export default class extends Controller {
    static targets = [
        'toggle',
        'label',
        'checkbox',
        'option',
        'optionsList',
        'search',
        'noResults'
    ];

    static values = {
        name: String,
        showApply: Boolean,
        searchable: Boolean,
        minChars: {type: Number, default: 0}
    };

    connect() {
        this.updateLabel();

        // Store original options for search filtering
        if (this.searchableValue) {
            this.allOptions = Array.from(this.optionTargets);
        }
    }

    /**
     * Update selection when checkbox changes
     */
    updateSelection(event) {
        // If not using apply button, update immediately
        if (!this.showApplyValue) {
            this.updateLabel();

            // Dispatch custom event for form integration
            this.dispatch('change', {
                detail: {
                    selected: this.getSelectedValues(),
                    count: this.getSelectedCount()
                }
            });
        }
    }

    /**
     * Select all checkboxes
     */
    selectAll(event) {
        event.preventDefault();
        event.stopPropagation();

        // Clear search first
        if (this.hasSearchTarget) {
            this.searchTarget.value = '';
            this.search({ target: this.searchTarget });
        }

        this.checkboxTargets.forEach(checkbox => {
            if (!checkbox.disabled) {
                checkbox.checked = true;
            }
        });

        if (!this.showApplyValue) {
            this.updateLabel();
            this.dispatchChangeEvent();
        }
    }

    /**
     * Clear all checkboxes
     */
    clearAll(event) {
        event.preventDefault();
        event.stopPropagation();

        // Clear search first
        if (this.hasSearchTarget) {
            this.searchTarget.value = '';
            this.search({ target: this.searchTarget });
        }

        this.checkboxTargets.forEach(checkbox => {
            if (!checkbox.disabled) {
                checkbox.checked = false;
            }
        });

        if (!this.showApplyValue) {
            this.updateLabel();
            this.dispatchChangeEvent();
        }
    }

    /**
     * Apply button clicked - update and close dropdown
     */
    apply(event) {
        event.preventDefault();
        event.stopPropagation();

        this.updateLabel();
        this.dispatchChangeEvent();

        // Close the dropdown
        const dropdownToggle = this.toggleTarget;
        const dropdown = bootstrap.Dropdown.getInstance(dropdownToggle);
        if (dropdown) {
            dropdown.hide();
        }
    }

    /**
     * Search/filter options
     */
    search(event) {
        if (!this.searchableValue) return;

        const query = event.target.value.toLowerCase().trim();

        // Don't filter until minimum chars met
        if (query.length > 0 && query.length < this.minCharsValue) {
            return;
        }

        let visibleCount = 0;

        this.optionTargets.forEach(option => {
            const label = option.dataset.optionLabel.toLowerCase();
            const matches = query === '' || label.includes(query);

            option.style.display = matches ? '' : 'none';
            if (matches) visibleCount++;
        });

        // Show/hide no results message
        if (this.hasNoResultsTarget) {
            if (visibleCount === 0) {
                this.noResultsTarget.classList.remove('d-none');
            } else {
                this.noResultsTarget.classList.add('d-none');
            }
        }
    }

    /**
     * Update button label based on selections
     */
    updateLabel() {
        if (!this.hasLabelTarget) return;

        const selected = this.getSelectedCheckboxes();
        const count = selected.length;

        if (count === 0) {
            // Get placeholder from data attribute or use default
            const placeholder = this.element.dataset.placeholder || 'Select options';
            this.labelTarget.textContent = placeholder;
            return;
        }

        // Get max display from data attribute or use default
        const maxDisplay = parseInt(this.element.dataset.maxDisplay || '3');

        if (count <= maxDisplay) {
            // Show individual labels
            const labels = selected.map(checkbox => {
                return checkbox.closest('[data-option-label]').dataset.optionLabel;
            });
            this.labelTarget.textContent = labels.join(', ');
        } else {
            // Show count
            const countFormat = this.element.dataset.countFormat || '{count} selected';
            this.labelTarget.textContent = countFormat.replace('{count}', count);
        }
    }

    /**
     * Get all checked checkboxes
     */
    getSelectedCheckboxes() {
        return this.checkboxTargets.filter(checkbox => checkbox.checked);
    }

    /**
     * Get selected count
     */
    getSelectedCount() {
        return this.getSelectedCheckboxes().length;
    }

    /**
     * Get array of selected values
     */
    getSelectedValues() {
        return this.getSelectedCheckboxes().map(checkbox => checkbox.value);
    }

    /**
     * Dispatch change event
     */
    dispatchChangeEvent() {
        this.dispatch('change', {
            detail: {
                selected: this.getSelectedValues(),
                count: this.getSelectedCount()
            }
        });
    }

    /**
     * Public API: Programmatically set selected values
     */
    setSelected(values) {
        const valueSet = new Set(values);

        this.checkboxTargets.forEach(checkbox => {
            checkbox.checked = valueSet.has(checkbox.value);
        });

        this.updateLabel();
        this.dispatchChangeEvent();
    }

    /**
     * Public API: Get selected values
     */
    getSelected() {
        return this.getSelectedValues();
    }

    /**
     * Public API: Clear all selections
     */
    clear() {
        this.checkboxTargets.forEach(checkbox => {
            checkbox.checked = false;
        });

        this.updateLabel();
        this.dispatchChangeEvent();
    }
}

