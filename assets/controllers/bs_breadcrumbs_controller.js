import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
  static targets = ['item']
  static values = { 
    divider: String,
    autoCollapse: Boolean,
    collapseThreshold: Number
  }

  connect() {
    // Initialize breadcrumbs functionality
    this.initBreadcrumbs()
  }

  disconnect() {
    // Cleanup if needed
  }

  initBreadcrumbs() {
    // Handle auto-collapse if enabled
    if (this.autoCollapseValue) {
      this.handleAutoCollapse()
    }

    // Add click tracking for analytics (optional)
    this.addClickTracking()
  }

  handleAutoCollapse() {
    const items = this.itemTargets
    const threshold = this.collapseThresholdValue || 4

    if (items.length > threshold) {
      // Hide middle items and show ellipsis
      const startIndex = 1 // Keep first item (usually home)
      const endIndex = items.length - 2 // Keep last item (current page)
      const middleItems = items.slice(startIndex, endIndex)

      // Hide middle items
      middleItems.forEach(item => {
        item.style.display = 'none'
      })

      // Add ellipsis item
      this.addEllipsisItem(startIndex)
    }
  }

  addEllipsisItem(insertIndex) {
    const ellipsisItem = document.createElement('li')
    ellipsisItem.className = 'breadcrumb-item'
    ellipsisItem.innerHTML = '<span class="text-muted">...</span>'
    ellipsisItem.setAttribute('data-bs-breadcrumbs-target', 'item')

    // Insert ellipsis at the specified position
    const items = this.itemTargets
    if (items[insertIndex]) {
      items[insertIndex].parentNode.insertBefore(ellipsisItem, items[insertIndex])
    }
  }

  addClickTracking() {
    // Add click event listeners to breadcrumb links for analytics
    this.itemTargets.forEach(item => {
      const link = item.querySelector('a')
      if (link) {
        link.addEventListener('click', (event) => {
          // Dispatch custom event for analytics tracking
          this.dispatch('breadcrumbs-click', {
            detail: {
              url: link.href,
              label: link.textContent.trim(),
              position: Array.from(this.itemTargets).indexOf(item)
            }
          })
        })
      }
    })
  }

  // Method to expand collapsed breadcrumbs (if needed)
  expand() {
    const hiddenItems = this.element.querySelectorAll('.breadcrumb-item[style*="display: none"]')
    const ellipsisItem = this.element.querySelector('.breadcrumb-item:has(.text-muted)')
    
    hiddenItems.forEach(item => {
      item.style.display = ''
    })
    
    if (ellipsisItem) {
      ellipsisItem.remove()
    }
  }

  // Method to collapse breadcrumbs (if needed)
  collapse() {
    this.handleAutoCollapse()
  }
}

