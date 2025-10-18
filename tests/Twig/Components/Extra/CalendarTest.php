<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\Calendar;
use PHPUnit\Framework\TestCase;

final class CalendarTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'calendar' => [
                'view' => 'month',
                'locale' => 'en',
                'show_week_numbers' => false,
                'show_navigation' => true,
                'show_today_button' => true,
                'show_view_switcher' => true,
                'initial_date' => null,
                'first_day_of_week' => 0,
                'event_url' => '/calendar/events',
                'load_events_async' => false,
                'show_header' => true,
                'show_weekends' => true,
                'event_limit' => 3,
                'show_time_grid' => true,
                'time_format' => '24h',
                'slot_duration' => '00:30:00',
                'slot_min_time' => '00:00:00',
                'slot_max_time' => '24:00:00',
                'allow_event_click' => true,
                'allow_date_click' => true,
                'event_click_url' => null,
                'date_click_url' => null,
                'height' => 'auto',
                'header_toolbar' => 'default',
                'editable' => false,
                'selectable' => false,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new Calendar($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('month', $options['view']);
        $this->assertSame('en', $options['locale']);
        $this->assertFalse($options['showWeekNumbers']);
        $this->assertTrue($options['showNavigation']);
        $this->assertTrue($options['showTodayButton']);
        $this->assertTrue($options['showViewSwitcher']);
        $this->assertStringContainsString('calendar-container', $options['classes']);
    }

    public function testViewOption(): void
    {
        $component = new Calendar($this->config);
        $component->view = 'week';
        $component->mount();
        $options = $component->options();

        $this->assertSame('week', $options['view']);
        $this->assertSame('week', $options['attrs']['data-bs-calendar-view-value']);
    }

    public function testDayViewOption(): void
    {
        $component = new Calendar($this->config);
        $component->view = 'day';
        $component->mount();
        $options = $component->options();

        $this->assertSame('day', $options['view']);
    }

    public function testListViewOption(): void
    {
        $component = new Calendar($this->config);
        $component->view = 'list';
        $component->mount();
        $options = $component->options();

        $this->assertSame('list', $options['view']);
    }

    public function testLocaleOption(): void
    {
        $component = new Calendar($this->config);
        $component->locale = 'de';
        $component->mount();
        $options = $component->options();

        $this->assertSame('de', $options['locale']);
        $this->assertSame('de', $options['attrs']['data-bs-calendar-locale-value']);
    }

    public function testShowWeekNumbers(): void
    {
        $component = new Calendar($this->config);
        $component->showWeekNumbers = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['showWeekNumbers']);
    }

    public function testNavigationOptions(): void
    {
        $component = new Calendar($this->config);
        $component->showNavigation = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['showNavigation']);
    }

    public function testTodayButtonOption(): void
    {
        $component = new Calendar($this->config);
        $component->showTodayButton = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['showTodayButton']);
    }

    public function testViewSwitcherOption(): void
    {
        $component = new Calendar($this->config);
        $component->showViewSwitcher = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['showViewSwitcher']);
    }

    public function testInitialDateOption(): void
    {
        $component = new Calendar($this->config);
        $component->initialDate = '2024-12-25';
        $component->mount();
        $options = $component->options();

        $this->assertSame('2024-12-25', $options['initialDate']);
        $this->assertArrayHasKey('data-bs-calendar-initial-date-value', $options['attrs']);
        $this->assertSame('2024-12-25', $options['attrs']['data-bs-calendar-initial-date-value']);
    }

    public function testFirstDayOfWeekOption(): void
    {
        $component = new Calendar($this->config);
        $component->firstDayOfWeek = 1; // Monday
        $component->mount();
        $options = $component->options();

        $this->assertSame(1, $options['firstDayOfWeek']);
        $this->assertSame('1', $options['attrs']['data-bs-calendar-first-day-value']);
    }

    public function testEventsOption(): void
    {
        $events = [
            ['id' => '1', 'title' => 'Event 1', 'start' => '2024-01-15'],
            ['id' => '2', 'title' => 'Event 2', 'start' => '2024-01-20'],
        ];

        $component = new Calendar($this->config);
        $component->events = $events;
        $component->mount();
        $options = $component->options();

        $this->assertCount(2, $options['events']);
        $this->assertSame('Event 1', $options['events'][0]['title']);
    }

    public function testEventUrlOption(): void
    {
        $component = new Calendar($this->config);
        $component->eventUrl = '/api/events';
        $component->mount();
        $options = $component->options();

        $this->assertSame('/api/events', $options['eventUrl']);
        $this->assertSame('/api/events', $options['attrs']['data-bs-calendar-event-url-value']);
    }

    public function testLoadEventsAsyncOption(): void
    {
        $component = new Calendar($this->config);
        $component->loadEventsAsync = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['loadEventsAsync']);
        $this->assertSame('true', $options['attrs']['data-bs-calendar-load-async-value']);
    }

    public function testShowHeaderOption(): void
    {
        $component = new Calendar($this->config);
        $component->showHeader = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['showHeader']);
    }

    public function testShowWeekendsOption(): void
    {
        $component = new Calendar($this->config);
        $component->showWeekends = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['showWeekends']);
        $this->assertSame('false', $options['attrs']['data-bs-calendar-show-weekends-value']);
    }

    public function testEventLimitOption(): void
    {
        $component = new Calendar($this->config);
        $component->eventLimit = 5;
        $component->mount();
        $options = $component->options();

        $this->assertSame(5, $options['eventLimit']);
        $this->assertSame('5', $options['attrs']['data-bs-calendar-event-limit-value']);
    }

    public function testShowTimeGridOption(): void
    {
        $component = new Calendar($this->config);
        $component->showTimeGrid = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['showTimeGrid']);
    }

    public function testTimeFormatOption(): void
    {
        $component = new Calendar($this->config);
        $component->timeFormat = '12h';
        $component->mount();
        $options = $component->options();

        $this->assertSame('12h', $options['timeFormat']);
        $this->assertSame('12h', $options['attrs']['data-bs-calendar-time-format-value']);
    }

    public function testSlotDurationOption(): void
    {
        $component = new Calendar($this->config);
        $component->slotDuration = '00:15:00';
        $component->mount();
        $options = $component->options();

        $this->assertSame('00:15:00', $options['slotDuration']);
    }

    public function testSlotTimeRangeOptions(): void
    {
        $component = new Calendar($this->config);
        $component->slotMinTime = '08:00:00';
        $component->slotMaxTime = '18:00:00';
        $component->mount();
        $options = $component->options();

        $this->assertSame('08:00:00', $options['slotMinTime']);
        $this->assertSame('18:00:00', $options['slotMaxTime']);
    }

    public function testAllowEventClickOption(): void
    {
        $component = new Calendar($this->config);
        $component->allowEventClick = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['allowEventClick']);
    }

    public function testAllowDateClickOption(): void
    {
        $component = new Calendar($this->config);
        $component->allowDateClick = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['allowDateClick']);
    }

    public function testEventClickUrlOption(): void
    {
        $component = new Calendar($this->config);
        $component->eventClickUrl = '/events/{id}';
        $component->mount();
        $options = $component->options();

        $this->assertSame('/events/{id}', $options['eventClickUrl']);
        $this->assertArrayHasKey('data-bs-calendar-event-click-url-value', $options['attrs']);
    }

    public function testDateClickUrlOption(): void
    {
        $component = new Calendar($this->config);
        $component->dateClickUrl = '/events/new?date={date}';
        $component->mount();
        $options = $component->options();

        $this->assertSame('/events/new?date={date}', $options['dateClickUrl']);
        $this->assertArrayHasKey('data-bs-calendar-date-click-url-value', $options['attrs']);
    }

    public function testHeightOption(): void
    {
        $component = new Calendar($this->config);
        $component->height = '600px';
        $component->mount();
        $options = $component->options();

        $this->assertSame('600px', $options['height']);
    }

    public function testHeaderToolbarOption(): void
    {
        $component = new Calendar($this->config);
        $component->headerToolbar = 'minimal';
        $component->mount();
        $options = $component->options();

        $this->assertSame('minimal', $options['headerToolbar']);
    }

    public function testEditableOption(): void
    {
        $component = new Calendar($this->config);
        $component->editable = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['editable']);
        $this->assertSame('true', $options['attrs']['data-bs-calendar-editable-value']);
    }

    public function testSelectableOption(): void
    {
        $component = new Calendar($this->config);
        $component->selectable = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['selectable']);
        $this->assertSame('true', $options['attrs']['data-bs-calendar-selectable-value']);
    }

    public function testBusinessHoursOption(): void
    {
        $businessHours = [
            'daysOfWeek' => [1, 2, 3, 4, 5],
            'startTime' => '09:00',
            'endTime' => '17:00',
        ];

        $component = new Calendar($this->config);
        $component->businessHours = $businessHours;
        $component->mount();
        $options = $component->options();

        $this->assertSame($businessHours, $options['businessHours']);
    }

    public function testHiddenDaysOption(): void
    {
        $component = new Calendar($this->config);
        $component->hiddenDays = [0, 6]; // Hide Sunday and Saturday
        $component->mount();
        $options = $component->options();

        $this->assertSame([0, 6], $options['hiddenDays']);
    }

    public function testCustomClasses(): void
    {
        $component = new Calendar($this->config);
        $component->class = 'custom-calendar my-calendar';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-calendar', $options['classes']);
        $this->assertStringContainsString('my-calendar', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new Calendar($this->config);
        $component->attr = [
            'data-test' => 'calendar',
            'aria-label' => 'Event Calendar',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('calendar', $options['attrs']['data-test']);
        $this->assertArrayHasKey('aria-label', $options['attrs']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'calendar' => [
                'view' => 'week',
                'locale' => 'fr',
                'first_day_of_week' => 1,
                'class' => 'default-calendar',
            ],
        ]);

        $component = new Calendar($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('week', $component->view);
        $this->assertSame('fr', $component->locale);
        $this->assertSame(1, $component->firstDayOfWeek);
        $this->assertStringContainsString('default-calendar', $options['classes']);
    }

    public function testStimulusControllerAttribute(): void
    {
        $component = new Calendar($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-controller', $options['attrs']);
        $this->assertSame('bs-calendar', $options['attrs']['data-controller']);
    }

    public function testCombinedOptions(): void
    {
        $component = new Calendar($this->config);
        $component->view = 'week';
        $component->locale = 'de';
        $component->showWeekNumbers = true;
        $component->firstDayOfWeek = 1;
        $component->eventLimit = 5;
        $component->timeFormat = '12h';
        $component->editable = true;
        $component->selectable = true;
        $component->mount();
        $options = $component->options();

        $this->assertSame('week', $options['view']);
        $this->assertSame('de', $options['locale']);
        $this->assertTrue($options['showWeekNumbers']);
        $this->assertSame(1, $options['firstDayOfWeek']);
        $this->assertSame(5, $options['eventLimit']);
        $this->assertSame('12h', $options['timeFormat']);
        $this->assertTrue($options['editable']);
        $this->assertTrue($options['selectable']);
    }

    public function testGetComponentName(): void
    {
        $component = new Calendar($this->config);
        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('calendar', $method->invoke($component));
    }
}

