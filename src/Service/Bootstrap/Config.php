<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Service\Bootstrap;

final class Config
{
    /**
     * @param array<string, mixed> $config
     */
    public function __construct(private array $config)
    {
    }

    /**
     * @return array<string, mixed>
     */
    public function for(string $component): array
    {
        return $this->config[$component] ?? [];
    }

    /**
     * Merge defaults with user overrides (attributes take precedence).
     *
     * @param array<string, mixed> $overrides
     * @return array<string, mixed>
     */
    public function merge(string $component, array $overrides): array
    {
        return array_replace_recursive(
            $this->for($component),
            array_filter(
                $overrides,
                static fn($v) => $v !== null && $v !== []
            )
        );
    }
}
