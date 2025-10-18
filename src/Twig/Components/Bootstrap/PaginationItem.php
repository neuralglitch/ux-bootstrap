<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:pagination-item', template: '@NeuralGlitchUxBootstrap/components/bootstrap/pagination-item.html.twig')]
final class PaginationItem extends AbstractBootstrap
{
    public ?string $href = null;
    public ?string $label = null;
    public bool $active = false;
    public bool $disabled = false;
    public ?string $ariaLabel = null;
    public string $ariaCurrent = 'page';

    public function mount(): void
    {
        $d = $this->config->for('pagination_item');

        $this->applyClassDefaults($d);

        // Apply defaults from config
        $this->active = $this->active || ($d['active'] ?? false);
        $this->disabled = $this->disabled || ($d['disabled'] ?? false);
        $this->ariaCurrent ??= $d['aria_current'] ?? 'page';
    }

    protected function getComponentName(): string
    {
        return 'pagination_item';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $itemClasses = $this->buildClasses(
            ['page-item'],
            $this->active ? ['active'] : [],
            $this->disabled ? ['disabled'] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $linkClasses = 'page-link';

        $itemAttrs = $this->mergeAttributes([], $this->attr);

        $linkAttrs = [];
        
        if ($this->href) {
            $linkAttrs['href'] = $this->href;
        }

        if ($this->ariaLabel) {
            $linkAttrs['aria-label'] = $this->ariaLabel;
        }

        if ($this->active && $this->href) {
            $linkAttrs['aria-current'] = $this->ariaCurrent;
        }

        if ($this->disabled) {
            $linkAttrs['tabindex'] = '-1';
        }

        return [
            'itemClasses' => $itemClasses,
            'linkClasses' => $linkClasses,
            'itemAttrs' => $itemAttrs,
            'linkAttrs' => $linkAttrs,
            'href' => $this->href,
            'label' => $this->label,
            'hasHref' => $this->href !== null,
        ];
    }
}

