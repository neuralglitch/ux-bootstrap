<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits;

trait SizeTrait
{
    public ?string $size = null;

    /**
     * @param array<string, mixed> $defaults
     */
    protected function applySizeDefaults(array $defaults): void
    {
        $this->size ??= $this->configString($defaults, 'size');
    }

    /**
     * @return array<int, string>
     */
    protected function sizeClassesFor(string $type): array
    {
        if ($this->size === null) {
            return [];
        }

        return match ($type) {
            'button' => [$this->size === 'sm' ? 'btn-sm' : 'btn-lg'],
            'input' => [$this->size === 'sm' ? 'form-control-sm' : 'form-control-lg'],
            'btn-group' => ["btn-group-{$this->size}"],
            'pagination' => ["pagination-{$this->size}"],
            'modal' => $this->modalSizeClasses(),
            default => [],
        };
    }

    /**
     * Modal supports sm, lg, and xl sizes
     * @return array<string>
     */
    private function modalSizeClasses(): array
    {
        if (in_array($this->size, ['sm', 'lg', 'xl'], true)) {
            return ["modal-{$this->size}"];
        }
        return [];
    }
}
