// assets/controllers/bs_theme_controller.js
import {Controller} from '@hotwired/stimulus';

/**
 * Bootstrap Theme Toggle Controller
 * - UX-Icons (moon/sun) für Toggle-Button
 * - Dropdown-Items (Light/Dark) mit Checkmark (bi:check)
 * - Sichtbarkeit via d-block/d-none
 * - Disabled-Handling & a11y
 * - Persistenz via LocalStorage + Cookie
 */
export default class extends Controller {
    static targets = [
        'moon', 'sun', 'label',
        'checkbox', 'select',
        'itemLight', 'itemDark',
        'checkLight', 'checkDark'
    ];

    connect() {
        const persisted = this.readPersisted(); // 'light' | 'dark' | null
        let current = document.documentElement.getAttribute('data-bs-theme');

        if (!persisted) {
            const os = this.detectOsTheme();
            if (current !== 'light' && current !== 'dark') {
                this.apply(os, true);
            } else {
                this.persist(os);
                this.updateUI(current || os);
            }
            return;
        }

        if (current !== persisted) {
            this.apply(persisted, false);
        } else {
            this.updateUI(current);
        }
    }

    // --- Events ---------------------------------------------------------------

    toggle() {
        const next = this.current() === 'light' ? 'dark' : 'light';
        this.apply(next, true);
    }

    select(event) {
        const val = event.target.value;
        if (val === 'light' || val === 'dark') this.apply(val, true);
    }

    switch(event) {
        const mode = event.target.checked ? 'dark' : 'light';
        this.apply(mode, true);
    }

    applyFromDropdown(event) {
        const btn = event.currentTarget;
        if (btn.classList.contains('disabled') || btn.getAttribute('aria-disabled') === 'true') return;
        const v = btn.getAttribute('data-value');
        if (v === 'light' || v === 'dark') this.apply(v, true);
    }

    // --- Core -----------------------------------------------------------------

    apply(mode, persist) {
        document.documentElement.setAttribute('data-bs-theme', mode);
        document.documentElement.style.colorScheme = mode;
        this.updateUI(mode);
        if (persist) this.persist(mode);
    }

    updateUI(currentMode) {
        // Icon (Button): Zeige ZIEL nach Klick
        const nextIsDark = currentMode === 'light';
        if (this.hasMoonTarget) this.setDisplay(this.moonTarget, nextIsDark);
        if (this.hasSunTarget) this.setDisplay(this.sunTarget, !nextIsDark);

        // Label/Tooltip
        const next = nextIsDark ? 'dark' : 'light';
        const label = `${next === 'dark' ? 'Dark' : 'Light'} Theme`;
        if (this.hasLabelTarget) this.labelTarget.textContent = label;
        const btn = this.element.matches('button') ? this.element : this.element.querySelector('button');
        if (btn) {
            btn.setAttribute('aria-label', label);
            btn.setAttribute('title', label);
        }

        // Form Controls sync
        if (this.hasCheckboxTarget) this.checkboxTarget.checked = (currentMode === 'dark');
        if (this.hasSelectTarget) this.selectTarget.value = currentMode;

        // Dropdown Items: aktuelles Theme deaktivieren + Check setzen
        if (this.hasItemLightTarget) this.setDisabled(this.itemLightTarget, currentMode === 'light');
        if (this.hasItemDarkTarget) this.setDisabled(this.itemDarkTarget, currentMode === 'dark');

        if (this.hasCheckLightTarget) this.setDisplay(this.checkLightTarget, currentMode === 'light');
        if (this.hasCheckDarkTarget) this.setDisplay(this.checkDarkTarget, currentMode === 'dark');

        // a11y
        if (this.hasItemLightTarget) this.itemLightTarget.setAttribute('aria-current', currentMode === 'light' ? 'true' : 'false');
        if (this.hasItemDarkTarget) this.itemDarkTarget.setAttribute('aria-current', currentMode === 'dark' ? 'true' : 'false');
    }

    // --- Helpers --------------------------------------------------------------

    setDisplay(el, show) {
        if (!el) return;
        el.classList.toggle('d-none', !show);
        el.classList.toggle('d-block', show);
    }

    setDisabled(el, disabled) {
        if (!el) return;
        el.classList.toggle('disabled', disabled);
        el.setAttribute('aria-disabled', disabled ? 'true' : 'false');
        if (disabled) el.setAttribute('tabindex', '-1');
        else el.removeAttribute('tabindex');
    }

    current() {
        return document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'dark' : 'light';
    }

    detectOsTheme() {
        return (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches)
            ? 'dark' : 'light';
    }

    persist(mode) {
        try {
            localStorage.setItem('theme', mode);
        } catch (_) {
        }
        try {
            document.cookie = `theme=${mode}; Max-Age=${60 * 60 * 24 * 365}; Path=/; SameSite=Lax`;
        } catch (_) {
        }
    }

    readPersisted() {
        try {
            const ls = localStorage.getItem('theme');
            if (ls === 'light' || ls === 'dark') return ls;
        } catch (_) {
        }
        const m = document.cookie.match(/(?:^|;\s*)theme=(dark|light)\b/);
        return m ? m[1] : null;
    }
}
