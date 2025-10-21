import {Controller} from '@hotwired/stimulus';

/**
 * Notification Center Controller
 *
 * Manages notification center interactions including:
 * - Mark as read/unread
 * - Mark all read
 * - Clear all notifications
 * - Auto-refresh
 * - Badge count updates
 *
 * Targets:
 * - trigger: The button that opens the notification center
 * - badge: The notification count badge
 * - notificationList: Container for notification items
 *
 * Values:
 * - unreadCount: Number of unread notifications
 * - markReadOnClick: Automatically mark as read when clicked
 * - autoRefresh: Enable auto-refresh
 * - autoRefreshInterval: Interval in milliseconds for auto-refresh
 * - fetchUrl: URL to fetch notifications from
 */
export default class extends Controller {
    static targets = ['trigger', 'badge', 'notificationList'];

    static values = {
        unreadCount: {type: Number, default: 0},
        markReadOnClick: {type: Boolean, default: true},
        autoRefresh: {type: Boolean, default: false},
        autoRefreshInterval: {type: Number, default: 30000},
        fetchUrl: String
    };

    connect() {
        // Initialize auto-refresh if enabled
        if (this.autoRefreshValue && this.hasFetchUrlValue) {
            this.startAutoRefresh();
        }

        // Listen for notification item clicks
        if (this.markReadOnClickValue) {
            this.element.addEventListener('click', this.handleNotificationClick.bind(this));
        }
    }

    disconnect() {
        this.stopAutoRefresh();

        if (this.markReadOnClickValue) {
            this.element.removeEventListener('click', this.handleNotificationClick.bind(this));
        }
    }

    /**
     * Mark a single notification as read
     */
    markAsRead(event) {
        const notificationItem = event.currentTarget.closest('[data-notification-id]');
        if (!notificationItem) return;

        const notificationId = notificationItem.dataset.notificationId;

        // Add visual feedback
        notificationItem.classList.remove('notification-unread');
        notificationItem.classList.add('notification-read');

        // Update unread count
        if (notificationItem.classList.contains('notification-unread')) {
            this.decrementUnreadCount();
        }

        // Trigger custom event for external handlers
        this.dispatch('marked-read', {detail: {id: notificationId}});

        // If fetch URL is provided, send request to backend
        if (this.hasFetchUrlValue) {
            this.sendMarkReadRequest(notificationId);
        }
    }

    /**
     * Mark a notification as unread
     */
    markAsUnread(event) {
        const notificationItem = event.currentTarget.closest('[data-notification-id]');
        if (!notificationItem) return;

        const notificationId = notificationItem.dataset.notificationId;

        // Add visual feedback
        notificationItem.classList.remove('notification-read');
        notificationItem.classList.add('notification-unread');

        // Update unread count
        this.incrementUnreadCount();

        // Trigger custom event
        this.dispatch('marked-unread', {detail: {id: notificationId}});

        // If fetch URL is provided, send request to backend
        if (this.hasFetchUrlValue) {
            this.sendMarkUnreadRequest(notificationId);
        }
    }

    /**
     * Mark all notifications as read
     */
    markAllRead(event) {
        event?.preventDefault();

        const unreadNotifications = this.notificationListTarget.querySelectorAll('.notification-unread');

        unreadNotifications.forEach(notification => {
            notification.classList.remove('notification-unread');
            notification.classList.add('notification-read');
        });

        // Reset unread count
        this.unreadCountValue = 0;
        this.updateBadge();

        // Trigger custom event
        this.dispatch('marked-all-read');

        // Send request to backend
        if (this.hasFetchUrlValue) {
            this.sendMarkAllReadRequest();
        }
    }

    /**
     * Clear all notifications
     */
    clearAll(event) {
        event?.preventDefault();

        if (!confirm('Are you sure you want to clear all notifications?')) {
            return;
        }

        // Clear the notification list
        this.notificationListTarget.innerHTML = `
            <div class="dropdown-item-text text-center text-muted">
                No notifications
            </div>
        `;

        // Reset unread count
        this.unreadCountValue = 0;
        this.updateBadge();

        // Trigger custom event
        this.dispatch('cleared-all');

        // Send request to backend
        if (this.hasFetchUrlValue) {
            this.sendClearAllRequest();
        }
    }

    /**
     * Delete a single notification
     */
    deleteNotification(event) {
        event.preventDefault();
        event.stopPropagation();

        const notificationItem = event.currentTarget.closest('[data-notification-id]');
        if (!notificationItem) return;

        const notificationId = notificationItem.dataset.notificationId;
        const isUnread = notificationItem.classList.contains('notification-unread');

        // Remove from DOM
        notificationItem.remove();

        // Update unread count if it was unread
        if (isUnread) {
            this.decrementUnreadCount();
        }

        // Check if list is empty
        const remainingNotifications = this.notificationListTarget.querySelectorAll('[data-notification-id]');
        if (remainingNotifications.length === 0) {
            this.notificationListTarget.innerHTML = `
                <div class="dropdown-item-text text-center text-muted">
                    No notifications
                </div>
            `;
        }

        // Trigger custom event
        this.dispatch('deleted', {detail: {id: notificationId}});

        // Send request to backend
        if (this.hasFetchUrlValue) {
            this.sendDeleteRequest(notificationId);
        }
    }

    /**
     * Refresh notifications from server
     */
    async refresh() {
        if (!this.hasFetchUrlValue) return;

        try {
            const response = await fetch(this.fetchUrlValue, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();

            // Update notification list
            if (data.html) {
                this.notificationListTarget.innerHTML = data.html;
            }

            // Update unread count
            if (typeof data.unreadCount !== 'undefined') {
                this.unreadCountValue = data.unreadCount;
                this.updateBadge();
            }

            // Trigger custom event
            this.dispatch('refreshed', {detail: data});
        } catch (error) {
            console.error('Failed to refresh notifications:', error);
            this.dispatch('refresh-error', {detail: {error}});
        }
    }

    /**
     * Handle notification item clicks
     */
    handleNotificationClick(event) {
        const notificationItem = event.target.closest('[data-notification-id]');
        if (!notificationItem) return;

        // Skip if clicking on action buttons
        if (event.target.closest('[data-action*="delete"]') ||
            event.target.closest('[data-action*="markAsRead"]') ||
            event.target.closest('[data-action*="markAsUnread"]')) {
            return;
        }

        // Mark as read if unread
        if (notificationItem.classList.contains('notification-unread')) {
            notificationItem.classList.remove('notification-unread');
            notificationItem.classList.add('notification-read');
            this.decrementUnreadCount();

            const notificationId = notificationItem.dataset.notificationId;
            this.dispatch('marked-read', {detail: {id: notificationId}});

            if (this.hasFetchUrlValue) {
                this.sendMarkReadRequest(notificationId);
            }
        }
    }

    /**
     * Update badge display
     */
    updateBadge() {
        if (!this.hasBadgeTarget) return;

        if (this.unreadCountValue > 0) {
            this.badgeTarget.textContent = this.unreadCountValue;
            this.badgeTarget.style.display = '';
        } else {
            this.badgeTarget.style.display = 'none';
        }
    }

    /**
     * Increment unread count
     */
    incrementUnreadCount() {
        this.unreadCountValue++;
        this.updateBadge();
    }

    /**
     * Decrement unread count
     */
    decrementUnreadCount() {
        if (this.unreadCountValue > 0) {
            this.unreadCountValue--;
            this.updateBadge();
        }
    }

    /**
     * Start auto-refresh timer
     */
    startAutoRefresh() {
        this.stopAutoRefresh(); // Clear any existing timer
        this.autoRefreshTimer = setInterval(() => {
            this.refresh();
        }, this.autoRefreshIntervalValue);
    }

    /**
     * Stop auto-refresh timer
     */
    stopAutoRefresh() {
        if (this.autoRefreshTimer) {
            clearInterval(this.autoRefreshTimer);
            this.autoRefreshTimer = null;
        }
    }

    /**
     * Send mark as read request to backend
     */
    async sendMarkReadRequest(notificationId) {
        try {
            await fetch(`${this.fetchUrlValue}/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
        } catch (error) {
            console.error('Failed to mark notification as read:', error);
        }
    }

    /**
     * Send mark as unread request to backend
     */
    async sendMarkUnreadRequest(notificationId) {
        try {
            await fetch(`${this.fetchUrlValue}/${notificationId}/unread`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
        } catch (error) {
            console.error('Failed to mark notification as unread:', error);
        }
    }

    /**
     * Send mark all read request to backend
     */
    async sendMarkAllReadRequest() {
        try {
            await fetch(`${this.fetchUrlValue}/read-all`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
        } catch (error) {
            console.error('Failed to mark all notifications as read:', error);
        }
    }

    /**
     * Send clear all request to backend
     */
    async sendClearAllRequest() {
        try {
            await fetch(`${this.fetchUrlValue}/clear-all`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
        } catch (error) {
            console.error('Failed to clear all notifications:', error);
        }
    }

    /**
     * Send delete request to backend
     */
    async sendDeleteRequest(notificationId) {
        try {
            await fetch(`${this.fetchUrlValue}/${notificationId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
        } catch (error) {
            console.error('Failed to delete notification:', error);
        }
    }
}

