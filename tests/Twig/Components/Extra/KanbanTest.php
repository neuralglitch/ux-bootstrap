<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\Kanban;
use PHPUnit\Framework\TestCase;

final class KanbanTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'kanban' => [
                'variant' => 'horizontal',
                'scrollable' => true,
                'height' => null,
                'draggable' => true,
                'allow_cross_column' => true,
                'drop_zone_class' => null,
                'container' => 'container-fluid',
                'responsive' => true,
                'mobile_breakpoint' => 'md',
                'card_wrapper' => false,
                'gap' => '3',
                'show_column_count' => true,
                'compact_mode' => false,
                'controller' => 'bs-kanban',
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new Kanban($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('kanban-board', $options['classes']);
        $this->assertSame('horizontal', $options['variant']);
        $this->assertSame('container-fluid', $options['container']);
        $this->assertFalse($options['card_wrapper']);
    }

    public function testVariantOption(): void
    {
        $component = new Kanban($this->config);
        $component->mount();
        $component->variant = 'compact';
        $options = $component->options();

        $this->assertSame('compact', $options['variant']);
        $this->assertStringContainsString('kanban-compact', $options['classes']);
    }

    public function testScrollableOption(): void
    {
        $component = new Kanban($this->config);
        $component->mount();
        $component->scrollable = true;
        $options = $component->options();

        $this->assertStringContainsString('kanban-scrollable', $options['classes']);
    }

    public function testHeightOption(): void
    {
        $component = new Kanban($this->config);
        $component->mount();
        $component->height = '600px';
        $options = $component->options();

        $this->assertSame('600px', $options['height']);
    }

    public function testDraggableOption(): void
    {
        $component = new Kanban($this->config);
        $component->mount();
        $component->draggable = true;
        $options = $component->options();

        $this->assertArrayHasKey('attrs', $options);
        $this->assertArrayHasKey('data-controller', $options['attrs']);
    }

    public function testDraggableDisabled(): void
    {
        $component = new Kanban($this->config);
        $component->mount();
        $component->draggable = false;
        $options = $component->options();

        $this->assertArrayHasKey('attrs', $options);
        $this->assertArrayHasKey('data-controller', $options['attrs']);
    }

    public function testAllowCrossColumn(): void
    {
        $component = new Kanban($this->config);
        $component->mount();
        $component->allow_cross_column = true;
        $options = $component->options();

        $this->assertArrayHasKey('attrs', $options);
        $this->assertArrayHasKey('data-controller', $options['attrs']);
    }

    public function testContainerOption(): void
    {
        $component = new Kanban($this->config);
        $component->mount();
        $component->container = 'container';
        $options = $component->options();

        $this->assertSame('container', $options['container']);
    }

    public function testResponsiveOption(): void
    {
        $component = new Kanban($this->config);
        $component->mount();
        $component->responsive = true;
        $component->mobile_breakpoint = 'lg';
        $options = $component->options();

        $this->assertStringContainsString('kanban-responsive-lg', $options['classes']);
    }

    public function testCardWrapperOption(): void
    {
        $component = new Kanban($this->config);
        $component->mount();
        $component->card_wrapper = true;
        $options = $component->options();

        $this->assertTrue($options['card_wrapper']);
    }

    public function testGapOption(): void
    {
        $component = new Kanban($this->config);
        $component->mount();
        $component->gap = '5';
        $options = $component->options();

        $this->assertSame('5', $options['gap']);
    }

    public function testCompactModeOption(): void
    {
        $component = new Kanban($this->config);
        $component->mount();
        $component->compact_mode = true;
        $options = $component->options();

        $this->assertStringContainsString('kanban-cards-compact', $options['classes']);
    }

    public function testStimulusController(): void
    {
        $component = new Kanban($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('bs-kanban', $options['attrs']['data-controller']);
    }

    public function testCustomClass(): void
    {
        $component = new Kanban($this->config);
        $component->mount();
        $component->class = 'custom-kanban';
        $options = $component->options();

        $this->assertStringContainsString('custom-kanban', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new Kanban($this->config);
        $component->mount();
        $component->attr = [
            'data-test' => 'value',
            'aria-label' => 'Kanban Board',
        ];
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('value', $options['attrs']['data-test']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'kanban' => [
                'variant' => 'vertical',
                'scrollable' => true,
                'height' => null,
                'draggable' => true,
                'allow_cross_column' => true,
                'drop_zone_class' => null,
                'container' => 'container',
                'responsive' => true,
                'mobile_breakpoint' => 'md',
                'card_wrapper' => false,
                'gap' => '4',
                'show_column_count' => true,
                'compact_mode' => false,
                'controller' => 'bs-kanban',
                'class' => 'default-class',
                'attr' => [],
            ],
        ]);

        $component = new Kanban($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('vertical', $component->variant);
        $this->assertSame('container', $component->container);
        $this->assertSame('4', $component->gap);
        $this->assertStringContainsString('default-class', $options['classes']);
    }
}

