import { Controller } from '@hotwired/stimulus';

/**
 * Mega Menu Navbar Controller
 * 
 * Enhances Bootstrap dropdowns to support mega menu functionality
 * with multi-column layouts and rich content
 * 
 * Usage:
 *   Add 'data-navbar-mega-menu' to dropdown items that should be mega menus
 *   Add 'data-navbar-mega-menu-width' attribute to control width ('full', 'auto', or specific value)
 * 
 * Targets:
 *   - megaMenu: Mega menu dropdown elements
 */
export default class extends Controller {
    static targets = ['megaMenu'];

    connect() {
        this.setupMegaMenus();
        
        // Handle window resize
        this.resizeHandler = this.handleResize.bind(this);
        window.addEventListener('resize', this.resizeHandler);
    }

    disconnect() {
        window.removeEventListener('resize', this.resizeHandler);
    }

    setupMegaMenus() {
        // Find all mega menu dropdowns
        const megaMenus = this.element.querySelectorAll('[data-navbar-mega-menu]');
        
        megaMenus.forEach(menu => {
            const dropdown = menu.querySelector('.dropdown-menu');
            if (!dropdown) return;

            // Ensure mega menu class exists
            if (!dropdown.classList.contains('mega-menu')) {
                dropdown.classList.add('mega-menu');
            }

            // Get width setting
            const width = menu.dataset.navbarMegaMenuWidth || 'full';
            
            if (width === 'full') {
                dropdown.classList.add('mega-menu-full');
                // Set full width immediately
                this.setFullWidth(dropdown);
            } else if (width === 'auto') {
                dropdown.classList.add('mega-menu-auto');
            } else {
                dropdown.style.width = width;
            }

            // Position mega menu
            this.positionMegaMenu(menu, dropdown);
        });
    }

    positionMegaMenu(menuItem, dropdown) {
        // On dropdown show, recalculate position
        menuItem.addEventListener('show.bs.dropdown', () => {
            if (dropdown.classList.contains('mega-menu-full')) {
                this.setFullWidth(dropdown);
            }

            // Center align mega menu if needed
            const rect = menuItem.getBoundingClientRect();
            const dropdownRect = dropdown.getBoundingClientRect();
            
            // Check if dropdown would overflow viewport
            const viewportWidth = window.innerWidth;
            const overflowRight = rect.left + dropdownRect.width > viewportWidth;
            const overflowLeft = rect.left < 0;

            if (overflowRight && !dropdown.classList.contains('mega-menu-full')) {
                dropdown.style.left = 'auto';
                dropdown.style.right = '0';
            } else if (overflowLeft && !dropdown.classList.contains('mega-menu-full')) {
                dropdown.style.left = '0';
                dropdown.style.right = 'auto';
            }
        });
    }

    setFullWidth(dropdown) {
        // CSS handles the positioning, just ensure class is set
        dropdown.classList.add('mega-menu-full');
    }

    handleResize() {
        // Recalculate on resize (throttled)
        clearTimeout(this.resizeTimeout);
        this.resizeTimeout = setTimeout(() => {
            this.setupMegaMenus();
        }, 100);
    }
}

