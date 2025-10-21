<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Toast;
use PHPUnit\Framework\TestCase;

final class ToastTest extends TestCase
{
    /** @param array<string, mixed> $config */
    private function createConfig(array $config = []): Config
    {
        return new Config(['toast' => $config]);
    }

    private function createToast(?Config $config = null): Toast
    {
        return new Toast($config ?? $this->createConfig());
    }

    public function testComponentHasCorrectDefaults(): void
    {
        $toast = $this->createToast();
        $toast->mount(); // Controller is set in mount()

        self::assertNull($toast->message);
        self::assertNull($toast->title);
        self::assertTrue($toast->header);
        self::assertTrue($toast->body);
        self::assertTrue($toast->autohide);
        self::assertSame(5000, $toast->delay);
        self::assertTrue($toast->animation);
        self::assertSame('top-0 end-0', $toast->position);
        self::assertSame('bs-toast', $toast->controller);
        self::assertNull($toast->variant);
        self::assertFalse($toast->outline);
        self::assertSame('', $toast->class);
        self::assertSame([], $toast->attr);
    }

    public function testMountAppliesConfigDefaults(): void
    {
        $config = $this->createConfig([
            'variant' => 'success',
            'title' => 'Success!',
            'header' => false,
            'body' => false,
            'autohide' => false,
            'delay' => 3000,
            'animation' => false,
            'position' => 'bottom-0 start-0',
            'controller' => 'custom-toast',
        ]);

        $toast = $this->createToast($config);
        $toast->delay = 0;
        $toast->position = '';
        $toast->mount();

        self::assertSame('success', $toast->variant);
        self::assertSame('Success!', $toast->title);
        self::assertFalse($toast->header);
        self::assertFalse($toast->body);
        self::assertFalse($toast->autohide);
        self::assertSame(3000, $toast->delay);
        self::assertFalse($toast->animation);
        self::assertSame('bottom-0 start-0', $toast->position);
        self::assertSame('custom-toast', $toast->controller);
    }

    public function testGetComponentName(): void
    {
        $toast = $this->createToast();

        $reflection = new \ReflectionClass($toast);
        $method = $reflection->getMethod('getComponentName');
        $method->setAccessible(true);

        self::assertSame('toast', $method->invoke($toast));
    }

    public function testOptionsReturnsCorrectStructure(): void
    {
        $toast = $this->createToast();
        $toast->mount();

        $options = $toast->options();

        self::assertIsArray($options);
        self::assertArrayHasKey('message', $options);
        self::assertArrayHasKey('title', $options);
        self::assertArrayHasKey('header', $options);
        self::assertArrayHasKey('body', $options);
        self::assertArrayHasKey('autohide', $options);
        self::assertArrayHasKey('delay', $options);
        self::assertArrayHasKey('animation', $options);
        self::assertArrayHasKey('position', $options);
        self::assertArrayHasKey('classes', $options);
        self::assertArrayHasKey('attrs', $options);
    }

    public function testOptionsBuildsCorrectClasses(): void
    {
        $toast = $this->createToast();
        $toast->mount();

        $options = $toast->options();

        self::assertStringContainsString('toast', $options['classes']);
    }

    public function testOptionsWithAnimation(): void
    {
        $toast = $this->createToast();
        $toast->animation = true;
        $toast->mount();

        $options = $toast->options();

        self::assertStringContainsString('fade', $options['classes']);
    }

    public function testOptionsWithoutAnimation(): void
    {
        $toast = $this->createToast();
        $toast->animation = false;
        $toast->mount();

        $options = $toast->options();

        self::assertStringNotContainsString('fade', $options['classes']);
    }

    public function testOptionsIncludesCustomClass(): void
    {
        $toast = $this->createToast();
        $toast->class = 'my-custom-class another-class';
        $toast->mount();

        $options = $toast->options();

        self::assertStringContainsString('my-custom-class', $options['classes']);
        self::assertStringContainsString('another-class', $options['classes']);
    }

    public function testOptionsIncludesAriaAttributes(): void
    {
        $toast = $this->createToast();
        $toast->mount();

        $options = $toast->options();

        self::assertArrayHasKey('role', $options['attrs']);
        self::assertSame('alert', $options['attrs']['role']);
        self::assertArrayHasKey('aria-live', $options['attrs']);
        self::assertSame('assertive', $options['attrs']['aria-live']);
        self::assertArrayHasKey('aria-atomic', $options['attrs']);
        self::assertSame('true', $options['attrs']['aria-atomic']);
    }

    public function testOptionsIncludesBootstrapDataAttributes(): void
    {
        $toast = $this->createToast();
        $toast->autohide = true;
        $toast->delay = 3000;
        $toast->mount();

        $options = $toast->options();

        self::assertArrayHasKey('data-bs-autohide', $options['attrs']);
        self::assertSame('true', $options['attrs']['data-bs-autohide']);
        self::assertArrayHasKey('data-bs-delay', $options['attrs']);
        self::assertSame('3000', $options['attrs']['data-bs-delay']);
    }

    public function testOptionsWithAutohideFalse(): void
    {
        $toast = $this->createToast();
        $toast->autohide = false;
        $toast->mount();

        $options = $toast->options();

        self::assertArrayHasKey('data-bs-autohide', $options['attrs']);
        self::assertSame('false', $options['attrs']['data-bs-autohide']);
    }

    public function testOptionsIncludesStimulusAttributes(): void
    {
        $toast = $this->createToast();
        $toast->controller = 'bs-toast';
        $toast->mount();

        $options = $toast->options();

        self::assertArrayHasKey('data-controller', $options['attrs']);
        self::assertSame('bs-toast', $options['attrs']['data-controller']);
    }

    public function testOptionsMergesCustomAttributes(): void
    {
        $toast = $this->createToast();
        $toast->attr = [
            'id' => 'my-toast',
            'data-test' => 'value',
        ];
        $toast->mount();

        $options = $toast->options();

        self::assertArrayHasKey('id', $options['attrs']);
        self::assertSame('my-toast', $options['attrs']['id']);
        self::assertArrayHasKey('data-test', $options['attrs']);
        self::assertSame('value', $options['attrs']['data-test']);
    }

    public function testOptionsReturnsContentValues(): void
    {
        $toast = $this->createToast();
        $toast->message = 'Toast message';
        $toast->title = 'Toast title';
        $toast->header = true;
        $toast->body = true;
        $toast->position = 'top-0 start-0';
        $toast->mount();

        $options = $toast->options();

        self::assertSame('Toast message', $options['message']);
        self::assertSame('Toast title', $options['title']);
        self::assertTrue($options['header']);
        self::assertTrue($options['body']);
        self::assertSame('top-0 start-0', $options['position']);
    }

    public function testToastWithAllFeaturesEnabled(): void
    {
        $config = $this->createConfig([
            'variant' => 'success',
            'title' => 'Success',
            'autohide' => true,
            'delay' => 3000,
            'animation' => true,
        ]);

        $toast = $this->createToast($config);
        $toast->message = 'Operation completed successfully';
        $toast->position = 'top-0 end-0';
        $toast->class = 'custom-toast';
        $toast->attr = ['id' => 'success-toast'];
        $toast->delay = 0;
        $toast->mount();

        $options = $toast->options();

        self::assertSame('Operation completed successfully', $options['message']);
        self::assertSame('Success', $options['title']);
        self::assertTrue($options['autohide']);
        self::assertSame(3000, $options['delay']);
        self::assertTrue($options['animation']);
        self::assertStringContainsString('toast', $options['classes']);
        self::assertStringContainsString('fade', $options['classes']);
        self::assertStringContainsString('custom-toast', $options['classes']);
        self::assertArrayHasKey('id', $options['attrs']);
        self::assertArrayHasKey('data-bs-autohide', $options['attrs']);
        self::assertArrayHasKey('data-controller', $options['attrs']);
    }

    public function testEmptyConfigUsesAllDefaults(): void
    {
        $toast = $this->createToast($this->createConfig([]));
        $toast->mount();

        self::assertNull($toast->variant);
        self::assertTrue($toast->header);
        self::assertTrue($toast->body);
        self::assertTrue($toast->autohide);
        self::assertSame(5000, $toast->delay);
        self::assertTrue($toast->animation);
    }
}

