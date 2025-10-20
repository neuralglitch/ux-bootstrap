import { Controller } from '@hotwired/stimulus';
import Masonry from 'masonry-layout';

/*
 * Masonry Controller
 * 
 * Usage:
 * <div data-controller="masonry" 
 *      data-masonry-item-selector-value=".grid-item"
 *      data-masonry-column-width-value="200"
 *      data-masonry-gutter-value="10">
 *   <div class="grid-item">...</div>
 *   <div class="grid-item">...</div>
 * </div>
 */
export default class extends Controller {
  static values = {
    itemSelector: { type: String, default: '.grid-item' },
    columnWidth: { type: Number, default: null },
    gutter: { type: Number, default: 0 },
    percentPosition: { type: Boolean, default: false },
    horizontalOrder: { type: Boolean, default: false },
    fitWidth: { type: Boolean, default: false },
    originLeft: { type: Boolean, default: true },
    originTop: { type: Boolean, default: true },
    resize: { type: Boolean, default: true },
    initLayout: { type: Boolean, default: true },
    transitionDuration: { type: String, default: '0.4s' }
  }

  connect() {
    // Build options object from values
    const options = {
      itemSelector: this.itemSelectorValue,
      percentPosition: this.percentPositionValue,
      horizontalOrder: this.horizontalOrderValue,
      fitWidth: this.fitWidthValue,
      originLeft: this.originLeftValue,
      originTop: this.originTopValue,
      resize: this.resizeValue,
      initLayout: this.initLayoutValue,
      transitionDuration: this.transitionDurationValue
    };

    // Only add columnWidth if specified
    if (this.hasColumnWidthValue && this.columnWidthValue !== null) {
      options.columnWidth = this.columnWidthValue;
    }

    // Only add gutter if specified
    if (this.hasGutterValue && this.gutterValue > 0) {
      options.gutter = this.gutterValue;
    }

    // Initialize Masonry
    this.masonry = new Masonry(this.element, options);

    // Handle image loading
    this.imageLoadHandler = this.handleImageLoad.bind(this);
    this.setupImageLoading();
  }

  disconnect() {
    if (this.masonry) {
      this.masonry.destroy();
      this.masonry = null;
    }

    // Remove image load listeners
    this.removeImageLoading();
  }

  setupImageLoading() {
    // Get all images in the grid
    const images = this.element.querySelectorAll('img');
    
    images.forEach(img => {
      if (img.complete) {
        // Image already loaded
        this.layout();
      } else {
        // Wait for image to load
        img.addEventListener('load', this.imageLoadHandler);
        img.addEventListener('error', this.imageLoadHandler);
      }
    });
  }

  removeImageLoading() {
    const images = this.element.querySelectorAll('img');
    images.forEach(img => {
      img.removeEventListener('load', this.imageLoadHandler);
      img.removeEventListener('error', this.imageLoadHandler);
    });
  }

  handleImageLoad() {
    // Relayout after image loads
    this.layout();
  }

  // Public method to trigger layout recalculation
  layout() {
    if (this.masonry) {
      this.masonry.layout();
    }
  }

  // Public method to add and layout new items
  appended(event) {
    if (this.masonry && event.detail && event.detail.elements) {
      this.masonry.appended(event.detail.elements);
    }
  }

  // Public method to prepend and layout new items
  prepended(event) {
    if (this.masonry && event.detail && event.detail.elements) {
      this.masonry.prepended(event.detail.elements);
    }
  }

  // Public method to remove items
  remove(event) {
    if (this.masonry && event.detail && event.detail.elements) {
      this.masonry.remove(event.detail.elements);
      this.masonry.layout();
    }
  }

  // Public method to reload the layout (useful after dynamic content changes)
  reloadItems() {
    if (this.masonry) {
      this.masonry.reloadItems();
      this.masonry.layout();
    }
  }
}

