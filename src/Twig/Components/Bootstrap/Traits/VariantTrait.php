<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits;

trait VariantTrait
{
    public ?string $variant = null;
    public bool $outline = false;

    /**
     * @param array<string, mixed> $defaults
     */
    protected function applyVariantDefaults(array $defaults): void
    {
        $this->variant ??= $defaults['variant'] ?? null;
        $this->outline = $this->outline || ($defaults['outline'] ?? false);
    }

    /**
     * @return array<int, string>
     */
    protected function variantClassesFor(string $type): array
    {
        // For links, only add variant class if explicitly set (no default)
        // This allows nav-link to work without interference
        if ($type === 'link' && $this->variant === null) {
            return [];
        }
        
        $v = $this->variant ?? 'primary';

        return match ($type) {
            'button' => [$this->outline ? "btn-outline-{$v}" : "btn-{$v}"],
            'link' => ["link-{$v}"],
            'badge' => ["text-bg-{$v}"],
            'alert' => ["alert-{$v}"],
            'list-group-item' => ["list-group-item-{$v}"],
            default => [],
        };
    }
}
