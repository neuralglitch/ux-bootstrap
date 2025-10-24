import {Controller} from '@hotwired/stimulus';

/**
 * TreeView Controller
 *
 * Handles expand/collapse, selection, and keyboard navigation
 * for hierarchical tree structures
 */
export default class extends Controller {
    static targets = ['item', 'children'];

    static values = {
        selectable: Boolean,
        multiSelect: Boolean,
        keyboard: Boolean,
        onItemClick: String,
        onExpand: String,
        onCollapse: String,
        onSelectionChange: String,
        selectedIds: Array
    };

    connect() {
        if (this.keyboardValue) {
            this.element.setAttribute('tabindex', '0');
            this.element.addEventListener('keydown', this.handleKeyDown.bind(this));
        }

        // Focus management
        this.focusedItemIndex = -1;

        // Initialize selection from selectedIds
        if (this.selectableValue && this.hasSelectedIdsValue) {
            this.initializeSelection();
        }
        
        // Initialize chevron icons based on expanded state
        this.initializeChevrons();
    }
    
    /**
     * Initialize chevron icon visibility based on aria-expanded state
     */
    initializeChevrons() {
        const items = this.element.querySelectorAll('.tree-view-item');
        items.forEach(item => {
            const isExpanded = item.getAttribute('aria-expanded') === 'true';
            const toggle = item.querySelector('.tree-toggle');
            if (!toggle) return;
            
            const collapsedIcon = toggle.querySelector('.tree-chevron-collapsed');
            const expandedIcon = toggle.querySelector('.tree-chevron-expanded');
            
            if (collapsedIcon) {
                if (isExpanded) {
                    collapsedIcon.classList.add('d-none');
                    collapsedIcon.classList.remove('d-block');
                } else {
                    collapsedIcon.classList.add('d-block');
                    collapsedIcon.classList.remove('d-none');
                }
            }
            if (expandedIcon) {
                if (isExpanded) {
                    expandedIcon.classList.add('d-block');
                    expandedIcon.classList.remove('d-none');
                } else {
                    expandedIcon.classList.add('d-none');
                    expandedIcon.classList.remove('d-block');
                }
            }
        });
    }

    disconnect() {
        if (this.keyboardValue) {
            this.element.removeEventListener('keydown', this.handleKeyDown.bind(this));
        }
    }

    /**
     * Initialize selection state from selectedIds
     */
    initializeSelection() {
        this.itemTargets.forEach((item) => {
            const itemId = item.dataset.itemId;
            const checkbox = item.querySelector('input[type="checkbox"]');

            if (checkbox && this.selectedIdsValue.includes(itemId)) {
                checkbox.checked = true;
                item.classList.add('selected');
            }
        });
    }

    /**
     * Toggle node expansion (alias for backwards compatibility)
     */
    toggle(event) {
        this.toggleNode(event);
    }

    /**
     * Toggle node expansion
     */
    toggleNode(event) {
        // Stop if clicking on a file (no data-action attribute)
        if (!event.currentTarget.hasAttribute('data-action')) {
            event.preventDefault();
            event.stopPropagation();
            return;
        }
        
        // Stop event propagation to prevent double execution
        event.stopPropagation();
        
        // Stop event bubbling if clicking on a child tree item
        if (event.target !== event.currentTarget && event.target.closest('.tree-view-item') !== event.currentTarget) {
            return;
        }
        
        const item = event.currentTarget;
        const children = item.querySelector('.tree-view-children');
        
        // Always look for chevron icons in the item (not just in toggle button)
        const collapsedIcon = item.querySelector('.tree-chevron-collapsed');
        const expandedIcon = item.querySelector('.tree-chevron-expanded');

        if (!children || children.children.length === 0) return;

        const isExpanded = children.style.display !== 'none';

        if (isExpanded) {
            // Collapse
            children.style.display = 'none';
            item.setAttribute('aria-expanded', 'false');
            
            // Toggle icons
            if (collapsedIcon) {
                collapsedIcon.classList.add('d-block');
                collapsedIcon.classList.remove('d-none');
            }
            if (expandedIcon) {
                expandedIcon.classList.add('d-none');
                expandedIcon.classList.remove('d-block');
            }

            // Update folder icon visibility if present
            const closedIcon = item.querySelector('.tree-folder-closed');
            const openIcon = item.querySelector('.tree-folder-open');
            if (closedIcon && openIcon && item.querySelector('.tree-view-children')) {
                // Show closed icon, hide open icon
                closedIcon.classList.remove('d-none');
                closedIcon.classList.add('d-block');
                openIcon.classList.add('d-none');
                openIcon.classList.remove('d-block');
            }

            // Fire callback
            if (this.hasOnCollapseValue) {
                this.fireCallback(this.onCollapseValue, {
                    item: this.getItemData(item)
                });
            }
        } else {
            // Expand
            children.style.display = '';
            item.setAttribute('aria-expanded', 'true');
            
            // Toggle icons
            if (collapsedIcon) {
                collapsedIcon.classList.add('d-none');
                collapsedIcon.classList.remove('d-block');
            }
            if (expandedIcon) {
                expandedIcon.classList.add('d-block');
                expandedIcon.classList.remove('d-none');
            }

            // Update folder icon visibility if present
            const closedIcon = item.querySelector('.tree-folder-closed');
            const openIcon = item.querySelector('.tree-folder-open');
            if (closedIcon && openIcon && item.querySelector('.tree-view-children')) {
                // Show open icon, hide closed icon
                closedIcon.classList.add('d-none');
                closedIcon.classList.remove('d-block');
                openIcon.classList.remove('d-none');
                openIcon.classList.add('d-block');
            }

            // Fire callback
            if (this.hasOnExpandValue) {
                this.fireCallback(this.onExpandValue, {
                    item: this.getItemData(item)
                });
            }
        }
    }

    /**
     * Handle item click
     */
    handleItemClick(event) {
        const content = event.currentTarget;
        const item = content.closest('.tree-view-item');

        // Don't trigger if clicking on checkbox or toggle button
        if (event.target.matches('input[type="checkbox"]') ||
            event.target.closest('.tree-view-toggle')) {
            return;
        }

        // Fire callback
        if (this.hasOnItemClickValue) {
            this.fireCallback(this.onItemClickValue, {
                item: this.getItemData(item),
                event: event
            });
        }
    }

    /**
     * Handle selection change
     */
    handleSelectionChange(event) {
        const checkbox = event.currentTarget;
        const item = checkbox.closest('.tree-view-item');
        const isChecked = checkbox.checked;

        if (isChecked) {
            item.classList.add('selected');

            // If not multi-select, uncheck other checkboxes
            if (!this.multiSelectValue) {
                this.itemTargets.forEach((otherItem) => {
                    if (otherItem !== item) {
                        const otherCheckbox = otherItem.querySelector('input[type="checkbox"]');
                        if (otherCheckbox) {
                            otherCheckbox.checked = false;
                            otherItem.classList.remove('selected');
                        }
                    }
                });
            }
        } else {
            item.classList.remove('selected');
        }

        // Fire callback with all selected items
        if (this.hasOnSelectionChangeValue) {
            this.fireCallback(this.onSelectionChangeValue, {
                selectedItems: this.getSelectedItems(),
                item: this.getItemData(item),
                checked: isChecked
            });
        }
    }

    /**
     * Keyboard navigation
     */
    handleKeyDown(event) {
        if (!this.keyboardValue) return;

        const {key} = event;
        const visibleItems = this.getVisibleItems();

        if (visibleItems.length === 0) return;

        switch (key) {
            case 'ArrowDown':
                event.preventDefault();
                this.focusNextItem(visibleItems);
                break;
            case 'ArrowUp':
                event.preventDefault();
                this.focusPreviousItem(visibleItems);
                break;
            case 'ArrowRight':
                event.preventDefault();
                this.expandFocusedItem();
                break;
            case 'ArrowLeft':
                event.preventDefault();
                this.collapseFocusedItem();
                break;
            case 'Enter':
            case ' ':
                event.preventDefault();
                this.selectFocusedItem();
                break;
            case 'Home':
                event.preventDefault();
                this.focusFirstItem(visibleItems);
                break;
            case 'End':
                event.preventDefault();
                this.focusLastItem(visibleItems);
                break;
        }
    }

    /**
     * Get visible items (not in collapsed parents)
     */
    getVisibleItems() {
        return this.itemTargets.filter((item) => {
            let parent = item.parentElement;
            while (parent && parent !== this.element) {
                if (parent.classList.contains('tree-view-children') &&
                    parent.classList.contains('collapse')) {
                    return false;
                }
                parent = parent.parentElement;
            }
            return true;
        });
    }

    focusNextItem(visibleItems) {
        this.focusedItemIndex = Math.min(this.focusedItemIndex + 1, visibleItems.length - 1);
        this.focusItem(visibleItems[this.focusedItemIndex]);
    }

    focusPreviousItem(visibleItems) {
        this.focusedItemIndex = Math.max(this.focusedItemIndex - 1, 0);
        this.focusItem(visibleItems[this.focusedItemIndex]);
    }

    focusFirstItem(visibleItems) {
        this.focusedItemIndex = 0;
        this.focusItem(visibleItems[0]);
    }

    focusLastItem(visibleItems) {
        this.focusedItemIndex = visibleItems.length - 1;
        this.focusItem(visibleItems[this.focusedItemIndex]);
    }

    focusItem(item) {
        if (!item) return;

        // Remove focus from previous item
        this.itemTargets.forEach((i) => i.classList.remove('focused'));

        // Add focus to new item
        item.classList.add('focused');
        item.scrollIntoView({block: 'nearest', behavior: 'smooth'});
    }

    expandFocusedItem() {
        const visibleItems = this.getVisibleItems();
        const item = visibleItems[this.focusedItemIndex];

        if (!item) return;

        const toggleButton = item.querySelector('.tree-view-toggle');
        const children = item.querySelector('.tree-view-children');

        if (children && children.classList.contains('collapse') && toggleButton) {
            toggleButton.click();
        }
    }

    collapseFocusedItem() {
        const visibleItems = this.getVisibleItems();
        const item = visibleItems[this.focusedItemIndex];

        if (!item) return;

        const toggleButton = item.querySelector('.tree-view-toggle');
        const children = item.querySelector('.tree-view-children');

        if (children && !children.classList.contains('collapse') && toggleButton) {
            toggleButton.click();
        }
    }

    selectFocusedItem() {
        const visibleItems = this.getVisibleItems();
        const item = visibleItems[this.focusedItemIndex];

        if (!item) return;

        if (this.selectableValue) {
            const checkbox = item.querySelector('input[type="checkbox"]');
            if (checkbox) {
                checkbox.checked = !checkbox.checked;
                checkbox.dispatchEvent(new Event('change', {bubbles: true}));
            }
        }
    }

    /**
     * Get item data
     */
    getItemData(item) {
        const label = item.querySelector('.tree-view-label');
        return {
            id: item.dataset.itemId,
            label: label ? label.textContent.trim() : '',
            hasChildren: item.dataset.hasChildren === 'true',
            expanded: item.getAttribute('aria-expanded') === 'true'
        };
    }

    /**
     * Get all selected items
     */
    getSelectedItems() {
        return this.itemTargets
            .filter((item) => {
                const checkbox = item.querySelector('input[type="checkbox"]');
                return checkbox && checkbox.checked;
            })
            .map((item) => this.getItemData(item));
    }

    /**
     * Fire custom callback
     */
    fireCallback(functionName, data) {
        if (typeof window[functionName] === 'function') {
            window[functionName](data);
        }
    }

    /**
     * Helper methods for icon classes
     */
    getExpandIcon() {
        // Default to chevron-right, but could be configured
        return 'bi-chevron-right';
    }

    getCollapseIcon() {
        // Default to chevron-down, but could be configured
        return 'bi-chevron-down';
    }

    /**
     * Public API: Expand all nodes
     */
    expandAll() {
        this.itemTargets.forEach((item) => {
            const children = item.querySelector('.tree-view-children');
            if (children && children.classList.contains('collapse')) {
                const toggleButton = item.querySelector('.tree-view-toggle');
                if (toggleButton) {
                    toggleButton.click();
                }
            }
        });
    }

    /**
     * Public API: Collapse all nodes
     */
    collapseAll() {
        this.itemTargets.forEach((item) => {
            const children = item.querySelector('.tree-view-children');
            if (children && !children.classList.contains('collapse')) {
                const toggleButton = item.querySelector('.tree-view-toggle');
                if (toggleButton) {
                    toggleButton.click();
                }
            }
        });
    }

    /**
     * Public API: Get selected item IDs
     */
    getSelectedIds() {
        return this.getSelectedItems().map((item) => item.id);
    }

    /**
     * Public API: Clear selection
     */
    clearSelection() {
        this.itemTargets.forEach((item) => {
            const checkbox = item.querySelector('input[type="checkbox"]');
            if (checkbox && checkbox.checked) {
                checkbox.checked = false;
                item.classList.remove('selected');
            }
        });
    }
}

