<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Service\TypeHelper;

/**
 * Abstract base class for all UX Bootstrap components
 * 
 * Provides common functionality including:
 * - Type-safe configuration handling
 * - TypeHelper service injection
 * - Common configuration patterns
 */
abstract class AbstractComponent
{
    public string $class = '';

    /**
     * @var array<string, mixed>
     */
    public array $attr = [];

    protected TypeHelper $typeHelper;

    public function __construct(
        protected readonly Config $config
    ) {
        $this->typeHelper = new TypeHelper();
    }

    /**
     * Get type helper instance
     */
    protected function type(): TypeHelper
    {
        return $this->typeHelper;
    }

    /**
     * Safely get configuration value as string
     * 
     * @param array<string, mixed> $config
     */
    protected function configString(array $config, string $key, ?string $default = null): ?string
    {
        return $this->typeHelper->toString($config[$key] ?? null, $default);
    }

    /**
     * Safely get configuration value as int
     * 
     * @param array<string, mixed> $config
     */
    protected function configInt(array $config, string $key, ?int $default = null): ?int
    {
        return $this->typeHelper->toInt($config[$key] ?? null, $default);
    }

    /**
     * Safely get configuration value as float
     * 
     * @param array<string, mixed> $config
     */
    protected function configFloat(array $config, string $key, ?float $default = null): ?float
    {
        return $this->typeHelper->toFloat($config[$key] ?? null, $default);
    }

    /**
     * Safely get configuration value as bool
     * 
     * @param array<string, mixed> $config
     */
    protected function configBool(array $config, string $key, ?bool $default = null): ?bool
    {
        return $this->typeHelper->toBool($config[$key] ?? null, $default);
    }

    /**
     * Safely get configuration value as array
     * 
     * @param array<string, mixed> $config
     * @param array<string, mixed>|null $default
     * @return array<string, mixed>|null
     */
    protected function configArray(array $config, string $key, ?array $default = null): ?array
    {
        return $this->typeHelper->toArray($config[$key] ?? null, $default);
    }

    /**
     * Safely get configuration value as string with fallback
     * 
     * @param array<string, mixed> $config
     */
    protected function configStringWithFallback(array $config, string $key, string $default = ''): string
    {
        return $this->typeHelper->toStringWithFallback($config[$key] ?? null, $default);
    }

    /**
     * Safely get configuration value as int with fallback
     * 
     * @param array<string, mixed> $config
     */
    protected function configIntWithFallback(array $config, string $key, int $default = 0): int
    {
        return $this->typeHelper->toIntWithFallback($config[$key] ?? null, $default);
    }

    /**
     * Safely get configuration value as float with fallback
     * 
     * @param array<string, mixed> $config
     */
    protected function configFloatWithFallback(array $config, string $key, float $default = 0.0): float
    {
        return $this->typeHelper->toFloatWithFallback($config[$key] ?? null, $default);
    }

    /**
     * Safely get configuration value as bool with fallback
     * 
     * @param array<string, mixed> $config
     */
    protected function configBoolWithFallback(array $config, string $key, bool $default = false): bool
    {
        return $this->typeHelper->toBoolWithFallback($config[$key] ?? null, $default);
    }

    /**
     * Apply class defaults from config
     *
     * @param array<string, mixed> $defaults
     */
    protected function applyClassDefaults(array $defaults): void
    {
        if (isset($defaults['class']) && is_string($defaults['class']) && trim($defaults['class'])) {
            $this->class = trim($this->class . ' ' . $defaults['class']);
        }
    }

    /**
     * Build CSS classes array
     * 
     * @param array<string> $baseClasses
     * @param array<string>|null $additionalClasses
     * @param array<string>|null $moreClasses
     * @param array<string>|null $evenMoreClasses
     * @return string
     */
    protected function buildClasses(array $baseClasses, ?array $additionalClasses = null, ?array $moreClasses = null, ?array $evenMoreClasses = null): string
    {
        $classes = $baseClasses;
        if ($additionalClasses !== null) {
            $classes = array_merge($classes, $additionalClasses);
        }
        if ($moreClasses !== null) {
            $classes = array_merge($classes, $moreClasses);
        }
        if ($evenMoreClasses !== null) {
            $classes = array_merge($classes, $evenMoreClasses);
        }
        return implode(' ', array_filter($classes));
    }

    /**
     * Build CSS classes from multiple arrays (flexible version)
     * 
     * @param array<string> ...$classArrays
     * @return string
     */
    protected function buildClassesFromArrays(array ...$classArrays): string
    {
        $classes = [];
        foreach ($classArrays as $classArray) {
            $classes = array_merge($classes, $classArray);
        }
        return implode(' ', array_filter($classes));
    }

    /**
     * Merge HTML attributes
     * 
     * @param array<string, mixed> $defaults
     * @param array<string, mixed> $overrides
     * @return array<string, mixed>
     */
    protected function mergeAttributes(array $defaults, array $overrides = []): array
    {
        return array_merge($defaults, $overrides);
    }

    /**
     * Render HTML attributes as string
     * 
     * @param array<string, mixed> $attributes
     * @return string
     */
    public function renderHtmlAttributes(array $attributes): string
    {
        $rendered = [];
        foreach ($attributes as $key => $value) {
            if ($value === null || $value === false) {
                continue;
            }
            if ($value === true) {
                $rendered[] = $key;
            } else {
                if (is_string($value)) {
                    $rendered[] = $key . '="' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '"';
                }
            }
        }
        return implode(' ', $rendered);
    }
}
