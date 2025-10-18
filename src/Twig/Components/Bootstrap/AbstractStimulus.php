<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\StimulusTrait;

/**
 * Base class for Bootstrap components with Stimulus controller support.
 */
abstract class AbstractStimulus extends AbstractBootstrap
{
    use StimulusTrait;

    public string $stimulusController;

    /**
     * Apply Stimulus controller defaults from config
     *
     * @param array<string, mixed> $defaults
     */
    protected function applyStimulusDefaults(array $defaults): void
    {
        if (!empty($defaults['stimulus_controller'])) {
            $this->stimulusController = (string)$defaults['stimulus_controller'];
        }
    }
}

