<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Placeholder;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class PlaceholderTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'placeholder' => [
                'col' => null,
                'size' => null,
                'animation' => null,
                'variant' => null,
                'width' => null,
                'tag' => 'span',
                'aria_hidden' => true,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new Placeholder($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('placeholder', $options['classes']);
        $this->assertSame('span', $options['tag']);
        $this->assertArrayHasKey('aria-hidden', $options['attrs']);
        $this->assertSame('true', $options['attrs']['aria-hidden']);
    }

    public function testColOption(): void
    {
        $component = new Placeholder($this->config);
        $component->col = '6';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('col-6', $options['classes']);
    }

    public function testColOptionFullWidth(): void
    {
        $component = new Placeholder($this->config);
        $component->col = '12';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('col-12', $options['classes']);
    }

    public function testSizeOptionLarge(): void
    {
        $component = new Placeholder($this->config);
        $component->size = 'lg';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('placeholder-lg', $options['classes']);
    }

    public function testSizeOptionSmall(): void
    {
        $component = new Placeholder($this->config);
        $component->size = 'sm';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('placeholder-sm', $options['classes']);
    }

    public function testSizeOptionExtraSmall(): void
    {
        $component = new Placeholder($this->config);
        $component->size = 'xs';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('placeholder-xs', $options['classes']);
    }

    public function testAnimationGlow(): void
    {
        $component = new Placeholder($this->config);
        $component->animation = 'glow';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('placeholder-glow', $options['classes']);
    }

    public function testAnimationWave(): void
    {
        $component = new Placeholder($this->config);
        $component->animation = 'wave';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('placeholder-wave', $options['classes']);
    }

    public function testVariantPrimary(): void
    {
        $component = new Placeholder($this->config);
        $component->variant = 'primary';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('bg-primary', $options['classes']);
    }

    public function testVariantDanger(): void
    {
        $component = new Placeholder($this->config);
        $component->variant = 'danger';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('bg-danger', $options['classes']);
    }

    public function testCustomWidth(): void
    {
        $component = new Placeholder($this->config);
        $component->width = '75%';
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('style', $options['attrs']);
        $this->assertStringContainsString('width: 75%', $options['attrs']['style']);
    }

    public function testCustomWidthPixels(): void
    {
        $component = new Placeholder($this->config);
        $component->width = '200px';
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('style', $options['attrs']);
        $this->assertStringContainsString('width: 200px', $options['attrs']['style']);
    }

    public function testCustomTag(): void
    {
        $component = new Placeholder($this->config);
        $component->tag = 'div';
        $component->mount();
        $options = $component->options();

        $this->assertSame('div', $options['tag']);
    }

    public function testAriaHiddenFalse(): void
    {
        $component = new Placeholder($this->config);
        $component->ariaHidden = false;
        $component->mount();
        $options = $component->options();

        $this->assertArrayNotHasKey('aria-hidden', $options['attrs']);
    }

    public function testCombinedOptions(): void
    {
        $component = new Placeholder($this->config);
        $component->col = '6';
        $component->size = 'lg';
        $component->variant = 'primary';
        $component->animation = 'glow';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('placeholder', $options['classes']);
        $this->assertStringContainsString('col-6', $options['classes']);
        $this->assertStringContainsString('placeholder-lg', $options['classes']);
        $this->assertStringContainsString('bg-primary', $options['classes']);
        $this->assertStringContainsString('placeholder-glow', $options['classes']);
    }

    public function testCustomClasses(): void
    {
        $component = new Placeholder($this->config);
        $component->class = 'custom-class another-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-class', $options['classes']);
        $this->assertStringContainsString('another-class', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new Placeholder($this->config);
        $component->attr = [
            'data-test' => 'value',
            'id' => 'my-placeholder',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('value', $options['attrs']['data-test']);
        $this->assertArrayHasKey('id', $options['attrs']);
        $this->assertSame('my-placeholder', $options['attrs']['id']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'placeholder' => [
                'col' => '6',
                'size' => 'lg',
                'variant' => 'secondary',
                'animation' => 'glow',
                'class' => 'default-class',
                'aria_hidden' => true,
            ],
        ]);

        $component = new Placeholder($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('6', $component->col);
        $this->assertSame('lg', $component->size);
        $this->assertSame('secondary', $component->variant);
        $this->assertSame('glow', $component->animation);
        $this->assertStringContainsString('default-class', $options['classes']);
    }

    public function testGetComponentName(): void
    {
        $component = new Placeholder($this->config);
        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('placeholder', $method->invoke($component));
    }
}

