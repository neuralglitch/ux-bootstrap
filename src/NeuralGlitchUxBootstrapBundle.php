<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap;

use NeuralGlitch\UxBootstrap\DependencyInjection\NeuralGlitchUxBootstrapExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Bootstrap 5.3 Twig Components & Stimulus Controllers Bundle
 * 
 * Provides a complete set of reusable Bootstrap components for Symfony applications.
 */
final class NeuralGlitchUxBootstrapBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function getContainerExtension(): ExtensionInterface
    {
        if (null === $this->extension) {
            $this->extension = new NeuralGlitchUxBootstrapExtension();
        }

        return $this->extension;
    }
}

