<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:dropdown-divider', template: '@NeuralGlitchUxBootstrap/components/bootstrap/dropdown-divider.html.twig')]
final class DropdownDivider extends AbstractBootstrap
{
    public function mount(): void
    {
        $d = $this->config->for('dropdown_divider');
        $this->applyClassDefaults($d);
    }

    protected function getComponentName(): string
    {
        return 'dropdown_divider';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = $this->buildClasses(
            ['dropdown-divider'],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = $this->mergeAttributes([], $this->attr);

        return [
            'classes' => $classes,
            'attrs' => $attrs,
        ];
    }
}

