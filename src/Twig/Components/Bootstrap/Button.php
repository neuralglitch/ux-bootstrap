<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\SizeTrait;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:button', template: '@NeuralGlitchUxBootstrap/components/bootstrap/button.html.twig')]
final class Button extends AbstractInteraction
{
    use SizeTrait;

    public ?string $href = null;
    public string $type = 'button';

    public function mount(): void
    {
        $d = $this->config->for('button');

        $this->applyCommonDefaults($d);
        $this->applySizeDefaults($d);
    }

    protected function getComponentType(): string
    {
        return 'button';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $isAnchor = $this->href !== null;

        $classes = array_merge(
            ['btn'],
            $this->variantClassesFor('button'),  // btn-(outline-)?<variant>
            $this->sizeClassesFor('button'),     // btn-sm/btn-lg
            $this->stateClassesFor('button'),    // w-100, active, …
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = $this->buildCommonAttributes($isAnchor);

        $iconSpace = $this->iconSpacingClasses('button');

        return [
            'tag' => $isAnchor ? 'a' : 'button',
            'href' => $this->href,
            'type' => $this->type,
            'label' => $this->label,
            'iconStart' => $this->iconStart,
            'iconEnd' => $this->iconEnd,
            'iconOnly' => $this->iconOnly,
            'iconSize' => $this->effectiveIconSize(),
            'classes' => implode(' ', array_unique(array_filter($classes))),
            'attrs' => $attrs,
            'disabled' => $this->disabled,
            'iconStartClasses' => implode(' ', $iconSpace['start']),
            'iconEndClasses' => implode(' ', $iconSpace['end']),
        ];
    }
}
