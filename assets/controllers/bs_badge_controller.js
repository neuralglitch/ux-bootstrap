import {Controller} from '@hotwired/stimulus';

/**
 * Generic Badge Controller
 * 
 * Provides interactive features for badges: counters, indicators, status, blinking
 * 
 * Features:
 * - Counter management (increment, decrement, animate)
 * - Status indicators with colors
 * - Blinking animations
 * - Auto-hide at zero
 * - Button state management
 * 
 * Custom Events (for adapter integration):
 * - bs-badge:count-changed - Fired when count changes
 *   detail: { count, action }
 * 
 * - bs-badge:animation-started - Fired when animation begins
 *   detail: { from, to, direction, amount }
 * 
 * - bs-badge:animation-complete - Fired when animation completes
 *   detail: { count, target }
 * 
 * - bs-badge:status-changed - Fired when status changes
 *   detail: { status, previousStatus }
 * 
 * - bs-badge:reset - Fired when reset to initial state
 *   detail: { count }
 * 
 * Example Adapter:
 * document.addEventListener('bs-badge:animation-complete', async (event) => {
 *     // Sync with backend
 *     await fetch('/api/inbox/mark-synced', {
 *         method: 'POST',
 *         body: JSON.stringify({ count: event.detail.count })
 *     });
 *     
 *     // Show notification
 *     toast.success(`Synced ${event.detail.count} items`);
 * });
 */
export default class extends Controller {
    static targets = ['counter', 'indicator', 'actionButton', 'resetButton'];
    
    static values = {
        count: { type: Number, default: 0 },
        maxCount: { type: Number, default: 999 },
        autoHide: { type: Boolean, default: true },
        status: { type: String, default: 'online' },
        blinking: { type: Boolean, default: false },
        animationSpeed: { type: Number, default: 200 }
    };

    connect() {
        console.log('🎯 BS Badge Controller connected!', this.element);
        this.initialCount = this.countValue;
        this.initialStatus = this.statusValue;
        this.animationTimer = null;
        this.blinkTimer = null;
        this.updateCounter();
        this.updateIndicator();
    }

    disconnect() {
        this.stopAnimation();
        this.stopBlinking();
    }

    // Counter Actions
    increment() {
        this.countValue++;
        this.updateCounter();
        console.log('🔔 Dispatching count-changed event:', { count: this.countValue, action: 'increment' });
        this.dispatch('count-changed', { detail: { count: this.countValue, action: 'increment' } });
    }

    decrement() {
        if (this.countValue > 0) {
            this.countValue--;
            this.updateCounter();
            this.dispatch('count-changed', { detail: { count: this.countValue, action: 'decrement' } });
        }
    }

    setCount(event) {
        const value = parseInt(event.params?.count ?? 0, 10);
        this.countValue = Math.max(0, value);
        this.updateCounter();
        this.dispatch('count-changed', { detail: { count: this.countValue, action: 'set' } });
    }

    reset() {
        this.stopAnimation();
        this.countValue = this.initialCount;
        this.updateCounter();
        this.enableButtons();
        this.dispatch('reset', { detail: { count: this.initialCount } });
    }

    // Animated Counter Actions
    animateTo(event) {
        if (this.animationTimer) return;
        
        const button = event.currentTarget;
        const target = parseInt(button.dataset.bsBadgeTargetParam ?? this.maxCountValue, 10);
        const resetOnStart = button.dataset.bsBadgeResetOnStartParam === 'true';
        
        this.disableActionButtons();
        
        if (resetOnStart) {
            this.countValue = this.initialCount;
            this.updateCounter();
        }
        
        const direction = target > this.countValue ? 1 : -1;
        this.dispatch('animation-started', { 
            detail: { 
                from: this.countValue, 
                to: target, 
                direction 
            } 
        });
        this.animate(target, direction);
    }

    animateBy(event) {
        if (this.animationTimer) return;
        
        const amount = parseInt(event.params?.amount ?? 1, 10);
        const target = this.countValue + amount;
        const direction = amount > 0 ? 1 : -1;
        
        this.disableActionButtons();
        this.dispatch('animation-started', { 
            detail: { 
                from: this.countValue, 
                to: target, 
                direction,
                amount
            } 
        });
        this.animate(target, direction);
    }

    animate(target, direction) {
        const shouldPause = () => Math.random() < 0.2;
        const pauseDuration = () => Math.floor(Math.random() * 500) + 200;
        const randomStep = () => Math.floor(Math.random() * 9) + 1;
        
        const step = () => {
            const done = direction > 0 ? this.countValue >= target : this.countValue <= target;
            
            if (done) {
                this.countValue = target;
                this.updateCounter();
                this.stopAnimation();
                this.enableResetButton();
                console.log('🔔 Dispatching animation-complete event:', { count: this.countValue, target });
                this.dispatch('animation-complete', { 
                    detail: { 
                        count: this.countValue, 
                        target 
                    } 
                });
                return;
            }
            
            const doStep = (stepSize) => {
                const newValue = this.countValue + (direction * stepSize);
                this.countValue = direction > 0 
                    ? Math.min(newValue, target) 
                    : Math.max(newValue, target);
                this.updateCounter();
            };
            
            if (shouldPause()) {
                setTimeout(() => {
                    if (this.animationTimer) {
                        doStep(randomStep());
                    }
                }, pauseDuration());
            } else {
                doStep(randomStep());
            }
        };
        
        this.animationTimer = setInterval(step, this.animationSpeedValue);
    }

    stopAnimation() {
        if (this.animationTimer) {
            clearInterval(this.animationTimer);
            this.animationTimer = null;
        }
    }

    // Status Actions
    setStatus(event) {
        const oldStatus = this.statusValue;
        this.statusValue = event.params.status;
        this.updateIndicator();
        this.dispatch('status-changed', { 
            detail: { 
                status: this.statusValue, 
                previousStatus: oldStatus 
            } 
        });
    }

    // Blinking Actions
    startBlinking() {
        if (this.blinkTimer || !this.hasIndicatorTarget) return;
        
        let isGreen = true;
        this.blinkTimer = setInterval(() => {
            this.indicatorTarget.style.backgroundColor = isGreen ? '#dc3545' : '#28a745';
            isGreen = !isGreen;
        }, 250);
    }

    stopBlinking() {
        if (this.blinkTimer) {
            clearInterval(this.blinkTimer);
            this.blinkTimer = null;
            this.updateIndicator();
        }
    }

    toggleBlinking() {
        this.blinkTimer ? this.stopBlinking() : this.startBlinking();
    }

    // UI Updates
    updateCounter() {
        if (!this.hasCounterTarget) return;

        this.counterTarget.textContent = this.countValue > this.maxCountValue
            ? `${this.maxCountValue}+`
            : this.countValue.toString();
        
        const badge = this.counterTarget.closest('.badge');
        if (badge && this.autoHideValue) {
            badge.classList.toggle('d-none', this.countValue === 0);
        }
    }

    updateIndicator() {
        if (!this.hasIndicatorTarget) return;
        
        const colors = {
            online: '#28a745',
            brb: '#ffc107',
            busy: '#dc3545',
            offline: '#6c757d'
        };
        
        this.indicatorTarget.style.backgroundColor = colors[this.statusValue] || colors.offline;
    }

    // Button State Management
    disableActionButtons() {
        this.actionButtonTargets.forEach(btn => btn.disabled = true);
        if (this.hasResetButtonTarget) {
            this.resetButtonTarget.disabled = true;
        }
    }

    enableResetButton() {
        if (this.hasResetButtonTarget) {
            this.resetButtonTarget.disabled = false;
        }
    }

    enableButtons() {
        this.actionButtonTargets.forEach(btn => btn.disabled = false);
        if (this.hasResetButtonTarget) {
            this.resetButtonTarget.disabled = false;
        }
    }
}
