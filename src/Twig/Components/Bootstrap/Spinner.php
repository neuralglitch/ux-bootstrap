<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:spinner', template: '@NeuralGlitchUxBootstrap/components/bootstrap/spinner.html.twig')]
final class Spinner extends AbstractStimulus
{
    public ?string $type = null;
    public ?string $variant = null;
    public ?string $size = null;
    public ?string $label = null;
    public ?string $role = null;

    public function mount(): void
    {
        $d = $this->config->for('spinner');

        $this->applyStimulusDefaults($d);

        $this->applyClassDefaults($d);

        $this->type ??= $this->configStringWithFallback($d, 'type', 'border');
        $this->variant ??= $this->configString($d, 'variant');
        $this->size ??= $this->configString($d, 'size');
        $this->label ??= $this->configStringWithFallback($d, 'label', 'Loading...');
        $this->role ??= $this->configStringWithFallback($d, 'role', 'status');


        // Initialize controller with default
        $this->initializeController();
    }

    protected function getComponentName(): string
    {
        return 'spinner';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $baseClass = $this->type === 'grow' ? 'spinner-grow' : 'spinner-border';
        $sizeClass = $this->size === 'sm' ? "{$baseClass}-sm" : null;
        $variantClass = $this->variant ? "text-{$this->variant}" : null;

        $classes = $this->buildClassesFromArrays([$baseClass], $sizeClass ? [$sizeClass] : [], $variantClass ? [$variantClass] : [], $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = $this->mergeAttributes(
            ['role' => $this->role ?? 'status'], $this->attr
        );

        return [
            'classes' => $classes,
            'attrs' => $attrs,
            'label' => $this->label ?? 'Loading...',
        ];
    }
}

