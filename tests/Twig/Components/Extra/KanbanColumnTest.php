<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\KanbanColumn;
use PHPUnit\Framework\TestCase;

final class KanbanColumnTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'kanban_column' => [
                'title' => 'Column',
                'description' => null,
                'limit' => null,
                'icon' => null,
                'variant' => null,
                'bg' => null,
                'shadow' => false,
                'border' => true,
                'collapsed' => false,
                'collapsible' => false,
                'disabled' => false,
                'show_count' => true,
                'show_add_button' => true,
                'add_button_label' => null,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new KanbanColumn($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('kanban-column', $options['classes']);
        $this->assertSame('Column', $options['title']);
        $this->assertTrue($options['show_count']);
        $this->assertTrue($options['show_add_button']);
    }

    public function testTitleOption(): void
    {
        $component = new KanbanColumn($this->config);
        $component->mount();
        $component->title = 'To Do';
        $options = $component->options();

        $this->assertSame('To Do', $options['title']);
    }

    public function testDescriptionOption(): void
    {
        $component = new KanbanColumn($this->config);
        $component->description = 'Tasks to be started';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Tasks to be started', $options['description']);
    }

    public function testLimitOption(): void
    {
        $component = new KanbanColumn($this->config);
        $component->limit = 5;
        $component->mount();
        $options = $component->options();

        $this->assertSame(5, $options['limit']);
        $this->assertArrayHasKey('data-kanban-limit', $options['attrs']);
    }

    public function testIconOption(): void
    {
        $component = new KanbanColumn($this->config);
        $component->icon = '📋';
        $component->mount();
        $options = $component->options();

        $this->assertSame('📋', $options['icon']);
    }

    public function testVariantOption(): void
    {
        $component = new KanbanColumn($this->config);
        $component->variant = 'primary';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('kanban-column-primary', $options['classes']);
    }

    public function testBackgroundOption(): void
    {
        $component = new KanbanColumn($this->config);
        $component->bg = 'light';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('bg-light', $options['classes']);
    }

    public function testShadowOption(): void
    {
        $component = new KanbanColumn($this->config);
        $component->mount();
        $component->shadow = true;
        $options = $component->options();

        $this->assertStringContainsString('shadow', $options['classes']);
    }

    public function testBorderOption(): void
    {
        $component = new KanbanColumn($this->config);
        $component->border = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('border', $options['classes']);
    }

    public function testCollapsedOption(): void
    {
        $component = new KanbanColumn($this->config);
        $component->mount();
        $component->collapsed = true;
        $options = $component->options();

        $this->assertTrue($options['collapsed']);
        $this->assertStringContainsString('collapsed', $options['classes']);
    }

    public function testCollapsibleOption(): void
    {
        $component = new KanbanColumn($this->config);
        $component->mount();
        $component->collapsible = true;
        $options = $component->options();

        $this->assertTrue($options['collapsible']);
    }

    public function testDisabledOption(): void
    {
        $component = new KanbanColumn($this->config);
        $component->mount();
        $component->disabled = true;
        $options = $component->options();

        $this->assertStringContainsString('disabled', $options['classes']);
    }

    public function testShowCountOption(): void
    {
        $component = new KanbanColumn($this->config);
        $component->mount();
        $component->show_count = false;
        $options = $component->options();

        $this->assertFalse($options['show_count']);
    }

    public function testShowAddButtonOption(): void
    {
        $component = new KanbanColumn($this->config);
        $component->mount();
        $component->show_add_button = false;
        $options = $component->options();

        $this->assertFalse($options['show_add_button']);
    }

    public function testAddButtonLabelOption(): void
    {
        $component = new KanbanColumn($this->config);
        $component->add_button_label = 'New Task';
        $component->mount();
        $options = $component->options();

        $this->assertSame('New Task', $options['add_button_label']);
    }

    public function testIdGeneration(): void
    {
        $component = new KanbanColumn($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('id', $options['attrs']);
        $this->assertStringStartsWith('kanban-col-', $options['attrs']['id']);
    }

    public function testCustomId(): void
    {
        $component = new KanbanColumn($this->config);
        $component->id = 'custom-column-id';
        $component->mount();
        $options = $component->options();

        $this->assertSame('custom-column-id', $options['attrs']['id']);
    }

    public function testColumnKey(): void
    {
        $component = new KanbanColumn($this->config);
        $component->column_key = 'in_progress';
        $component->mount();
        $options = $component->options();

        $this->assertSame('in_progress', $options['attrs']['data-kanban-column']);
    }

    public function testCustomClass(): void
    {
        $component = new KanbanColumn($this->config);
        $component->class = 'custom-column';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-column', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new KanbanColumn($this->config);
        $component->attr = [
            'data-test' => 'value',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('value', $options['attrs']['data-test']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'kanban_column' => [
                'title' => 'Custom Default',
                'variant' => 'success',
                'show_add_button' => false,
                'class' => 'default-class',
            ],
        ]);

        $component = new KanbanColumn($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('Custom Default', $component->title);
        $this->assertStringContainsString('kanban-column-success', $options['classes']);
        $this->assertStringContainsString('default-class', $options['classes']);
    }
}

