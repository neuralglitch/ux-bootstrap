import { Controller } from '@hotwired/stimulus'
import * as bootstrap from 'bootstrap'

export default class extends Controller {
  connect() {
    // Instance tracker
    this._toasts = []

    // Initialize toasts
    this.initToasts()

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

  initToasts() {
    const Toast = (window.bootstrap?.Toast) ?? bootstrap.Toast
    
    // Only auto-show toasts that are not inside collapse containers
    // (autohide examples should be triggered by buttons, not auto-shown)
    const collapseContainer = this.element.closest('.collapse')
    
    if (!collapseContainer) {
      // Regular toast - show immediately
      const options = this.getToastOptions()
      const instance = Toast.getOrCreateInstance(this.element, options)
      this._toasts.push(instance)
      instance.show()
    } else {
      // Toast in collapse - listen for collapse shown event
      this._collapseShownHandler = () => {
        // Check if element still exists (might have been removed by Bootstrap)
        if (!this.element.parentNode) {
          return
        }
        
        const options = this.getToastOptions()
        
        // Create new instance each time to ensure fresh state
        const instance = new Toast(this.element, options)
        this._toasts.push(instance)
        instance.show()
        
        // Handle autohide manually if needed
        if (options.autohide && options.delay) {
          setTimeout(() => {
            try {
              instance.hide()
            } catch (e) {
              // Element might already be removed
            }
          }, options.delay)
        }
      }
      collapseContainer.addEventListener('shown.bs.collapse', this._collapseShownHandler)
    }
  }

  getToastOptions() {
    // Read options from data attributes
    const options = {}
    
    if (this.element.dataset.bsAutohide !== undefined) {
      options.autohide = this.element.dataset.bsAutohide === 'true'
    }
    
    if (this.element.dataset.bsDelay !== undefined) {
      options.delay = parseInt(this.element.dataset.bsDelay, 10)
    }
    
    return options
  }

  disposeAll() {
    // Gracefully hide and dispose toasts
    this._toasts?.forEach(t => { 
      try { 
        t.hide(); 
        t.dispose(); 
      } catch (_) {} 
    })
    this._toasts = []
  }
}
