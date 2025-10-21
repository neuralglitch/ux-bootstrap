import {Controller} from '@hotwired/stimulus';

/*
 * Bootstrap Search Controller
 * 
 * Usage:
 * <div data-controller="bs-search">
 *   <input 
 *     type="text" 
 *     data-bs-search-target="input" 
 *     data-action="input->bs-search#handleInput"
 *     data-bs-search-url-value="/search"
 *     data-bs-search-min-chars-value="2"
 *     data-bs-search-debounce-value="300"
 *   />
 *   <div data-bs-search-target="results"></div>
 *   <div data-bs-search-target="spinner" style="display: none;">Searching...</div>
 * </div>
 */
export default class extends Controller {
    static targets = ['input', 'results', 'spinner', 'clear'];

    static values = {
        url: String,
        minChars: {type: Number, default: 2},
        debounce: {type: Number, default: 300}
    };

    static classes = [
        'searching',
        'hasResults',
        'noResults'
    ];

    connect() {
        this.timeout = null;
        this.abortController = null;
        this.isSearching = false;
    }

    disconnect() {
        this.clearTimeout();
        this.abortRequest();
    }

    handleInput(event) {
        const query = this.inputTarget.value.trim();

        // Clear previous timeout
        this.clearTimeout();

        // Show/hide clear button if available
        if (this.hasClearTarget) {
            this.clearTarget.style.display = query.length > 0 ? 'block' : 'none';
        }

        // If query is too short, clear results
        if (query.length < this.minCharsValue) {
            this.clearResults();
            return;
        }

        // Debounce the search
        this.timeout = setTimeout(() => {
            this.performSearch(query);
        }, this.debounceValue);
    }

    async performSearch(query) {
        // Abort previous request if still running
        this.abortRequest();

        // Create new abort controller
        this.abortController = new AbortController();

        try {
            this.showSpinner();
            this.isSearching = true;

            const url = new URL(this.urlValue, window.location.origin);
            url.searchParams.set('q', query);

            const response = await fetch(url.toString(), {
                signal: this.abortController.signal,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json, text/html'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const contentType = response.headers.get('content-type');

            if (contentType && contentType.includes('application/json')) {
                const data = await response.json();
                this.displayJsonResults(data);
            } else {
                const html = await response.text();
                this.displayHtmlResults(html);
            }

        } catch (error) {
            if (error.name === 'AbortError') {
                // Request was aborted, this is expected
                return;
            }
            console.error('Search error:', error);
            this.showError('An error occurred while searching. Please try again.');
        } finally {
            this.hideSpinner();
            this.isSearching = false;
        }
    }

    displayJsonResults(data) {
        if (!this.hasResultsTarget) return;

        if (data.results && data.results.length > 0) {
            let html = '<div class="search-results">';

            if (data.total) {
                html += `<div class="search-results-header">${data.total} result${data.total !== 1 ? 's' : ''} found</div>`;
            }

            html += '<ul class="search-results-list">';
            data.results.forEach(result => {
                html += this.renderResultItem(result);
            });
            html += '</ul></div>';

            this.resultsTarget.innerHTML = html;
            this.addResultsClass();
        } else {
            this.showNoResults();
        }
    }

    displayHtmlResults(html) {
        if (!this.hasResultsTarget) return;

        this.resultsTarget.innerHTML = html;

        // Check if results are empty
        const hasContent = this.resultsTarget.textContent.trim().length > 0;
        if (hasContent) {
            this.addResultsClass();
        } else {
            this.showNoResults();
        }
    }

    renderResultItem(result) {
        const title = this.escapeHtml(result.title || 'Untitled');
        const description = result.description ? this.escapeHtml(result.description) : '';
        const url = this.escapeHtml(result.url || '#');
        const type = result.type ? `<span class="search-result-type badge bg-secondary">${this.escapeHtml(result.type)}</span>` : '';

        return `
            <li class="search-result-item">
                <a href="${url}" class="search-result-link">
                    <div class="search-result-title">
                        ${title}
                        ${type}
                    </div>
                    ${description ? `<div class="search-result-description">${description}</div>` : ''}
                </a>
            </li>
        `;
    }

    showNoResults() {
        if (!this.hasResultsTarget) return;

        this.resultsTarget.innerHTML = '<div class="search-no-results">No results found.</div>';
        this.addNoResultsClass();
    }

    showError(message) {
        if (!this.hasResultsTarget) return;

        this.resultsTarget.innerHTML = `<div class="search-error alert alert-danger">${this.escapeHtml(message)}</div>`;
    }

    clearResults() {
        if (this.hasResultsTarget) {
            this.resultsTarget.innerHTML = '';
        }
        this.removeResultsClasses();
    }

    clearInput() {
        if (this.hasInputTarget) {
            this.inputTarget.value = '';
            this.inputTarget.focus();
        }
        this.clearResults();

        if (this.hasClearTarget) {
            this.clearTarget.style.display = 'none';
        }
    }

    showSpinner() {
        if (this.hasSpinnerTarget) {
            this.spinnerTarget.style.display = 'block';
        }

        if (this.hasSearchingClass) {
            this.element.classList.add(this.searchingClass);
        }
    }

    hideSpinner() {
        if (this.hasSpinnerTarget) {
            this.spinnerTarget.style.display = 'none';
        }

        if (this.hasSearchingClass) {
            this.element.classList.remove(this.searchingClass);
        }
    }

    addResultsClass() {
        this.removeResultsClasses();
        if (this.hasHasResultsClass) {
            this.element.classList.add(this.hasResultsClass);
        }
    }

    addNoResultsClass() {
        this.removeResultsClasses();
        if (this.hasNoResultsClass) {
            this.element.classList.add(this.noResultsClass);
        }
    }

    removeResultsClasses() {
        if (this.hasHasResultsClass) {
            this.element.classList.remove(this.hasResultsClass);
        }
        if (this.hasNoResultsClass) {
            this.element.classList.remove(this.noResultsClass);
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

    // Keyboard navigation support
    handleKeydown(event) {
        const {key} = event;

        if (key === 'Escape') {
            this.clearInput();
        }
    }
}

