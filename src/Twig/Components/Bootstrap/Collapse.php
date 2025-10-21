<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:collapse', template: '@NeuralGlitchUxBootstrap/components/bootstrap/collapse.html.twig')]
final class Collapse extends AbstractStimulus
{
    public ?string $id = null;
    public ?bool $show = null;
    public ?bool $horizontal = null;
    public ?string $parent = null;

    public function mount(): void
    {
        $d = $this->config->for('collapse');

        $this->applyStimulusDefaults($d);

        $this->applyClassDefaults($d);

        $this->show ??= $d['show'] ?? false;
        $this->horizontal ??= $d['horizontal'] ?? false;
        $this->parent ??= $d['parent'] ?? null;

        
        // Initialize controller with default
        $this->initializeController();
    }

    protected function getComponentName(): string
    {
        return 'collapse';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = $this->buildClasses(
            ['collapse'],
            $this->show ? ['show'] : [],
            $this->horizontal ? ['collapse-horizontal'] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = $this->mergeAttributes(
            array_filter([
                'id' => $this->id,
                'data-bs-parent' => $this->parent,
            ]),
            $this->attr
        );

        return [
            'classes' => $classes,
            'attrs' => $attrs,
        ];
    }
}

