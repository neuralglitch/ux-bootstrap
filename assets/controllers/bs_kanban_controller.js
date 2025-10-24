import { Controller } from '@hotwired/stimulus';

/**
 * Kanban Board Controller
 * Handles drag and drop functionality with mode switching
 */
export default class extends Controller {
    static targets = ['column', 'card'];
    static values = {
        allowCrossColumn: { type: Boolean, default: true },
        allowReorder: { type: Boolean, default: true }
    };

    connect() {
        console.debug('🎯 Kanban controller connected');
        console.debug('🎯 Controller element:', this.element);
        console.debug('🎯 Column targets:', this.columnTargets);
        console.debug('🎯 Card targets:', this.cardTargets);
        console.debug('🎯 Allow cross column:', this.allowCrossColumnValue);
        console.debug('🎯 Allow reorder:', this.allowReorderValue);
        
        // Use setTimeout to ensure DOM is fully rendered
        setTimeout(() => {
            this.setupDragAndDrop();
        }, 100);
    }

    setupDragAndDrop() {
        console.debug('🎯 Setting up drag and drop');
        
        // Find cards and columns using direct DOM queries instead of targets
        const cards = this.element.querySelectorAll('[data-kanban-card]');
        const columns = this.element.querySelectorAll('[data-kanban-column]');
        
        console.debug('🎯 Found cards:', cards.length);
        console.debug('🎯 Found columns:', columns.length);
        console.debug('🎯 Cards:', cards);
        console.debug('🎯 Columns:', columns);
        
        // Make all cards draggable
        cards.forEach((card, index) => {
            console.debug(`🎯 Setting up card ${index}:`, card);
            card.draggable = true;
            card.addEventListener('dragstart', this.handleDragStart.bind(this));
            card.addEventListener('dragend', this.handleDragEnd.bind(this));
            console.debug(`🎯 Card ${index} draggable:`, card.draggable);
        });

        // Setup drop zones
        columns.forEach((column, index) => {
            console.debug(`🎯 Setting up column ${index}:`, column);
            const dropZone = column.querySelector('[data-kanban-drop-zone]');
            console.debug(`🎯 Column ${index} drop zone:`, dropZone);
            if (dropZone) {
                dropZone.addEventListener('dragover', this.handleDragOver.bind(this));
                dropZone.addEventListener('drop', this.handleDrop.bind(this));
                dropZone.addEventListener('dragenter', this.handleDragEnter.bind(this));
                dropZone.addEventListener('dragleave', this.handleDragLeave.bind(this));
                console.debug(`🎯 Column ${index} drop zone listeners added`);
            } else {
                console.warn(`🎯 No drop zone found in column ${index}`);
            }
        });
    }

    handleDragStart(event) {
        console.debug('🎯 Drag start event triggered');
        console.debug('🎯 Event target:', event.target);
        console.debug('🎯 Event currentTarget:', event.currentTarget);
        
        const card = event.target.closest('[data-kanban-card]');
        console.debug('🎯 Found card:', card);
        if (!card) {
            console.warn('🎯 No card found for drag start');
            return;
        }

        const cardId = card.dataset.kanbanCard;
        console.debug('🎯 Card ID:', cardId);
        
        event.dataTransfer.setData('text/plain', cardId);
        event.dataTransfer.effectAllowed = 'move';
        console.debug('🎯 Data transfer set:', event.dataTransfer.getData('text/plain'));
        
        // Add dragging class
        card.classList.add('kanban-card-dragging');
        console.debug('🎯 Added dragging class to card');
        
        // Store original column for mode switching
        this.draggedCard = card;
        this.originalColumn = card.closest('[data-kanban-column]');
        console.debug('🎯 Original column:', this.originalColumn);
        console.debug('🎯 Dragged card stored:', this.draggedCard);
    }

    handleDragEnd(event) {
        console.debug('🎯 Drag end event triggered');
        console.debug('🎯 Event target:', event.target);
        
        const card = event.target.closest('[data-kanban-card]');
        console.debug('🎯 Found card for drag end:', card);
        if (card) {
            card.classList.remove('kanban-card-dragging');
            console.debug('🎯 Removed dragging class from card');
        }
        
        this.draggedCard = null;
        this.originalColumn = null;
        console.debug('🎯 Cleared dragged card and original column');
    }

    handleDragOver(event) {
        console.debug('🎯 Drag over event triggered');
        console.debug('🎯 Event target:', event.target);
        console.debug('🎯 Event currentTarget:', event.currentTarget);
        
        event.preventDefault();
        event.dataTransfer.dropEffect = 'move';
        console.debug('🎯 Drag over prevented default and set drop effect to move');
    }

    handleDragEnter(event) {
        console.debug('🎯 Drag enter event triggered');
        console.debug('🎯 Event target:', event.target);
        
        event.preventDefault();
        const column = event.target.closest('[data-kanban-column]');
        console.debug('🎯 Found column for drag enter:', column);
        if (column) {
            column.classList.add('kanban-column-drag-over');
            console.debug('🎯 Added drag over class to column');
        }
    }

    handleDragLeave(event) {
        console.debug('🎯 Drag leave event triggered');
        console.debug('🎯 Event target:', event.target);
        console.debug('🎯 Event relatedTarget:', event.relatedTarget);
        
        const column = event.target.closest('[data-kanban-column]');
        console.debug('🎯 Found column for drag leave:', column);
        if (column && !column.contains(event.relatedTarget)) {
            column.classList.remove('kanban-column-drag-over');
            console.debug('🎯 Removed drag over class from column');
        }
    }

    handleDrop(event) {
        console.debug('🎯 Drop event triggered');
        console.debug('🎯 Event target:', event.target);
        console.debug('🎯 Event currentTarget:', event.currentTarget);
        
        event.preventDefault();
        const column = event.target.closest('[data-kanban-column]');
        console.debug('🎯 Found column for drop:', column);
        if (!column) {
            console.warn('🎯 No column found for drop');
                return;
        }

        const cardId = event.dataTransfer.getData('text/plain');
        console.debug('🎯 Card ID from data transfer:', cardId);
        const card = this.element.querySelector(`[data-kanban-card="${cardId}"]`);
        console.debug('🎯 Found card for drop:', card);
        if (!card) {
            console.warn('🎯 No card found for drop');
            return;
        }

        // Remove drag over styling
        column.classList.remove('kanban-column-drag-over');
        console.debug('🎯 Removed drag over class from column');

        // Move card to new column
            const dropZone = column.querySelector('[data-kanban-drop-zone]');
        console.debug('🎯 Found drop zone:', dropZone);
        if (dropZone) {
            dropZone.appendChild(card);
            console.debug('🎯 Moved card to drop zone');
                } else {
            console.warn('🎯 No drop zone found in column');
        }

        // Switch card mode based on column
        console.debug('🎯 Switching card mode');
        this.switchCardMode(card, column);
        
        // Update column counts
        console.debug('🎯 Updating column counts');
        this.updateColumnCounts();
        
        console.debug('🎯 Drop completed successfully');
    }

    switchCardMode(card, targetColumn) {
        console.debug('🎯 Switching card mode');
        console.debug('🎯 Card:', card);
        console.debug('🎯 Target column:', targetColumn);
        
        const columnId = targetColumn.dataset.kanbanColumn;
        const isBacklog = columnId === 'backlog';
        console.debug('🎯 Column ID:', columnId);
        console.debug('🎯 Is backlog:', isBacklog);
        
        // Get card data
        const cardId = card.dataset.kanbanCard;
        const title = card.querySelector('.card-title')?.textContent || '';
        const description = card.querySelector('.card-text')?.textContent || '';
        const badge = card.querySelector('.badge')?.textContent || '';
        const badgeVariant = this.getBadgeVariant(card);
        
        console.debug('🎯 Card data:', { cardId, title, description, badge, badgeVariant });
        
        // Clear existing content
        card.innerHTML = '';
        console.debug('🎯 Cleared card content');
        
        if (isBacklog) {
            // Simple mode for Backlog
            console.debug('🎯 Creating simple card for backlog');
            this.createSimpleCard(card, cardId, title, description, badge, badgeVariant);
        } else {
            // Verbose mode for other columns
            console.debug('🎯 Creating verbose card for column:', columnId);
            this.createVerboseCard(card, cardId, title, description, badge, badgeVariant, columnId);
        }
    }

    createSimpleCard(card, cardId, title, description, badge, badgeVariant) {
        console.debug('🎯 Creating simple card with data:', { cardId, title, description, badge, badgeVariant });
        card.innerHTML = `
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center gap-2">
                        ${badge ? `<span class="badge text-bg-${badgeVariant}">${badge}</span>` : ''}
                        <h6 class="card-title mb-0">${title}</h6>
                    </div>
                    <span class="kanban-card-drag-handle text-muted cursor-move" title="Drag to move">⋮⋮</span>
                </div>
                ${description ? `<p class="card-text small text-muted mb-0">${description}</p>` : ''}
                <div class="d-flex align-items-center gap-2 mt-3">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-person-circle text-primary me-1" style="width: 1.25rem; height: 1.25rem;"></i>
                        <small>Assignee</small>
                    </div>
                    <small class="text-body-secondary ms-auto">#${cardId}</small>
                </div>
            </div>
        `;
        console.debug('🎯 Simple card created successfully');
    }

    createVerboseCard(card, cardId, title, description, badge, badgeVariant, columnId) {
        console.debug('🎯 Creating verbose card with data:', { cardId, title, description, badge, badgeVariant, columnId });
        let verboseContent = '';
        
        if (columnId === 'todo') {
            verboseContent = `
                <div class="d-flex align-items-center gap-2 mt-3">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-person-circle text-info me-1" style="width: 1.25rem; height: 1.25rem;"></i>
                        <small>Emma</small>
                    </div>
                    <small class="text-body-secondary ms-auto">2/5 done</small>
                </div>
            `;
        } else if (columnId === 'in-progress') {
            verboseContent = `
                <div class="progress mb-2" style="height: 6px;">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 65%"></div>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person-circle text-warning me-1" style="width: 1.25rem; height: 1.25rem;"></i>
                            <small>Taylor</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-clock text-body-secondary me-1" style="width: 1rem; height: 1rem;"></i>
                            <small class="text-body-secondary">5h</small>
                        </div>
                    </div>
                    <small class="text-body-secondary">65%</small>
                </div>
            `;
        } else if (columnId === 'review') {
            verboseContent = `
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="bi bi-github text-body-secondary" style="width: 1rem; height: 1rem;"></i>
                    <small class="text-body-secondary">PR #42</small>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-person-circle text-primary me-1" style="width: 1.25rem; height: 1.25rem;"></i>
                        <small>Sam</small>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check2-circle text-success me-1" style="width: 1rem; height: 1rem;"></i>
                        <small class="text-success">2 approvals</small>
                    </div>
                </div>
            `;
        } else if (columnId === 'done') {
            verboseContent = `
                <div class="d-flex align-items-center gap-2 mt-3">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill text-success me-1" style="width: 1rem; height: 1rem;"></i>
                        <small class="text-success">Completed</small>
                    </div>
                </div>
            `;
        }

        card.innerHTML = `
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center gap-2 flex-grow-1">
                        ${badge ? `<span class="badge text-bg-${badgeVariant}">${badge}</span>` : ''}
                        <h6 class="card-title mb-0">${title}</h6>
                    </div>
                    <span class="kanban-card-drag-handle text-muted cursor-move flex-shrink-0" title="Drag to move">⋮⋮</span>
                </div>
                ${description ? `<p class="card-text small text-muted mb-0">${description}</p>` : ''}
                ${verboseContent}
            </div>
        `;
        console.debug('🎯 Verbose card created successfully');
    }

    getBadgeVariant(card) {
        const badge = card.querySelector('.badge');
        if (!badge) return 'secondary';
        
        const classes = badge.className;
        if (classes.includes('text-bg-info')) return 'info';
        if (classes.includes('text-bg-success')) return 'success';
        if (classes.includes('text-bg-warning')) return 'warning';
        if (classes.includes('text-bg-danger')) return 'danger';
        if (classes.includes('text-bg-primary')) return 'primary';
        return 'secondary';
    }

    updateColumnCounts() {
        console.debug('🎯 Updating column counts');
        const columns = this.element.querySelectorAll('[data-kanban-column]');
        columns.forEach((column, index) => {
            const countElement = column.querySelector('[data-kanban-count]');
            console.debug(`🎯 Column ${index} count element:`, countElement);
            if (countElement) {
                const cards = column.querySelectorAll('[data-kanban-card]');
                const count = cards.length;
                countElement.textContent = count;
                console.debug(`🎯 Column ${index} count updated to:`, count);
            } else {
                console.warn(`🎯 No count element found in column ${index}`);
            }
        });
    }
}