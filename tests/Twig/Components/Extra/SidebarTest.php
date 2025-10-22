<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\Sidebar;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class SidebarTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'sidebar' => [
                'variant' => 'fixed',
                'position' => 'left',
                'width' => '280px',
                'mini_width' => '80px',
                'collapsed' => false,
                'collapsible' => true,
                'overlay' => false,
                'backdrop_close' => true,
                'mobile_breakpoint' => 'lg',
                'mobile_behavior' => 'overlay',
                'show_header' => false,
                'header_title' => null,
                'show_toggle' => true,
                'show_footer' => false,
                'bg' => null,
                'text_color' => null,
                'border' => false,
                'shadow' => false,
                'scrollable' => true,
                'z_index' => 1040,
                'transition' => 'slide',
                'transition_duration' => 300,
                'controller' => 'bs-sidebar',
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new Sidebar($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('ux-sidebar', $options['classes']);
        $this->assertStringContainsString('ux-sidebar--fixed', $options['classes']);
        $this->assertStringContainsString('ux-sidebar--left', $options['classes']);
        $this->assertStringContainsString('ux-sidebar--scrollable', $options['classes']);
        $this->assertSame('fixed', $options['variant']);
        $this->assertSame('left', $options['position']);
        $this->assertSame('280px', $options['width']);
        $this->assertFalse($options['collapsed']);

        $this->assertIsArray($options);
    }

    public function testVariantCollapsible(): void
    {
        $component = new Sidebar($this->config);
        $component->variant = 'collapsible';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('ux-sidebar--collapsible', $options['classes']);
        $this->assertSame('collapsible', $options['variant']);

        $this->assertIsArray($options);
    }

    public function testVariantOverlay(): void
    {
        $component = new Sidebar($this->config);
        $component->variant = 'overlay';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('ux-sidebar--overlay', $options['classes']);
        $this->assertSame('overlay', $options['variant']);

        $this->assertIsArray($options);
    }

    public function testVariantPush(): void
    {
        $component = new Sidebar($this->config);
        $component->variant = 'push';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('ux-sidebar--push', $options['classes']);
        $this->assertSame('push', $options['variant']);

        $this->assertIsArray($options);
    }

    public function testVariantMini(): void
    {
        $component = new Sidebar($this->config);
        $component->variant = 'mini';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('ux-sidebar--mini', $options['classes']);
        $this->assertSame('mini', $options['variant']);

        $this->assertIsArray($options);
    }

    public function testPositionRight(): void
    {
        $component = new Sidebar($this->config);
        $component->position = 'right';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('ux-sidebar--right', $options['classes']);
        $this->assertSame('right', $options['position']);

        $this->assertIsArray($options);
    }

    public function testCollapsedState(): void
    {
        $component = new Sidebar($this->config);
        $component->collapsed = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('ux-sidebar--collapsed', $options['classes']);
        $this->assertTrue($options['collapsed']);

        $this->assertIsArray($options);
    }

    public function testOverlayEnabled(): void
    {
        $component = new Sidebar($this->config);
        $component->overlay = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('ux-sidebar--with-overlay', $options['classes']);
        $this->assertTrue($options['overlay']);

        $this->assertIsArray($options);
    }

    public function testCustomWidth(): void
    {
        $component = new Sidebar($this->config);
        $component->width = '320px';
        $component->mount();
        $options = $component->options();

        $this->assertSame('320px', $options['width']);

        $this->assertIsArray($options);
    }

    public function testCustomMiniWidth(): void
    {
        $component = new Sidebar($this->config);
        $component->miniWidth = '60px';
        $component->mount();
        $options = $component->options();

        $this->assertSame('60px', $options['miniWidth']);

        $this->assertIsArray($options);
    }

    public function testBackgroundVariant(): void
    {
        $component = new Sidebar($this->config);
        $component->bg = 'dark';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('bg-dark', $options['classes']);

        $this->assertIsArray($options);
    }

    public function testTextColor(): void
    {
        $component = new Sidebar($this->config);
        $component->textColor = 'white';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('text-white', $options['classes']);

        $this->assertIsArray($options);
    }

    public function testBorder(): void
    {
        $component = new Sidebar($this->config);
        $component->border = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('border-end', $options['classes']);

        $this->assertIsArray($options);
    }

    public function testShadow(): void
    {
        $component = new Sidebar($this->config);
        $component->shadow = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('shadow', $options['classes']);

        $this->assertIsArray($options);
    }

    public function testHeaderEnabled(): void
    {
        $component = new Sidebar($this->config);
        $component->showHeader = true;
        $component->headerTitle = 'Admin Dashboard';
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['showHeader']);
        $this->assertSame('Admin Dashboard', $options['headerTitle']);

        $this->assertIsArray($options);
    }

    public function testFooterEnabled(): void
    {
        $component = new Sidebar($this->config);
        $component->showFooter = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['showFooter']);

        $this->assertIsArray($options);
    }

    public function testMobileBreakpoint(): void
    {
        $component = new Sidebar($this->config);
        $component->mobileBreakpoint = 'md';
        $component->mount();
        $options = $component->options();

        $this->assertSame('md', $options['mobileBreakpoint']);

        $this->assertIsArray($options);
    }

    public function testMobileBehavior(): void
    {
        $component = new Sidebar($this->config);
        $component->mobileBehavior = 'hidden';
        $component->mount();
        $options = $component->options();

        $this->assertSame('hidden', $options['mobileBehavior']);

        $this->assertIsArray($options);
    }

    public function testTransitionOptions(): void
    {
        $component = new Sidebar($this->config);
        $component->transition = 'fade';
        $component->transitionDuration = 500;
        $component->mount();
        $options = $component->options();

        $this->assertSame('fade', $options['transition']);

        $this->assertIsArray($options);
    }

    public function testStimulusController(): void
    {
        $component = new Sidebar($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-controller', $options['attrs']);
        $this->assertSame('bs-sidebar', $options['attrs']['data-controller']);

        $this->assertIsArray($options);
    }

    public function testCustomClasses(): void
    {
        $component = new Sidebar($this->config);
        $component->class = 'custom-sidebar my-sidebar';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-sidebar', $options['classes']);
        $this->assertStringContainsString('my-sidebar', $options['classes']);

        $this->assertIsArray($options);
    }

    public function testCustomAttributes(): void
    {
        $component = new Sidebar($this->config);
        $component->attr = [
            'data-test' => 'sidebar',
            'aria-label' => 'Main navigation',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('sidebar', $options['attrs']['data-test']);
        $this->assertArrayHasKey('aria-label', $options['attrs']);
        $this->assertSame('Main navigation', $options['attrs']['aria-label']);

        $this->assertIsArray($options);
    }

    public function testConfigDefaults(): void
    {
        $config = new Config([
            'sidebar' => [
                'variant' => 'overlay',
                'position' => 'right',
                'width' => '300px',
                'collapsed' => true,
                'bg' => 'primary',
                'class' => 'config-class',
            ],
        ]);

        $component = new Sidebar($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('overlay', $component->variant);
        $this->assertSame('right', $component->position);
        $this->assertSame('300px', $component->width);
        $this->assertTrue($component->collapsed);
        $this->assertStringContainsString('bg-primary', $options['classes']);
        $this->assertStringContainsString('config-class', $options['classes']);

        $this->assertIsArray($options);
    }

    public function testCombinedOptions(): void
    {
        $component = new Sidebar($this->config);
        $component->variant = 'mini';
        $component->position = 'right';
        $component->collapsed = true;
        $component->overlay = true;
        $component->bg = 'dark';
        $component->textColor = 'white';
        $component->border = true;
        $component->shadow = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('ux-sidebar--mini', $options['classes']);
        $this->assertStringContainsString('ux-sidebar--right', $options['classes']);
        $this->assertStringContainsString('ux-sidebar--collapsed', $options['classes']);
        $this->assertStringContainsString('ux-sidebar--with-overlay', $options['classes']);
        $this->assertStringContainsString('bg-dark', $options['classes']);
        $this->assertStringContainsString('text-white', $options['classes']);
        $this->assertStringContainsString('border-end', $options['classes']);
        $this->assertStringContainsString('shadow', $options['classes']);

        $this->assertIsArray($options);
    }

    public function testGetComponentName(): void
    {
        $component = new Sidebar($this->config);
        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('sidebar', $method->invoke($component));
    }
}

