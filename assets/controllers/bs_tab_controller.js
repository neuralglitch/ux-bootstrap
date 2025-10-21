import {Controller} from '@hotwired/stimulus';
import * as bootstrap from 'bootstrap';

/**
 * Universal Tab Controller
 *
 * Automatically initializes Bootstrap tabs on elements.
 * Works with nav-tabs, nav-pills, and any tabbed interface.
 *
 * Usage:
 * 1. Automatic via component (recommended):
 *    <twig:bs:nav type="tabs">...</twig:bs:nav>
 *
 * 2. Manual on any element:
 *    <ul data-controller="bs-tab" class="nav nav-tabs">
 *      <li class="nav-item">
 *        <button data-bs-toggle="tab" data-bs-target="#home">Home</button>
 *      </li>
 *    </ul>
 *
 * Features:
 * - Auto-initialization of Bootstrap Tab instances
 * - Proper cleanup for Turbo compatibility
 * - Support for all tab triggers
 * - Debug logging when APP_DEBUG=1
 */
export default class extends Controller {
    connect() {
        this.tabs = [];
        this.initializeTabs();
    }

    disconnect() {
        this.disposeTabs();
    }

    initializeTabs() {
        const Tab = window.bootstrap?.Tab ?? bootstrap.Tab;

        // Find all tab triggers
        const triggers = this.element.querySelectorAll('[data-bs-toggle="tab"], [data-bs-toggle="pill"]');

        if (triggers.length === 0) {
            console.warn('[bs-tab] No tab triggers found');
        }


        try {
            triggers.forEach((trigger) => {
                const tab = new Tab(trigger);
                this.tabs.push(tab);
            });
        } catch
            (error) {
            console.error('bs-tab failed to initialize:', error);
        }

    }

    disposeTabs() {
        if (this.tabs.length > 0) {
            try {
                this.tabs.forEach(tab => {
                    try {
                        tab.dispose();
                    } catch (error) {
                        // Individual tab disposal might fail
                    }
                });
            } catch (error) {
                console.warn('bs-tab dispose error:', error);
            } finally {
                this.tabs = [];
            }
        }
    }
}

