<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\Timeline;
use PHPUnit\Framework\TestCase;

final class TimelineTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'timeline' => [
                'variant' => 'vertical',
                'align' => 'start',
                'show_line' => true,
                'line_style' => 'solid',
                'line_variant' => null,
                'size' => null,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new Timeline($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('timeline', $options['classes']);
        $this->assertStringContainsString('timeline-vertical', $options['classes']);
        $this->assertStringContainsString('timeline-align-start', $options['classes']);
        $this->assertStringContainsString('timeline-connected', $options['classes']);
        $this->assertSame('vertical', $options['variant']);
        $this->assertSame('start', $options['align']);
        $this->assertTrue($options['showLine']);
        $this->assertSame('solid', $options['lineStyle']);
    }

    public function testVerticalVariant(): void
    {
        $component = new Timeline($this->config);
        $component->variant = 'vertical';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('timeline-vertical', $options['classes']);
    }

    public function testHorizontalVariant(): void
    {
        $component = new Timeline($this->config);
        $component->variant = 'horizontal';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('timeline-horizontal', $options['classes']);
        $this->assertStringNotContainsString('timeline-align-', $options['classes']);
    }

    public function testAlternatingVariant(): void
    {
        $component = new Timeline($this->config);
        $component->variant = 'alternating';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('timeline-alternating', $options['classes']);
    }

    public function testCompactVariant(): void
    {
        $component = new Timeline($this->config);
        $component->variant = 'compact';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('timeline-compact', $options['classes']);
    }

    public function testAlignStart(): void
    {
        $component = new Timeline($this->config);
        $component->align = 'start';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('timeline-align-start', $options['classes']);
    }

    public function testAlignCenter(): void
    {
        $component = new Timeline($this->config);
        $component->align = 'center';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('timeline-align-center', $options['classes']);
    }

    public function testAlignEnd(): void
    {
        $component = new Timeline($this->config);
        $component->align = 'end';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('timeline-align-end', $options['classes']);
    }

    public function testShowLine(): void
    {
        $component = new Timeline($this->config);
        $component->showLine = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('timeline-connected', $options['classes']);
        $this->assertTrue($options['showLine']);
    }

    public function testHideLine(): void
    {
        $component = new Timeline($this->config);
        $component->showLine = false;
        $component->mount();
        $options = $component->options();

        $this->assertStringNotContainsString('timeline-connected', $options['classes']);
        $this->assertFalse($options['showLine']);
    }

    public function testLineStyleSolid(): void
    {
        $component = new Timeline($this->config);
        $component->lineStyle = 'solid';
        $component->mount();
        $options = $component->options();

        $this->assertStringNotContainsString('timeline-line-solid', $options['classes']);
        $this->assertSame('solid', $options['lineStyle']);
    }

    public function testLineStyleDashed(): void
    {
        $component = new Timeline($this->config);
        $component->lineStyle = 'dashed';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('timeline-line-dashed', $options['classes']);
        $this->assertSame('dashed', $options['lineStyle']);
    }

    public function testLineStyleDotted(): void
    {
        $component = new Timeline($this->config);
        $component->lineStyle = 'dotted';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('timeline-line-dotted', $options['classes']);
        $this->assertSame('dotted', $options['lineStyle']);
    }

    public function testLineVariant(): void
    {
        $component = new Timeline($this->config);
        $component->lineVariant = 'primary';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('timeline-line-primary', $options['classes']);
        $this->assertSame('primary', $options['lineVariant']);
    }

    public function testSizeSmall(): void
    {
        $component = new Timeline($this->config);
        $component->size = 'sm';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('timeline-sm', $options['classes']);
        $this->assertSame('sm', $options['size']);
    }

    public function testSizeLarge(): void
    {
        $component = new Timeline($this->config);
        $component->size = 'lg';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('timeline-lg', $options['classes']);
        $this->assertSame('lg', $options['size']);
    }

    public function testCustomClass(): void
    {
        $component = new Timeline($this->config);
        $component->class = 'custom-timeline extra-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-timeline', $options['classes']);
        $this->assertStringContainsString('extra-class', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new Timeline($this->config);
        $component->attr = [
            'data-test' => 'timeline',
            'id' => 'my-timeline',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('timeline', $options['attrs']['data-test']);
        $this->assertArrayHasKey('id', $options['attrs']);
        $this->assertSame('my-timeline', $options['attrs']['id']);
    }

    public function testCombinedOptions(): void
    {
        $component = new Timeline($this->config);
        $component->variant = 'vertical';
        $component->align = 'center';
        $component->showLine = true;
        $component->lineStyle = 'dashed';
        $component->lineVariant = 'primary';
        $component->size = 'lg';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('timeline-vertical', $options['classes']);
        $this->assertStringContainsString('timeline-align-center', $options['classes']);
        $this->assertStringContainsString('timeline-connected', $options['classes']);
        $this->assertStringContainsString('timeline-line-dashed', $options['classes']);
        $this->assertStringContainsString('timeline-line-primary', $options['classes']);
        $this->assertStringContainsString('timeline-lg', $options['classes']);
    }

    public function testConfigDefaults(): void
    {
        $config = new Config([
            'timeline' => [
                'variant' => 'horizontal',
                'align' => 'center',
                'show_line' => false,
                'line_style' => 'dotted',
                'line_variant' => 'success',
                'size' => 'sm',
                'class' => 'config-class',
                'attr' => ['data-config' => 'test'],
            ],
        ]);

        $component = new Timeline($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('horizontal', $component->variant);
        $this->assertSame('center', $component->align);
        $this->assertFalse($component->showLine);
        $this->assertSame('dotted', $component->lineStyle);
        $this->assertSame('success', $component->lineVariant);
        $this->assertSame('sm', $component->size);
        $this->assertStringContainsString('config-class', $options['classes']);
        $this->assertArrayHasKey('data-config', $options['attrs']);
    }

    public function testGetComponentName(): void
    {
        $component = new Timeline($this->config);
        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('timeline', $method->invoke($component));
    }
}

