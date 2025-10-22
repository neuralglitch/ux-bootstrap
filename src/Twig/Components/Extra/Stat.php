<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:stat', template: '@NeuralGlitchUxBootstrap/components/extra/stat.html.twig')]
final class Stat extends AbstractStimulus
{
    // Core properties
    public string|int|float|null $value = null;
    public ?string $label = null;
    public ?string $variant = null;

    // Icon
    public ?string $icon = null;
    public string $iconPosition = 'start'; // 'start' | 'end' | 'top'

    // Trend indicator
    public ?string $trend = null; // 'up' | 'down' | 'neutral'
    public ?string $change = null; // e.g., "+12%" or "-5%"

    // Additional info
    public ?string $description = null;

    // Layout
    public ?string $size = null; // 'sm' | 'default' | 'lg'
    public bool $border = false;
    public bool $shadow = false;
    public ?string $textAlign = null; // 'start' | 'center' | 'end'

    public function mount(): void
    {
        $d = $this->config->for('stat');

        $this->applyStimulusDefaults($d);

        // Apply base class defaults
        $this->applyClassDefaults($d);

        // Apply component-specific defaults
        $this->value ??= $d['value'] ?? '0';
        $this->label ??= $d['label'] ?? 'Statistic';
        $this->variant ??= $d['variant'] ?? null;
        $this->icon ??= $d['icon'] ?? null;
        $this->iconPosition ??= $d['icon_position'] ?? 'start';
        $this->trend ??= $d['trend'] ?? null;
        $this->change ??= $d['change'] ?? null;
        $this->description ??= $d['description'] ?? null;
        $this->size ??= $d['size'] ?? 'default';
        $this->border = $this->border || ($d['border'] ?? false);
        $this->shadow = $this->shadow || ($d['shadow'] ?? false);
        $this->textAlign ??= $d['text_align'] ?? 'start';

        // Initialize controller with default
        $this->initializeController();
    }

    protected function getComponentName(): string
    {
        return 'stat';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        // Normalize values
        $size = $this->size ?? 'default';
        $textAlign = $this->textAlign ?? 'start';
        $value = $this->value ?? '0';
        $label = $this->label ?? 'Statistic';

        // Build card classes
        $cardClasses = $this->buildClasses(
            ['card', 'stat-card'],
            $this->border ? ['border'] : ['border-0'],
            $this->shadow ? ['shadow-sm'] : [],
            $this->variant ? ["border-{$this->variant}"] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        // Build card body classes
        $bodyClasses = $this->buildClasses(
            ['card-body'],
            $size === 'sm' ? ['p-3'] : ($size === 'lg' ? ['p-4'] : []),
            $textAlign !== 'start' ? ["text-{$textAlign}"] : [],
            $this->iconPosition === 'top' ? ['d-flex', 'flex-column', 'align-items-center'] : []
        );

        // Build value classes
        $valueClasses = $this->buildClasses(
            ['stat-value', 'fs-2', 'fw-bold', 'mb-1'],
            $this->variant ? ["text-{$this->variant}"] : [],
            $size === 'sm' ? ['fs-4'] : ($size === 'lg' ? ['fs-1'] : [])
        );

        // Build label classes
        $labelClasses = $this->buildClasses(
            ['stat-label', 'text-muted', 'mb-0'],
            $size === 'sm' ? ['small'] : []
        );

        // Build icon classes
        $iconClasses = [];
        if ($this->icon) {
            $iconClasses = $this->buildClasses(
                ['stat-icon'],
                $this->variant ? ["text-{$this->variant}"] : ['text-muted'],
                $this->iconPosition === 'top' ? ['mb-3', 'px-3'] : ($this->iconPosition === 'end' ? [
                    'ms-3',
                    'px-2'
                ] : ['me-3', 'px-2']),
                $size === 'sm' ? ['fs-5'] : ($size === 'lg' ? ['fs-1'] : ['fs-3'])
            );
        }

        // Build trend classes
        $trendClasses = [];
        $trendIcon = null;
        if ($this->trend) {
            $trendVariant = match ($this->trend) {
                'up' => 'success',
                'down' => 'danger',
                'neutral' => 'secondary',
                default => 'secondary',
            };

            $trendIcon = match ($this->trend) {
                'up' => '↑',
                'down' => '↓',
                'neutral' => '→',
                default => '→',
            };

            $trendClasses = $this->buildClasses(
                ['stat-trend', 'badge', "text-bg-{$trendVariant}", 'ms-2'],
                $this->size === 'sm' ? ['badge-sm'] : []
            );
        }

        // Build description classes
        $descriptionClasses = $this->buildClasses(
            ['stat-description', 'text-muted', 'small', 'mt-1']
        );

        $attrs = $this->mergeAttributes([], $this->attr);

        return [
            'value' => $value,
            'label' => $label,
            'icon' => $this->icon,
            'iconPosition' => $this->iconPosition,
            'trend' => $this->trend,
            'trendIcon' => $trendIcon,
            'change' => $this->change,
            'description' => $this->description,
            'cardClasses' => $cardClasses,
            'bodyClasses' => $bodyClasses,
            'valueClasses' => $valueClasses,
            'labelClasses' => $labelClasses,
            'iconClasses' => $iconClasses,
            'trendClasses' => $trendClasses,
            'descriptionClasses' => $descriptionClasses,
            'attrs' => $attrs,
        ];
    }
}

