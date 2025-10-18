<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:pagination', template: '@NeuralGlitchUxBootstrap/components/bootstrap/pagination.html.twig')]
final class Pagination extends AbstractBootstrap
{
    use Traits\SizeTrait;

    public ?string $ariaLabel = null;
    public ?string $alignment = null; // null (start/default) | 'center' | 'end'

    public function mount(): void
    {
        $d = $this->config->for('pagination');

        $this->applySizeDefaults($d);
        $this->applyClassDefaults($d);

        // Apply defaults from config
        $this->ariaLabel ??= $d['aria_label'] ?? 'Page navigation';
        $this->alignment ??= $d['alignment'] ?? null;
    }

    protected function getComponentName(): string
    {
        return 'pagination';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = $this->buildClasses(
            ['pagination'],
            $this->sizeClassesFor('pagination'),
            $this->alignment === 'center' ? ['justify-content-center'] : [],
            $this->alignment === 'end' ? ['justify-content-end'] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = $this->mergeAttributes([], $this->attr);

        return [
            'ariaLabel' => $this->ariaLabel,
            'classes' => $classes,
            'attrs' => $attrs,
        ];
    }
}

