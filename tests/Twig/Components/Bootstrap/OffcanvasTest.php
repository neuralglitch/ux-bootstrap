<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Offcanvas;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class OffcanvasTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'offcanvas' => [
                'placement' => 'start',
                'backdrop' => true,
                'scroll' => false,
                'keyboard' => true,
                'show' => false,
                'show_close_button' => true,
                'body_class' => null,
                'header_class' => null,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new Offcanvas($this->config);
        $component->id = 'testOffcanvas';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('offcanvas', $options['classes']);
        $this->assertStringContainsString('offcanvas-start', $options['classes']);
        $this->assertSame('testOffcanvas', $options['id']);
        $this->assertSame('-1', $options['attrs']['tabindex']);
        $this->assertTrue($options['showCloseButton']);
    }

    public function testPlacementStart(): void
    {
        $component = new Offcanvas($this->config);
        $component->id = 'testOffcanvas';
        $component->placement = 'start';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('offcanvas-start', $options['classes']);
    }

    public function testPlacementEnd(): void
    {
        $component = new Offcanvas($this->config);
        $component->id = 'testOffcanvas';
        $component->placement = 'end';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('offcanvas-end', $options['classes']);
    }

    public function testPlacementTop(): void
    {
        $component = new Offcanvas($this->config);
        $component->id = 'testOffcanvas';
        $component->placement = 'top';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('offcanvas-top', $options['classes']);
    }

    public function testPlacementBottom(): void
    {
        $component = new Offcanvas($this->config);
        $component->id = 'testOffcanvas';
        $component->placement = 'bottom';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('offcanvas-bottom', $options['classes']);
    }

    public function testShowOption(): void
    {
        $component = new Offcanvas($this->config);
        $component->id = 'testOffcanvas';
        $component->show = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('show', $options['classes']);
    }

    public function testBackdropStatic(): void
    {
        $component = new Offcanvas($this->config);
        $component->id = 'testOffcanvas';
        $component->backdrop = 'static';
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-bs-backdrop', $options['attrs']);
        $this->assertSame('static', $options['attrs']['data-bs-backdrop']);
    }

    public function testBackdropFalse(): void
    {
        $component = new Offcanvas($this->config);
        $component->id = 'testOffcanvas';
        $component->backdrop = false;
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-bs-backdrop', $options['attrs']);
        $this->assertSame('false', $options['attrs']['data-bs-backdrop']);
    }

    public function testBackdropTrue(): void
    {
        $component = new Offcanvas($this->config);
        $component->id = 'testOffcanvas';
        $component->backdrop = true;
        $component->mount();
        $options = $component->options();

        // When backdrop is true, no data attribute is added (it's the default)
        $this->assertArrayNotHasKey('data-bs-backdrop', $options['attrs']);
    }

    public function testScrollOption(): void
    {
        $component = new Offcanvas($this->config);
        $component->id = 'testOffcanvas';
        $component->scroll = true;
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-bs-scroll', $options['attrs']);
        $this->assertSame('true', $options['attrs']['data-bs-scroll']);
    }

    public function testKeyboardFalse(): void
    {
        $component = new Offcanvas($this->config);
        $component->id = 'testOffcanvas';
        $component->keyboard = false;
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-bs-keyboard', $options['attrs']);
        $this->assertSame('false', $options['attrs']['data-bs-keyboard']);
    }

    public function testWithTitle(): void
    {
        $component = new Offcanvas($this->config);
        $component->id = 'testOffcanvas';
        $component->title = 'Test Offcanvas Title';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Test Offcanvas Title', $options['title']);
        $this->assertArrayHasKey('aria-labelledby', $options['attrs']);
        $this->assertSame('testOffcanvasLabel', $options['attrs']['aria-labelledby']);
    }

    public function testWithoutTitle(): void
    {
        $component = new Offcanvas($this->config);
        $component->id = 'testOffcanvas';
        $component->mount();
        $options = $component->options();

        $this->assertNull($options['title']);
        $this->assertNull($options['attrs']['aria-labelledby']);
    }

    public function testShowCloseButtonFalse(): void
    {
        $component = new Offcanvas($this->config);
        $component->id = 'testOffcanvas';
        $component->showCloseButton = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['showCloseButton']);
    }

    public function testCustomBodyClass(): void
    {
        $component = new Offcanvas($this->config);
        $component->id = 'testOffcanvas';
        $component->bodyClass = 'custom-body-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('offcanvas-body', $options['bodyClasses']);
        $this->assertStringContainsString('custom-body-class', $options['bodyClasses']);
    }

    public function testCustomHeaderClass(): void
    {
        $component = new Offcanvas($this->config);
        $component->id = 'testOffcanvas';
        $component->headerClass = 'custom-header-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('offcanvas-header', $options['headerClasses']);
        $this->assertStringContainsString('custom-header-class', $options['headerClasses']);
    }

    public function testCustomClasses(): void
    {
        $component = new Offcanvas($this->config);
        $component->id = 'testOffcanvas';
        $component->class = 'custom-offcanvas another-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-offcanvas', $options['classes']);
        $this->assertStringContainsString('another-class', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new Offcanvas($this->config);
        $component->id = 'testOffcanvas';
        $component->attr = [
            'data-test' => 'value',
            'data-custom' => 'attribute',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('value', $options['attrs']['data-test']);
        $this->assertArrayHasKey('data-custom', $options['attrs']);
        $this->assertSame('attribute', $options['attrs']['data-custom']);
    }

    public function testAutoGeneratedId(): void
    {
        $component = new Offcanvas($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertNotNull($component->id);
        $this->assertStringStartsWith('offcanvas-', $component->id);
    }

    public function testCombinedOptions(): void
    {
        $component = new Offcanvas($this->config);
        $component->id = 'testOffcanvas';
        $component->placement = 'end';
        $component->backdrop = 'static';
        $component->scroll = true;
        $component->keyboard = false;
        $component->show = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('offcanvas-end', $options['classes']);
        $this->assertStringContainsString('show', $options['classes']);
        $this->assertSame('static', $options['attrs']['data-bs-backdrop']);
        $this->assertSame('true', $options['attrs']['data-bs-scroll']);
        $this->assertSame('false', $options['attrs']['data-bs-keyboard']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'offcanvas' => [
                'placement' => 'end',
                'backdrop' => false,
                'scroll' => true,
                'keyboard' => false,
                'show' => false,
                'show_close_button' => false,
                'body_class' => 'default-body-class',
                'header_class' => 'default-header-class',
                'class' => 'default-class',
                'attr' => [],
            ],
        ]);

        $component = new Offcanvas($config);
        $component->id = 'testOffcanvas';
        $component->mount();
        $options = $component->options();

        $this->assertSame('end', $component->placement);
        $this->assertFalse($component->backdrop);
        $this->assertTrue($component->scroll);
        $this->assertFalse($component->keyboard);
        $this->assertFalse($options['showCloseButton']);
        $this->assertStringContainsString('default-body-class', $options['bodyClasses']);
        $this->assertStringContainsString('default-header-class', $options['headerClasses']);
        $this->assertStringContainsString('default-class', $options['classes']);
    }

    public function testGetComponentName(): void
    {
        $component = new Offcanvas($this->config);
        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('offcanvas', $method->invoke($component));
    }
}

