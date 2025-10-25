<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:kanban-card', template: '@NeuralGlitchUxBootstrap/components/extra/kanban-card.html.twig')]
final class KanbanCard extends AbstractStimulus
{
    // Content
    public ?string $title = null;
    public ?string $description = null;
    public ?string $label = null; // Fallback if no content provided

    // Identification
    public ?string $id = null;
    public ?string $card_id = null; // Business/data ID for the card

    // Metadata
    public ?string $badge = null; // Badge text (e.g., priority, status)
    public ?string $badge_variant = 'secondary'; // Badge color variant
    public ?string $avatar_src = null; // Assigned user avatar
    public ?string $avatar_alt = null;
    public ?string $footer_text = null; // Due date, timestamp, etc.
    public ?string $icon = null; // Icon HTML in header

    // Styling
    public ?string $variant = null; // null | 'primary' | 'secondary' | 'success' | 'danger' | 'warning' | 'info' | 'light' | 'dark'
    public bool $shadow = true;
    public bool $hover_effect = true;

    // Features
    public bool $clickable = false; // Make entire card clickable
    public ?string $href = null; // Link destination if clickable
    public bool $show_drag_handle = true; // Show drag handle icon

    // State
    public bool $draggable = true; // Can be dragged
    public ?string $priority = null; // 'low' | 'medium' | 'high' | 'urgent'
    public ?string $status = null; // Custom status indicator

    public function mount(): void
    {
        $d = $this->config->for('kanban-card');

        $this->applyStimulusDefaults($d);

        // Apply defaults - config takes precedence over component defaults
        $this->title ??= $this->configString($d, 'title');
        $this->description ??= $this->configString($d, 'description');
        $this->label ??= $this->configString($d, 'label');
        $this->badge ??= $this->configString($d, 'badge');
        $this->badge_variant ??= $this->configString($d, 'badge_variant');
        $this->avatar_src ??= $this->configString($d, 'avatar_src');
        $this->avatar_alt ??= $this->configString($d, 'avatar_alt');
        $this->footer_text ??= $this->configString($d, 'footer_text');
        $this->icon ??= $this->configString($d, 'icon');
        $this->variant ??= $this->configString($d, 'variant');
        $this->shadow = isset($d['shadow']) ? $this->configBoolWithFallback($d, 'shadow', true) : $this->shadow;
        $this->hover_effect = isset($d['hover_effect']) ? $this->configBoolWithFallback($d, 'hover_effect', true) : $this->hover_effect;
        $this->clickable = isset($d['clickable']) ? $this->configBoolWithFallback($d, 'clickable', false) : $this->clickable;
        $this->href ??= $this->configString($d, 'href');
        $this->show_drag_handle = $this->show_drag_handle || $this->configBoolWithFallback($d, 'show_drag_handle', false);
        $this->draggable = $this->draggable || $this->configBoolWithFallback($d, 'draggable', false);
        $this->priority ??= $this->configString($d, 'priority');
        $this->status ??= $this->configString($d, 'status');

        // Generate ID if not provided
        if (!$this->id) {
            $this->id = 'kanban-card-' . uniqid();
        }

        // Auto-detect clickable from href
        if ($this->href !== null && $this->href !== '') {
            $this->clickable = true;
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
        return 'kanban-card';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classArray = $this->class ? array_filter(explode(' ', trim($this->class)), fn($v) => $v !== '') : [];
        /** @var array<string> $classArray */

        $classes = $this->buildClassesFromArrays(
            ['kanban-card', 'card'],
            $this->variant ? ["border-{$this->variant}"] : [],
            $this->shadow ? ['shadow-sm'] : [],
            $this->hover_effect ? ['kanban-card-hover'] : [],
            $this->clickable ? ['kanban-card-clickable', 'cursor-pointer'] : [],
            $this->priority ? ["kanban-card-priority-{$this->priority}"] : [],
            $classArray
        );

        $attrs = $this->mergeAttributes(
            [
                'id' => $this->id,
                'draggable' => $this->draggable ? 'true' : 'false',
                'data-kanban-card' => $this->card_id ?? $this->id,
                'data-kanban-priority' => $this->priority,
            ],
            $this->attr
        );

        // Remove null attributes
        $attrs = array_filter($attrs, fn($value) => $value !== null);

        return [
            'title' => $this->title,
            'description' => $this->description,
            'label' => $this->label,
            'badge' => $this->badge,
            'badge_variant' => $this->badge_variant,
            'avatar_src' => $this->avatar_src,
            'avatar_alt' => $this->avatar_alt,
            'footer_text' => $this->footer_text,
            'icon' => $this->icon,
            'show_drag_handle' => $this->show_drag_handle && $this->draggable,
            'clickable' => $this->clickable,
            'href' => $this->href,
            'priority' => $this->priority,
            'status' => $this->status,
            'card_id' => $this->card_id,
            'classes' => $classes,
            'attrs' => $attrs,
        ];
    }
}

