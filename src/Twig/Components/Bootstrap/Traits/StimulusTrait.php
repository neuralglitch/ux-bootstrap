<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits;

trait StimulusTrait
{
    /**
     * @return array<string, string>
     */
    protected function stimulusAttributes(string $controller): array
    {
        return [
            'data-controller' => $controller,
        ];
    }
}
