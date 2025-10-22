import {Controller} from '@hotwired/stimulus';

/**
 * Calendar Controller
 *
 * Event calendar (not datepicker) with multiple views and event management
 *
 * @example
 * <div data-controller="bs-calendar"
 *      data-bs-calendar-view-value="month"
 *      data-bs-calendar-event-url-value="/calendar/events">
 * </div>
 */
export default class extends Controller {
    static targets = ['content', 'title', 'eventModal', 'eventModalTitle', 'eventModalBody', 'eventsData'];

    static values = {
        view: {type: String, default: 'month'},
        locale: {type: String, default: 'en'},
        eventUrl: {type: String, default: '/calendar/events'},
        loadAsync: {type: Boolean, default: false},
        firstDay: {type: Number, default: 0},
        showWeekends: {type: Boolean, default: true},
        eventLimit: {type: Number, default: 3},
        timeFormat: {type: String, default: '24h'},
        editable: {type: Boolean, default: false},
        selectable: {type: Boolean, default: false},
        initialDate: String,
        eventClickUrl: String,
        dateClickUrl: String
    };

    connect() {
        this.currentDate = this.hasInitialDateValue ? new Date(this.initialDateValue) : new Date();
        this.events = [];
        this.selectedDate = null;
        this.draggedEvent = null;

        // Parse inline events data if present
        if (this.hasEventsDataTarget && !this.loadAsyncValue) {
            try {
                this.events = JSON.parse(this.eventsDataTarget.textContent);
            } catch (e) {
                console.error('Failed to parse events data:', e);
            }
        }

        this.render();

        // Load events asynchronously if enabled
        if (this.loadAsyncValue) {
            this.loadEvents();
        }
    }

    disconnect() {
        // Cleanup if needed
    }

    // Navigation actions
    previousPeriod() {
        switch (this.viewValue) {
            case 'month':
                this.currentDate.setMonth(this.currentDate.getMonth() - 1);
                break;
            case 'week':
                this.currentDate.setDate(this.currentDate.getDate() - 7);
                break;
            case 'day':
                this.currentDate.setDate(this.currentDate.getDate() - 1);
                break;
        }
        this.render();
    }

    nextPeriod() {
        switch (this.viewValue) {
            case 'month':
                this.currentDate.setMonth(this.currentDate.getMonth() + 1);
                break;
            case 'week':
                this.currentDate.setDate(this.currentDate.getDate() + 7);
                break;
            case 'day':
                this.currentDate.setDate(this.currentDate.getDate() + 1);
                break;
        }
        this.render();
    }

    goToToday() {
        this.currentDate = new Date();
        this.render();
    }

    changeView(event) {
        const view = event.params.view || event.currentTarget.dataset.bsCalendarViewParam;
        if (view) {
            this.viewValue = view;
            this.updateViewButtons(view);
            this.render();
        }
    }

    // Rendering methods
    render() {
        this.updateTitle();

        switch (this.viewValue) {
            case 'month':
                this.renderMonthView();
                break;
            case 'week':
                this.renderWeekView();
                break;
            case 'day':
                this.renderDayView();
                break;
            case 'list':
                this.renderListView();
                break;
        }
    }

    updateTitle() {
        if (!this.hasTitleTarget) return;

        const options = {month: 'long', year: 'numeric'};
        let title = '';

        switch (this.viewValue) {
            case 'month':
                title = this.currentDate.toLocaleDateString(this.localeValue, options);
                break;
            case 'week':
                const weekStart = this.getWeekStart(this.currentDate);
                const weekEnd = this.getWeekEnd(this.currentDate);
                title = `${weekStart.toLocaleDateString(this.localeValue, {
                    month: 'short',
                    day: 'numeric'
                })} - ${weekEnd.toLocaleDateString(this.localeValue, {
                    month: 'short',
                    day: 'numeric',
                    year: 'numeric'
                })}`;
                break;
            case 'day':
                title = this.currentDate.toLocaleDateString(this.localeValue, {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                break;
            case 'list':
                title = this.currentDate.toLocaleDateString(this.localeValue, options);
                break;
        }

        this.titleTarget.textContent = title;
    }

    renderMonthView() {
        const year = this.currentDate.getFullYear();
        const month = this.currentDate.getMonth();
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);

        let html = '<table class="table table-bordered mb-0 calendar-month-view" style="table-layout: fixed;">';

        // Header row (weekdays)
        html += '<thead><tr>';
        const weekdays = this.getWeekdayNames();
        weekdays.forEach(day => {
            html += `<th class="text-center p-2 bg-body-secondary">${day}</th>`;
        });
        html += '</tr></thead><tbody>';

        // Calculate starting position
        let startingDayOfWeek = firstDay.getDay() - this.firstDayValue;
        if (startingDayOfWeek < 0) startingDayOfWeek += 7;

        let date = new Date(firstDay);
        date.setDate(date.getDate() - startingDayOfWeek);

        // Generate weeks
        for (let week = 0; week < 6; week++) {
            html += '<tr>';
            let lastDayOfWeek = 0;
            for (let day = 0; day < 7; day++) {
                lastDayOfWeek = day;
                const isCurrentMonth = date.getMonth() === month;
                const isToday = this.isToday(date);
                const dayEvents = this.getEventsForDate(date);

                if (!this.showWeekendsValue && (day === 0 || day === 6)) {
                    date.setDate(date.getDate() + 1);
                    continue;
                }

                const classes = ['calendar-day', 'p-2', 'align-top'];
                if (!isCurrentMonth) classes.push('text-muted', 'bg-light-subtle');
                if (isToday) classes.push('bg-primary-subtle', 'border-primary');

                html += `<td class="${classes.join(' ')}" data-date="${this.formatDate(date)}" data-action="click->bs-calendar#handleDateClick">`;
                html += `<div class="calendar-day-number small fw-bold mb-1">${date.getDate()}</div>`;

                // Render events
                const displayLimit = this.eventLimitValue;
                dayEvents.slice(0, displayLimit).forEach(event => {
                    html += this.renderEventBadge(event);
                });

                if (dayEvents.length > displayLimit) {
                    html += `<div class="badge bg-secondary text-white w-100 mt-1 small">+${dayEvents.length - displayLimit} more</div>`;
                }

                html += '</td>';
                date.setDate(date.getDate() + 1);
            }
            html += '</tr>';

            // Stop if we've passed the last day and filled the row
            if (date.getMonth() !== month && lastDayOfWeek === 6) break;
        }

        html += '</tbody></table>';
        this.contentTarget.innerHTML = html;
    }

    renderWeekView() {
        const weekStart = this.getWeekStart(this.currentDate);
        const weekEnd = this.getWeekEnd(this.currentDate);

        let html = '<table class="table table-bordered mb-0 calendar-week-view">';

        // Header
        html += '<thead><tr><th class="bg-body-secondary p-2" style="width: 80px;">Time</th>';
        const date = new Date(weekStart);
        for (let i = 0; i < 7; i++) {
            if (!this.showWeekendsValue && (date.getDay() === 0 || date.getDay() === 6)) {
                date.setDate(date.getDate() + 1);
                continue;
            }
            const isToday = this.isToday(date);
            html += `<th class="text-center p-2 ${isToday ? 'bg-primary-subtle' : 'bg-body-secondary'}">`;
            html += `<div>${date.toLocaleDateString(this.localeValue, {weekday: 'short'})}</div>`;
            html += `<div class="h5 mb-0">${date.getDate()}</div>`;
            html += '</th>';
            date.setDate(date.getDate() + 1);
        }
        html += '</tr></thead>';

        // Body with time slots
        html += '<tbody>';
        const hours = 24;
        const hourHeight = 60; // pixels per hour
        
        for (let hour = 0; hour < hours; hour++) {
            html += '<tr>';
            html += `<td class="text-center text-muted small p-2 bg-body-secondary" style="height: ${hourHeight}px;">${this.formatHour(hour)}</td>`;

            const slotDate = new Date(weekStart);
            for (let day = 0; day < 7; day++) {
                if (!this.showWeekendsValue && (slotDate.getDay() === 0 || slotDate.getDay() === 6)) {
                    slotDate.setDate(slotDate.getDate() + 1);
                    continue;
                }

                html += `<td class="calendar-time-slot position-relative p-0" style="height: ${hourHeight}px;" data-date="${this.formatDate(slotDate)}" data-hour="${hour}">`;

                // Find events that START in this hour slot
                const slotEvents = this.getEventsStartingInHour(slotDate, hour);
                slotEvents.forEach(event => {
                    html += this.renderWeekEventBlock(event, hourHeight);
                });

                html += '</td>';
                slotDate.setDate(slotDate.getDate() + 1);
            }
            html += '</tr>';
        }
        html += '</tbody></table>';

        this.contentTarget.innerHTML = html;
    }

    renderDayView() {
        let html = '<div class="calendar-day-view">';
        html += `<h4 class="p-3 mb-0 border-bottom">${this.currentDate.toLocaleDateString(this.localeValue, {
            weekday: 'long',
            month: 'long',
            day: 'numeric',
            year: 'numeric'
        })}</h4>`;

        const dayEvents = this.getEventsForDate(this.currentDate);

        if (dayEvents.length === 0) {
            html += '<div class="p-5 text-center text-muted">No events scheduled for this day</div>';
        } else {
            html += '<div class="list-group list-group-flush">';
            dayEvents.forEach(event => {
                html += this.renderEventListItem(event);
            });
            html += '</div>';
        }

        html += '</div>';
        this.contentTarget.innerHTML = html;
    }

    renderListView() {
        const month = this.currentDate.getMonth();
        const year = this.currentDate.getFullYear();
        const monthEvents = this.getEventsForMonth(year, month);

        let html = '<div class="calendar-list-view">';

        if (monthEvents.length === 0) {
            html += '<div class="p-5 text-center text-muted">No events scheduled for this month</div>';
        } else {
            // Group events by date
            const groupedEvents = this.groupEventsByDate(monthEvents);

            html += '<div class="list-group list-group-flush">';
            Object.keys(groupedEvents).sort().forEach(dateKey => {
                const date = new Date(dateKey);
                html += `<div class="list-group-item bg-body-secondary fw-bold">${date.toLocaleDateString(this.localeValue, {
                    weekday: 'long',
                    month: 'long',
                    day: 'numeric'
                })}</div>`;

                groupedEvents[dateKey].forEach(event => {
                    html += this.renderEventListItem(event);
                });
            });
            html += '</div>';
        }

        html += '</div>';
        this.contentTarget.innerHTML = html;
    }

    // Event rendering helpers
    renderEventBadge(event, showTime = false) {
        const color = event.color || event.classNames?.[0]?.replace('bg-', '') || 'primary';
        const time = showTime && event.start ? this.formatEventTime(event.start) : '';
        const duration = this.getEventDuration(event);
        const durationText = duration ? ` (${duration})` : '';
        
        return `<div class="badge bg-${color} text-white w-100 mt-1 small text-truncate" 
                     data-event-id="${event.id || ''}" 
                     data-action="click->bs-calendar#handleEventClick"
                     style="cursor: pointer;">
                  ${time}${time ? ' ' : ''}${event.title || 'Untitled'}${durationText}
                </div>`;
    }
    
    /**
     * Calculate event duration in hours
     */
    getEventDuration(event) {
        if (!event.start || !event.end) return null;
        
        const start = new Date(event.start);
        const end = new Date(event.end);
        const diffMs = end - start;
        const diffHours = Math.round(diffMs / (1000 * 60 * 60) * 10) / 10; // Round to 1 decimal
        
        if (diffHours < 1) {
            const diffMinutes = Math.round(diffMs / (1000 * 60));
            return `${diffMinutes}min`;
        }
        
        return `${diffHours}h`;
    }

    renderEventListItem(event) {
        const color = event.color || 'primary';
        const startTime = event.start ? this.formatEventTime(event.start) : '';
        const endTime = event.end ? this.formatEventTime(event.end) : '';
        const timeRange = startTime && endTime ? `${startTime} - ${endTime}` : startTime;

        return `<div class="list-group-item list-group-item-action" 
                     data-event-id="${event.id || ''}"
                     data-action="click->bs-calendar#handleEventClick"
                     style="cursor: pointer; border-left: 4px solid var(--bs-${color});">
                  <div class="d-flex w-100 justify-content-between">
                    <h6 class="mb-1">${event.title || 'Untitled'}</h6>
                    ${timeRange ? `<small class="text-muted">${timeRange}</small>` : ''}
                  </div>
                  ${event.description ? `<p class="mb-1 small">${event.description}</p>` : ''}
                </div>`;
    }

    // Event handlers
    handleDateClick(event) {
        const dateStr = event.currentTarget.dataset.date;
        if (!dateStr) return;

        this.selectedDate = new Date(dateStr);

        if (this.hasDateClickUrlValue) {
            window.location.href = this.dateClickUrlValue.replace('{date}', dateStr);
        } else {
            // Dispatch custom event
            this.dispatch('dateClick', {detail: {date: dateStr, dateObj: this.selectedDate}});
        }
    }

    handleEventClick(event) {
        event.stopPropagation();
        const eventId = event.currentTarget.dataset.eventId;
        const eventData = this.events.find(e => e.id === eventId);

        if (this.hasEventClickUrlValue) {
            window.location.href = this.eventClickUrlValue.replace('{id}', eventId);
        } else if (this.hasEventModalTarget) {
            this.showEventModal(eventData);
        } else {
            // Dispatch custom event
            this.dispatch('eventClick', {detail: {eventId, event: eventData}});
        }
    }

    showEventModal(event) {
        if (!event) return;

        this.eventModalTitleTarget.textContent = event.title || 'Event Details';

        let body = '';
        if (event.start) {
            body += `<p><strong>Start:</strong> ${new Date(event.start).toLocaleString(this.localeValue)}</p>`;
        }
        if (event.end) {
            body += `<p><strong>End:</strong> ${new Date(event.end).toLocaleString(this.localeValue)}</p>`;
        }
        if (event.description) {
            body += `<p><strong>Description:</strong> ${event.description}</p>`;
        }
        if (event.location) {
            body += `<p><strong>Location:</strong> ${event.location}</p>`;
        }

        this.eventModalBodyTarget.innerHTML = body;

        // Show modal using Bootstrap
        const modal = new bootstrap.Modal(this.eventModalTarget);
        modal.show();
    }

    // Event data methods
    async loadEvents() {
        try {
            const response = await fetch(this.eventUrlValue);
            if (!response.ok) throw new Error('Failed to load events');

            this.events = await response.json();
            this.render();
        } catch (error) {
            console.error('Error loading events:', error);
            this.contentTarget.innerHTML = '<div class="alert alert-danger m-3">Failed to load events</div>';
        }
    }

    getEventsForDate(date) {
        const dateStr = this.formatDate(date);
        return this.events.filter(event => {
            const eventDate = event.start ? this.formatDate(new Date(event.start)) : null;
            return eventDate === dateStr;
        });
    }

    getEventsForDateAndHour(date, hour) {
        const dateStr = this.formatDate(date);
        return this.events.filter(event => {
            if (!event.start) return false;
            const eventDate = new Date(event.start);
            return this.formatDate(eventDate) === dateStr && eventDate.getHours() === hour;
        });
    }
    
    getEventsStartingInHour(date, hour) {
        const dateStr = this.formatDate(date);
        return this.events.filter(event => {
            if (!event.start) return false;
            const eventDate = new Date(event.start);
            return this.formatDate(eventDate) === dateStr && eventDate.getHours() === hour;
        });
    }
    
    /**
     * Render event as a block with height corresponding to duration (for week view)
     */
    renderWeekEventBlock(event, hourHeight) {
        if (!event.start) return '';
        
        const color = event.color || event.classNames?.[0]?.replace('bg-', '') || 'primary';
        const startDate = new Date(event.start);
        const startMinutes = startDate.getMinutes();
        const topOffset = (startMinutes / 60) * hourHeight;
        
        // Calculate height based on duration
        let height = hourHeight; // default 1 hour
        if (event.end) {
            const endDate = new Date(event.end);
            const durationMs = endDate - startDate;
            const durationHours = durationMs / (1000 * 60 * 60);
            height = durationHours * hourHeight;
        }
        
        const startTime = this.formatEventTime(event.start);
        const endTime = event.end ? this.formatEventTime(event.end) : '';
        const duration = this.getEventDuration(event);
        
        return `<div class="calendar-event-block bg-${color} text-white p-1 position-absolute w-100" 
                     data-event-id="${event.id || ''}" 
                     data-action="click->bs-calendar#handleEventClick"
                     style="top: ${topOffset}px; height: ${height}px; cursor: pointer; overflow: hidden; font-size: 0.75rem; line-height: 1.2; border-radius: 3px; border: 1px solid rgba(255,255,255,0.2);">
                  <div class="fw-bold text-truncate">${event.title || 'Untitled'}</div>
                  <div class="small text-truncate opacity-75">${startTime}${endTime ? ' - ' + endTime : ''}</div>
                  ${duration && height > 40 ? `<div class="small opacity-50">${duration}</div>` : ''}
                </div>`;
    }

    getEventsForMonth(year, month) {
        return this.events.filter(event => {
            if (!event.start) return false;
            const eventDate = new Date(event.start);
            return eventDate.getFullYear() === year && eventDate.getMonth() === month;
        });
    }

    groupEventsByDate(events) {
        return events.reduce((groups, event) => {
            const dateKey = this.formatDate(new Date(event.start));
            if (!groups[dateKey]) groups[dateKey] = [];
            groups[dateKey].push(event);
            return groups;
        }, {});
    }

    // Utility methods
    getWeekStart(date) {
        const d = new Date(date);
        const day = d.getDay();
        const diff = (day < this.firstDayValue ? 7 : 0) + day - this.firstDayValue;
        d.setDate(d.getDate() - diff);
        d.setHours(0, 0, 0, 0);
        return d;
    }

    getWeekEnd(date) {
        const d = this.getWeekStart(date);
        d.setDate(d.getDate() + 6);
        d.setHours(23, 59, 59, 999);
        return d;
    }

    getWeekdayNames() {
        const names = [];
        const date = new Date(2024, 0, this.firstDayValue); // Start from configured first day
        for (let i = 0; i < 7; i++) {
            names.push(date.toLocaleDateString(this.localeValue, {weekday: 'short'}));
            date.setDate(date.getDate() + 1);
        }
        return names;
    }

    isToday(date) {
        const today = new Date();
        return date.getDate() === today.getDate() &&
            date.getMonth() === today.getMonth() &&
            date.getFullYear() === today.getFullYear();
    }

    formatDate(date) {
        return date.toISOString().split('T')[0];
    }

    formatHour(hour) {
        if (this.timeFormatValue === '12h') {
            const period = hour >= 12 ? 'PM' : 'AM';
            const displayHour = hour % 12 || 12;
            return `${displayHour} ${period}`;
        }
        return `${hour.toString().padStart(2, '0')}:00`;
    }

    formatEventTime(dateStr) {
        const date = new Date(dateStr);
        return date.toLocaleTimeString(this.localeValue, {
            hour: 'numeric',
            minute: '2-digit',
            hour12: this.timeFormatValue === '12h'
        });
    }

    updateViewButtons(activeView) {
        this.element.querySelectorAll('.calendar-view-switcher button').forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.bsCalendarViewParam === activeView) {
                btn.classList.add('active');
            }
        });
    }
}

