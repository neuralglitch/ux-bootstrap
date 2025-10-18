import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
  static targets = ['alert']
  static values = {
    autoHide: Boolean,
    autoHideDelay: Number,
    maxAlerts: Number
  }

  connect() {
    // Track alert timers
    this._timers = new Map()

    // Setup auto-hide for existing alerts if enabled
    if (this.autoHideValue) {
      this.setupAutoHide()
    }

    // Observe for new alerts added dynamically
    this.setupMutationObserver()

    // Listen for alert close events
    this.element.addEventListener('closed.bs.alert', this.handleAlertClosed.bind(this))
  }

  disconnect() {
    // Clear all timers
    this._timers.forEach(timer => clearTimeout(timer))
    this._timers.clear()

    // Disconnect mutation observer
    if (this._observer) {
      this._observer.disconnect()
      this._observer = null
    }

    // Remove event listener
    this.element.removeEventListener('closed.bs.alert', this.handleAlertClosed.bind(this))
  }

  setupAutoHide() {
    this.alertTargets.forEach(alert => {
      // Check if alert has its own auto-hide settings
      const autoHide = alert.dataset.bsAlertAutoHide === 'true'
      const delay = parseInt(alert.dataset.bsAlertAutoHideDelay || this.autoHideDelayValue, 10)

      if (autoHide) {
        this.scheduleAutoHide(alert, delay)
      }
    })
  }

  scheduleAutoHide(alert, delay) {
    // Clear existing timer if any
    if (this._timers.has(alert)) {
      clearTimeout(this._timers.get(alert))
    }

    // Schedule auto-hide
    const timer = setTimeout(() => {
      this.hideAlert(alert)
      this._timers.delete(alert)
    }, delay)

    this._timers.set(alert, timer)
  }

  hideAlert(alert) {
    try {
      // Use Bootstrap's alert close method
      const bsAlert = bootstrap.Alert.getInstance(alert)
      if (bsAlert) {
        bsAlert.close()
      } else {
        // Fallback: manually remove
        alert.classList.remove('show')
        setTimeout(() => alert.remove(), 150)
      }
    } catch (e) {
      // Element might already be removed
      console.warn('Failed to hide alert:', e)
    }
  }

  handleAlertClosed(event) {
    const alert = event.target
    
    // Clear timer if exists
    if (this._timers.has(alert)) {
      clearTimeout(this._timers.get(alert))
      this._timers.delete(alert)
    }

    // Enforce max alerts limit
    this.enforceMaxAlerts()
  }

  enforceMaxAlerts() {
    if (this.maxAlertsValue > 0) {
      const alerts = this.alertTargets
      if (alerts.length > this.maxAlertsValue) {
        // Remove oldest alerts (from the beginning)
        const alertsToRemove = alerts.slice(0, alerts.length - this.maxAlertsValue)
        alertsToRemove.forEach(alert => this.hideAlert(alert))
      }
    }
  }

  setupMutationObserver() {
    this._observer = new MutationObserver(mutations => {
      mutations.forEach(mutation => {
        mutation.addedNodes.forEach(node => {
          if (node.nodeType === 1 && node.matches('[data-bs-alert-stack-target="alert"]')) {
            // New alert added
            this.onAlertAdded(node)
          }
        })
      })
    })

    this._observer.observe(this.element, {
      childList: true,
      subtree: false
    })
  }

  onAlertAdded(alert) {
    // Setup auto-hide for new alert if enabled
    const autoHide = alert.dataset.bsAlertAutoHide === 'true'
    const delay = parseInt(alert.dataset.bsAlertAutoHideDelay || this.autoHideDelayValue, 10)

    if (autoHide) {
      this.scheduleAutoHide(alert, delay)
    }

    // Enforce max alerts limit
    this.enforceMaxAlerts()
  }

  /**
   * Public method to add a new alert dynamically
   * @param {Object} options - Alert options
   * @param {string} options.message - Alert message (HTML)
   * @param {string} options.variant - Bootstrap variant (default: 'info')
   * @param {boolean} options.dismissible - Whether dismissible (default: true)
   * @param {boolean} options.autoHide - Whether to auto-hide (default: uses stack setting)
   * @param {number} options.autoHideDelay - Auto-hide delay (default: uses stack setting)
   */
  addAlert(options = {}) {
    const {
      message = '',
      variant = 'info',
      dismissible = true,
      autoHide = this.autoHideValue,
      autoHideDelay = this.autoHideDelayValue
    } = options

    // Create alert element
    const alert = document.createElement('div')
    alert.className = `alert alert-${variant} ${dismissible ? 'alert-dismissible' : ''} fade show`
    alert.setAttribute('role', 'alert')
    alert.setAttribute('data-bs-alert-stack-target', 'alert')
    alert.setAttribute('data-controller', 'bs-alert')
    alert.id = `alert-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`

    if (autoHide) {
      alert.setAttribute('data-bs-alert-auto-hide', 'true')
      alert.setAttribute('data-bs-alert-auto-hide-delay', autoHideDelay.toString())
    }

    // Set message
    alert.innerHTML = message

    // Add close button if dismissible
    if (dismissible) {
      const closeBtn = document.createElement('button')
      closeBtn.type = 'button'
      closeBtn.className = 'btn-close'
      closeBtn.setAttribute('data-bs-dismiss', 'alert')
      closeBtn.setAttribute('aria-label', 'Close')
      alert.appendChild(closeBtn)
    }

    // Add to stack
    this.element.appendChild(alert)

    return alert
  }

  /**
   * Public method to clear all alerts
   */
  clearAll() {
    this.alertTargets.forEach(alert => this.hideAlert(alert))
  }

  /**
   * Public method to remove a specific alert by ID
   * @param {string} alertId - Alert element ID
   */
  removeAlert(alertId) {
    const alert = this.element.querySelector(`#${alertId}`)
    if (alert) {
      this.hideAlert(alert)
    }
  }
}

