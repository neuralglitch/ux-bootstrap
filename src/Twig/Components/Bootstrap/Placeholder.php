<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:placeholder', template: '@NeuralGlitchUxBootstrap/components/bootstrap/placeholder.html.twig')]
final class Placeholder extends AbstractStimulus
{
    /**
     * Grid column class for width (e.g., '6' for 'col-6', '12' for 'col-12')
     */
    public ?string $col = null;

    /**
     * Size modifier: 'lg', 'sm', 'xs', or null for default
     */
    public ?string $size = null;

    /**
     * Animation type: 'glow', 'wave', or null
     */
    public ?string $animation = null;

    /**
     * Color variant for background (e.g., 'primary', 'secondary', etc.)
     */
    public ?string $variant = null;

    /**
     * Custom width (e.g., '75%', '100px')
     */
    public ?string $width = null;

    /**
     * HTML tag to use (default: 'span')
     */
    public string $tag = 'span';

    /**
     * ARIA hidden attribute (default: true for accessibility)
     */
    public bool $ariaHidden = true;

    public function mount(): void
    {
        $d = $this->config->for('placeholder');

        $this->applyStimulusDefaults($d);

        $this->applyClassDefaults($d);

        $this->col ??= $d['col'] ?? null;
        $this->size ??= $d['size'] ?? null;
        $this->animation ??= $d['animation'] ?? null;
        $this->variant ??= $d['variant'] ?? null;
        $this->width ??= $d['width'] ?? null;
        $this->tag = $this->tag !== 'span' ? $this->tag : ($d['tag'] ?? 'span');
        $this->ariaHidden = $this->ariaHidden !== true ? $this->ariaHidden : ($d['aria_hidden'] ?? true);


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
        $classes = $this->buildClasses(
            ['placeholder'],
            $this->col ? ["col-{$this->col}"] : [],
            $this->size ? ["placeholder-{$this->size}"] : [],
            $this->variant ? ["bg-{$this->variant}"] : [],
            $this->animation ? ["placeholder-{$this->animation}"] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = [];

        if ($this->ariaHidden) {
            $attrs['aria-hidden'] = 'true';
        }

        if ($this->width) {
            $attrs['style'] = "width: {$this->width}";
        }

        $attrs = $this->mergeAttributes($attrs, $this->attr);

        return [
            'tag' => $this->tag,
            'classes' => $classes,
            'attrs' => $attrs,
        ];
    }
}

