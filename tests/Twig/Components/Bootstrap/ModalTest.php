<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Modal;
use PHPUnit\Framework\TestCase;

final class ModalTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'modal' => [
                'size' => null,
                'fullscreen' => false,
                'centered' => false,
                'scrollable' => false,
                'backdrop' => true,
                'keyboard' => true,
                'focus' => true,
                'animation' => true,
                'show_header' => true,
                'show_footer' => true,
                'show_close_button' => true,
                'close_label' => 'Close',
                'save_label' => 'Save changes',
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new Modal($this->config);
        $component->id = 'testModal';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('modal', $options['modalClasses']);
        $this->assertStringContainsString('fade', $options['modalClasses']);
        $this->assertStringContainsString('modal-dialog', $options['dialogClasses']);
        $this->assertSame('testModal', $options['attrs']['id']);
        $this->assertSame('-1', $options['attrs']['tabindex']);
        $this->assertSame('true', $options['attrs']['aria-hidden']);
        $this->assertTrue($options['showHeader']);
        $this->assertTrue($options['showFooter']);
        $this->assertTrue($options['showCloseButton']);
    }

    public function testSizeSmall(): void
    {
        $component = new Modal($this->config);
        $component->id = 'testModal';
        $component->size = 'sm';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('modal-sm', $options['dialogClasses']);
    }

    public function testSizeLarge(): void
    {
        $component = new Modal($this->config);
        $component->id = 'testModal';
        $component->size = 'lg';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('modal-lg', $options['dialogClasses']);
    }

    public function testSizeExtraLarge(): void
    {
        $component = new Modal($this->config);
        $component->id = 'testModal';
        $component->size = 'xl';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('modal-xl', $options['dialogClasses']);
    }

    public function testFullscreenTrue(): void
    {
        $component = new Modal($this->config);
        $component->id = 'testModal';
        $component->fullscreen = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('modal-fullscreen', $options['dialogClasses']);
    }

    public function testFullscreenBreakpoint(): void
    {
        $component = new Modal($this->config);
        $component->id = 'testModal';
        $component->fullscreen = 'md';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('modal-fullscreen-md-down', $options['dialogClasses']);
    }

    public function testCenteredOption(): void
    {
        $component = new Modal($this->config);
        $component->id = 'testModal';
        $component->centered = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('modal-dialog-centered', $options['dialogClasses']);
    }

    public function testScrollableOption(): void
    {
        $component = new Modal($this->config);
        $component->id = 'testModal';
        $component->scrollable = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('modal-dialog-scrollable', $options['dialogClasses']);
    }

    public function testStaticBackdrop(): void
    {
        $component = new Modal($this->config);
        $component->id = 'testModal';
        $component->backdrop = 'static';
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-bs-backdrop', $options['attrs']);
        $this->assertSame('static', $options['attrs']['data-bs-backdrop']);
    }

    public function testBackdropFalse(): void
    {
        $component = new Modal($this->config);
        $component->id = 'testModal';
        $component->backdrop = false;
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-bs-backdrop', $options['attrs']);
        $this->assertSame('false', $options['attrs']['data-bs-backdrop']);
    }

    public function testKeyboardFalse(): void
    {
        $component = new Modal($this->config);
        $component->id = 'testModal';
        $component->keyboard = false;
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-bs-keyboard', $options['attrs']);
        $this->assertSame('false', $options['attrs']['data-bs-keyboard']);
    }

    public function testNoAnimation(): void
    {
        $component = new Modal($this->config);
        $component->id = 'testModal';
        $component->animation = false;
        $component->mount();
        $options = $component->options();

        $this->assertStringNotContainsString('fade', $options['modalClasses']);
    }

    public function testWithTitle(): void
    {
        $component = new Modal($this->config);
        $component->id = 'testModal';
        $component->title = 'Test Modal Title';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Test Modal Title', $options['title']);
        $this->assertSame('testModalLabel', $options['titleId']);
        $this->assertArrayHasKey('aria-labelledby', $options['attrs']);
        $this->assertSame('testModalLabel', $options['attrs']['aria-labelledby']);
    }

    public function testWithoutTitle(): void
    {
        $component = new Modal($this->config);
        $component->id = 'testModal';
        $component->mount();
        $options = $component->options();

        $this->assertNull($options['title']);
        $this->assertNull($options['titleId']);
        $this->assertNull($options['attrs']['aria-labelledby']);
    }

    public function testShowHeaderFalse(): void
    {
        $component = new Modal($this->config);
        $component->id = 'testModal';
        $component->showHeader = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['showHeader']);
    }

    public function testShowFooterFalse(): void
    {
        $component = new Modal($this->config);
        $component->id = 'testModal';
        $component->showFooter = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['showFooter']);
    }

    public function testShowCloseButtonFalse(): void
    {
        $component = new Modal($this->config);
        $component->id = 'testModal';
        $component->showCloseButton = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['showCloseButton']);
    }

    public function testCustomLabels(): void
    {
        $component = new Modal($this->config);
        $component->id = 'testModal';
        $component->closeLabel = 'Cancel';
        $component->saveLabel = 'Submit';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Cancel', $options['closeLabel']);
        $this->assertSame('Submit', $options['saveLabel']);
    }

    public function testCustomClasses(): void
    {
        $component = new Modal($this->config);
        $component->id = 'testModal';
        $component->class = 'custom-modal another-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-modal', $options['modalClasses']);
        $this->assertStringContainsString('another-class', $options['modalClasses']);
    }

    public function testCustomAttributes(): void
    {
        $component = new Modal($this->config);
        $component->id = 'testModal';
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

    public function testCombinedOptions(): void
    {
        $component = new Modal($this->config);
        $component->id = 'testModal';
        $component->size = 'lg';
        $component->centered = true;
        $component->scrollable = true;
        $component->backdrop = 'static';
        $component->keyboard = false;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('modal-lg', $options['dialogClasses']);
        $this->assertStringContainsString('modal-dialog-centered', $options['dialogClasses']);
        $this->assertStringContainsString('modal-dialog-scrollable', $options['dialogClasses']);
        $this->assertSame('static', $options['attrs']['data-bs-backdrop']);
        $this->assertSame('false', $options['attrs']['data-bs-keyboard']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'modal' => [
                'size' => 'lg',
                'centered' => true,
                'animation' => false,
                'close_label' => 'Dismiss',
                'save_label' => 'Confirm',
                'fullscreen' => false,
                'scrollable' => false,
                'backdrop' => true,
                'keyboard' => true,
                'focus' => true,
                'show_header' => true,
                'show_footer' => true,
                'show_close_button' => true,
                'class' => 'default-class',
                'attr' => [],
            ],
        ]);

        $component = new Modal($config);
        $component->id = 'testModal';
        $component->mount();
        $options = $component->options();

        $this->assertSame('lg', $component->size);
        $this->assertTrue($component->centered);
        $this->assertFalse($component->animation);
        $this->assertSame('Dismiss', $options['closeLabel']);
        $this->assertSame('Confirm', $options['saveLabel']);
        $this->assertStringContainsString('default-class', $options['modalClasses']);
    }

    public function testGetComponentName(): void
    {
        $component = new Modal($this->config);
        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('modal', $method->invoke($component));
    }
}

