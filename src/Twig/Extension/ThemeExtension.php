<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Extension;

use NeuralGlitch\UxBootstrap\Twig\Runtime\ThemeRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class ThemeExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'ux_bootstrap_html_attrs',
                [ThemeRuntime::class, 'getHtmlThemeAttributes'],
                ['is_safe' => ['html']]
            ),
        ];
    }
}




