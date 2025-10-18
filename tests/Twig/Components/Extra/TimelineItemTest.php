<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\TimelineItem;
use PHPUnit\Framework\TestCase;

final class TimelineItemTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'timeline_item' => [
                'time_position' => 'inline',
                'variant' => null,
                'state' => null,
                'show_line' => true,
                'marker_size' => null,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new TimelineItem($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('timeline-item', $options['classes']);
        $this->assertStringContainsString('timeline-marker', $options['markerClasses']);
        $this->assertSame('inline', $options['timePosition']);
        $this->assertTrue($options['showLine']);
    }

    public function testTitle(): void
    {
        $component = new TimelineItem($this->config);
        $component->title = 'Event Title';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Event Title', $options['title']);
    }

    public function testDescription(): void
    {
        $component = new TimelineItem($this->config);
        $component->description = 'Event description text';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Event description text', $options['description']);
    }

    public function testTime(): void
    {
        $component = new TimelineItem($this->config);
        $component->time = '2:30 PM';
        $component->mount();
        $options = $component->options();

        $this->assertSame('2:30 PM', $options['time']);
    }

    public function testTimePositionInline(): void
    {
        $component = new TimelineItem($this->config);
        $component->timePosition = 'inline';
        $component->mount();
        $options = $component->options();

        $this->assertSame('inline', $options['timePosition']);
    }

    public function testTimePositionBelow(): void
    {
        $component = new TimelineItem($this->config);
        $component->timePosition = 'below';
        $component->mount();
        $options = $component->options();

        $this->assertSame('below', $options['timePosition']);
    }

    public function testTimePositionOpposite(): void
    {
        $component = new TimelineItem($this->config);
        $component->timePosition = 'opposite';
        $component->mount();
        $options = $component->options();

        $this->assertSame('opposite', $options['timePosition']);
    }

    public function testIcon(): void
    {
        $component = new TimelineItem($this->config);
        $component->icon = '<i class="bi bi-check"></i>';
        $component->mount();
        $options = $component->options();

        $this->assertSame('<i class="bi bi-check"></i>', $options['icon']);
    }

    public function testBadge(): void
    {
        $component = new TimelineItem($this->config);
        $component->badge = '1';
        $component->mount();
        $options = $component->options();

        $this->assertSame('1', $options['badge']);
    }

    public function testVariantPrimary(): void
    {
        $component = new TimelineItem($this->config);
        $component->variant = 'primary';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('timeline-item-primary', $options['classes']);
        $this->assertStringContainsString('bg-primary', $options['markerClasses']);
    }

    public function testVariantSuccess(): void
    {
        $component = new TimelineItem($this->config);
        $component->variant = 'success';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('timeline-item-success', $options['classes']);
        $this->assertStringContainsString('bg-success', $options['markerClasses']);
    }

    public function testVariantDanger(): void
    {
        $component = new TimelineItem($this->config);
        $component->variant = 'danger';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('timeline-item-danger', $options['classes']);
        $this->assertStringContainsString('bg-danger', $options['markerClasses']);
    }

    public function testStatePending(): void
    {
        $component = new TimelineItem($this->config);
        $component->state = 'pending';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('timeline-item-pending', $options['classes']);
        $this->assertStringContainsString('bg-secondary', $options['markerClasses']);
    }

    public function testStateActive(): void
    {
        $component = new TimelineItem($this->config);
        $component->state = 'active';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('timeline-item-active', $options['classes']);
        $this->assertStringContainsString('bg-primary', $options['markerClasses']);
        $this->assertStringContainsString('timeline-marker-pulse', $options['markerClasses']);
    }

    public function testStateCompleted(): void
    {
        $component = new TimelineItem($this->config);
        $component->state = 'completed';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('timeline-item-completed', $options['classes']);
        $this->assertStringContainsString('bg-success', $options['markerClasses']);
    }

    public function testShowLine(): void
    {
        $component = new TimelineItem($this->config);
        $component->showLine = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['showLine']);
    }

    public function testHideLine(): void
    {
        $component = new TimelineItem($this->config);
        $component->showLine = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['showLine']);
    }

    public function testMarkerSizeSmall(): void
    {
        $component = new TimelineItem($this->config);
        $component->markerSize = 'sm';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('timeline-marker-sm', $options['markerClasses']);
    }

    public function testMarkerSizeLarge(): void
    {
        $component = new TimelineItem($this->config);
        $component->markerSize = 'lg';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('timeline-marker-lg', $options['markerClasses']);
    }

    public function testCustomClass(): void
    {
        $component = new TimelineItem($this->config);
        $component->class = 'custom-item extra-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-item', $options['classes']);
        $this->assertStringContainsString('extra-class', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new TimelineItem($this->config);
        $component->attr = [
            'data-test' => 'item',
            'id' => 'timeline-item-1',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('item', $options['attrs']['data-test']);
        $this->assertArrayHasKey('id', $options['attrs']);
        $this->assertSame('timeline-item-1', $options['attrs']['id']);
    }

    public function testCombinedOptions(): void
    {
        $component = new TimelineItem($this->config);
        $component->title = 'Order Shipped';
        $component->description = 'Your order has been shipped';
        $component->time = '2:30 PM';
        $component->timePosition = 'opposite';
        $component->icon = '📦';
        $component->variant = 'success';
        $component->state = 'completed';
        $component->markerSize = 'lg';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Order Shipped', $options['title']);
        $this->assertSame('Your order has been shipped', $options['description']);
        $this->assertSame('2:30 PM', $options['time']);
        $this->assertSame('opposite', $options['timePosition']);
        $this->assertSame('📦', $options['icon']);
        $this->assertSame('success', $options['variant']);
        $this->assertSame('completed', $options['state']);
        $this->assertStringContainsString('timeline-marker-lg', $options['markerClasses']);
    }

    public function testConfigDefaults(): void
    {
        $config = new Config([
            'timeline_item' => [
                'time_position' => 'below',
                'variant' => 'primary',
                'state' => 'active',
                'show_line' => false,
                'marker_size' => 'lg',
                'class' => 'config-item',
                'attr' => ['data-config' => 'test'],
            ],
        ]);

        $component = new TimelineItem($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('below', $component->timePosition);
        $this->assertSame('primary', $component->variant);
        $this->assertSame('active', $component->state);
        $this->assertFalse($component->showLine);
        $this->assertSame('lg', $component->markerSize);
        $this->assertStringContainsString('config-item', $options['classes']);
        $this->assertArrayHasKey('data-config', $options['attrs']);
    }

    public function testGetComponentName(): void
    {
        $component = new TimelineItem($this->config);
        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('timeline_item', $method->invoke($component));
    }

    public function testStateOverridesVariant(): void
    {
        $component = new TimelineItem($this->config);
        $component->variant = 'primary';
        $component->state = 'completed';
        $component->mount();
        $options = $component->options();

        // State should override variant for marker
        $this->assertStringContainsString('bg-success', $options['markerClasses']);
        $this->assertStringNotContainsString('bg-primary', $options['markerClasses']);
    }

    public function testNullValues(): void
    {
        $component = new TimelineItem($this->config);
        $component->title = null;
        $component->description = null;
        $component->time = null;
        $component->icon = null;
        $component->badge = null;
        $component->mount();
        $options = $component->options();

        $this->assertNull($options['title']);
        $this->assertNull($options['description']);
        $this->assertNull($options['time']);
        $this->assertNull($options['icon']);
        $this->assertNull($options['badge']);
    }
}

