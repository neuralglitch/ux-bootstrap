<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\HtmlAttributesTrait;

/**
 * Base class for all Bootstrap components providing common properties and methods.
 */
abstract class AbstractBootstrap
{
    use HtmlAttributesTrait;

    public string $class = '';

    /**
     * @var array<string, mixed>
     */
    public array $attr = [];

    public function __construct(protected readonly Config $config)
    {
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
     * Build CSS classes string from multiple arrays
     *
     * @param array<int, string> ...$classSets
     */
    protected function buildClasses(array ...$classSets): string
    {
        $classes = array_merge(...$classSets);
        return implode(' ', array_unique(array_filter($classes)));
    }

    /**
     * Get component name for config lookup
     */
    abstract protected function getComponentName(): string;
}

