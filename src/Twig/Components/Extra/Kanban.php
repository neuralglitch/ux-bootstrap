<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:kanban', template: '@NeuralGlitchUxBootstrap/components/extra/kanban.html.twig')]
final class Kanban extends AbstractStimulus
{
    public string $stimulusController = 'bs-kanban';

    // Layout
    public string $variant = 'horizontal'; // 'horizontal' | 'vertical' | 'compact'
    public bool $scrollable = true;
    public ?string $height = null; // CSS height value (e.g., '600px', '80vh')

    // Drag and drop
    public bool $draggable = true;
    public bool $allow_cross_column = true; // Allow cards to be dragged between columns
    public bool $allow_reorder = true; // Allow cards to be reordered within columns
    public ?string $drop_zone_class = null; // Custom class for drop zones

    // Container
    public string $container = 'container-fluid'; // 'container' | 'container-fluid' | 'container-{breakpoint}'

    // Responsive
    public bool $responsive = true; // Stack columns on mobile
    public string $mobile_breakpoint = 'md'; // 'sm' | 'md' | 'lg' | 'xl' | 'xxl'

    // Styling
    public bool $card_wrapper = false; // Wrap entire kanban in a card
    public ?string $gap = '3'; // Gap between columns (Bootstrap spacing scale: 0-5)

    // Features
    public bool $show_column_count = true; // Show card count in column headers
    public bool $compact_mode = false; // More compact card layout

    // Stimulus
    public ?string $stimulus_controller = 'bs-kanban';

    public function mount(): void
    {
        $d = $this->config->for('kanban');

        $this->applyStimulusDefaults($d);

        // Apply defaults - config takes precedence over component defaults
        $this->variant = $this->configStringWithFallback($d, 'variant', $this->variant);
        $this->scrollable = $this->configBoolWithFallback($d, 'scrollable', $this->scrollable);
        $this->height = $this->configString($d, 'height') ?? $this->height;
        $this->draggable = $this->configBoolWithFallback($d, 'draggable', $this->draggable);
        $this->allow_cross_column = $this->configBoolWithFallback($d, 'allow_cross_column', $this->allow_cross_column);
        $this->allow_reorder = $this->configBoolWithFallback($d, 'allow_reorder', $this->allow_reorder);
        $this->drop_zone_class = $this->configString($d, 'drop_zone_class') ?? $this->drop_zone_class;
        $this->container = $this->configStringWithFallback($d, 'container', $this->container);
        $this->responsive = $this->configBoolWithFallback($d, 'responsive', $this->responsive);
        $this->mobile_breakpoint = $this->configStringWithFallback($d, 'mobile_breakpoint', $this->mobile_breakpoint);
        $this->card_wrapper = $this->configBoolWithFallback($d, 'card_wrapper', $this->card_wrapper);
        $this->gap = $this->configString($d, 'gap') ?? $this->gap;
        $this->show_column_count = $this->configBoolWithFallback($d, 'show_column_count', $this->show_column_count);
        $this->compact_mode = $this->configBoolWithFallback($d, 'compact_mode', $this->compact_mode);
        $this->stimulus_controller = $this->configString($d, 'stimulus_controller') ?? $this->stimulus_controller;

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
        return 'kanban';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classArray = $this->class ? array_filter(explode(' ', trim($this->class)), fn($v) => $v !== '') : [];
        /** @var array<string> $classArray */
        
        $classes = $this->buildClassesFromArrays(
            ['kanban-board'],
            $this->variant === 'compact' ? ['kanban-compact'] : [],
            $this->scrollable ? ['kanban-scrollable'] : [],
            $this->responsive ? ["kanban-responsive-{$this->mobile_breakpoint}"] : [],
            $this->compact_mode ? ['kanban-cards-compact'] : [],
            $classArray
        );

        $attrs = $this->buildStimulusAttributes();
        $attrs = $this->mergeAttributes($attrs, $this->attr);

        return [
            'variant' => $this->variant,
            'container' => $this->container,
            'card_wrapper' => $this->card_wrapper,
            'height' => $this->height,
            'gap' => $this->gap,
            'show_column_count' => $this->show_column_count,
            'allow_cross_column' => $this->allow_cross_column,
            'allow_reorder' => $this->allow_reorder,
            'classes' => $classes,
            'attrs' => $attrs,
        ];
    }
}

