import { Controller } from '@hotwired/stimulus';

/**
 * Data Table Controller
 * 
 * Provides interactive features for data tables:
 * - Client-side sorting
 * - Search/filtering
 * - Pagination
 * - Row selection
 */
export default class extends Controller {
    static targets = ['table', 'tbody', 'search', 'pagination', 'info', 'selectAll'];
    
    static values = {
        perPage: { type: Number, default: 10 },
        currentPage: { type: Number, default: 1 },
        sortColumn: { type: String, default: '' },
        sortDirection: { type: String, default: 'asc' },
        searchTerm: { type: String, default: '' }
    };

    connect() {
        this.allRows = [];
        this.filteredRows = [];
        
        // Store original table data
        this.storeTableData();
        
        // Initial render
        this.render();
    }

    /**
     * Store all table rows for client-side manipulation
     */
    storeTableData() {
        if (!this.hasTbodyTarget) return;
        
        const rows = Array.from(this.tbodyTarget.querySelectorAll('tr'));
        this.allRows = rows.map(row => {
            const cells = Array.from(row.querySelectorAll('td'));
            return {
                element: row.cloneNode(true),
                data: cells.map(cell => cell.textContent.trim()),
                selected: row.querySelector('input[type="checkbox"]')?.checked || false
            };
        });
        
        this.filteredRows = [...this.allRows];
    }

    /**
     * Sort table by column index
     */
    sort(event) {
        event.preventDefault();
        
        const columnIndex = parseInt(event.currentTarget.dataset.column, 10);
        const currentColumn = this.sortColumnValue;
        
        // Toggle direction if same column, otherwise default to asc
        if (currentColumn === columnIndex.toString()) {
            this.sortDirectionValue = this.sortDirectionValue === 'asc' ? 'desc' : 'asc';
        } else {
            this.sortColumnValue = columnIndex.toString();
            this.sortDirectionValue = 'asc';
        }
        
        this.sortData(columnIndex);
        this.currentPageValue = 1; // Reset to first page
        this.render();
        this.updateSortIcons();
    }

    /**
     * Sort the filtered data
     */
    sortData(columnIndex) {
        this.filteredRows.sort((a, b) => {
            const aVal = a.data[columnIndex] || '';
            const bVal = b.data[columnIndex] || '';
            
            // Try numeric comparison first
            const aNum = parseFloat(aVal);
            const bNum = parseFloat(bVal);
            
            if (!isNaN(aNum) && !isNaN(bNum)) {
                return this.sortDirectionValue === 'asc' ? aNum - bNum : bNum - aNum;
            }
            
            // String comparison
            const comparison = aVal.localeCompare(bVal);
            return this.sortDirectionValue === 'asc' ? comparison : -comparison;
        });
    }

    /**
     * Search/filter table rows
     */
    search(event) {
        this.searchTermValue = event.target.value.toLowerCase().trim();
        this.filterData();
        this.currentPageValue = 1; // Reset to first page
        this.render();
    }

    /**
     * Filter data based on search term
     */
    filterData() {
        if (!this.searchTermValue) {
            this.filteredRows = [...this.allRows];
            return;
        }
        
        this.filteredRows = this.allRows.filter(row => {
            return row.data.some(cell => 
                cell.toLowerCase().includes(this.searchTermValue)
            );
        });
    }

    /**
     * Navigate to specific page
     */
    goToPage(event) {
        event.preventDefault();
        const page = parseInt(event.currentTarget.dataset.page, 10);
        
        if (page >= 1 && page <= this.totalPages()) {
            this.currentPageValue = page;
            this.render();
        }
    }

    /**
     * Go to previous page
     */
    previousPage(event) {
        event.preventDefault();
        if (this.currentPageValue > 1) {
            this.currentPageValue--;
            this.render();
        }
    }

    /**
     * Go to next page
     */
    nextPage(event) {
        event.preventDefault();
        if (this.currentPageValue < this.totalPages()) {
            this.currentPageValue++;
            this.render();
        }
    }

    /**
     * Toggle selection of all visible rows
     */
    toggleSelectAll(event) {
        const checked = event.target.checked;
        const visibleRows = this.getVisibleRows();
        
        visibleRows.forEach((row, index) => {
            row.selected = checked;
            const checkbox = this.tbodyTarget.rows[index]?.querySelector('input[type="checkbox"]');
            if (checkbox) {
                checkbox.checked = checked;
            }
        });
        
        this.dispatchSelectionChange();
    }

    /**
     * Toggle selection of individual row
     */
    toggleRow(event) {
        const rowIndex = parseInt(event.currentTarget.closest('tr').dataset.rowIndex, 10);
        const globalIndex = (this.currentPageValue - 1) * this.perPageValue + rowIndex;
        
        if (this.filteredRows[globalIndex]) {
            this.filteredRows[globalIndex].selected = event.target.checked;
        }
        
        this.updateSelectAllCheckbox();
        this.dispatchSelectionChange();
    }

    /**
     * Update select-all checkbox state
     */
    updateSelectAllCheckbox() {
        if (!this.hasSelectAllTarget) return;
        
        const visibleRows = this.getVisibleRows();
        const allSelected = visibleRows.length > 0 && visibleRows.every(row => row.selected);
        const someSelected = visibleRows.some(row => row.selected);
        
        this.selectAllTarget.checked = allSelected;
        this.selectAllTarget.indeterminate = !allSelected && someSelected;
    }

    /**
     * Render current page
     */
    render() {
        if (!this.hasTbodyTarget) return;
        
        const visibleRows = this.getVisibleRows();
        
        // Clear tbody
        this.tbodyTarget.innerHTML = '';
        
        // Add visible rows
        visibleRows.forEach((row, index) => {
            const rowElement = row.element.cloneNode(true);
            rowElement.dataset.rowIndex = index.toString();
            
            // Update checkbox if present
            const checkbox = rowElement.querySelector('input[type="checkbox"]');
            if (checkbox) {
                checkbox.checked = row.selected;
                checkbox.dataset.action = 'change->bs-data-table#toggleRow';
            }
            
            this.tbodyTarget.appendChild(rowElement);
        });
        
        // Update pagination
        this.renderPagination();
        
        // Update info
        this.renderInfo();
        
        // Update select-all checkbox
        this.updateSelectAllCheckbox();
    }

    /**
     * Get rows for current page
     */
    getVisibleRows() {
        const start = (this.currentPageValue - 1) * this.perPageValue;
        const end = start + this.perPageValue;
        return this.filteredRows.slice(start, end);
    }

    /**
     * Calculate total pages
     */
    totalPages() {
        return Math.ceil(this.filteredRows.length / this.perPageValue);
    }

    /**
     * Render pagination controls
     */
    renderPagination() {
        if (!this.hasPaginationTarget) return;
        
        const totalPages = this.totalPages();
        if (totalPages <= 1) {
            this.paginationTarget.innerHTML = '';
            return;
        }
        
        let html = '<nav><ul class="pagination mb-0">';
        
        // Previous button
        html += `<li class="page-item ${this.currentPageValue === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" data-action="click->bs-data-table#previousPage">Previous</a>
        </li>`;
        
        // Page numbers (show max 7 pages)
        const maxVisible = 7;
        let startPage = Math.max(1, this.currentPageValue - Math.floor(maxVisible / 2));
        let endPage = Math.min(totalPages, startPage + maxVisible - 1);
        
        if (endPage - startPage < maxVisible - 1) {
            startPage = Math.max(1, endPage - maxVisible + 1);
        }
        
        if (startPage > 1) {
            html += `<li class="page-item"><a class="page-link" href="#" data-page="1" data-action="click->bs-data-table#goToPage">1</a></li>`;
            if (startPage > 2) {
                html += '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
        }
        
        for (let i = startPage; i <= endPage; i++) {
            html += `<li class="page-item ${i === this.currentPageValue ? 'active' : ''}">
                <a class="page-link" href="#" data-page="${i}" data-action="click->bs-data-table#goToPage">${i}</a>
            </li>`;
        }
        
        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                html += '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
            html += `<li class="page-item"><a class="page-link" href="#" data-page="${totalPages}" data-action="click->bs-data-table#goToPage">${totalPages}</a></li>`;
        }
        
        // Next button
        html += `<li class="page-item ${this.currentPageValue === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" data-action="click->bs-data-table#nextPage">Next</a>
        </li>`;
        
        html += '</ul></nav>';
        this.paginationTarget.innerHTML = html;
    }

    /**
     * Render info text
     */
    renderInfo() {
        if (!this.hasInfoTarget) return;
        
        const start = (this.currentPageValue - 1) * this.perPageValue + 1;
        const end = Math.min(this.currentPageValue * this.perPageValue, this.filteredRows.length);
        const total = this.filteredRows.length;
        
        this.infoTarget.textContent = `Showing ${start} to ${end} of ${total} entries${this.searchTermValue ? ' (filtered)' : ''}`;
    }

    /**
     * Update sort icons in table headers
     */
    updateSortIcons() {
        const headers = this.element.querySelectorAll('th[data-sortable]');
        headers.forEach((header, index) => {
            const icon = header.querySelector('.sort-icon');
            if (!icon) return;
            
            if (index.toString() === this.sortColumnValue) {
                icon.textContent = this.sortDirectionValue === 'asc' ? '↑' : '↓';
                header.classList.add('sorted');
            } else {
                icon.textContent = '⇅';
                header.classList.remove('sorted');
            }
        });
    }

    /**
     * Dispatch custom event when selection changes
     */
    dispatchSelectionChange() {
        const selectedRows = this.filteredRows
            .map((row, index) => ({ index, data: row.data, selected: row.selected }))
            .filter(row => row.selected);
        
        this.dispatch('selectionChange', {
            detail: {
                selectedCount: selectedRows.length,
                selectedRows: selectedRows
            }
        });
    }

    /**
     * Get selected row data
     */
    getSelectedRows() {
        return this.filteredRows
            .filter(row => row.selected)
            .map(row => row.data);
    }
}


