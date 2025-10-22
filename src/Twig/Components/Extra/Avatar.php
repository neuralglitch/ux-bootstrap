<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:avatar', template: '@NeuralGlitchUxBootstrap/components/extra/avatar.html.twig')]
final class Avatar extends AbstractStimulus
{
    // Image properties
    public ?string $src = null;
    public ?string $alt = null;

    // Fallback content
    public ?string $initials = null;

    // Sizing (sm, md, lg, xl, or custom pixel value like '64px')
    public ?string $size = null;

    // Shape: circle, square, rounded
    public ?string $shape = null;

    // Status indicator: online, offline, away, busy, null (none)
    public ?string $status = null;

    // Border
    public bool $border = false;
    public ?string $borderColor = null; // Bootstrap color variant

    // Background variant for initials (when no image)
    public ?string $variant = null;

    // Link
    public ?string $href = null;
    public ?string $target = null;

    public function mount(): void
    {
        $d = $this->config->for('avatar');

        $this->applyStimulusDefaults($d);

        // Apply base class defaults
        $this->applyClassDefaults($d);

        // Apply component-specific defaults
        $this->size ??= $d['size'] ?? 'md';
        $this->shape ??= $d['shape'] ?? 'circle';
        $this->status ??= $d['status'] ?? null;
        $this->border = $this->border || ($d['border'] ?? false);
        $this->borderColor ??= $d['border_color'] ?? null;
        $this->variant ??= $d['variant'] ?? null;

        // Generate alt text from initials if not provided
        if ($this->alt === null && $this->initials !== null) {
            $this->alt = $this->initials;
        }

        // Initialize controller with default
        $this->initializeController();
    }

    protected function getComponentName(): string
    {
        return 'avatar';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        // Build wrapper classes
        $wrapperClasses = $this->buildClasses(
            ['avatar'],
            $this->getSizeClasses(),
            $this->getShapeClasses(),
            $this->border ? ['avatar-border'] : [],
            $this->borderColor ? ["border-{$this->borderColor}"] : [],
            $this->href ? ['avatar-link'] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        // Build image classes
        $imageClasses = $this->buildClasses(
            ['avatar-img']
        );

        // Build initials classes (for fallback)
        $initialsClasses = $this->buildClasses(
            ['avatar-initials'],
            $this->variant ? ["bg-{$this->variant}", "text-white"] : ['bg-secondary', 'text-white']
        );

        // Build status indicator classes
        $statusClasses = null;
        if ($this->status) {
            $statusClasses = $this->buildClasses(
                ['avatar-status'],
                ["avatar-status-{$this->status}"]
            );
        }

        $attrs = $this->mergeAttributes([], $this->attr);

        // Add link attributes if href is set
        $linkAttrs = [];
        if ($this->href) {
            $linkAttrs['href'] = $this->href;
            if ($this->target) {
                $linkAttrs['target'] = $this->target;
                if ($this->target === '_blank') {
                    $linkAttrs['rel'] = 'noopener noreferrer';
                }
            }
        }

        return [
            'wrapperClasses' => $wrapperClasses,
            'imageClasses' => $imageClasses,
            'initialsClasses' => $initialsClasses,
            'statusClasses' => $statusClasses,
            'attrs' => $attrs,
            'linkAttrs' => $linkAttrs,
            'src' => $this->src,
            'alt' => $this->alt ?? '',
            'initials' => $this->initials,
            'href' => $this->href,
            'hasStatus' => $this->status !== null,
        ];
    }

    /**
     * @return array<string>
     */
    private function getSizeClasses(): array
    {
        // Predefined sizes
        $sizeMap = [
            'xs' => 'avatar-xs',
            'sm' => 'avatar-sm',
            'md' => 'avatar-md',
            'lg' => 'avatar-lg',
            'xl' => 'avatar-xl',
            'xxl' => 'avatar-xxl',
        ];

        return isset($sizeMap[$this->size]) ? [$sizeMap[$this->size]] : [];
    }

    /**
     * @return array<string>
     */
    private function getShapeClasses(): array
    {
        $shapeMap = [
            'circle' => 'rounded-circle',
            'square' => 'rounded-0',
            'rounded' => 'rounded',
        ];

        return isset($shapeMap[$this->shape]) ? [$shapeMap[$this->shape]] : [];
    }

    /**
     * Get inline styles for custom size
     */
    public function getCustomSizeStyle(): ?string
    {
        // If size is null or a predefined value, no custom style needed
        if ($this->size === null) {
            return null;
        }

        $predefinedSizes = ['xs', 'sm', 'md', 'lg', 'xl', 'xxl'];

        if (!in_array($this->size, $predefinedSizes, true)) {
            // Assume it's a custom value like '64px' or '3rem'
            return "width: {$this->size}; height: {$this->size};";
        }

        return null;
    }
}

