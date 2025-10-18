<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class NeuralGlitchUxBootstrapExtension extends Extension
{
    public function getAlias(): string
    {
        return 'neuralglitch_ux_bootstrap';
    }

    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // Register configuration as parameter
        $container->setParameter('neuralglitch.ux_bootstrap', $config);
        
        // Load services
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../../config'));
        $loader->load('services.yaml');
    }
}

