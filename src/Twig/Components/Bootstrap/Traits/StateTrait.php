<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits;

trait StateTrait
{
    public bool $block = false;
    public bool $active = false;
    public bool $disabled = false;

    /**
     * @param array<string, mixed> $defaults
     */
    protected function applyStateDefaults(array $defaults): void
    {
        $this->block = $this->block || (bool)($defaults['block'] ?? false);
        $this->active = $this->active || (bool)($defaults['active'] ?? false);
        $this->disabled = $this->disabled || (bool)($defaults['disabled'] ?? false);
    }

    /**
     * @return array<int, string>
     */
    protected function stateClassesFor(string $type): array
    {
        $classes = [];

        if ($this->block) {
            $classes[] = $type === 'button' ? 'w-100' : 'd-block';
        }

        if ($this->active) {
            $classes[] = 'active';
        }

        if ($this->disabled && $type === 'link') {
            $classes[] = 'disabled';
        }

        return $classes;
    }

    /**
     * @return array<string, mixed>
     */
    protected function stateAttributesFor(string $type, bool $isAnchor): array
    {
        $attrs = [];

        if ($this->disabled) {
            $attrs['aria-disabled'] = 'true';
            if ($isAnchor) {
                $attrs['tabindex'] = '-1';
            } else {
                $attrs['disabled'] = true;
            }
        }

        if ($this->active) {
            $attrs['aria-pressed'] = 'true';
        }

        return $attrs;
    }
}
