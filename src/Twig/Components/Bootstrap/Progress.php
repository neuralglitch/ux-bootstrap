<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:progress', template: '@NeuralGlitchUxBootstrap/components/bootstrap/progress.html.twig')]
final class Progress extends AbstractStimulus
{
    public string $stimulusController = 'bs-progress';

    /** Current progress value (0-100 by default) */
    public int|float|null $value = null;

    /** Minimum value */
    public int|float|null $min = null;

    /** Maximum value */
    public int|float|null $max = null;

    /** Optional label text to display on the progress bar */
    public ?string $label = null;

    /** If true, automatically shows percentage as label */
    public bool $showLabel = false;

    /** Custom height (e.g., '1px', '20px') */
    public ?string $height = null;

    /** Bootstrap variant for the progress bar background (primary, success, info, warning, danger, etc.) */
    public ?string $variant = null;

    /** If true, applies striped appearance */
    public bool $striped = false;

    /** If true, applies animated stripes (requires striped=true) */
    public bool $animated = false;

    /** Accessible label for screen readers */
    public ?string $ariaLabel = null;

    public function mount(): void
    {
        $d = $this->config->for('progress');

        $this->applyStimulusDefaults($d);

        $this->applyClassDefaults($d);

        // Apply defaults from config
        $this->value ??= $d['value'] ?? 0;
        $this->min ??= $d['min'] ?? 0;
        $this->max ??= $d['max'] ?? 100;
        $this->showLabel = $this->showLabel || ($d['show_label'] ?? false);
        $this->height ??= $d['height'] ?? null;
        $this->variant ??= $d['variant'] ?? null;
        $this->striped = $this->striped || ($d['striped'] ?? false);
        $this->animated = $this->animated || ($d['animated'] ?? false);
        $this->ariaLabel ??= $d['aria_label'] ?? null;

        // Normalize value to be within min-max range
        $this->value = max($this->min, min($this->max, $this->value));


        // Initialize controller with default
        $this->initializeController();
    }

    protected function getComponentName(): string
    {
        return 'progress';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        // Calculate percentage
        $range = $this->max - $this->min;
        $percentage = $range > 0 ? (($this->value - $this->min) / $range) * 100 : 0;

        // Determine label to display
        $displayLabel = $this->label ?? ($this->showLabel ? round($percentage) . '%' : null);

        // Progress wrapper classes
        $wrapperClasses = $this->buildClasses(
            ['progress'],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        // Progress bar classes
        $barClasses = $this->buildClasses(
            ['progress-bar'],
            $this->variant ? ["bg-{$this->variant}"] : [],
            $this->striped ? ['progress-bar-striped'] : [],
            $this->animated ? ['progress-bar-animated'] : []
        );

        // Wrapper attributes
        $wrapperAttrs = [
            'role' => 'progressbar',
            'aria-valuenow' => (string)$this->value,
            'aria-valuemin' => (string)$this->min,
            'aria-valuemax' => (string)$this->max,
        ];

        if ($this->ariaLabel) {
            $wrapperAttrs['aria-label'] = $this->ariaLabel;
        }

        // Add custom height style if provided
        if ($this->height) {
            $wrapperAttrs['style'] = 'height: ' . $this->height;
        }

        $wrapperAttrs = $this->mergeAttributes($wrapperAttrs, $this->attr);

        return [
            'wrapperClasses' => $wrapperClasses,
            'wrapperAttrs' => $wrapperAttrs,
            'barClasses' => $barClasses,
            'percentage' => $percentage,
            'label' => $displayLabel,
        ];
    }
}

