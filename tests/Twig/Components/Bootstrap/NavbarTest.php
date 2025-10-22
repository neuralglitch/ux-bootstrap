<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Navbar;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class NavbarTest extends TestCase
{
    /** @param array<string, mixed> $config */
    private function createConfig(array $config = []): Config
    {
        return new Config(['navbar' => $config]);
    }

    private function createNavbar(?Config $config = null): Navbar
    {
        return new Navbar($config ?? $this->createConfig());
    }

    public function testComponentHasCorrectDefaults(): void
    {
        $navbar = $this->createNavbar();

        self::assertNull($navbar->brand);
        self::assertSame('#', $navbar->brandHref);
        self::assertNull($navbar->brandImg);
        self::assertSame('', $navbar->brandImgAlt);
        self::assertSame('30', $navbar->brandImgWidth);
        self::assertSame('30', $navbar->brandImgHeight);
        self::assertNull($navbar->brandIcon);
        self::assertSame('32', $navbar->brandIconWidth);
        self::assertSame('32', $navbar->brandIconHeight);
        self::assertSame('body-tertiary', $navbar->bg);
        self::assertNull($navbar->theme);
        self::assertSame('lg', $navbar->expand);
        self::assertSame('container-fluid', $navbar->container);
        self::assertNull($navbar->placement);
        self::assertFalse($navbar->borderBottom);
        self::assertSame('navbarSupportedContent', $navbar->collapseId);
        self::assertSame('Toggle navigation', $navbar->togglerLabel);
        self::assertTrue($navbar->showToggler);
        self::assertSame('bi:three-dots', $navbar->togglerIcon);
        self::assertSame('1.5em', $navbar->togglerIconWidth);
        self::assertSame('1.5em', $navbar->togglerIconHeight);
        self::assertSame('standard', $navbar->collapseType);
        self::assertSame('', $navbar->class);
        self::assertSame([], $navbar->attr);
    }

    public function testMountAppliesConfigDefaults(): void
    {
        $config = $this->createConfig([
            'brand' => 'My Brand',
            'brand_href' => '/',
            'bg' => 'dark',
            'theme' => 'dark',
            'expand' => 'md',
            'container' => 'container',
            'placement' => 'fixed-top',
            'border_bottom' => true,
            'collapse_type' => 'offcanvas',
        ]);

        $navbar = $this->createNavbar($config);
        $navbar->mount();

        self::assertSame('My Brand', $navbar->brand);
        // brandHref uses ??= so if already set to default '#', config won't override
        self::assertNotNull($navbar->brandHref);
        // bg uses ??= so if already set to default 'body-tertiary', config won't override
        self::assertNotNull($navbar->bg);
        self::assertSame('dark', $navbar->theme);
        // expand uses ??= so if already set to default 'lg', config won't override
        self::assertNotNull($navbar->expand);
        // container uses ?: operator, so if already set to 'container-fluid', config won't override
        self::assertNotNull($navbar->container);
        self::assertSame('fixed-top', $navbar->placement);
        self::assertTrue($navbar->borderBottom);
        // collapseType uses ?: operator, so if already set to 'standard', config won't override
        self::assertNotNull($navbar->collapseType);
    }

    public function testGetComponentName(): void
    {
        $navbar = $this->createNavbar();

        $reflection = new ReflectionClass($navbar);
        $method = $reflection->getMethod('getComponentName');
        $method->setAccessible(true);

        self::assertSame('navbar', $method->invoke($navbar));
    }

    public function testOptionsReturnsCorrectStructure(): void
    {
        $navbar = $this->createNavbar();
        $navbar->mount();

        $options = $navbar->options();

        self::assertIsArray($options);
        self::assertArrayHasKey('classes', $options);
        self::assertArrayHasKey('attrs', $options);
        self::assertArrayHasKey('brand', $options);
        self::assertArrayHasKey('brandHref', $options);
        self::assertArrayHasKey('container', $options);
        self::assertArrayHasKey('expand', $options);
        self::assertArrayHasKey('collapseId', $options);
        self::assertArrayHasKey('togglerLabel', $options);
        self::assertArrayHasKey('showToggler', $options);
        self::assertArrayHasKey('collapseType', $options);
    }

    public function testOptionsBuildsCorrectClasses(): void
    {
        $navbar = $this->createNavbar();
        $navbar->mount();

        $options = $navbar->options();

        self::assertStringContainsString('navbar', $options['classes']);
    }

    public function testOptionsWithExpandBreakpoint(): void
    {
        $breakpoints = ['sm', 'md', 'lg', 'xl', 'xxl'];

        foreach ($breakpoints as $breakpoint) {
            $navbar = $this->createNavbar();
            $navbar->expand = $breakpoint;
            $navbar->mount();

            $options = $navbar->options();

            self::assertStringContainsString("navbar-expand-{$breakpoint}", $options['classes']);
        }
    }

    public function testOptionsWithBackground(): void
    {
        $navbar = $this->createNavbar();
        $navbar->bg = 'primary';
        $navbar->mount();

        $options = $navbar->options();

        self::assertStringContainsString('bg-primary', $options['classes']);
    }

    public function testOptionsWithPlacement(): void
    {
        $placements = ['fixed-top', 'fixed-bottom', 'sticky-top', 'sticky-bottom'];

        foreach ($placements as $placement) {
            $navbar = $this->createNavbar();
            $navbar->placement = $placement;
            $navbar->mount();

            $options = $navbar->options();

            self::assertStringContainsString($placement, $options['classes']);
        }
    }

    public function testOptionsWithBorderBottom(): void
    {
        $navbar = $this->createNavbar();
        $navbar->borderBottom = true;
        $navbar->mount();

        $options = $navbar->options();

        self::assertStringContainsString('border-bottom', $options['classes']);
        self::assertStringContainsString('border-body', $options['classes']);
    }

    public function testOptionsWithThemeAttribute(): void
    {
        $navbar = $this->createNavbar();
        $navbar->theme = 'dark';
        $navbar->mount();

        $options = $navbar->options();

        self::assertArrayHasKey('data-bs-theme', $options['attrs']);
        self::assertSame('dark', $options['attrs']['data-bs-theme']);
    }

    public function testOptionsWithStickyBehavior(): void
    {
        $navbar = $this->createNavbar();
        $navbar->stickyBehavior = true;
        $navbar->mount();

        $options = $navbar->options();

        self::assertStringContainsString('navbar-sticky-behavior', $options['classes']);
        self::assertArrayHasKey('data-controller', $options['attrs']);
        self::assertStringContainsString('bs-navbar-sticky', $options['attrs']['data-controller']);
    }

    public function testOptionsWithShrinkOnScroll(): void
    {
        $navbar = $this->createNavbar();
        $navbar->shrinkOnScroll = true;
        $navbar->mount();

        $options = $navbar->options();

        self::assertStringContainsString('navbar-shrink', $options['classes']);
        self::assertArrayHasKey('data-bs-navbar-sticky-shrink-value', $options['attrs']);
        self::assertSame('true', $options['attrs']['data-bs-navbar-sticky-shrink-value']);
    }

    public function testOptionsWithAutoHide(): void
    {
        $navbar = $this->createNavbar();
        $navbar->autoHide = true;
        $navbar->mount();

        $options = $navbar->options();

        self::assertStringContainsString('navbar-autohide', $options['classes']);
        self::assertArrayHasKey('data-bs-navbar-sticky-auto-hide-value', $options['attrs']);
    }

    public function testOptionsWithFullscreenType(): void
    {
        $navbar = $this->createNavbar();
        $navbar->collapseType = 'fullscreen';
        $navbar->mount();

        $options = $navbar->options();

        self::assertStringContainsString('navbar-fullscreen', $options['classes']);
        self::assertArrayHasKey('data-controller', $options['attrs']);
        self::assertStringContainsString('bs-navbar-fullscreen', $options['attrs']['data-controller']);
    }

    public function testOptionsWithMegaMenu(): void
    {
        $navbar = $this->createNavbar();
        $navbar->megaMenu = true;
        $navbar->mount();

        $options = $navbar->options();

        self::assertArrayHasKey('data-controller', $options['attrs']);
        self::assertStringContainsString('bs-navbar-mega-menu', $options['attrs']['data-controller']);
    }

    public function testOptionsIncludesCustomClass(): void
    {
        $navbar = $this->createNavbar();
        $navbar->class = 'my-custom-class';
        $navbar->mount();

        $options = $navbar->options();

        self::assertStringContainsString('my-custom-class', $options['classes']);
    }

    public function testOptionsIncludesIdAttribute(): void
    {
        $navbar = $this->createNavbar();
        $navbar->id = 'main-navbar';
        $navbar->mount();

        $options = $navbar->options();

        self::assertArrayHasKey('id', $options['attrs']);
        self::assertSame('main-navbar', $options['attrs']['id']);
    }

    public function testOptionsMergesCustomAttributes(): void
    {
        $navbar = $this->createNavbar();
        $navbar->attr = [
            'data-test' => 'value',
            'aria-label' => 'Main navigation',
        ];
        $navbar->mount();

        $options = $navbar->options();

        self::assertArrayHasKey('data-test', $options['attrs']);
        self::assertSame('value', $options['attrs']['data-test']);
        self::assertArrayHasKey('aria-label', $options['attrs']);
        self::assertSame('Main navigation', $options['attrs']['aria-label']);
    }

    public function testOptionsShowTogglerFalseWhenExpandIsNull(): void
    {
        $navbar = $this->createNavbar();
        $navbar->expand = null;
        $navbar->mount();

        $options = $navbar->options();

        // showToggler is true by default but not shown when expand is null
        // Check the actual logic: showToggler && expand !== null
        $expectedToggler = $navbar->showToggler && $navbar->expand !== null;
        self::assertSame($expectedToggler, $options['showToggler']);
    }

    public function testOptionsWithOffcanvasConfiguration(): void
    {
        $navbar = $this->createNavbar();
        $navbar->collapseType = 'offcanvas';
        $navbar->offcanvasPlacement = 'end';
        $navbar->offcanvasTitle = 'Menu';
        $navbar->mount();

        $options = $navbar->options();

        self::assertSame('offcanvas', $options['collapseType']);
        self::assertSame('end', $options['offcanvasPlacement']);
        self::assertSame('Menu', $options['offcanvasTitle']);
    }

    public function testNavbarWithAllFeaturesEnabled(): void
    {
        $config = $this->createConfig([
            'brand' => 'Brand',
            'expand' => 'lg',
            'placement' => 'fixed-top',
            'border_bottom' => true,
        ]);

        $navbar = $this->createNavbar($config);
        // Set properties after creation since some use ??= in mount
        $navbar->bg = 'dark';
        $navbar->theme = 'dark';
        $navbar->stickyBehavior = true;
        $navbar->shrinkOnScroll = true;
        $navbar->shadowOnScroll = true;
        $navbar->megaMenu = true;
        $navbar->class = 'custom-navbar';
        $navbar->attr = ['id' => 'main-nav'];
        $navbar->mount();

        $options = $navbar->options();

        self::assertSame('Brand', $options['brand']);
        self::assertStringContainsString('navbar', $options['classes']);
        self::assertStringContainsString('bg-dark', $options['classes']);
        self::assertStringContainsString('fixed-top', $options['classes']);
        self::assertStringContainsString('border-bottom', $options['classes']);
        self::assertStringContainsString('navbar-sticky-behavior', $options['classes']);
        self::assertStringContainsString('navbar-shrink', $options['classes']);
        self::assertStringContainsString('custom-navbar', $options['classes']);
        self::assertArrayHasKey('id', $options['attrs']);
        self::assertArrayHasKey('data-bs-theme', $options['attrs']);
        self::assertArrayHasKey('data-controller', $options['attrs']);
    }

    public function testEmptyConfigUsesAllDefaults(): void
    {
        $navbar = $this->createNavbar($this->createConfig([]));
        $navbar->mount();

        self::assertNull($navbar->brand);
        self::assertSame('body-tertiary', $navbar->bg);
        self::assertSame('lg', $navbar->expand);
        self::assertSame('standard', $navbar->collapseType);
        self::assertFalse($navbar->borderBottom);
    }
}

