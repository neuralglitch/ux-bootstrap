// assets/controllers/bs-link_controller.js
import { Controller } from '@hotwired/stimulus'
import * as bootstrap from 'bootstrap' // oder nutze window.bootstrap.* bei Tree-Shaking

export default class extends Controller {
  connect () {
    // Instanz-Tracker
    this._tooltips = []
    this._popovers = []

    // Initialisieren
    this.initTooltips()
    this.initPopovers()

    // Turbo: vor neuem Render alles entsorgen
    this._beforeRender = () => this.disposeAll()
    document.addEventListener('turbo:before-render', this._beforeRender, { passive: true })
  }

  disconnect () {
    // Aufräumen: Instanzen + Event-Listener
    this.disposeAll()
    if (this._beforeRender) {
      document.removeEventListener('turbo:before-render', this._beforeRender)
      this._beforeRender = null
    }
  }

  initTooltips () {
    const Tooltip = (window.bootstrap?.Tooltip) ?? bootstrap.Tooltip
    const els = this.element.matches('[data-bs-toggle="tooltip"]')
      ? [this.element]
      : this.element.querySelectorAll('[data-bs-toggle="tooltip"]')

    els.forEach(el => {
      const opts = {}
      if (el.dataset.bsHtml) opts.html = el.dataset.bsHtml === 'true'
      if (el.dataset.bsContainer) opts.container = el.dataset.bsContainer
      if (el.dataset.bsPlacement) opts.placement = el.dataset.bsPlacement
      if (el.dataset.bsTrigger) opts.trigger = el.dataset.bsTrigger
      const instance = Tooltip.getOrCreateInstance(el, opts)
      this._tooltips.push(instance)
    })
  }

  initPopovers () {
    const Popover = (window.bootstrap?.Popover) ?? bootstrap.Popover
    const els = this.element.matches('[data-bs-toggle="popover"]')
      ? [this.element]
      : this.element.querySelectorAll('[data-bs-toggle="popover"]')

    els.forEach(el => {
      const opts = {}
      if (el.dataset.bsHtml) opts.html = el.dataset.bsHtml === 'true'
      if (el.dataset.bsContainer) opts.container = el.dataset.bsContainer
      if (el.dataset.bsPlacement) opts.placement = el.dataset.bsPlacement
      if (el.dataset.bsTrigger) opts.trigger = el.dataset.bsTrigger
      if (el.dataset.bsBoundary) opts.boundary = el.dataset.bsBoundary
      const instance = Popover.getOrCreateInstance(el, opts)
      this._popovers.push(instance)
    })
  }

  disposeAll () {
    // sanft verstecken (verhindert hängenbleibende Backdrops)
    this._tooltips?.forEach(t => { try { t.hide(); t.dispose(); } catch (_) {} })
    this._popovers?.forEach(p => { try { p.hide(); p.dispose(); } catch (_) {} })
    this._tooltips = []
    this._popovers = []
  }
}
