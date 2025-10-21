<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:timeline-item', template: '@NeuralGlitchUxBootstrap/components/extra/timeline-item.html.twig')]
final class TimelineItem extends AbstractStimulus
{
    /**
     * Title/heading for the timeline item
     */
    public ?string $title = null;

    /**
     * Description/content for the timeline item (used as fallback if no content block)
     */
    public ?string $description = null;

    /**
     * Time/date label
     */
    public ?string $time = null;

    /**
     * Position of the time label
     * - inline: Next to the title
     * - below: Below the title
     * - opposite: On the opposite side of the timeline
     */
    public ?string $timePosition = null;

    /**
     * Icon HTML or class (e.g., '<i class="bi bi-check"></i>' or emoji)
     */
    public ?string $icon = null;

    /**
     * Badge text (alternative to icon)
     */
    public ?string $badge = null;

    /**
     * Variant/color for the marker (badge or icon background)
     * null | 'primary' | 'secondary' | 'success' | 'danger' | 'warning' | 'info' | 'light' | 'dark'
     */
    public ?string $variant = null;

    /**
     * State of the timeline item
     * - pending: Not yet completed (gray/muted)
     * - active: Currently active (highlighted)
     * - completed: Completed (success color)
     */
    public ?string $state = null;

    /**
     * Show connecting line to next item
     */
    public ?bool $showLine = null;

    /**
     * Custom marker size
     * - sm: Small marker
     * - null: Default size
     * - lg: Large marker
     */
    public ?string $markerSize = null;

    public function mount(): void
    {
        $d = $this->config->for('timeline_item');

        $this->applyStimulusDefaults($d);

        // Apply defaults from config
        $this->timePosition = $this->timePosition ?? ($d['time_position'] ?? 'inline');
        $this->variant = $this->variant ?? ($d['variant'] ?? null);
        $this->state = $this->state ?? ($d['state'] ?? null);
        $this->showLine = $this->showLine ?? ($d['show_line'] ?? true);
        $this->markerSize = $this->markerSize ?? ($d['marker_size'] ?? null);

        $this->applyClassDefaults($d);

        // Merge attr defaults
        if (isset($d['attr']) && is_array($d['attr'])) {
            $this->attr = array_merge($d['attr'], $this->attr);

        
        // Initialize controller with default
        $this->initializeController();
    }
    }

    protected function getComponentName(): string
    {
        return 'timeline_item';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = $this->buildClasses(
            ['timeline-item'],
            $this->state ? ["timeline-item-{$this->state}"] : [],
            $this->variant ? ["timeline-item-{$this->variant}"] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $markerClasses = $this->buildClasses(
            ['timeline-marker'],
            $this->variant && !$this->state ? ["bg-{$this->variant}"] : [],
            $this->state === 'completed' ? ['bg-success'] : [],
            $this->state === 'pending' ? ['bg-secondary'] : [],
            $this->state === 'active' ? ['bg-primary', 'timeline-marker-pulse'] : [],
            $this->markerSize ? ["timeline-marker-{$this->markerSize}"] : []
        );

        $attrs = $this->mergeAttributes([], $this->attr);

        return [
            'title' => $this->title,
            'description' => $this->description,
            'time' => $this->time,
            'timePosition' => $this->timePosition,
            'icon' => $this->icon,
            'badge' => $this->badge,
            'variant' => $this->variant,
            'state' => $this->state,
            'showLine' => $this->showLine,
            'markerSize' => $this->markerSize,
            'classes' => $classes,
            'markerClasses' => $markerClasses,
            'attrs' => $attrs,
        ];
    }
}

