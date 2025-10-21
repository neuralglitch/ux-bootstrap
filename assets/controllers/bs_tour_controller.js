// assets/controllers/bs_tour_controller.js
import {Controller} from '@hotwired/stimulus';
import {computePosition, flip, shift, offset, arrow} from '@floating-ui/dom';

/**
 * Bootstrap Tour Controller
 * - Guided product tours and feature highlights
 * - Step-by-step walkthrough with highlighting
 * - Keyboard navigation support
 * - Progress tracking
 * - Backdrop and element highlighting
 */
export default class extends Controller {
    static targets = [
        'backdrop', 'highlight', 'popover', 'arrow',
        'stepNumber', 'title', 'content', 'progressBar',
        'prevBtn', 'nextBtn', 'skipBtn', 'finishBtn'
    ];

    static values = {
        tourId: String,
        steps: {type: Array, default: []},
        keyboard: {type: Boolean, default: true},
        backdrop: {type: Boolean, default: true},
        highlight: {type: Boolean, default: true},
        scrollToElement: {type: Boolean, default: true},
        autoStart: {type: Boolean, default: false},
        allowClickThrough: {type: Boolean, default: false},
        popoverVariant: {type: String, default: 'light'},
        popoverPlacement: {type: String, default: 'auto'},
        popoverWidth: {type: Number, default: 360},
        highlightPadding: {type: Number, default: 10},
        highlightBorderRadius: {type: Number, default: 8},
        onStart: String,
        onComplete: String,
        onSkip: String,
        onStepShow: String
    };

    connect() {
        this.currentStepIndex = -1;
        this.isActive = false;
        this.boundKeyHandler = this.handleKeyPress.bind(this);

        // Check if tour was already completed
        const completed = this.getTourState();
        if (completed && !this.autoStartValue) {
            return;
        }

        // Auto-start if enabled
        if (this.autoStartValue && !completed) {
            setTimeout(() => this.start(), 100);
        }
    }

    disconnect() {
        this.end();
    }

    // --- Public API -----------------------------------------------------------

    start() {
        if (this.isActive || this.stepsValue.length === 0) return;

        this.isActive = true;
        this.currentStepIndex = -1;

        // Show backdrop if enabled
        if (this.backdropValue && this.hasBackdropTarget) {
            this.backdropTarget.style.display = 'block';
            if (!this.allowClickThroughValue) {
                this.backdropTarget.addEventListener('click', () => this.close());
            }
        }

        // Setup keyboard navigation
        if (this.keyboardValue) {
            document.addEventListener('keydown', this.boundKeyHandler);
        }

        // Trigger onStart callback
        this.executeCallback(this.onStartValue);

        // Show first step
        this.next();
    }

    next() {
        if (!this.isActive) return;

        const nextIndex = this.currentStepIndex + 1;
        if (nextIndex < this.stepsValue.length) {
            this.showStep(nextIndex);
        }
    }

    previous() {
        if (!this.isActive) return;

        const prevIndex = this.currentStepIndex - 1;
        if (prevIndex >= 0) {
            this.showStep(prevIndex);
        }
    }

    skip() {
        this.executeCallback(this.onSkipValue);
        this.saveTourState(true);
        this.end();
    }

    finish() {
        this.executeCallback(this.onCompleteValue);
        this.saveTourState(true);
        this.end();
    }

    close() {
        this.saveTourState(false);
        this.end();
    }

    end() {
        if (!this.isActive) return;

        this.isActive = false;
        this.currentStepIndex = -1;

        // Hide all elements
        if (this.hasPopoverTarget) this.popoverTarget.style.display = 'none';
        if (this.hasBackdropTarget) this.backdropTarget.style.display = 'none';
        if (this.hasHighlightTarget) this.highlightTarget.style.display = 'none';

        // Remove keyboard handler
        if (this.keyboardValue) {
            document.removeEventListener('keydown', this.boundKeyHandler);
        }
    }

    // --- Step Management ------------------------------------------------------

    showStep(index) {
        if (index < 0 || index >= this.stepsValue.length) return;

        this.currentStepIndex = index;
        const step = this.stepsValue[index];

        // Update content
        this.updateStepContent(step, index);

        // Update navigation buttons
        this.updateNavigation(index);

        // Update progress
        this.updateProgress(index);

        // Get target element
        const targetElement = step.target ? document.querySelector(step.target) : null;

        // Scroll to element if enabled
        if (this.scrollToElementValue && targetElement) {
            this.scrollToTarget(targetElement);
        }

        // Highlight element if enabled
        if (this.highlightValue && targetElement && this.hasHighlightTarget) {
            this.highlightElement(targetElement);
        } else if (this.hasHighlightTarget) {
            this.highlightTarget.style.display = 'none';
        }

        // Position popover
        this.positionPopover(targetElement, step);

        // Show popover
        if (this.hasPopoverTarget) {
            this.popoverTarget.style.display = 'block';
        }

        // Trigger onStepShow callback
        this.executeCallback(this.onStepShowValue, {step, index});
    }

    updateStepContent(step, index) {
        // Step number
        if (this.hasStepNumberTarget) {
            this.stepNumberTarget.textContent = `Step ${index + 1} of ${this.stepsValue.length}`;
        }

        // Title
        if (this.hasTitleTarget) {
            this.titleTarget.textContent = step.title || '';
        }

        // Content
        if (this.hasContentTarget) {
            if (step.contentHtml) {
                this.contentTarget.innerHTML = step.content || '';
            } else {
                this.contentTarget.textContent = step.content || '';
            }
        }
    }

    updateNavigation(index) {
        const isFirst = index === 0;
        const isLast = index === this.stepsValue.length - 1;

        // Previous button
        if (this.hasPrevBtnTarget) {
            this.prevBtnTarget.disabled = isFirst;
            this.prevBtnTarget.style.display = isFirst ? 'none' : 'inline-block';
        }

        // Next button
        if (this.hasNextBtnTarget) {
            this.nextBtnTarget.style.display = isLast ? 'none' : 'inline-block';
        }

        // Finish button
        if (this.hasFinishBtnTarget) {
            this.finishBtnTarget.style.display = isLast ? 'inline-block' : 'none';
        }
    }

    updateProgress(index) {
        if (!this.hasProgressBarTarget) return;

        const progress = ((index + 1) / this.stepsValue.length) * 100;
        this.progressBarTarget.style.width = `${progress}%`;
        this.progressBarTarget.setAttribute('aria-valuenow', progress.toString());
    }

    // --- Positioning & Highlighting -------------------------------------------

    async positionPopover(targetElement, step) {
        if (!this.hasPopoverTarget) return;

        const placement = step.placement || this.popoverPlacementValue;

        if (!targetElement) {
            // Center on screen if no target
            this.popoverTarget.style.position = 'fixed';
            this.popoverTarget.style.top = '50%';
            this.popoverTarget.style.left = '50%';
            this.popoverTarget.style.transform = 'translate(-50%, -50%)';
            return;
        }

        // Use Popper.js for positioning
        const middleware = [
            offset(10),
            flip(),
            shift({padding: 5})
        ];

        if (this.hasArrowTarget) {
            middleware.push(arrow({element: this.arrowTarget}));
        }

        const {x, y, placement: finalPlacement, middlewareData} = await computePosition(
            targetElement,
            this.popoverTarget,
            {
                placement,
                middleware
            }
        );

        // Apply position
        Object.assign(this.popoverTarget.style, {
            position: 'absolute',
            left: `${x}px`,
            top: `${y}px`,
            transform: 'none'
        });

        // Update popover placement class
        this.popoverTarget.className = this.popoverTarget.className.replace(
            /bs-popover-(auto|top|right|bottom|left)/g,
            ''
        );
        this.popoverTarget.classList.add(`bs-popover-${finalPlacement.split('-')[0]}`);

        // Position arrow
        if (this.hasArrowTarget && middlewareData.arrow) {
            const {x: arrowX, y: arrowY} = middlewareData.arrow;
            const staticSide = {
                top: 'bottom',
                right: 'left',
                bottom: 'top',
                left: 'right'
            }[finalPlacement.split('-')[0]];

            Object.assign(this.arrowTarget.style, {
                left: arrowX != null ? `${arrowX}px` : '',
                top: arrowY != null ? `${arrowY}px` : '',
                right: '',
                bottom: '',
                [staticSide]: '-4px'
            });
        }
    }

    highlightElement(element) {
        if (!this.hasHighlightTarget) return;

        const rect = element.getBoundingClientRect();
        const padding = this.highlightPaddingValue;

        Object.assign(this.highlightTarget.style, {
            display: 'block',
            position: 'absolute',
            top: `${window.scrollY + rect.top - padding}px`,
            left: `${window.scrollX + rect.left - padding}px`,
            width: `${rect.width + padding * 2}px`,
            height: `${rect.height + padding * 2}px`,
            borderRadius: `${this.highlightBorderRadiusValue}px`,
            pointerEvents: 'none',
            zIndex: '1049'
        });
    }

    scrollToTarget(element) {
        element.scrollIntoView({
            behavior: 'smooth',
            block: 'center',
            inline: 'center'
        });
    }

    // --- Event Handlers -------------------------------------------------------

    handleKeyPress(event) {
        if (!this.isActive) return;

        switch (event.key) {
            case 'Escape':
                event.preventDefault();
                this.close();
                break;
            case 'ArrowRight':
            case 'ArrowDown':
                event.preventDefault();
                this.next();
                break;
            case 'ArrowLeft':
            case 'ArrowUp':
                event.preventDefault();
                this.previous();
                break;
        }
    }

    // --- Persistence ----------------------------------------------------------

    getTourState() {
        try {
            const state = localStorage.getItem(`tour-${this.tourIdValue}`);
            return state === 'completed';
        } catch {
            return false;
        }
    }

    saveTourState(completed) {
        try {
            if (completed) {
                localStorage.setItem(`tour-${this.tourIdValue}`, 'completed');
            } else {
                localStorage.removeItem(`tour-${this.tourIdValue}`);
            }
        } catch {
            // Ignore storage errors
        }
    }

    // --- Helpers --------------------------------------------------------------

    executeCallback(callbackName, data = {}) {
        if (!callbackName) return;

        try {
            const callback = window[callbackName];
            if (typeof callback === 'function') {
                callback({tourId: this.tourIdValue, ...data});
            }
        } catch (error) {
            console.error(`Tour callback error: ${error.message}`);
        }
    }
}

