<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Progress;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class ProgressTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'progress' => [
                'value' => 0,
                'min' => 0,
                'max' => 100,
                'show_label' => false,
                'height' => null,
                'variant' => null,
                'striped' => false,
                'animated' => false,
                'aria_label' => null,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new Progress($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('progress', $options['wrapperClasses']);
        $this->assertStringContainsString('progress-bar', $options['barClasses']);
        $this->assertEquals(0.0, $options['percentage']);
        $this->assertNull($options['label']);
        $this->assertArrayHasKey('role', $options['wrapperAttrs']);
        $this->assertSame('progressbar', $options['wrapperAttrs']['role']);
    }

    public function testValueOption(): void
    {
        $component = new Progress($this->config);
        $component->value = 50;
        $component->mount();
        $options = $component->options();

        $this->assertSame(50.0, $options['percentage']);
        $this->assertSame('50', $options['wrapperAttrs']['aria-valuenow']);
    }

    public function testShowLabelOption(): void
    {
        $component = new Progress($this->config);
        $component->value = 75;
        $component->showLabel = true;
        $component->mount();
        $options = $component->options();

        $this->assertSame('75%', $options['label']);
    }

    public function testCustomLabelOption(): void
    {
        $component = new Progress($this->config);
        $component->value = 50;
        $component->label = 'Loading...';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Loading...', $options['label']);
    }

    public function testCustomMinMaxOptions(): void
    {
        $component = new Progress($this->config);
        $component->value = 5;
        $component->min = 0;
        $component->max = 10;
        $component->mount();
        $options = $component->options();

        // 5 out of 10 is 50%
        $this->assertSame(50.0, $options['percentage']);
        $this->assertSame('0', $options['wrapperAttrs']['aria-valuemin']);
        $this->assertSame('10', $options['wrapperAttrs']['aria-valuemax']);
    }

    public function testValueNormalization(): void
    {
        $component = new Progress($this->config);
        $component->value = 150; // Above max
        $component->mount();

        $this->assertSame(100, $component->value);
    }

    public function testValueNormalizationBelowMin(): void
    {
        $component = new Progress($this->config);
        $component->value = -10; // Below min
        $component->mount();

        $this->assertSame(0, $component->value);
    }

    public function testHeightOption(): void
    {
        $component = new Progress($this->config);
        $component->height = '20px';
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('style', $options['wrapperAttrs']);
        $this->assertStringContainsString('height: 20px', $options['wrapperAttrs']['style']);
    }

    public function testVariantOption(): void
    {
        $component = new Progress($this->config);
        $component->variant = 'success';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('bg-success', $options['barClasses']);
    }

    public function testStripedOption(): void
    {
        $component = new Progress($this->config);
        $component->striped = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('progress-bar-striped', $options['barClasses']);
    }

    public function testAnimatedOption(): void
    {
        $component = new Progress($this->config);
        $component->animated = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('progress-bar-animated', $options['barClasses']);
    }

    public function testStripedAndAnimatedCombined(): void
    {
        $component = new Progress($this->config);
        $component->striped = true;
        $component->animated = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('progress-bar-striped', $options['barClasses']);
        $this->assertStringContainsString('progress-bar-animated', $options['barClasses']);
    }

    public function testAriaLabelOption(): void
    {
        $component = new Progress($this->config);
        $component->ariaLabel = 'File upload progress';
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('aria-label', $options['wrapperAttrs']);
        $this->assertSame('File upload progress', $options['wrapperAttrs']['aria-label']);
    }

    public function testCustomClasses(): void
    {
        $component = new Progress($this->config);
        $component->class = 'custom-progress another-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-progress', $options['wrapperClasses']);
        $this->assertStringContainsString('another-class', $options['wrapperClasses']);
    }

    public function testCustomAttributes(): void
    {
        $component = new Progress($this->config);
        $component->attr = [
            'data-test' => 'value',
            'id' => 'my-progress',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['wrapperAttrs']);
        $this->assertSame('value', $options['wrapperAttrs']['data-test']);
        $this->assertArrayHasKey('id', $options['wrapperAttrs']);
        $this->assertSame('my-progress', $options['wrapperAttrs']['id']);
    }

    public function testCombinedOptions(): void
    {
        $component = new Progress($this->config);
        $component->value = 65;
        $component->variant = 'warning';
        $component->striped = true;
        $component->animated = true;
        $component->showLabel = true;
        $component->height = '25px';
        $component->mount();
        $options = $component->options();

        $this->assertSame(65.0, $options['percentage']);
        $this->assertSame('65%', $options['label']);
        $this->assertStringContainsString('bg-warning', $options['barClasses']);
        $this->assertStringContainsString('progress-bar-striped', $options['barClasses']);
        $this->assertStringContainsString('progress-bar-animated', $options['barClasses']);
        $this->assertStringContainsString('height: 25px', $options['wrapperAttrs']['style']);
    }

    public function testFloatValues(): void
    {
        $component = new Progress($this->config);
        $component->value = 33.33;
        $component->mount();
        $options = $component->options();

        $this->assertSame(33.33, $options['percentage']);
        $this->assertSame('33.33', $options['wrapperAttrs']['aria-valuenow']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'progress' => [
                'value' => 25,
                'variant' => 'info',
                'striped' => true,
                'show_label' => true,
                'class' => 'default-class',
            ],
        ]);

        $component = new Progress($config);
        $component->mount();
        $options = $component->options();

        $this->assertEquals(25.0, $options['percentage']);
        $this->assertStringContainsString('bg-info', $options['barClasses']);
        $this->assertStringContainsString('progress-bar-striped', $options['barClasses']);
        $this->assertSame('25%', $options['label']);
        $this->assertStringContainsString('default-class', $options['wrapperClasses']);
    }

    public function testZeroPercentage(): void
    {
        $component = new Progress($this->config);
        $component->value = 0;
        $component->mount();
        $options = $component->options();

        $this->assertEquals(0.0, $options['percentage']);
    }

    public function testFullPercentage(): void
    {
        $component = new Progress($this->config);
        $component->value = 100;
        $component->mount();
        $options = $component->options();

        $this->assertEquals(100.0, $options['percentage']);
    }

    public function testGetComponentName(): void
    {
        $component = new Progress($this->config);
        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('progress', $method->invoke($component));
    }
}

