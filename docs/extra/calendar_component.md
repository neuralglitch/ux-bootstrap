# Calendar Component

## Overview

The `bs:calendar` component is a full-featured **event calendar** (not a datepicker) for displaying and managing events. It provides multiple view types (month, week, day, list), interactive navigation, and extensive customization options. Built with Symfony UX TwigComponent and enhanced with Stimulus for dynamic behavior.

**Key Features:**
- Multiple view types: Month, Week, Day, and List views
- Interactive navigation with prev/next and "today" buttons
- Event rendering with customizable display
- Async event loading support
- Event and date click handling
- Time grid for week/day views
- Fully configurable display options
- Responsive and accessible
- Bootstrap 5.3 styled

**Use Cases:**
- Team calendars
- Event scheduling
- Meeting planners
- Content calendars
- Availability displays
- Activity timelines

---

## Basic Usage

### Simple Month View Calendar

```twig
<twig:bs:calendar />
```

This renders a calendar with default settings:
- Month view
- Current month displayed
- Navigation enabled
- View switcher enabled

### Calendar with Events

```twig
{% set events = [
    {
        id: '1',
        title: 'Team Meeting',
        start: '2024-01-15T10:00:00',
        end: '2024-01-15T11:00:00',
        color: 'primary',
        description: 'Monthly team sync'
    },
    {
        id: '2',
        title: 'Project Deadline',
        start: '2024-01-20',
        color: 'danger',
        description: 'Q1 deliverables due'
    }
] %}

<twig:bs:calendar :events="events" />
```

### Week View Calendar

```twig
<twig:bs:calendar
    view="week"
    :showTimeGrid="true"
    timeFormat="12h"
    slotMinTime="08:00:00"
    slotMaxTime="18:00:00"
/>
```

### Day View Calendar

```twig
<twig:bs:calendar
    view="day"
    initialDate="2024-01-15"
/>
```

### List View Calendar

```twig
<twig:bs:calendar
    view="list"
    :showViewSwitcher="false"
/>
```

---

## Component Props

### View Configuration

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `view` | `string` | `'month'` | Calendar view: `'month'` \| `'week'` \| `'day'` \| `'list'` |
| `locale` | `string` | `'en'` | Locale for date formatting |
| `showWeekNumbers` | `bool` | `false` | Display week numbers in month view |

### Navigation

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `showNavigation` | `bool` | `true` | Show navigation buttons |
| `showTodayButton` | `bool` | `true` | Show "Today" button |
| `showViewSwitcher` | `bool` | `true` | Show view type switcher buttons |

### Date Configuration

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `initialDate` | `?string` | `null` | Initial date (Y-m-d format), defaults to today |
| `firstDayOfWeek` | `int` | `0` | First day of week: `0`=Sunday, `1`=Monday |

### Event Configuration

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `events` | `array` | `[]` | Array of event objects |
| `eventUrl` | `string` | `'/calendar/events'` | URL for async event loading |
| `loadEventsAsync` | `bool` | `false` | Load events via AJAX |

### Display Options

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `showHeader` | `bool` | `true` | Show calendar header |
| `showWeekends` | `bool` | `true` | Display weekend columns |
| `eventLimit` | `int` | `3` | Max events per day before "+N more" |
| `showTimeGrid` | `bool` | `true` | Show time slots in week/day view |
| `timeFormat` | `string` | `'24h'` | Time format: `'12h'` \| `'24h'` |
| `slotDuration` | `string` | `'00:30:00'` | Duration of time slots |
| `slotMinTime` | `string` | `'00:00:00'` | Start time of day |
| `slotMaxTime` | `string` | `'24:00:00'` | End time of day |

### Event Actions

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `allowEventClick` | `bool` | `true` | Enable event clicking |
| `allowDateClick` | `bool` | `true` | Enable date clicking |
| `eventClickUrl` | `?string` | `null` | URL pattern for event clicks (use `{id}` placeholder) |
| `dateClickUrl` | `?string` | `null` | URL pattern for date clicks (use `{date}` placeholder) |

### Styling

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `height` | `string` | `'auto'` | Calendar height: `'auto'` or specific (e.g., `'600px'`) |
| `headerToolbar` | `string` | `'default'` | Header style: `'default'` \| `'minimal'` \| `'none'` |

### Advanced Options

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `editable` | `bool` | `false` | Allow drag-and-drop (future feature) |
| `selectable` | `bool` | `false` | Allow date range selection |
| `businessHours` | `array` | `[]` | Define business hours |
| `hiddenDays` | `array` | `[]` | Days to hide (0-6) |

### Extensibility

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `class` | `?string` | `null` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

---

## Examples

### 1. Team Calendar with Business Hours

```twig
{% set businessHours = {
    daysOfWeek: [1, 2, 3, 4, 5],
    startTime: '09:00',
    endTime: '17:00'
} %}

<twig:bs:calendar
    view="week"
    :firstDayOfWeek="1"
    :businessHours="businessHours"
    :hiddenDays="[0, 6]"
    slotMinTime="08:00:00"
    slotMaxTime="19:00:00"
    eventUrl="/api/team/events"
    :loadEventsAsync="true"
/>
```

### 2. Event Calendar with Click Handlers

```twig
<twig:bs:calendar
    view="month"
    eventClickUrl="/events/{id}/view"
    dateClickUrl="/events/new?date={date}"
    :showWeekNumbers="true"
/>
```

### 3. Compact Calendar (Minimal UI)

```twig
<twig:bs:calendar
    view="month"
    :showNavigation="false"
    :showViewSwitcher="false"
    height="400px"
    class="shadow-sm"
/>
```

### 4. 12-Hour Time Format Calendar

```twig
<twig:bs:calendar
    view="day"
    timeFormat="12h"
    slotDuration="00:15:00"
    slotMinTime="08:00:00"
    slotMaxTime="20:00:00"
/>
```

### 5. Multi-Language Calendar

```twig
<twig:bs:calendar
    view="month"
    locale="de"
    :firstDayOfWeek="1"
/>
```

### 6. Event List View

```twig
<twig:bs:calendar
    view="list"
    :showNavigation="true"
    :showViewSwitcher="true"
    :events="upcomingEvents"
/>
```

### 7. Fixed Height Scrollable Calendar

```twig
<twig:bs:calendar
    view="week"
    height="600px"
/>
```

### 8. Custom Styled Calendar

```twig
<twig:bs:calendar
    class="border-primary shadow-lg rounded"
    :attr="{
        'data-theme': 'dark',
        'aria-label': 'Company Events Calendar'
    }"
/>
```

### 9. Async Event Loading

```twig
<twig:bs:calendar
    view="month"
    eventUrl="/api/calendar/events?start={start}&end={end}"
    :loadEventsAsync="true"
/>
```

---

## Event Object Format

Events should follow this structure:

```javascript
{
    id: '1',                          // Unique identifier
    title: 'Event Title',             // Event name
    start: '2024-01-15T10:00:00',     // ISO datetime or date string
    end: '2024-01-15T11:00:00',       // Optional end datetime
    color: 'primary',                 // Bootstrap color variant
    description: 'Event details',     // Optional description
    location: 'Conference Room A',    // Optional location
    allDay: false,                    // Optional all-day flag
    url: '/events/1'                  // Optional URL
}
```

### Event Colors

Use Bootstrap color variants:
- `primary` (blue)
- `secondary` (gray)
- `success` (green)
- `danger` (red)
- `warning` (yellow)
- `info` (cyan)
- `light` (light gray)
- `dark` (dark gray)

---

## JavaScript API

The calendar is powered by a Stimulus controller that provides custom events and actions.

### Custom Events

Listen for calendar interactions:

```javascript
// Date click event
document.querySelector('[data-controller="bs-calendar"]')
    .addEventListener('bs-calendar:date-click', (event) => {
        console.log('Date clicked:', event.detail.date);
        console.log('Date object:', event.detail.dateObj);
    });

// Event click (when no URL is configured)
document.querySelector('[data-controller="bs-calendar"]')
    .addEventListener('bs-calendar:event-click', (event) => {
        console.log('Event clicked:', event.detail.eventId);
        console.log('Event data:', event.detail.event);
    });
```

### Programmatic Actions

Control the calendar via Stimulus actions:

```javascript
// Get controller instance
const calendar = application.getControllerForElementAndIdentifier(
    document.querySelector('[data-controller="bs-calendar"]'),
    'bs-calendar'
);

// Navigate
calendar.nextPeriod();
calendar.previousPeriod();
calendar.goToToday();

// Change view
calendar.viewValue = 'week';
calendar.render();
```

---

## Accessibility

The calendar component follows accessibility best practices:

### ARIA Attributes
- Navigation buttons have `aria-label` attributes
- Interactive elements have proper roles
- Modal dialog for event details is keyboard accessible

### Keyboard Navigation
- Tab: Navigate between interactive elements
- Enter/Space: Activate buttons and links
- Escape: Close event modal

### Screen Reader Support
- Meaningful labels for all interactive elements
- Date and event information announced properly
- Loading states communicated

### Focus Management
- Visible focus indicators
- Logical focus order
- Focus trapped in modal when open

---

## Configuration

You can set global defaults in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  calendar:
    view: 'month'
    locale: 'en'
    show_week_numbers: false
    show_navigation: true
    show_today_button: true
    show_view_switcher: true
    first_day_of_week: 1  # Monday
    event_url: '/calendar/events'
    show_weekends: true
    event_limit: 3
    time_format: '24h'
    height: 'auto'
    class: 'shadow-sm'
```

---

## Stimulus Controller

The calendar uses the `bs-calendar` Stimulus controller.

### Targets

- `content`: Main calendar content area
- `title`: Calendar title/period display
- `eventModal`: Event detail modal (optional)
- `eventModalTitle`: Modal title
- `eventModalBody`: Modal body content
- `eventsData`: Hidden script tag with events JSON

### Values

- `view`: Current view type
- `locale`: Locale setting
- `eventUrl`: Event loading URL
- `loadAsync`: Async loading flag
- `firstDay`: First day of week
- `showWeekends`: Weekend display flag
- `eventLimit`: Event display limit
- `timeFormat`: Time format setting
- `editable`: Drag-and-drop enabled
- `selectable`: Date selection enabled
- `initialDate`: Initial date
- `eventClickUrl`: Event click URL pattern
- `dateClickUrl`: Date click URL pattern

### Actions

- `previousPeriod`: Navigate to previous period
- `nextPeriod`: Navigate to next period
- `goToToday`: Go to current date
- `changeView`: Change calendar view
- `handleDateClick`: Handle date clicks
- `handleEventClick`: Handle event clicks

---

## Styling

### Custom CSS Classes

The calendar uses these CSS classes:

```css
.calendar-container       /* Main container */
.calendar-header          /* Header section */
.calendar-nav             /* Navigation buttons */
.calendar-title           /* Period title */
.calendar-view-switcher   /* View buttons */
.calendar-body            /* Content area */
.calendar-month-view      /* Month view table */
.calendar-week-view       /* Week view table */
.calendar-day-view        /* Day view container */
.calendar-list-view       /* List view container */
.calendar-day             /* Individual day cell */
.calendar-day-number      /* Day number */
.calendar-time-slot       /* Time slot cell */
```

### Custom Styling Example

```css
.calendar-container {
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.calendar-day:hover {
    background-color: var(--bs-light);
    cursor: pointer;
}

.calendar-day-number {
    color: var(--bs-primary);
}
```

---

## Server-Side Event Loading

### Controller Example

```php
// src/Controller/CalendarController.php

#[Route('/calendar/events', name: 'calendar_events')]
public function events(Request $request): JsonResponse
{
    $start = $request->query->get('start');
    $end = $request->query->get('end');
    
    $events = $this->eventRepository->findBetween($start, $end);
    
    return $this->json(array_map(function($event) {
        return [
            'id' => (string) $event->getId(),
            'title' => $event->getTitle(),
            'start' => $event->getStartDate()->format('c'),
            'end' => $event->getEndDate()?->format('c'),
            'color' => $event->getColorVariant(),
            'description' => $event->getDescription(),
            'location' => $event->getLocation(),
        ];
    }, $events));
}
```

---

## Testing

The calendar component has comprehensive test coverage. See `tests/Twig/Components/Extra/CalendarTest.php` for examples.

### Running Tests

```bash
# Run calendar tests
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Extra/CalendarTest.php

# Run all tests
bin/php-in-docker vendor/bin/phpunit
```

---

## Related Components

- **[DatePicker](#)**: For date input selection (separate component)
- **[Timeline](/docs/timeline_component.md)**: For chronological event display
- **[List Group](/docs/list_group_component.md)**: For simple event lists

---

## Browser Support

The calendar component works in all modern browsers:
- Chrome/Edge 90+
- Firefox 88+
- Safari 14+
- Opera 76+

---

## References

- [Bootstrap 5.3 Documentation](https://getbootstrap.com/docs/5.3)
- [Symfony UX TwigComponent](https://symfony.com/bundles/ux-twig-component/current/index.html)
- [Stimulus Handbook](https://stimulus.hotwired.dev/)

---

## Migration Notes

### From Other Calendar Libraries

If you're migrating from FullCalendar or similar:

**Event Format**: Adjust your event objects to match the format above
**Views**: Map view names (`dayGridMonth` → `month`, `timeGridWeek` → `week`)
**Options**: Check configuration differences in props table

### Version Compatibility

- Requires Symfony 6.4+ or 7.x
- Requires Bootstrap 5.3+
- Requires PHP 8.2+

