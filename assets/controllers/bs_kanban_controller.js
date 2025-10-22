import {Controller} from '@hotwired/stimulus';

/**
 * Kanban Board Controller
 *
 * Manages drag-and-drop functionality for kanban boards
 *
 * Usage:
 *   <div data-controller="bs-kanban" data-bs-kanban-draggable-value="true">
 *     ...kanban columns and cards...
 *   </div>
 */
export default class extends Controller {
    static values = {
        draggable: {type: Boolean, default: true},
        crossColumn: {type: Boolean, default: true}
    };

    static targets = ['card', 'column'];

    connect() {
        if (this.draggableValue) {
            this.initializeDragAndDrop();
        }
        this.updateColumnCounts();
    }

    disconnect() {
        this.removeDragAndDropListeners();
    }

    initializeDragAndDrop() {
        // Find all kanban cards
        const cards = this.element.querySelectorAll('[data-kanban-card]');
        cards.forEach(card => {
            if (card.getAttribute('draggable') === 'true') {
                this.addCardDragListeners(card);
            }
        });

        // Find all drop zones (column bodies)
        const dropZones = this.element.querySelectorAll('[data-kanban-drop-zone]');
        dropZones.forEach(dropZone => {
            this.addDropZoneListeners(dropZone);
        });
    }

    addCardDragListeners(card) {
        card.addEventListener('dragstart', this.handleDragStart.bind(this));
        card.addEventListener('dragend', this.handleDragEnd.bind(this));
    }

    addDropZoneListeners(dropZone) {
        dropZone.addEventListener('dragover', this.handleDragOver.bind(this));
        dropZone.addEventListener('dragenter', this.handleDragEnter.bind(this));
        dropZone.addEventListener('dragleave', this.handleDragLeave.bind(this));
        dropZone.addEventListener('drop', this.handleDrop.bind(this));
    }

    removeDragAndDropListeners() {
        const cards = this.element.querySelectorAll('[data-kanban-card]');
        cards.forEach(card => {
            card.removeEventListener('dragstart', this.handleDragStart);
            card.removeEventListener('dragend', this.handleDragEnd);
        });

        const dropZones = this.element.querySelectorAll('[data-kanban-drop-zone]');
        dropZones.forEach(dropZone => {
            dropZone.removeEventListener('dragover', this.handleDragOver);
            dropZone.removeEventListener('dragenter', this.handleDragEnter);
            dropZone.removeEventListener('dragleave', this.handleDragLeave);
            dropZone.removeEventListener('drop', this.handleDrop);
        });
    }

    handleDragStart(event) {
        const card = event.target.closest('[data-kanban-card]');
        if (!card) return;

        card.classList.add('dragging');
        event.dataTransfer.effectAllowed = 'move';
        event.dataTransfer.setData('text/html', card.innerHTML);
        event.dataTransfer.setData('card-id', card.dataset.kanbanCard);

        // Store the source column
        const sourceColumn = card.closest('[data-kanban-column]');
        if (sourceColumn) {
            event.dataTransfer.setData('source-column', sourceColumn.dataset.kanbanColumn);
        }
    }

    handleDragEnd(event) {
        const card = event.target.closest('[data-kanban-card]');
        if (!card) return;

        card.classList.remove('dragging');

        // Remove all drop zone highlights
        const dropZones = this.element.querySelectorAll('[data-kanban-drop-zone]');
        dropZones.forEach(zone => {
            zone.classList.remove('drag-over');
        });
    }

    handleDragOver(event) {
        event.preventDefault();
        event.dataTransfer.dropEffect = 'move';
    }

    handleDragEnter(event) {
        const dropZone = event.target.closest('[data-kanban-drop-zone]');
        if (!dropZone) return;

        // Check if cross-column dragging is allowed
        if (!this.crossColumnValue) {
            const sourceColumn = event.dataTransfer.getData('source-column');
            const targetColumn = dropZone.closest('[data-kanban-column]')?.dataset.kanbanColumn;
            if (sourceColumn !== targetColumn) {
                return;
            }
        }

        dropZone.classList.add('drag-over');
    }

    handleDragLeave(event) {
        const dropZone = event.target.closest('[data-kanban-drop-zone]');
        if (!dropZone) return;

        // Only remove highlight if we're actually leaving the drop zone
        const rect = dropZone.getBoundingClientRect();
        const x = event.clientX;
        const y = event.clientY;

        if (x < rect.left || x >= rect.right || y < rect.top || y >= rect.bottom) {
            dropZone.classList.remove('drag-over');
        }
    }

    handleDrop(event) {
        event.preventDefault();
        event.stopPropagation();

        const dropZone = event.target.closest('[data-kanban-drop-zone]');
        if (!dropZone) return;

        dropZone.classList.remove('drag-over');

        const draggingCard = this.element.querySelector('.dragging');
        if (!draggingCard) return;

        // Check WIP limit
        const column = dropZone.closest('[data-kanban-column]');
        const limit = column?.dataset.kanbanLimit;
        if (limit) {
            const currentCount = dropZone.querySelectorAll('[data-kanban-card]').length;
            if (currentCount >= parseInt(limit)) {
                // Show error or prevent drop
                console.warn('Column has reached its WIP limit');
                return;
            }
        }

        // Get the container div inside the drop zone
        const container = dropZone.querySelector('.d-flex');
        if (container) {
            // Append the card to the new column
            container.appendChild(draggingCard);

            // Update column counts
            this.updateColumnCounts();

            // Dispatch custom event for external handling
            this.dispatchCardMoved(draggingCard, column);
        }
    }

    updateColumnCounts() {
        const columns = this.element.querySelectorAll('[data-kanban-column]');
        columns.forEach(column => {
            const dropZone = column.querySelector('[data-kanban-drop-zone]');
            if (!dropZone) return;

            const count = dropZone.querySelectorAll('[data-kanban-card]').length;
            const countBadges = column.querySelectorAll('[data-kanban-count]');
            countBadges.forEach(badge => {
                badge.textContent = count;
            });

            // Show/hide empty state
            const emptyState = dropZone.querySelector('[data-kanban-empty]');
            if (emptyState) {
                if (count === 0) {
                    emptyState.classList.remove('d-none');
                } else {
                    emptyState.classList.add('d-none');
                }
            }
        });
    }

    dispatchCardMoved(card, targetColumn) {
        const event = new CustomEvent('kanban:card-moved', {
            detail: {
                cardId: card.dataset.kanbanCard,
                targetColumn: targetColumn?.dataset.kanbanColumn,
                card: card
            },
            bubbles: true
        });
        this.element.dispatchEvent(event);
    }

    addCard(event) {
        event.preventDefault();

        const button = event.currentTarget;
        const column = button.closest('.kanban-column, [data-kanban-column]');
        if (!column) return;

        // Find template and drop zone
        const template = column.querySelector('[data-kanban-card-template]');
        const dropZone = column.querySelector('[data-kanban-drop-zone] > .d-flex');
        
        if (!template || !dropZone) return;

        // Clone template content
        const cardHtml = template.innerHTML;
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = cardHtml;
        const newCard = tempDiv.firstElementChild;

        // Add to drop zone
        dropZone.appendChild(newCard);

        // Focus on title input
        const titleInput = newCard.querySelector('[data-card-title]');
        if (titleInput) {
            titleInput.focus();
        }

        // Update counts
        this.updateColumnCounts();
    }

    saveCard(event) {
        event.preventDefault();

        const button = event.currentTarget;
        const editCard = button.closest('.kanban-card');
        if (!editCard) return;

        const titleInput = editCard.querySelector('[data-card-title]');
        const descriptionTextarea = editCard.querySelector('[data-card-description]');

        const title = titleInput?.value.trim() || 'Untitled';
        const description = descriptionTextarea?.value.trim() || '';

        if (!title) {
            // Remove if empty
            editCard.remove();
            this.updateColumnCounts();
            return;
        }

        // Generate unique ID
        const cardId = 'kanban-card-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
        
        // Replace edit form with actual card (matching original template structure)
        editCard.innerHTML = `
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="card-title mb-0">${this.escapeHtml(title)}</h6>
                    <span class="kanban-card-drag-handle text-muted cursor-move" title="Drag to move">⋮⋮</span>
                </div>
                ${description ? `<p class="card-text small text-muted mb-0">${this.escapeHtml(description)}</p>` : ''}
            </div>
        `;

        // Update classes to match original structure
        editCard.className = 'kanban-card card shadow-sm kanban-card-hover';
        editCard.id = cardId;
        editCard.setAttribute('data-kanban-card', cardId);
        editCard.setAttribute('draggable', 'true');

        // Add drag listeners
        this.addCardDragListeners(editCard);

        // Dispatch event
        this.dispatch('cardAdded', {
            detail: {
                title,
                description,
                card: editCard
            }
        });
    }

    cancelCard(event) {
        event.preventDefault();

        const button = event.currentTarget;
        const editCard = button.closest('.kanban-card');
        if (!editCard) return;

        // Remove the edit card
        editCard.remove();
        this.updateColumnCounts();
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
}

