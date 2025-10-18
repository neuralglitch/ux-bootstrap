import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['firstPane', 'secondPane', 'divider'];
    
    static values = {
        orientation: { type: String, default: 'horizontal' },
        resizable: { type: Boolean, default: true },
        collapsible: { type: Boolean, default: false },
        persistent: { type: Boolean, default: false },
        storageKey: { type: String, default: '' },
        initialSize: { type: String, default: '50%' },
        minSize: { type: String, default: '10%' },
        maxSize: { type: String, default: '90%' },
        dividerSize: { type: Number, default: 4 },
        snapThreshold: { type: Number, default: 50 },
        collapsed: { type: String, default: '' }
    };

    connect() {
        this.isDragging = false;
        this.startPos = 0;
        this.startSize = 0;

        // Bind methods
        this.handleResize = this.handleResize.bind(this);
        this.stopResize = this.stopResize.bind(this);
        this.handleKeyboard = this.handleKeyboard.bind(this);

        // Initialize
        this.initialize();

        // Add keyboard support to divider
        this.dividerTarget.addEventListener('keydown', this.handleKeyboard);
    }

    disconnect() {
        this.removeResizeListeners();
        this.dividerTarget.removeEventListener('keydown', this.handleKeyboard);
    }

    initialize() {
        const isHorizontal = this.orientationValue === 'horizontal';
        
        // Load persisted size or use initial/collapsed state
        let size = this.initialSizeValue;

        if (this.persistentValue && this.storageKeyValue) {
            const stored = localStorage.getItem(`split-panes-${this.storageKeyValue}`);
            if (stored) {
                size = stored;
            }
        }

        // Handle collapsed state
        if (this.collapsedValue === 'first') {
            size = '0%';
        } else if (this.collapsedValue === 'second') {
            size = '100%';
        }

        // Apply initial size
        if (isHorizontal) {
            this.firstPaneTarget.style.width = size;
            this.firstPaneTarget.style.flexShrink = '0';
        } else {
            this.firstPaneTarget.style.height = size;
            this.firstPaneTarget.style.flexShrink = '0';
        }

        // Set divider cursor
        if (this.resizableValue) {
            this.dividerTarget.style.cursor = isHorizontal ? 'col-resize' : 'row-resize';
        }
    }

    startResize(event) {
        if (!this.resizableValue) return;

        event.preventDefault();
        
        this.isDragging = true;
        const isHorizontal = this.orientationValue === 'horizontal';

        // Get start position
        if (event.type === 'touchstart') {
            this.startPos = isHorizontal ? event.touches[0].clientX : event.touches[0].clientY;
        } else {
            this.startPos = isHorizontal ? event.clientX : event.clientY;
        }

        // Get current size
        const rect = this.firstPaneTarget.getBoundingClientRect();
        this.startSize = isHorizontal ? rect.width : rect.height;

        // Add listeners
        this.addResizeListeners();

        // Add dragging class
        this.element.classList.add('split-panes-dragging');
        document.body.style.cursor = isHorizontal ? 'col-resize' : 'row-resize';
        document.body.style.userSelect = 'none';
    }

    handleResize(event) {
        if (!this.isDragging) return;

        event.preventDefault();

        const isHorizontal = this.orientationValue === 'horizontal';
        let currentPos;

        if (event.type === 'touchmove') {
            currentPos = isHorizontal ? event.touches[0].clientX : event.touches[0].clientY;
        } else {
            currentPos = isHorizontal ? event.clientX : event.clientY;
        }

        const delta = currentPos - this.startPos;
        const newSize = this.startSize + delta;

        // Get container size
        const containerRect = this.element.getBoundingClientRect();
        const containerSize = isHorizontal ? containerRect.width : containerRect.height;

        // Calculate percentage
        let percentage = (newSize / containerSize) * 100;

        // Apply min/max constraints
        const minPx = this.parseSize(this.minSizeValue, containerSize);
        const maxPx = this.parseSize(this.maxSizeValue, containerSize);
        const minPercent = (minPx / containerSize) * 100;
        const maxPercent = (maxPx / containerSize) * 100;

        percentage = Math.max(minPercent, Math.min(maxPercent, percentage));

        // Snap to collapse if within threshold
        if (this.collapsibleValue) {
            const snapPx = this.snapThresholdValue;
            const snapPercent = (snapPx / containerSize) * 100;

            if (percentage < snapPercent) {
                percentage = 0;
            } else if (percentage > (100 - snapPercent)) {
                percentage = 100;
            }
        }

        // Apply size
        this.applySize(percentage);

        // Update aria-valuenow
        this.dividerTarget.setAttribute('aria-valuenow', Math.round(percentage).toString());
    }

    stopResize() {
        if (!this.isDragging) return;

        this.isDragging = false;

        // Remove listeners
        this.removeResizeListeners();

        // Remove dragging class
        this.element.classList.remove('split-panes-dragging');
        document.body.style.cursor = '';
        document.body.style.userSelect = '';

        // Save to localStorage if persistent
        if (this.persistentValue && this.storageKeyValue) {
            const isHorizontal = this.orientationValue === 'horizontal';
            const size = isHorizontal ? this.firstPaneTarget.style.width : this.firstPaneTarget.style.height;
            localStorage.setItem(`split-panes-${this.storageKeyValue}`, size);
        }
    }

    handleKeyboard(event) {
        if (!this.resizableValue) return;

        const isHorizontal = this.orientationValue === 'horizontal';
        const step = 5; // 5% per key press

        let handled = false;

        if ((isHorizontal && event.key === 'ArrowLeft') || (!isHorizontal && event.key === 'ArrowUp')) {
            this.adjustSize(-step);
            handled = true;
        } else if ((isHorizontal && event.key === 'ArrowRight') || (!isHorizontal && event.key === 'ArrowDown')) {
            this.adjustSize(step);
            handled = true;
        } else if (event.key === 'Home') {
            this.applySize(0);
            handled = true;
        } else if (event.key === 'End') {
            this.applySize(100);
            handled = true;
        }

        if (handled) {
            event.preventDefault();
            
            // Save to localStorage
            if (this.persistentValue && this.storageKeyValue) {
                const size = isHorizontal ? this.firstPaneTarget.style.width : this.firstPaneTarget.style.height;
                localStorage.setItem(`split-panes-${this.storageKeyValue}`, size);
            }
        }
    }

    adjustSize(delta) {
        const isHorizontal = this.orientationValue === 'horizontal';
        const current = isHorizontal ? this.firstPaneTarget.style.width : this.firstPaneTarget.style.height;
        const currentPercent = parseFloat(current) || 50;
        const newPercent = Math.max(0, Math.min(100, currentPercent + delta));
        
        this.applySize(newPercent);
    }

    applySize(percentage) {
        const isHorizontal = this.orientationValue === 'horizontal';
        const size = `${percentage}%`;

        if (isHorizontal) {
            this.firstPaneTarget.style.width = size;
        } else {
            this.firstPaneTarget.style.height = size;
        }

        // Update aria-valuenow
        this.dividerTarget.setAttribute('aria-valuenow', Math.round(percentage).toString());

        // Dispatch custom event
        this.element.dispatchEvent(new CustomEvent('split-panes:resize', {
            detail: { size: percentage }
        }));
    }

    parseSize(sizeString, containerSize) {
        if (sizeString.endsWith('%')) {
            return (parseFloat(sizeString) / 100) * containerSize;
        } else if (sizeString.endsWith('px')) {
            return parseFloat(sizeString);
        } else {
            return parseFloat(sizeString);
        }
    }

    addResizeListeners() {
        document.addEventListener('mousemove', this.handleResize);
        document.addEventListener('mouseup', this.stopResize);
        document.addEventListener('touchmove', this.handleResize);
        document.addEventListener('touchend', this.stopResize);
    }

    removeResizeListeners() {
        document.removeEventListener('mousemove', this.handleResize);
        document.removeEventListener('mouseup', this.stopResize);
        document.removeEventListener('touchmove', this.handleResize);
        document.removeEventListener('touchend', this.stopResize);
    }
}

