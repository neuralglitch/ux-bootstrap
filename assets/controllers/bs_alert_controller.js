import { Controller } from '@hotwired/stimulus'
import * as bootstrap from 'bootstrap'

export default class extends Controller {
  connect() {
    // Instance tracker
    this._alerts = []

    // Initialize alerts
    this.initAlerts()

    // Turbo: dispose all before new render
    this._beforeRender = () => this.disposeAll()
    document.addEventListener('turbo:before-render', this._beforeRender, { passive: true })
  }

  disconnect() {
    // Cleanup: instances + event listeners
    this.disposeAll()
    if (this._beforeRender) {
      document.removeEventListener('turbo:before-render', this._beforeRender)
      this._beforeRender = null
    }
    if (this._collapseShownHandler) {
      const collapseContainer = this.element.closest('.collapse')
      if (collapseContainer) {
        collapseContainer.removeEventListener('shown.bs.collapse', this._collapseShownHandler)
      }
      this._collapseShownHandler = null
    }
  }

  initAlerts() {
    const Alert = (window.bootstrap?.Alert) ?? bootstrap.Alert
    
    // Only auto-show alerts that are not inside collapse containers
    // (autohide examples should be triggered by buttons, not auto-shown)
    const collapseContainer = this.element.closest('.collapse')
    
    if (!collapseContainer) {
      // Regular alert - initialize immediately
      const instance = Alert.getOrCreateInstance(this.element)
      this._alerts.push(instance)
    } else {
      // Alert in collapse - listen for collapse shown event
      this._collapseShownHandler = () => {
        // Check if element still exists (might have been removed by Bootstrap)
        if (!this.element.parentNode) {
          return
        }
        
        // Create new instance each time to ensure fresh state
        const instance = new Alert(this.element)
        this._alerts.push(instance)
        
        // Handle autohide manually if needed
        const autoHideDelay = this.getAutoHideDelay()
        if (autoHideDelay) {
          setTimeout(() => {
            try {
              instance.close()
            } catch (e) {
              // Element might already be removed
            }
          }, autoHideDelay)
        }
      }
      collapseContainer.addEventListener('shown.bs.collapse', this._collapseShownHandler)
    }
  }

  getAutoHideDelay() {
    // Read autoHideDelay from data attribute
    if (this.element.dataset.autoHideDelay !== undefined) {
      return parseInt(this.element.dataset.autoHideDelay, 10)
    }
    return null
  }

  disposeAll() {
    // Gracefully hide and dispose alerts
    this._alerts?.forEach(a => { 
      try { 
        a.close(); 
        a.dispose(); 
      } catch (_) {} 
    })
    this._alerts = []
  }
}
