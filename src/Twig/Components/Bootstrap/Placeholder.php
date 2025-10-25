<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:placeholder', template: '@NeuralGlitchUxBootstrap/components/bootstrap/placeholder.html.twig')]
final class Placeholder extends AbstractStimulus
{
    public int|string|null $col = null; // Bootstrap grid column (1-12)
    public ?string $size = null; // 'sm' | 'lg' | 'xs'
    public ?string $animation = null; // 'glow' | 'wave'
    public ?string $variant = null; // Bootstrap color variant
    public ?string $width = null; // Custom width (e.g., '75%', '200px')
    public ?string $tag = null; // HTML tag (default: 'div')
    public bool $ariaHidden = true;

    public function mount(): void
    {
        $d = $this->config->for('placeholder');

        $this->applyStimulusDefaults($d);
        $this->applyClassDefaults($d);

        // Apply defaults from config
        $this->col ??= $this->configString($d, 'col');
        $this->size ??= $this->configString($d, 'size');
        $this->animation ??= $this->configString($d, 'animation');
        $this->variant ??= $this->configString($d, 'variant');
        $this->width ??= $this->configString($d, 'width');
        $this->tag ??= $this->configStringWithFallback($d, 'tag', 'div');
        $this->ariaHidden = $this->ariaHidden && $this->configBoolWithFallback($d, 'aria_hidden', true);

        // Initialize controller with default
        $this->initializeController();
    }

    protected function getComponentName(): string
    {
        return 'placeholder';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = $this->buildClassesFromArrays(
            ['placeholder'],
            $this->col ? ['col-' . (string)$this->col] : [],
            $this->size ? ['placeholder-' . $this->size] : [],
            $this->animation ? ['placeholder-' . $this->animation] : [],
            $this->variant ? ['bg-' . $this->variant] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = [];

        if ($this->ariaHidden) {
            $attrs['aria-hidden'] = 'true';
        }

        if ($this->width) {
            $attrs['style'] = 'width: ' . $this->width;
        }

        $attrs = $this->mergeAttributes($attrs, $this->attr);

        return [
            'tag' => $this->tag,
            'classes' => $classes,
            'attrs' => $attrs,
            'width' => $this->width,
        ];
    }
}