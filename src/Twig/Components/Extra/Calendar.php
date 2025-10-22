<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractBootstrap;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:calendar', template: '@NeuralGlitchUxBootstrap/components/extra/calendar.html.twig')]
final class Calendar extends AbstractBootstrap
{
    // View configuration
    public string $view;  // 'month' | 'week' | 'day' | 'list'
    public string $locale;
    public bool $showWeekNumbers;

    // Navigation
    public bool $showNavigation;
    public bool $showTodayButton;
    public bool $showViewSwitcher;

    // Date configuration
    public ?string $initialDate = null;  // Y-m-d format, defaults to today
    public int $firstDayOfWeek;  // 0=Sunday, 1=Monday

    // Event configuration
    /** @var array<string, mixed> */
    public array $events = [];  // Array of event objects
    public string $eventUrl;  // URL for AJAX event loading
    public bool $loadEventsAsync;

    // Display options
    public bool $showHeader;
    public bool $showWeekends;
    public int $eventLimit;  // Max events per day before "+N more"
    public bool $showTimeGrid;  // Show time slots in week/day view
    public string $timeFormat;  // '12h' | '24h'
    public string $slotDuration;  // Duration of time slots
    public string $slotMinTime;  // Start time of day
    public string $slotMaxTime;  // End time of day

    // Event actions
    public bool $allowEventClick;
    public bool $allowDateClick;
    public ?string $eventClickUrl = null;  // URL pattern for event clicks
    public ?string $dateClickUrl = null;   // URL pattern for date clicks

    // Styling
    public string $height;  // 'auto' | specific height like '600px'
    public string $headerToolbar;  // 'default' | 'minimal' | 'none'

    // Advanced
    public bool $editable;  // Allow drag-and-drop
    public bool $selectable;  // Allow date range selection
    /** @var array<string, mixed> */
    public array $businessHours = [];  // Define business hours
    /** @var array<int> */
    public array $hiddenDays = [];  // Days to hide (0-6)

    public function mount(): void
    {
        $d = $this->config->for('calendar');

        // View configuration - use config if not explicitly set by component usage
        if (!isset($this->view)) {
            $this->view = $d['view'] ?? 'month';
        }
        if (!isset($this->locale)) {
            $this->locale = $d['locale'] ?? 'en';
        }
        if (!isset($this->showWeekNumbers)) {
            $this->showWeekNumbers = $d['show_week_numbers'] ?? false;
        }

        // Navigation
        if (!isset($this->showNavigation)) {
            $this->showNavigation = $d['show_navigation'] ?? true;
        }
        if (!isset($this->showTodayButton)) {
            $this->showTodayButton = $d['show_today_button'] ?? true;
        }
        if (!isset($this->showViewSwitcher)) {
            $this->showViewSwitcher = $d['show_view_switcher'] ?? true;
        }

        // Date configuration
        $this->initialDate ??= $d['initial_date'] ?? null;
        if (!isset($this->firstDayOfWeek)) {
            $this->firstDayOfWeek = $d['first_day_of_week'] ?? 0;
        }

        // Event configuration
        if (!isset($this->eventUrl)) {
            $this->eventUrl = $d['event_url'] ?? '/calendar/events';
        }
        if (!isset($this->loadEventsAsync)) {
            $this->loadEventsAsync = $d['load_events_async'] ?? false;
        }

        // Display options
        if (!isset($this->showHeader)) {
            $this->showHeader = $d['show_header'] ?? true;
        }
        if (!isset($this->showWeekends)) {
            $this->showWeekends = $d['show_weekends'] ?? true;
        }
        if (!isset($this->eventLimit)) {
            $this->eventLimit = $d['event_limit'] ?? 3;
        }
        if (!isset($this->showTimeGrid)) {
            $this->showTimeGrid = $d['show_time_grid'] ?? true;
        }
        if (!isset($this->timeFormat)) {
            $this->timeFormat = $d['time_format'] ?? '24h';
        }
        if (!isset($this->slotDuration)) {
            $this->slotDuration = $d['slot_duration'] ?? '00:30:00';
        }
        if (!isset($this->slotMinTime)) {
            $this->slotMinTime = $d['slot_min_time'] ?? '00:00:00';
        }
        if (!isset($this->slotMaxTime)) {
            $this->slotMaxTime = $d['slot_max_time'] ?? '24:00:00';
        }

        // Event actions
        if (!isset($this->allowEventClick)) {
            $this->allowEventClick = $d['allow_event_click'] ?? true;
        }
        if (!isset($this->allowDateClick)) {
            $this->allowDateClick = $d['allow_date_click'] ?? true;
        }
        $this->eventClickUrl ??= $d['event_click_url'] ?? null;
        $this->dateClickUrl ??= $d['date_click_url'] ?? null;

        // Styling
        if (!isset($this->height)) {
            $this->height = $d['height'] ?? 'auto';
        }
        if (!isset($this->headerToolbar)) {
            $this->headerToolbar = $d['header_toolbar'] ?? 'default';
        }

        // Advanced
        if (!isset($this->editable)) {
            $this->editable = $d['editable'] ?? false;
        }
        if (!isset($this->selectable)) {
            $this->selectable = $d['selectable'] ?? false;
        }

        $this->applyClassDefaults($d);

        // Merge attr defaults
        if (isset($d['attr']) && is_array($d['attr'])) {
            $this->attr = array_merge($d['attr'], $this->attr);
        }
    }

    protected function getComponentName(): string
    {
        return 'calendar';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = $this->buildClasses(
            ['calendar-container'],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = $this->mergeAttributes($this->attr, [
            'data-controller' => 'bs-calendar',
            'data-bs-calendar-view-value' => $this->view,
            'data-bs-calendar-locale-value' => $this->locale,
            'data-bs-calendar-event-url-value' => $this->eventUrl,
            'data-bs-calendar-load-async-value' => $this->loadEventsAsync ? 'true' : 'false',
            'data-bs-calendar-first-day-value' => (string)$this->firstDayOfWeek,
            'data-bs-calendar-show-weekends-value' => $this->showWeekends ? 'true' : 'false',
            'data-bs-calendar-event-limit-value' => (string)$this->eventLimit,
            'data-bs-calendar-time-format-value' => $this->timeFormat,
            'data-bs-calendar-editable-value' => $this->editable ? 'true' : 'false',
            'data-bs-calendar-selectable-value' => $this->selectable ? 'true' : 'false',
        ]);

        // Add initial date if set
        if ($this->initialDate !== null) {
            $attrs['data-bs-calendar-initial-date-value'] = $this->initialDate;
        }

        // Add event/date click URLs if set
        if ($this->eventClickUrl !== null) {
            $attrs['data-bs-calendar-event-click-url-value'] = $this->eventClickUrl;
        }
        if ($this->dateClickUrl !== null) {
            $attrs['data-bs-calendar-date-click-url-value'] = $this->dateClickUrl;
        }

        return [
            'view' => $this->view,
            'locale' => $this->locale,
            'showWeekNumbers' => $this->showWeekNumbers,
            'showNavigation' => $this->showNavigation,
            'showTodayButton' => $this->showTodayButton,
            'showViewSwitcher' => $this->showViewSwitcher,
            'initialDate' => $this->initialDate,
            'firstDayOfWeek' => $this->firstDayOfWeek,
            'events' => $this->events,
            'eventUrl' => $this->eventUrl,
            'loadEventsAsync' => $this->loadEventsAsync,
            'showHeader' => $this->showHeader,
            'showWeekends' => $this->showWeekends,
            'eventLimit' => $this->eventLimit,
            'showTimeGrid' => $this->showTimeGrid,
            'timeFormat' => $this->timeFormat,
            'slotDuration' => $this->slotDuration,
            'slotMinTime' => $this->slotMinTime,
            'slotMaxTime' => $this->slotMaxTime,
            'allowEventClick' => $this->allowEventClick,
            'allowDateClick' => $this->allowDateClick,
            'eventClickUrl' => $this->eventClickUrl,
            'dateClickUrl' => $this->dateClickUrl,
            'height' => $this->height,
            'headerToolbar' => $this->headerToolbar,
            'editable' => $this->editable,
            'selectable' => $this->selectable,
            'businessHours' => $this->businessHours,
            'hiddenDays' => $this->hiddenDays,
            'classes' => $classes,
            'attrs' => $attrs,
        ];
    }
}

