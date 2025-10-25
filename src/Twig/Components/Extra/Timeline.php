<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:timeline', template: '@NeuralGlitchUxBootstrap/components/extra/timeline.html.twig')]
final class Timeline extends AbstractStimulus
{
    /**
     * Layout variant for the timeline
     * - vertical: Standard vertical timeline (default)
     * - horizontal: Horizontal timeline (works well for mobile-first)
     * - alternating: Alternating sides for larger screens
     * - compact: Dense layout with minimal spacing
     */
    public ?string $variant = null;

    /**
     * Alignment for vertical timelines
     * - start: Timeline line on the left (default)
     * - center: Timeline line in the center
     * - end: Timeline line on the right
     */
    public ?string $align = null;

    /**
     * Show connecting line between items
     */
    public ?bool $showLine = null;

    /**
     * Line style
     * - solid: Solid line (default)
     * - dashed: Dashed line
     * - dotted: Dotted line
     */
    public ?string $lineStyle = null;

    /**
     * Theme/color variant for the timeline
     */
    public ?string $lineVariant = null;

    /**
     * Size variant
     * - sm: Small compact timeline
     * - null: Default size
     * - lg: Large timeline with more spacing
     */
    public ?string $size = null;

    public function mount(): void
    {
        $d = $this->config->for('timeline');

        $this->applyStimulusDefaults($d);

        // Apply defaults from config
        $this->variant = $this->variant ?? $this->configStringWithFallback($d, 'variant', 'vertical');
        $this->align = $this->align ?? $this->configStringWithFallback($d, 'align', 'start');
        $this->showLine = $this->showLine ?? $this->configBoolWithFallback($d, 'show_line', true);
        $this->lineStyle = $this->lineStyle ?? $this->configStringWithFallback($d, 'line_style', 'solid');
        $this->lineVariant = $this->lineVariant ?? $this->configString($d, 'line_variant');
        $this->size = $this->size ?? $this->configString($d, 'size');

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
        return 'timeline';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = $this->buildClassesFromArrays(
            ['timeline'],
            ["timeline-{$this->variant}"],
            $this->align && $this->variant === 'vertical' ? ["timeline-align-{$this->align}"] : [],
            $this->showLine ? ['timeline-connected'] : [],
            $this->lineStyle !== 'solid' ? ["timeline-line-{$this->lineStyle}"] : [],
            $this->lineVariant ? ["timeline-line-{$this->lineVariant}"] : [],
            $this->size ? ["timeline-{$this->size}"] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = $this->mergeAttributes([], $this->attr);

        return [
            'variant' => $this->variant,
            'align' => $this->align,
            'showLine' => $this->showLine,
            'lineStyle' => $this->lineStyle,
            'lineVariant' => $this->lineVariant,
            'size' => $this->size,
            'classes' => $classes,
            'attrs' => $attrs,
        ];
    }
}

