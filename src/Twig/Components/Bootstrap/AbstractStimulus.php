<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\StimulusTrait;
use NeuralGlitch\UxBootstrap\Twig\Components\AbstractComponent;

/**
 * Base class for Bootstrap components with Stimulus controller support.
 *
 * This class provides comprehensive Stimulus controller management:
 * - Out-of-the-box interactivity with sensible defaults
 * - Easy controller disable/replace/extend via properties
 * - Consistent kebab-case data attributes
 * - Support for multiple controllers
 *
 * Usage Examples:
 *
 * 1. Default controller (automatic):
 *    <twig:bs:badge>Text</twig:bs:badge>
 *    // Renders: data-controller="bs-badge"
 *
 * 2. Disable controller:
 *    <twig:bs:badge :controller-enabled="false">Text</twig:bs:badge>
 *    // No data-controller attribute
 *
 * 3. Replace controller:
 *    <twig:bs:badge controller="my-custom-controller">Text</twig:bs:badge>
 *    // Renders: data-controller="my-custom-controller"
 *
 * 4. Extend with additional controllers:
 *    <twig:bs:badge controller="bs-badge my-animation">Text</twig:bs:badge>
 *    // Renders: data-controller="bs-badge my-animation"
 */
abstract class AbstractStimulus extends AbstractComponent
{
    use StimulusTrait;

    /**
     * Apply Stimulus controller defaults from config
     *
     * @param array<string, mixed> $defaults
     */
    protected function applyStimulusDefaults(array $defaults): void
    {
        if (!empty($defaults['controller']) && $this->controller === '') {
            $this->controller = $this->configStringWithFallback($defaults, 'controller', '');
        }

        if (isset($defaults['controller_enabled'])) {
            $this->controllerEnabled = $this->configBoolWithFallback($defaults, 'controller_enabled', false);
        }
    }

    /**
     * Initialize controller with default if not explicitly set.
     * Call this in mount() after applying all defaults.
     */
    protected function initializeController(): void
    {
        // If controller is not explicitly set, initialize with default
        if ($this->controller === '' && $this->shouldAttachController()) {
            $this->controller = $this->getDefaultController();
        }
    }

    /**
     * Get component name for default controller
     */
    protected function getComponentName(): string
    {
        // This should be implemented by the concrete component
        return '';
    }
}

