<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:kanban-column', template: '@NeuralGlitchUxBootstrap/components/extra/kanban-column.html.twig')]
final class KanbanColumn extends AbstractStimulus
{
    // Content
    public string $title = 'Column';
    public ?string $description = null;
    public ?int $limit = null; // Maximum number of cards (WIP limit)
    public ?string $icon = null; // Icon HTML (emoji or SVG)

    // Styling
    public ?string $variant = null; // null | 'primary' | 'secondary' | 'success' | 'danger' | 'warning' | 'info' | 'light' | 'dark'
    public ?string $bg = null; // Background color for column
    public bool $shadow = false;
    public bool $border = true;

    // State
    public bool $collapsed = false; // Collapsed state
    public bool $collapsible = false; // Allow collapsing
    public bool $disabled = false; // Disable dropping

    // Features
    public bool $show_count = true; // Show card count in header
    public bool $show_add_button = true; // Show "Add card" button
    public ?string $add_button_label = null; // Custom label for add button

    // Identification
    public ?string $id = null;
    public ?string $column_key = null; // Unique identifier for this column (e.g., 'todo', 'in_progress', 'done')

    public function mount(): void
    {
        $d = $this->config->for('kanban-column');

        $this->applyStimulusDefaults($d);

        // Apply defaults - config takes precedence over component defaults
        $this->title = $this->configStringWithFallback($d, 'title', $this->title);
        $this->description ??= $this->configString($d, 'description');
        $this->limit ??= $this->configInt($d, 'limit');
        $this->icon ??= $this->configString($d, 'icon');
        $this->variant ??= $this->configString($d, 'variant');
        $this->bg ??= $this->configString($d, 'bg');
        $this->shadow = $this->shadow || $this->configBoolWithFallback($d, 'shadow', false);
        $this->border = $this->border || $this->configBoolWithFallback($d, 'border', false);
        $this->collapsed = $this->collapsed || $this->configBoolWithFallback($d, 'collapsed', false);
        $this->collapsible = $this->collapsible || $this->configBoolWithFallback($d, 'collapsible', false);
        $this->disabled = $this->disabled || $this->configBoolWithFallback($d, 'disabled', false);
        $this->show_count = $this->show_count || $this->configBoolWithFallback($d, 'show_count', false);
        $this->show_add_button = $this->show_add_button || $this->configBoolWithFallback($d, 'show_add_button', false);
        $this->add_button_label ??= $this->configString($d, 'add_button_label');

        // Generate ID if not provided
        if (!$this->id) {
            $this->id = 'kanban-col-' . uniqid();
        }

        $this->applyClassDefaults($d);

        // Merge attr defaults
        if (isset($d['attr']) && is_array($d['attr'])) {
            $this->attr = array_merge($d['attr'], $this->attr);
        }

        // Initialize controller with default
        $this->initializeController();
    }

    protected function getComponentName(): string
    {
        return 'kanban-column';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classArray = $this->class ? array_filter(explode(' ', trim($this->class)), fn($v) => $v !== '') : [];
        /** @var array<string> $classArray */

        $classes = $this->buildClassesFromArrays(
            ['kanban-column'],
            $this->variant ? ["kanban-column-{$this->variant}"] : [],
            $this->bg ? ["bg-{$this->bg}"] : [],
            $this->shadow ? ['shadow'] : [],
            $this->border ? ['border'] : [],
            $this->collapsed ? ['collapsed'] : [],
            $this->disabled ? ['disabled'] : [],
            $classArray
        );

        $attrs = $this->mergeAttributes(
            [
                'id' => $this->id,
                'data-kanban-column' => $this->column_key ?? $this->id,
                'data-kanban-limit' => $this->limit,
            ],
            $this->attr
        );

        // Remove null attributes
        $attrs = array_filter($attrs, fn($value) => $value !== null);

        return [
            'title' => $this->title,
            'description' => $this->description,
            'icon' => $this->icon,
            'variant' => $this->variant,
            'limit' => $this->limit,
            'collapsible' => $this->collapsible,
            'collapsed' => $this->collapsed,
            'show_count' => $this->show_count,
            'show_add_button' => $this->show_add_button,
            'add_button_label' => $this->add_button_label ?? 'Add card',
            'classes' => $classes,
            'attrs' => $attrs,
        ];
    }
}

