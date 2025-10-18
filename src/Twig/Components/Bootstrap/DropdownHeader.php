<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:dropdown-header', template: '@NeuralGlitchUxBootstrap/components/bootstrap/dropdown-header.html.twig')]
final class DropdownHeader extends AbstractBootstrap
{
    public ?string $label = null;

    public function mount(): void
    {
        $d = $this->config->for('dropdown_header');

        $this->applyClassDefaults($d);
        $this->label ??= $d['label'] ?? null;
    }

    protected function getComponentName(): string
    {
        return 'dropdown_header';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = $this->buildClasses(
            ['dropdown-header'],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = $this->mergeAttributes([], $this->attr);

        return [
            'label' => $this->label,
            'classes' => $classes,
            'attrs' => $attrs,
        ];
    }
}

