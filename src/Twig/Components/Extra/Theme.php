<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractBootstrap;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\VariantTrait;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:theme', template: '@NeuralGlitchUxBootstrap/components/extra/theme.html.twig')]
final class Theme extends AbstractBootstrap
{
    use VariantTrait;

    public ?string $initial = null;
    public ?string $mode = null;

    public function mount(): void
    {
        $d = $this->config->for('theme_toggle');

        $this->applyVariantDefaults($d);
        $this->applyClassDefaults($d);

        // Apply mode default if not explicitly set
        if ($this->mode === null && isset($d['mode'])) {
            $this->mode = (string)$d['mode'];
        }
    }

    protected function getComponentName(): string
    {
        return 'theme';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        // Wrapper div should only have user-defined classes, not button variant classes
        $classes = $this->buildClasses(
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = $this->mergeAttributes($this->attr, [
            'data-controller' => 'bs-theme',
        ]);

        return [
            'mode' => $this->mode ?? 'button-icon',
            'variant' => $this->variant ?? 'outline-secondary',
            'initial' => $this->initial,
            'classes' => $classes,
            'attrs' => $attrs,
        ];
    }
}

