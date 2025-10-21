import {Controller} from '@hotwired/stimulus';

/**
 * Code Block Controller
 * Handles copy-to-clipboard functionality for code blocks
 */
export default class extends Controller {
    static targets = ['code', 'copyBtn', 'copyText'];

    /**
     * Copy code content to clipboard
     * @param {Event} event
     */
    async copy(event) {
        event.preventDefault();

        if (!this.hasCodeTarget) {
            console.warn('Code target not found');
            return;
        }

        const code = this.codeTarget.textContent;

        try {
            // Modern Clipboard API
            if (navigator.clipboard && window.isSecureContext) {
                await navigator.clipboard.writeText(code);
                this.showSuccess();
            } else {
                // Fallback for older browsers or insecure context
                this.fallbackCopy(code);
                this.showSuccess();
            }
        } catch (err) {
            console.error('Failed to copy code:', err);
            this.showError();
        }
    }

    /**
     * Fallback copy method for older browsers
     * @param {string} text
     */
    fallbackCopy(text) {
        const textarea = document.createElement('textarea');
        textarea.value = text;
        textarea.style.position = 'fixed';
        textarea.style.opacity = '0';
        document.body.appendChild(textarea);
        textarea.select();

        try {
            document.execCommand('copy');
        } finally {
            document.body.removeChild(textarea);
        }
    }

    /**
     * Show success feedback
     */
    showSuccess() {
        if (this.hasCopyTextTarget) {
            const originalText = this.copyTextTarget.textContent;
            this.copyTextTarget.textContent = 'Copied!';

            // Reset after 2 seconds
            setTimeout(() => {
                this.copyTextTarget.textContent = originalText;
            }, 2000);
        }

        if (this.hasCopyBtnTarget) {
            this.copyBtnTarget.classList.add('btn-success');
            this.copyBtnTarget.classList.remove('btn-outline-secondary');

            setTimeout(() => {
                this.copyBtnTarget.classList.remove('btn-success');
                this.copyBtnTarget.classList.add('btn-outline-secondary');
            }, 2000);
        }
    }

    /**
     * Show error feedback
     */
    showError() {
        if (this.hasCopyTextTarget) {
            const originalText = this.copyTextTarget.textContent;
            this.copyTextTarget.textContent = 'Failed';

            setTimeout(() => {
                this.copyTextTarget.textContent = originalText;
            }, 2000);
        }

        if (this.hasCopyBtnTarget) {
            this.copyBtnTarget.classList.add('btn-danger');
            this.copyBtnTarget.classList.remove('btn-outline-secondary');

            setTimeout(() => {
                this.copyBtnTarget.classList.remove('btn-danger');
                this.copyBtnTarget.classList.add('btn-outline-secondary');
            }, 2000);
        }
    }
}

