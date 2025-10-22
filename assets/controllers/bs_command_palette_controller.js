import {Controller} from '@hotwired/stimulus';
import {Modal} from 'bootstrap';

/**
 * Bootstrap Command Palette Controller
 *
 * A Cmd+K style command palette for quick actions, navigation, and commands.
 *
 * Features:
 * - Keyboard shortcut to open (Cmd+K / Ctrl+K)
 * - Fuzzy search and filtering
 * - Keyboard navigation (arrow keys, enter, escape)
 * - Recent commands tracking
 * - Grouped commands by category
 * - Icons and shortcuts display
 *
 * Usage:
 * <twig:bs:command-palette
 *   searchUrl="/command-palette"
 *   :showRecent="true"
 *   :maxRecent="5"
 * />
 */
export default class extends Controller {
    static targets = [
        'input',
        'results',
        'groups',
        'recentSection',
        'recentList',
        'empty',
        'loading'
    ];

    static values = {
        searchUrl: String,
        minChars: {type: Number, default: 0},
        debounce: {type: Number, default: 150},
        closeOnSelect: {type: Boolean, default: true},
        closeOnEscape: {type: Boolean, default: true},
        closeOnBackdrop: {type: Boolean, default: true},
        triggerKey: {type: String, default: 'k'},
        triggerCtrl: {type: Boolean, default: false},
        triggerMeta: {type: Boolean, default: true},
        triggerShift: {type: Boolean, default: false},
        triggerAlt: {type: Boolean, default: false},
        showShortcuts: {type: Boolean, default: true},
        showIcons: {type: Boolean, default: true},
        showRecent: {type: Boolean, default: true},
        maxRecent: {type: Number, default: 5},
        grouped: {type: Boolean, default: true},
        animationDuration: {type: Number, default: 200}
    };

    connect() {
        this.timeout = null;
        this.abortController = null;
        this.modal = null;
        this.selectedIndex = -1;
        this.commands = [];
        this.filteredCommands = [];
        this.recentCommands = this.loadRecentCommands();

        // Initialize Bootstrap modal
        this.initModal();

        // Bind keyboard shortcut
        this.boundKeyboardHandler = this.handleGlobalKeydown.bind(this);
        document.addEventListener('keydown', this.boundKeyboardHandler);

        // Load recent commands if enabled
        if (this.showRecentValue && this.recentCommands.length > 0) {
            this.renderRecentCommands();
        }
    }

    disconnect() {
        document.removeEventListener('keydown', this.boundKeyboardHandler);
        this.clearTimeout();
        this.abortRequest();

        if (this.modal) {
            this.modal.dispose();
        }
    }

    initModal() {
        this.modal = new Modal(this.element, {
            backdrop: this.closeOnBackdropValue ? true : 'static',
            keyboard: this.closeOnEscapeValue
        });

        // Focus input when modal opens
        this.element.addEventListener('shown.bs.modal', () => {
            if (this.hasInputTarget) {
                this.inputTarget.focus();
            }
        });

        // Clear search when modal closes
        this.element.addEventListener('hidden.bs.modal', () => {
            this.clearSearch();
        });
    }

    handleGlobalKeydown(event) {
        const {key, ctrlKey, metaKey, shiftKey, altKey} = event;

        // Check if trigger shortcut matches
        const isCorrectKey = key.toLowerCase() === this.triggerKeyValue.toLowerCase();
        
        // Check modifiers - support EITHER Ctrl OR Meta (not both)
        let modifiersMatch = true;
        
        // If both Ctrl and Meta are configured, allow either one (cross-platform support)
        if (this.triggerCtrlValue && this.triggerMetaValue) {
            modifiersMatch = (ctrlKey || metaKey) && !shiftKey && !altKey;
        } else {
            // Otherwise check each modifier individually
            if (this.triggerCtrlValue && !ctrlKey) modifiersMatch = false;
            if (this.triggerMetaValue && !metaKey) modifiersMatch = false;
            if (this.triggerShiftValue && !shiftKey) modifiersMatch = false;
            if (this.triggerAltValue && !altKey) modifiersMatch = false;
            
            // Also ensure unwanted modifiers are NOT pressed
            if (!this.triggerCtrlValue && ctrlKey && !this.triggerMetaValue) modifiersMatch = false;
            if (!this.triggerMetaValue && metaKey && !this.triggerCtrlValue) modifiersMatch = false;
            if (!this.triggerShiftValue && shiftKey) modifiersMatch = false;
            if (!this.triggerAltValue && altKey) modifiersMatch = false;
        }

        if (isCorrectKey && modifiersMatch) {
            event.preventDefault();
            this.open();
        }
    }

    handleInput(event) {
        const query = this.inputTarget.value.trim();

        // Clear previous timeout
        this.clearTimeout();

        // Hide recent commands when user starts typing
        if (query.length > 0 && this.hasRecentSectionTarget) {
            this.recentSectionTarget.style.display = 'none';
        } else if (query.length === 0 && this.hasRecentSectionTarget) {
            this.recentSectionTarget.style.display = '';
        }

        // If query is too short, show initial state
        if (query.length < this.minCharsValue) {
            this.clearResults();
            return;
        }

        // Debounce the search
        this.timeout = setTimeout(() => {
            this.performSearch(query);
        }, this.debounceValue);
    }

    handleKeydown(event) {
        const {key} = event;

        switch (key) {
            case 'ArrowDown':
                event.preventDefault();
                this.selectNext();
                break;
            case 'ArrowUp':
                event.preventDefault();
                this.selectPrevious();
                break;
            case 'Enter':
                event.preventDefault();
                this.executeSelected();
                break;
            case 'Escape':
                if (this.closeOnEscapeValue) {
                    event.preventDefault();
                    this.close();
                }
                break;
            case 'Home':
                event.preventDefault();
                this.selectFirst();
                break;
            case 'End':
                event.preventDefault();
                this.selectLast();
                break;
        }
    }

    async performSearch(query) {
        // Abort previous request if still running
        this.abortRequest();

        // Create new abort controller
        this.abortController = new AbortController();

        try {
            this.showLoading();

            const url = new URL(this.searchUrlValue, window.location.origin);
            url.searchParams.set('q', query);

            const response = await fetch(url.toString(), {
                signal: this.abortController.signal,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            this.displayResults(data);

        } catch (error) {
            if (error.name === 'AbortError') {
                return;
            }
            console.error('Command palette search error:', error);
            this.showEmpty();
        } finally {
            this.hideLoading();
        }
    }

    displayResults(data) {
        if (!this.hasGroupsTarget) return;

        // Store commands for keyboard navigation
        this.commands = data.commands || [];
        this.filteredCommands = this.commands;

        if (this.commands.length === 0) {
            this.showEmpty();
            return;
        }

        // Hide empty state
        if (this.hasEmptyTarget) {
            this.emptyTarget.style.display = 'none';
        }

        // Group commands if enabled
        const groups = this.groupedValue ? this.groupCommands(this.commands) : {'All': this.commands};

        // Render groups
        let html = '';
        for (const [groupName, groupCommands] of Object.entries(groups)) {
            html += this.renderGroup(groupName, groupCommands);
        }

        this.groupsTarget.innerHTML = html;

        // Reset selection
        this.selectedIndex = -1;
        this.selectFirst();
    }

    groupCommands(commands) {
        const groups = {};

        commands.forEach(command => {
            const group = command.group || 'Other';
            if (!groups[group]) {
                groups[group] = [];
            }
            groups[group].push(command);
        });

        return groups;
    }

    renderGroup(groupName, commands) {
        let html = `
            <div class="command-palette-section">
                <div class="command-palette-section-header">
                    <span class="command-palette-section-title">${this.escapeHtml(groupName)}</span>
                </div>
                <div class="command-palette-list">
        `;

        commands.forEach((command, index) => {
            html += this.renderCommand(command, index);
        });

        html += `
                </div>
            </div>
        `;

        return html;
    }

    renderCommand(command, index) {
        const icon = this.showIconsValue && command.icon
            ? `<span class="command-palette-item-icon">${command.icon}</span>`
            : '';

        const shortcut = this.showShortcutsValue && command.shortcut
            ? `<kbd class="command-palette-item-shortcut">${this.escapeHtml(command.shortcut)}</kbd>`
            : '';

        const description = command.description
            ? `<span class="command-palette-item-description">${this.escapeHtml(command.description)}</span>`
            : '';

        return `
            <button
                type="button"
                class="command-palette-item"
                data-command-id="${this.escapeHtml(command.id || '')}"
                data-command-action="${this.escapeHtml(command.action || '')}"
                data-command-href="${this.escapeHtml(command.href || '')}"
                data-command-index="${index}"
                data-action="click->bs-command-palette#executeCommand mouseenter->bs-command-palette#hoverCommand"
            >
                ${icon}
                <div class="command-palette-item-content">
                    <span class="command-palette-item-label">${this.escapeHtml(command.label || command.name || '')}</span>
                    ${description}
                </div>
                ${shortcut}
            </button>
        `;
    }

    renderRecentCommands() {
        if (!this.hasRecentListTarget) return;

        if (this.recentCommands.length === 0) {
            if (this.hasRecentSectionTarget) {
                this.recentSectionTarget.style.display = 'none';
            }
            return;
        }

        let html = '';
        this.recentCommands.slice(0, this.maxRecentValue).forEach((command, index) => {
            html += this.renderCommand(command, index);
        });

        this.recentListTarget.innerHTML = html;
    }

    executeCommand(event) {
        const button = event.currentTarget;
        const commandId = button.dataset.commandId;
        const commandAction = button.dataset.commandAction;
        const commandHref = button.dataset.commandHref;
        const commandIndex = parseInt(button.dataset.commandIndex, 10);

        // Get full command data
        const command = this.commands[commandIndex];

        if (command) {
            // Save to recent commands
            this.addToRecent(command);

            // Execute command
            if (commandHref) {
                window.location.href = commandHref;
            } else if (commandAction) {
                // Dispatch custom event for command execution
                this.element.dispatchEvent(new CustomEvent('command:execute', {
                    detail: {
                        id: commandId,
                        action: commandAction,
                        command: command
                    },
                    bubbles: true
                }));
            }

            // Close modal if configured
            if (this.closeOnSelectValue) {
                this.close();
            }
        }
    }

    executeSelected() {
        const selectedButton = this.getSelectedButton();
        if (selectedButton) {
            selectedButton.click();
        }
    }

    hoverCommand(event) {
        const button = event.currentTarget;
        const index = parseInt(button.dataset.commandIndex, 10);
        this.selectByIndex(index);
    }

    selectNext() {
        const items = this.getAllCommandButtons();
        if (items.length === 0) return;

        this.selectedIndex = (this.selectedIndex + 1) % items.length;
        this.updateSelection(items);
    }

    selectPrevious() {
        const items = this.getAllCommandButtons();
        if (items.length === 0) return;

        this.selectedIndex = this.selectedIndex <= 0 ? items.length - 1 : this.selectedIndex - 1;
        this.updateSelection(items);
    }

    selectFirst() {
        const items = this.getAllCommandButtons();
        if (items.length === 0) return;

        this.selectedIndex = 0;
        this.updateSelection(items);
    }

    selectLast() {
        const items = this.getAllCommandButtons();
        if (items.length === 0) return;

        this.selectedIndex = items.length - 1;
        this.updateSelection(items);
    }

    selectByIndex(index) {
        const items = this.getAllCommandButtons();
        if (items.length === 0) return;

        this.selectedIndex = index;
        this.updateSelection(items);
    }

    updateSelection(items) {
        // Remove previous selection
        items.forEach(item => item.classList.remove('selected'));

        // Add selection to current item
        if (items[this.selectedIndex]) {
            items[this.selectedIndex].classList.add('selected');
            items[this.selectedIndex].scrollIntoView({
                block: 'nearest',
                behavior: 'smooth'
            });
        }
    }

    getAllCommandButtons() {
        return Array.from(this.element.querySelectorAll('.command-palette-item'));
    }

    getSelectedButton() {
        return this.element.querySelector('.command-palette-item.selected');
    }

    addToRecent(command) {
        if (!this.showRecentValue) return;

        // Remove if already exists
        this.recentCommands = this.recentCommands.filter(c => c.id !== command.id);

        // Add to start
        this.recentCommands.unshift(command);

        // Limit size
        this.recentCommands = this.recentCommands.slice(0, this.maxRecentValue);

        // Save to localStorage
        this.saveRecentCommands();
    }

    loadRecentCommands() {
        try {
            const stored = localStorage.getItem('command-palette-recent');
            return stored ? JSON.parse(stored) : [];
        } catch (e) {
            return [];
        }
    }

    saveRecentCommands() {
        try {
            localStorage.setItem('command-palette-recent', JSON.stringify(this.recentCommands));
        } catch (e) {
            // Ignore localStorage errors
        }
    }

    clearSearch() {
        if (this.hasInputTarget) {
            this.inputTarget.value = '';
        }
        this.clearResults();
        this.selectedIndex = -1;

        // Show recent commands again
        if (this.hasRecentSectionTarget && this.showRecentValue) {
            this.recentSectionTarget.style.display = '';
        }
    }

    clearResults() {
        if (this.hasGroupsTarget) {
            this.groupsTarget.innerHTML = '';
        }
        if (this.hasEmptyTarget) {
            this.emptyTarget.style.display = 'none';
        }
    }

    showEmpty() {
        this.clearResults();
        if (this.hasEmptyTarget) {
            this.emptyTarget.style.display = 'flex';
        }
    }

    showLoading() {
        if (this.hasLoadingTarget) {
            this.loadingTarget.style.display = 'flex';
        }
    }

    hideLoading() {
        if (this.hasLoadingTarget) {
            this.loadingTarget.style.display = 'none';
        }
    }

    open() {
        if (this.modal) {
            this.modal.show();
        }
    }

    close() {
        if (this.modal) {
            // Blur input before hiding to prevent aria-hidden focus conflict
            if (this.hasInputTarget && document.activeElement === this.inputTarget) {
                this.inputTarget.blur();
            }
            this.modal.hide();
        }
    }

    clearTimeout() {
        if (this.timeout) {
            clearTimeout(this.timeout);
            this.timeout = null;
        }
    }

    abortRequest() {
        if (this.abortController) {
            this.abortController.abort();
            this.abortController = null;
        }
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
}

