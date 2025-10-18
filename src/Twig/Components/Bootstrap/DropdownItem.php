<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:dropdown-item', template: '@NeuralGlitchUxBootstrap/components/bootstrap/dropdown-item.html.twig')]
final class DropdownItem extends AbstractBootstrap
{
    public ?string $label = null;
    public ?string $href = null;
    public bool $active = false;
    public bool $disabled = false;
    public ?string $tag = null;

    public function mount(): void
    {
        $d = $this->config->for('dropdown_item');

        $this->applyClassDefaults($d);

        $this->label ??= $d['label'] ?? null;
        $this->href ??= $d['href'] ?? null;
        $this->active = $this->active || ($d['active'] ?? false);
        $this->disabled = $this->disabled || ($d['disabled'] ?? false);
        $this->tag ??= $d['tag'] ?? null;

        // Auto-detect tag if not specified
        if ($this->tag === null) {
            $this->tag = $this->href !== null ? 'a' : 'button';
        }
    }

    protected function getComponentName(): string
    {
        return 'dropdown_item';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = $this->buildClasses(
            ['dropdown-item'],
            $this->active ? ['active'] : [],
            $this->disabled ? ['disabled'] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = [];

        if ($this->tag === 'a') {
            $attrs['href'] = $this->href ?? '#';
        } elseif ($this->tag === 'button') {
            $attrs['type'] = 'button';
        }

        if ($this->active) {
            $attrs['aria-current'] = 'true';
        }

        if ($this->disabled) {
            if ($this->tag === 'a') {
                $attrs['tabindex'] = '-1';
                $attrs['aria-disabled'] = 'true';
            } else {
                $attrs['disabled'] = 'disabled';
            }
        }

        $attrs = $this->mergeAttributes($attrs, $this->attr);

        return [
            'tag' => $this->tag,
            'label' => $this->label,
            'classes' => $classes,
            'attrs' => $attrs,
        ];
    }
}

