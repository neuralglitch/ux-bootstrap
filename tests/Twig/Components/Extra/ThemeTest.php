<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\Theme;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class ThemeTest extends TestCase
{
    /** @param array<string, mixed> $config */
    private function createConfig(array $config = []): Config
    {
        return new Config(['theme-toggle' => $config]);
    }

    private function createTheme(?Config $config = null): Theme
    {
        return new Theme($config ?? $this->createConfig());
    }

    public function testComponentHasCorrectDefaults(): void
    {
        $theme = $this->createTheme();

        self::assertNull($theme->variant);
        self::assertNull($theme->initial);
        self::assertNull($theme->mode);
        self::assertFalse($theme->outline);
        self::assertSame('', $theme->class);
        self::assertSame([], $theme->attr);
    }

    public function testMountAppliesConfigDefaults(): void
    {
        $config = $this->createConfig([
            'variant' => 'primary',
            'outline' => true,
            'mode' => 'button-icon',
        ]);

        $theme = $this->createTheme($config);
        $theme->mount();

        self::assertSame('primary', $theme->variant);
        self::assertTrue($theme->outline);
        self::assertSame('button-icon', $theme->mode);
    }

    public function testGetComponentName(): void
    {
        $theme = $this->createTheme();

        $reflection = new ReflectionClass($theme);
        $method = $reflection->getMethod('getComponentName');
        $method->setAccessible(true);

        self::assertSame('theme', $method->invoke($theme));
    }

    public function testOptionsReturnsCorrectStructure(): void
    {
        $theme = $this->createTheme();
        $theme->mount();

        $options = $theme->options();

        self::assertIsArray($options);
        self::assertArrayHasKey('mode', $options);
        self::assertArrayHasKey('variant', $options);
        self::assertArrayHasKey('initial', $options);
        self::assertArrayHasKey('classes', $options);
        self::assertArrayHasKey('attrs', $options);
    }

    public function testOptionsWithDefaultMode(): void
    {
        $theme = $this->createTheme();
        $theme->mount();

        $options = $theme->options();

        self::assertSame('button-icon', $options['mode']);
    }

    public function testOptionsWithCustomMode(): void
    {
        $theme = $this->createTheme();
        $theme->mode = 'dropdown-text';
        $theme->mount();

        $options = $theme->options();

        self::assertSame('dropdown-text', $options['mode']);
    }

    public function testOptionsWithDefaultVariant(): void
    {
        $theme = $this->createTheme();
        $theme->mount();

        $options = $theme->options();

        self::assertSame('outline-secondary', $options['variant']);
    }

    public function testOptionsWithCustomVariant(): void
    {
        $theme = $this->createTheme();
        $theme->variant = 'primary';
        $theme->mount();

        $options = $theme->options();

        self::assertSame('primary', $options['variant']);
    }

    public function testOptionsWithInitialTheme(): void
    {
        $theme = $this->createTheme();
        $theme->initial = 'dark';
        $theme->mount();

        $options = $theme->options();

        self::assertSame('dark', $options['initial']);
    }

    public function testOptionsIncludesStimulusController(): void
    {
        $theme = $this->createTheme();
        $theme->mount();

        $options = $theme->options();

        self::assertArrayHasKey('data-controller', $options['attrs']);
        self::assertSame('bs-theme', $options['attrs']['data-controller']);
    }

    public function testOptionsIncludesCustomClass(): void
    {
        $theme = $this->createTheme();
        $theme->class = 'my-custom-class another-class';
        $theme->mount();

        $options = $theme->options();

        self::assertStringContainsString('my-custom-class', $options['classes']);
        self::assertStringContainsString('another-class', $options['classes']);
    }

    public function testOptionsMergesCustomAttributes(): void
    {
        $theme = $this->createTheme();
        $theme->attr = [
            'id' => 'theme-toggle',
            'data-test' => 'value',
        ];
        $theme->mount();

        $options = $theme->options();

        self::assertArrayHasKey('id', $options['attrs']);
        self::assertSame('theme-toggle', $options['attrs']['id']);
        self::assertArrayHasKey('data-test', $options['attrs']);
        self::assertSame('value', $options['attrs']['data-test']);
    }

    public function testOptionsCustomAttributesOverrideStimulusController(): void
    {
        $theme = $this->createTheme();
        $theme->attr = ['data-controller' => 'custom-controller'];
        $theme->mount();

        $options = $theme->options();

        // Custom attributes override default controller
        self::assertArrayHasKey('data-controller', $options['attrs']);
        self::assertSame('custom-controller', $options['attrs']['data-controller']);
    }

    public function testThemeWithAllModesWork(): void
    {
        $modes = [
            'button-icon',
            'button-icon-toggle',
            'button-text',
            'button-icon-text',
            'dropdown-text',
            'dropdown-icon',
            'link',
            'link-icon',
            'form-select',
            'form-switch',
            'form-check',
        ];

        foreach ($modes as $mode) {
            $theme = $this->createTheme();
            $theme->mode = $mode;
            $theme->mount();

            $options = $theme->options();

            self::assertSame($mode, $options['mode']);
        }
    }

    public function testThemeWithAllFeaturesEnabled(): void
    {
        $config = $this->createConfig([
            'variant' => 'primary',
            'mode' => 'dropdown-icon',
        ]);

        $theme = $this->createTheme($config);
        $theme->initial = 'dark';
        $theme->class = 'custom-theme-toggle';
        $theme->attr = ['id' => 'main-theme-toggle'];
        $theme->mount();

        $options = $theme->options();

        self::assertSame('dropdown-icon', $options['mode']);
        self::assertSame('primary', $options['variant']);
        self::assertSame('dark', $options['initial']);
        self::assertStringContainsString('custom-theme-toggle', $options['classes']);
        self::assertArrayHasKey('id', $options['attrs']);
        self::assertArrayHasKey('data-controller', $options['attrs']);
    }

    public function testEmptyConfigUsesAllDefaults(): void
    {
        $theme = $this->createTheme($this->createConfig([]));
        $theme->mount();

        self::assertNull($theme->variant);
        self::assertNull($theme->mode);
        self::assertNull($theme->initial);
    }

    public function testVariantClassesForDifferentVariants(): void
    {
        $variants = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'];

        foreach ($variants as $variant) {
            $config = $this->createConfig(['variant' => $variant]);
            $theme = $this->createTheme($config);
            $theme->mount();

            $options = $theme->options();

            self::assertSame($variant, $options['variant']);
        }
    }
}

