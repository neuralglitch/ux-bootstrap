<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Runtime;

use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\RuntimeExtensionInterface;

final class ThemeRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private readonly RequestStack $requestStack
    ) {
    }

    /**
     * Generate HTML attributes for theme support.
     *
     * Returns data-bs-theme and style attributes based on the current theme.
     * Safe to use in any HTML tag.
     *
     * @return string HTML attributes string (already escaped)
     */
    public function getHtmlThemeAttributes(): string
    {
        $request = $this->requestStack->getCurrentRequest();

        if ($request === null) {
            // Fallback when no request (CLI, tests, etc.)
            return 'data-bs-theme="auto" style="color-scheme: light dark;"';
        }

        $theme = $request->attributes->get('theme');
        $colorScheme = $request->attributes->get('color_scheme');
        
        // Fallback to defaults if null or empty
        if ($theme === null || $theme === '') {
            $theme = 'auto';
        } else {
            // Convert to string if not already
            $theme = (string) $theme;
        }
        
        if ($colorScheme === null || $colorScheme === '') {
            $colorScheme = 'light dark';
        } else {
            // Convert to string if not already
            $colorScheme = (string) $colorScheme;
        }

        return sprintf(
            'data-bs-theme="%s" style="color-scheme: %s;"',
            htmlspecialchars($theme, ENT_QUOTES | ENT_HTML5, 'UTF-8'),
            htmlspecialchars($colorScheme, ENT_QUOTES | ENT_HTML5, 'UTF-8')
        );
    }
}

