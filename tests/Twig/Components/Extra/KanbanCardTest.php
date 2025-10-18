<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\KanbanCard;
use PHPUnit\Framework\TestCase;

final class KanbanCardTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'kanban_card' => [
                'title' => null,
                'description' => null,
                'label' => null,
                'badge' => null,
                'badge_variant' => 'secondary',
                'avatar_src' => null,
                'avatar_alt' => null,
                'footer_text' => null,
                'icon' => null,
                'variant' => null,
                'shadow' => true,
                'hover_effect' => true,
                'clickable' => false,
                'href' => null,
                'show_drag_handle' => true,
                'draggable' => true,
                'priority' => null,
                'status' => null,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new KanbanCard($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('kanban-card', $options['classes']);
        $this->assertStringContainsString('card', $options['classes']);
        $this->assertTrue($options['show_drag_handle']);
    }

    public function testTitleOption(): void
    {
        $component = new KanbanCard($this->config);
        $component->title = 'Task Title';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Task Title', $options['title']);
    }

    public function testDescriptionOption(): void
    {
        $component = new KanbanCard($this->config);
        $component->description = 'Task description';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Task description', $options['description']);
    }

    public function testLabelOption(): void
    {
        $component = new KanbanCard($this->config);
        $component->label = 'Simple label';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Simple label', $options['label']);
    }

    public function testBadgeOption(): void
    {
        $component = new KanbanCard($this->config);
        $component->mount();
        $component->badge = 'High Priority';
        $component->badge_variant = 'danger';
        $options = $component->options();

        $this->assertSame('High Priority', $options['badge']);
        $this->assertSame('danger', $options['badge_variant']);
    }

    public function testAvatarOption(): void
    {
        $component = new KanbanCard($this->config);
        $component->avatar_src = '/avatar.jpg';
        $component->avatar_alt = 'John Doe';
        $component->mount();
        $options = $component->options();

        $this->assertSame('/avatar.jpg', $options['avatar_src']);
        $this->assertSame('John Doe', $options['avatar_alt']);
    }

    public function testFooterTextOption(): void
    {
        $component = new KanbanCard($this->config);
        $component->footer_text = 'Due: Tomorrow';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Due: Tomorrow', $options['footer_text']);
    }

    public function testIconOption(): void
    {
        $component = new KanbanCard($this->config);
        $component->icon = '🔥';
        $component->mount();
        $options = $component->options();

        $this->assertSame('🔥', $options['icon']);
    }

    public function testVariantOption(): void
    {
        $component = new KanbanCard($this->config);
        $component->variant = 'success';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('border-success', $options['classes']);
    }

    public function testShadowOption(): void
    {
        $component = new KanbanCard($this->config);
        $component->shadow = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('shadow-sm', $options['classes']);
    }

    public function testHoverEffectOption(): void
    {
        $component = new KanbanCard($this->config);
        $component->hover_effect = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('kanban-card-hover', $options['classes']);
    }

    public function testClickableOption(): void
    {
        $component = new KanbanCard($this->config);
        $component->mount();
        $component->clickable = true;
        $options = $component->options();

        $this->assertTrue($options['clickable']);
        $this->assertStringContainsString('kanban-card-clickable', $options['classes']);
        $this->assertStringContainsString('cursor-pointer', $options['classes']);
    }

    public function testHrefAutoClickable(): void
    {
        $component = new KanbanCard($this->config);
        $component->href = '/task/123';
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['clickable']);
        $this->assertSame('/task/123', $options['href']);
    }

    public function testShowDragHandleOption(): void
    {
        $component = new KanbanCard($this->config);
        $component->mount();
        $component->show_drag_handle = false;
        $options = $component->options();

        $this->assertFalse($options['show_drag_handle']);
    }

    public function testDraggableOption(): void
    {
        $component = new KanbanCard($this->config);
        $component->mount();
        $component->draggable = true;
        $options = $component->options();

        $this->assertSame('true', $options['attrs']['draggable']);
    }

    public function testDraggableDisabled(): void
    {
        $component = new KanbanCard($this->config);
        $component->mount();
        $component->draggable = false;
        $options = $component->options();

        $this->assertSame('false', $options['attrs']['draggable']);
        $this->assertFalse($options['show_drag_handle']);
    }

    public function testPriorityOption(): void
    {
        $component = new KanbanCard($this->config);
        $component->priority = 'urgent';
        $component->mount();
        $options = $component->options();

        $this->assertSame('urgent', $options['priority']);
        $this->assertStringContainsString('kanban-card-priority-urgent', $options['classes']);
    }

    public function testPriorityHigh(): void
    {
        $component = new KanbanCard($this->config);
        $component->priority = 'high';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('kanban-card-priority-high', $options['classes']);
    }

    public function testPriorityMedium(): void
    {
        $component = new KanbanCard($this->config);
        $component->priority = 'medium';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('kanban-card-priority-medium', $options['classes']);
    }

    public function testPriorityLow(): void
    {
        $component = new KanbanCard($this->config);
        $component->priority = 'low';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('kanban-card-priority-low', $options['classes']);
    }

    public function testIdGeneration(): void
    {
        $component = new KanbanCard($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('id', $options['attrs']);
        $this->assertStringStartsWith('kanban-card-', $options['attrs']['id']);
    }

    public function testCustomId(): void
    {
        $component = new KanbanCard($this->config);
        $component->id = 'custom-card-id';
        $component->mount();
        $options = $component->options();

        $this->assertSame('custom-card-id', $options['attrs']['id']);
    }

    public function testCardId(): void
    {
        $component = new KanbanCard($this->config);
        $component->card_id = 'task-123';
        $component->mount();
        $options = $component->options();

        $this->assertSame('task-123', $options['attrs']['data-kanban-card']);
    }

    public function testCustomClass(): void
    {
        $component = new KanbanCard($this->config);
        $component->class = 'custom-card';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-card', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new KanbanCard($this->config);
        $component->attr = [
            'data-test' => 'value',
            'aria-label' => 'Task Card',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('value', $options['attrs']['data-test']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'kanban_card' => [
                'shadow' => false,
                'hover_effect' => false,
                'badge_variant' => 'primary',
                'class' => 'default-class',
            ],
        ]);

        $component = new KanbanCard($config);
        $component->mount();
        $options = $component->options();

        $this->assertFalse($component->shadow);
        $this->assertFalse($component->hover_effect);
        $this->assertStringContainsString('default-class', $options['classes']);
    }
}

