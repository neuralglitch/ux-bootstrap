<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Service;

/**
 * Central type helper service for safe type casting from mixed configuration values
 * 
 * This service provides type-safe casting methods that can be injected into components
 * to handle mixed values from Symfony configuration without PHPStan errors.
 */
final class TypeHelper
{
    /**
     * Safely cast mixed value to string or return default
     */
    public function toString(mixed $value, ?string $default = null): ?string
    {
        if (is_string($value)) {
            return $value;
        }
        return $default;
    }

    /**
     * Safely cast mixed value to int or return default
     */
    public function toInt(mixed $value, ?int $default = null): ?int
    {
        if (is_int($value)) {
            return $value;
        }
        if (is_string($value) && is_numeric($value)) {
            return (int) $value;
        }
        return $default;
    }

    /**
     * Safely cast mixed value to float or return default
     */
    public function toFloat(mixed $value, ?float $default = null): ?float
    {
        if (is_float($value)) {
            return $value;
        }
        if (is_int($value)) {
            return (float) $value;
        }
        if (is_string($value) && is_numeric($value)) {
            return (float) $value;
        }
        return $default;
    }

    /**
     * Safely cast mixed value to bool or return default
     */
    public function toBool(mixed $value, ?bool $default = null): ?bool
    {
        if (is_bool($value)) {
            return $value;
        }
        if (is_string($value)) {
            return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? $default;
        }
        return $default;
    }

    /**
     * Safely cast mixed value to array or return default
     * 
     * @param array<string, mixed>|null $default
     * @return array<string, mixed>|null
     */
    public function toArray(mixed $value, ?array $default = null): ?array
    {
        if (is_array($value)) {
            /** @var array<string, mixed> $value */
            return $value;
        }
        return $default;
    }

    /**
     * Safely cast mixed value to string with fallback to string conversion
     */
    public function toStringWithFallback(mixed $value, string $default = ''): string
    {
        if (is_string($value)) {
            return $value;
        }
        if (is_scalar($value)) {
            return (string) $value;
        }
        return $default;
    }

    /**
     * Safely cast mixed value to int with fallback to int conversion
     */
    public function toIntWithFallback(mixed $value, int $default = 0): int
    {
        if (is_int($value)) {
            return $value;
        }
        if (is_numeric($value)) {
            return (int) $value;
        }
        return $default;
    }

    /**
     * Safely cast mixed value to float with fallback to float conversion
     */
    public function toFloatWithFallback(mixed $value, float $default = 0.0): float
    {
        if (is_float($value)) {
            return $value;
        }
        if (is_numeric($value)) {
            return (float) $value;
        }
        return $default;
    }

    /**
     * Safely cast mixed value to bool with fallback to bool conversion
     */
    public function toBoolWithFallback(mixed $value, bool $default = false): bool
    {
        if (is_bool($value)) {
            return $value;
        }
        if (is_string($value)) {
            $result = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            return $result ?? $default;
        }
        return $default;
    }
}
