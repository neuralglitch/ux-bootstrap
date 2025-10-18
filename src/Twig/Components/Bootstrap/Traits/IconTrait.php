<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits;

trait IconTrait
{
    public ?string $iconStart = null;
    public ?string $iconEnd = null;
    public bool $iconOnly = false;
    public int|string|float|null $iconSize = null;
    public int|string|null $iconGap = null;

    protected function toIntOrNull(int|string|null $v): ?int
    {
        if (is_int($v)) {
            return $v;
        }
        if (is_string($v) && preg_match('/^\d+$/', $v)) {
            return (int)$v;
        }
        return null;
    }

    protected function hasIconStart(): bool
    {
        return $this->iconStart !== null && $this->iconStart !== '';
    }

    protected function hasIconEnd(): bool
    {
        return $this->iconEnd !== null && $this->iconEnd !== '';
    }

    protected function effectiveIconGap(): int
    {
        $gap = is_int($this->iconGap) ? max(0, min(5, $this->iconGap)) : null;
        if ($gap !== null) {
            return $gap;
        }
        // @phpstan-ignore-next-line - property may or may not exist depending on which class uses this trait
        $size = property_exists($this, 'size') ? ($this->size ?? null) : null;
        return $size === 'sm' ? 1 : 2;
    }

    /**
     * @return array<string, array<int, string>>
     */
    protected function iconSpacingClasses(string $context = 'button'): array
    {
        $gap = $this->effectiveIconGap();
        if ($gap === 0) {
            return ['start' => [], 'end' => []];
        }

        return [
            'start' => ["me-{$gap}"],
            'end' => ["ms-{$gap}"],
        ];
    }

    /**
     * @param array<string, mixed> $attrs
     * @return array<string, mixed>
     */
    protected function applyIconOnlyAria(array $attrs, ?string $visibleLabel, ?string $ariaLabel): array
    {
        if ($this->iconOnly) {
            $label = $ariaLabel ?: $visibleLabel;
            if ($label) {
                $attrs['aria-label'] = $label;
            }
        }
        return $attrs;
    }

    protected function effectiveIconSize(): string
    {
        if ($this->iconSize === null) {
            return '1em';
        }

        // If it's a numeric value, convert to em
        if (is_numeric($this->iconSize)) {
            return $this->iconSize . 'em';
        }

        // Otherwise use the string as-is (allows "24px", "2rem", etc.)
        return (string)$this->iconSize;
    }
}
