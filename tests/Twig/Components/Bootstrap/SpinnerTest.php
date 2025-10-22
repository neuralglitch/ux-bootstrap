<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Spinner;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class SpinnerTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'spinner' => [
                'type' => 'border',
                'variant' => null,
                'size' => null,
                'label' => 'Loading...',
                'role' => 'status',
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new Spinner($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('spinner-border', $options['classes']);
        $this->assertStringNotContainsString('spinner-grow', $options['classes']);
        $this->assertSame('Loading...', $options['label']);
        $this->assertArrayHasKey('role', $options['attrs']);
        $this->assertSame('status', $options['attrs']['role']);
    }

    public function testBorderType(): void
    {
        $component = new Spinner($this->config);
        $component->type = 'border';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('spinner-border', $options['classes']);
        $this->assertStringNotContainsString('spinner-grow', $options['classes']);
    }

    public function testGrowType(): void
    {
        $component = new Spinner($this->config);
        $component->type = 'grow';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('spinner-grow', $options['classes']);
        $this->assertStringNotContainsString('spinner-border', $options['classes']);
    }

    public function testPrimaryVariant(): void
    {
        $component = new Spinner($this->config);
        $component->variant = 'primary';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('text-primary', $options['classes']);
    }

    public function testSecondaryVariant(): void
    {
        $component = new Spinner($this->config);
        $component->variant = 'secondary';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('text-secondary', $options['classes']);
    }

    public function testSuccessVariant(): void
    {
        $component = new Spinner($this->config);
        $component->variant = 'success';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('text-success', $options['classes']);
    }

    public function testDangerVariant(): void
    {
        $component = new Spinner($this->config);
        $component->variant = 'danger';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('text-danger', $options['classes']);
    }

    public function testWarningVariant(): void
    {
        $component = new Spinner($this->config);
        $component->variant = 'warning';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('text-warning', $options['classes']);
    }

    public function testInfoVariant(): void
    {
        $component = new Spinner($this->config);
        $component->variant = 'info';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('text-info', $options['classes']);
    }

    public function testLightVariant(): void
    {
        $component = new Spinner($this->config);
        $component->variant = 'light';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('text-light', $options['classes']);
    }

    public function testDarkVariant(): void
    {
        $component = new Spinner($this->config);
        $component->variant = 'dark';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('text-dark', $options['classes']);
    }

    public function testSmallSize(): void
    {
        $component = new Spinner($this->config);
        $component->size = 'sm';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('spinner-border-sm', $options['classes']);
    }

    public function testSmallSizeWithGrowType(): void
    {
        $component = new Spinner($this->config);
        $component->type = 'grow';
        $component->size = 'sm';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('spinner-grow-sm', $options['classes']);
    }

    public function testCustomLabel(): void
    {
        $component = new Spinner($this->config);
        $component->label = 'Please wait...';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Please wait...', $options['label']);
    }

    public function testCustomRole(): void
    {
        $component = new Spinner($this->config);
        $component->role = 'alert';
        $component->mount();
        $options = $component->options();

        $this->assertSame('alert', $options['attrs']['role']);
    }

    public function testCombinedOptions(): void
    {
        $component = new Spinner($this->config);
        $component->type = 'grow';
        $component->variant = 'primary';
        $component->size = 'sm';
        $component->label = 'Processing...';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('spinner-grow', $options['classes']);
        $this->assertStringContainsString('spinner-grow-sm', $options['classes']);
        $this->assertStringContainsString('text-primary', $options['classes']);
        $this->assertSame('Processing...', $options['label']);
    }

    public function testCustomClasses(): void
    {
        $component = new Spinner($this->config);
        $component->class = 'custom-class another-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-class', $options['classes']);
        $this->assertStringContainsString('another-class', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new Spinner($this->config);
        $component->attr = [
            'data-test' => 'spinner',
            'aria-hidden' => 'true',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('spinner', $options['attrs']['data-test']);
        $this->assertArrayHasKey('aria-hidden', $options['attrs']);
        $this->assertSame('true', $options['attrs']['aria-hidden']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'spinner' => [
                'type' => 'grow',
                'variant' => 'success',
                'size' => 'sm',
                'label' => 'Working...',
                'role' => 'status',
                'class' => 'default-class',
                'attr' => [],
            ],
        ]);

        $component = new Spinner($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('grow', $component->type);
        $this->assertSame('success', $component->variant);
        $this->assertSame('sm', $component->size);
        $this->assertSame('Working...', $component->label);
        $this->assertStringContainsString('default-class', $options['classes']);
    }

    public function testPropsOverrideConfigDefaults(): void
    {
        $config = new Config([
            'spinner' => [
                'type' => 'border',
                'variant' => 'primary',
                'size' => null,
                'label' => 'Loading...',
                'role' => 'status',
                'class' => null,
                'attr' => [],
            ],
        ]);

        $component = new Spinner($config);
        $component->type = 'grow';
        $component->variant = 'danger';
        $component->size = 'sm';
        $component->label = 'Custom label';
        $component->mount();
        $options = $component->options();

        $this->assertSame('grow', $component->type);
        $this->assertSame('danger', $component->variant);
        $this->assertSame('sm', $component->size);
        $this->assertSame('Custom label', $component->label);
        $this->assertStringContainsString('spinner-grow', $options['classes']);
        $this->assertStringContainsString('text-danger', $options['classes']);
    }

    public function testGetComponentName(): void
    {
        $component = new Spinner($this->config);
        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('spinner', $method->invoke($component));
    }
}

