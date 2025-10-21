import {Controller} from '@hotwired/stimulus';

/**
 * Cookie Banner Controller
 *
 * Manages cookie consent banner with localStorage/cookie persistence
 *
 * @data-bs-cookie-banner-cookie-name-value - Cookie name for consent storage
 * @data-bs-cookie-banner-expiry-days-value - Cookie expiry in days
 * @data-bs-cookie-banner-backdrop-value - Show backdrop overlay
 */
export default class extends Controller {
    static targets = ['banner', 'backdrop'];
    static values = {
        cookieName: {type: String, default: 'cookie_consent'},
        expiryDays: {type: Number, default: 365},
        backdrop: {type: Boolean, default: false}
    };

    connect() {
        this.checkConsent();
    }

    checkConsent() {
        const consent = this.getConsent();

        if (!consent) {
            // No consent found, show banner
            this.showBanner();
        }
    }

    showBanner() {
        if (this.hasBannerTarget) {
            this.bannerTarget.style.display = 'block';

            // Animate in
            requestAnimationFrame(() => {
                this.bannerTarget.style.opacity = '0';
                this.bannerTarget.style.transform = this.getInitialTransform();
                this.bannerTarget.style.transition = 'opacity 0.3s ease, transform 0.3s ease';

                requestAnimationFrame(() => {
                    this.bannerTarget.style.opacity = '1';
                    this.bannerTarget.style.transform = 'none';
                });
            });
        }

        if (this.backdropValue && this.hasBackdropTarget) {
            this.backdropTarget.style.display = 'block';

            requestAnimationFrame(() => {
                this.backdropTarget.style.opacity = '0';
                this.backdropTarget.style.transition = 'opacity 0.3s ease';

                requestAnimationFrame(() => {
                    this.backdropTarget.style.opacity = '1';
                });
            });
        }

        // Dispatch event
        this.dispatch('shown');
    }

    hideBanner() {
        if (this.hasBannerTarget) {
            this.bannerTarget.style.opacity = '0';
            this.bannerTarget.style.transform = this.getInitialTransform();

            setTimeout(() => {
                this.bannerTarget.style.display = 'none';
            }, 300);
        }

        if (this.backdropValue && this.hasBackdropTarget) {
            this.backdropTarget.style.opacity = '0';

            setTimeout(() => {
                this.backdropTarget.style.display = 'none';
            }, 300);
        }

        // Dispatch event
        this.dispatch('hidden');
    }

    accept(event) {
        event?.preventDefault();

        this.setConsent('accepted');
        this.hideBanner();

        // Dispatch custom event for analytics/tracking
        this.dispatch('accepted', {detail: {consent: 'accepted'}});
    }

    reject(event) {
        event?.preventDefault();

        this.setConsent('rejected');
        this.hideBanner();

        // Dispatch custom event for analytics/tracking
        this.dispatch('rejected', {detail: {consent: 'rejected'}});
    }

    customize(event) {
        event?.preventDefault();

        // Dispatch event to open customization modal/panel
        // This should be handled by the parent application
        this.dispatch('customize', {detail: {action: 'customize'}});
    }

    dismiss(event) {
        event?.preventDefault();

        // Just hide without storing consent
        this.hideBanner();

        this.dispatch('dismissed');
    }

    // Consent storage methods
    getConsent() {
        // Try localStorage first
        try {
            const stored = localStorage.getItem(this.cookieNameValue);
            if (stored) {
                return stored;
            }
        } catch (e) {
            // localStorage not available
        }

        // Fallback to cookies
        return this.getCookie(this.cookieNameValue);
    }

    setConsent(value) {
        // Store in localStorage
        try {
            localStorage.setItem(this.cookieNameValue, value);
        } catch (e) {
            // localStorage not available
        }

        // Store in cookie as fallback
        this.setCookie(this.cookieNameValue, value, this.expiryDaysValue);
    }

    // Cookie helpers
    getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);

        if (parts.length === 2) {
            return parts.pop().split(';').shift();
        }

        return null;
    }

    setCookie(name, value, days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        const expires = `expires=${date.toUTCString()}`;

        document.cookie = `${name}=${value};${expires};path=/;SameSite=Lax`;
    }

    // Animation helper
    getInitialTransform() {
        // Get position from classes
        const classes = this.bannerTarget.className;

        if (classes.includes('cookie-banner-top')) {
            return 'translateY(-100%)';
        }

        if (classes.includes('cookie-banner-bottom')) {
            return 'translateY(100%)';
        }

        return 'translateY(100%)'; // default
    }
}

