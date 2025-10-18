<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:accordion', template: '@NeuralGlitchUxBootstrap/components/bootstrap/accordion.html.twig')]
final class Accordion extends AbstractBootstrap
{
    public ?string $id = null;
    public bool $flush = false;
    public bool $alwaysOpen = false;

    public function mount(): void
    {
        $d = $this->config->for('accordion');

        $this->applyClassDefaults($d);

        // Apply defaults from config
        $this->flush = $this->flush || ($d['flush'] ?? false);
        $this->alwaysOpen = $this->alwaysOpen || ($d['always_open'] ?? false);
        
        // Generate unique ID if not provided
        if (null === $this->id) {
            $this->id = $d['id'] ?? 'accordion-' . uniqid();
        }
    }

    protected function getComponentName(): string
    {
        return 'accordion';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = $this->buildClasses(
            ['accordion'],
            $this->flush ? ['accordion-flush'] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = [
            'id' => $this->id,
        ];

        $attrs = $this->mergeAttributes($attrs, $this->attr);

        return [
            'id' => $this->id,
            'flush' => $this->flush,
            'alwaysOpen' => $this->alwaysOpen,
            'classes' => $classes,
            'attrs' => $attrs,
        ];
    }
}

