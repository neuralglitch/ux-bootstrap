<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\Stat;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class StatTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'stat' => [
                'value' => '0',
                'label' => 'Statistic',
                'variant' => null,
                'icon' => null,
                'icon_position' => 'start',
                'trend' => null,
                'change' => null,
                'description' => null,
                'size' => 'default',
                'border' => false,
                'shadow' => false,
                'text_align' => 'start',
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new Stat($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('card', $options['cardClasses']);
        $this->assertStringContainsString('stat-card', $options['cardClasses']);
        $this->assertStringContainsString('border-0', $options['cardClasses']);
        $this->assertSame('0', $options['value']);
        $this->assertSame('Statistic', $options['label']);
    }

    public function testValueOption(): void
    {
        $component = new Stat($this->config);
        $component->value = 1250;
        $component->mount();
        $options = $component->options();

        $this->assertSame(1250, $options['value']);
    }

    public function testStringValueOption(): void
    {
        $component = new Stat($this->config);
        $component->value = '$1,250.00';
        $component->mount();
        $options = $component->options();

        $this->assertSame('$1,250.00', $options['value']);
    }

    public function testLabelOption(): void
    {
        $component = new Stat($this->config);
        $component->label = 'Total Revenue';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Total Revenue', $options['label']);
    }

    public function testVariantOption(): void
    {
        $component = new Stat($this->config);
        $component->variant = 'primary';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('border-primary', $options['cardClasses']);
        $this->assertStringContainsString('text-primary', $options['valueClasses']);
    }

    public function testVariantSuccess(): void
    {
        $component = new Stat($this->config);
        $component->variant = 'success';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('border-success', $options['cardClasses']);
        $this->assertStringContainsString('text-success', $options['valueClasses']);
    }

    public function testBorderOption(): void
    {
        $component = new Stat($this->config);
        $component->border = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('border', $options['cardClasses']);
        $this->assertStringNotContainsString('border-0', $options['cardClasses']);
    }

    public function testShadowOption(): void
    {
        $component = new Stat($this->config);
        $component->shadow = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('shadow-sm', $options['cardClasses']);
    }

    public function testSizeSmall(): void
    {
        $component = new Stat($this->config);
        $component->size = 'sm';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('p-3', $options['bodyClasses']);
        $this->assertStringContainsString('fs-4', $options['valueClasses']);
        $this->assertStringContainsString('small', $options['labelClasses']);
    }

    public function testSizeLarge(): void
    {
        $component = new Stat($this->config);
        $component->size = 'lg';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('p-4', $options['bodyClasses']);
        $this->assertStringContainsString('fs-1', $options['valueClasses']);
    }

    public function testIconOption(): void
    {
        $component = new Stat($this->config);
        $component->icon = '<svg>...</svg>';
        $component->mount();
        $options = $component->options();

        $this->assertSame('<svg>...</svg>', $options['icon']);
        $this->assertNotEmpty($options['iconClasses']);
    }

    public function testIconPositionStart(): void
    {
        $component = new Stat($this->config);
        $component->icon = '📊';
        $component->iconPosition = 'start';
        $component->mount();
        $options = $component->options();

        $this->assertSame('start', $options['iconPosition']);
        $this->assertStringContainsString('me-3', $options['iconClasses']);
        $this->assertStringContainsString('px-2', $options['iconClasses']);
    }

    public function testIconPositionEnd(): void
    {
        $component = new Stat($this->config);
        $component->icon = '📊';
        $component->iconPosition = 'end';
        $component->mount();
        $options = $component->options();

        $this->assertSame('end', $options['iconPosition']);
        $this->assertStringContainsString('ms-3', $options['iconClasses']);
        $this->assertStringContainsString('px-2', $options['iconClasses']);
    }

    public function testIconPositionTop(): void
    {
        $component = new Stat($this->config);
        $component->icon = '📊';
        $component->iconPosition = 'top';
        $component->mount();
        $options = $component->options();

        $this->assertSame('top', $options['iconPosition']);
        $this->assertStringContainsString('mb-3', $options['iconClasses']);
        $this->assertStringContainsString('px-3', $options['iconClasses']);
        $this->assertStringContainsString('d-flex', $options['bodyClasses']);
        $this->assertStringContainsString('flex-column', $options['bodyClasses']);
    }

    public function testTrendUp(): void
    {
        $component = new Stat($this->config);
        $component->trend = 'up';
        $component->mount();
        $options = $component->options();

        $this->assertSame('up', $options['trend']);
        $this->assertSame('↑', $options['trendIcon']);
        $this->assertStringContainsString('text-bg-success', $options['trendClasses']);
    }

    public function testTrendDown(): void
    {
        $component = new Stat($this->config);
        $component->trend = 'down';
        $component->mount();
        $options = $component->options();

        $this->assertSame('down', $options['trend']);
        $this->assertSame('↓', $options['trendIcon']);
        $this->assertStringContainsString('text-bg-danger', $options['trendClasses']);
    }

    public function testTrendNeutral(): void
    {
        $component = new Stat($this->config);
        $component->trend = 'neutral';
        $component->mount();
        $options = $component->options();

        $this->assertSame('neutral', $options['trend']);
        $this->assertSame('→', $options['trendIcon']);
        $this->assertStringContainsString('text-bg-secondary', $options['trendClasses']);
    }

    public function testChangeOption(): void
    {
        $component = new Stat($this->config);
        $component->change = '+12%';
        $component->trend = 'up';
        $component->mount();
        $options = $component->options();

        $this->assertSame('+12%', $options['change']);
    }

    public function testDescriptionOption(): void
    {
        $component = new Stat($this->config);
        $component->description = 'vs. last month';
        $component->mount();
        $options = $component->options();

        $this->assertSame('vs. last month', $options['description']);
    }

    public function testTextAlignCenter(): void
    {
        $component = new Stat($this->config);
        $component->textAlign = 'center';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('text-center', $options['bodyClasses']);
    }

    public function testTextAlignEnd(): void
    {
        $component = new Stat($this->config);
        $component->textAlign = 'end';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('text-end', $options['bodyClasses']);
    }

    public function testCombinedOptions(): void
    {
        $component = new Stat($this->config);
        $component->value = '$52,430';
        $component->label = 'Total Revenue';
        $component->variant = 'success';
        $component->icon = '💰';
        $component->trend = 'up';
        $component->change = '+12.5%';
        $component->description = 'vs. last month';
        $component->size = 'lg';
        $component->border = true;
        $component->shadow = true;
        $component->mount();
        $options = $component->options();

        $this->assertSame('$52,430', $options['value']);
        $this->assertSame('Total Revenue', $options['label']);
        $this->assertStringContainsString('border-success', $options['cardClasses']);
        $this->assertStringContainsString('shadow-sm', $options['cardClasses']);
        $this->assertStringContainsString('fs-1', $options['valueClasses']);
        $this->assertSame('up', $options['trend']);
        $this->assertSame('+12.5%', $options['change']);
    }

    public function testCustomClasses(): void
    {
        $component = new Stat($this->config);
        $component->class = 'custom-stat-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-stat-class', $options['cardClasses']);
    }

    public function testCustomAttributes(): void
    {
        $component = new Stat($this->config);
        $component->attr = [
            'data-analytics' => 'revenue',
            'id' => 'stat-1',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-analytics', $options['attrs']);
        $this->assertSame('revenue', $options['attrs']['data-analytics']);
        $this->assertArrayHasKey('id', $options['attrs']);
        $this->assertSame('stat-1', $options['attrs']['id']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'stat' => [
                'value' => '100',
                'label' => 'Default Label',
                'variant' => 'primary',
                'border' => true,
                'size' => 'lg',
                'class' => 'default-class',
                'icon_position' => 'start',
                'trend' => null,
                'change' => null,
                'description' => null,
                'shadow' => false,
                'text_align' => 'start',
                'icon' => null,
                'attr' => [],
            ],
        ]);

        $component = new Stat($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('100', $options['value']);
        $this->assertSame('Default Label', $options['label']);
        $this->assertStringContainsString('border-primary', $options['cardClasses']);
        $this->assertStringContainsString('default-class', $options['cardClasses']);
        $this->assertStringContainsString('fs-1', $options['valueClasses']);
    }

    public function testGetComponentName(): void
    {
        $component = new Stat($this->config);
        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('stat', $method->invoke($component));
    }

    public function testWithNullValues(): void
    {
        $component = new Stat($this->config);
        $component->variant = null;
        $component->icon = null;
        $component->trend = null;
        $component->change = null;
        $component->description = null;
        $component->mount();
        $options = $component->options();

        $this->assertNull($options['variant']);
        $this->assertNull($options['icon']);
        $this->assertNull($options['trend']);
        $this->assertNull($options['change']);
        $this->assertNull($options['description']);
    }

    public function testFloatValue(): void
    {
        $component = new Stat($this->config);
        $component->value = 98.7;
        $component->mount();
        $options = $component->options();

        $this->assertSame(98.7, $options['value']);
    }

    public function testBorderWithVariant(): void
    {
        $component = new Stat($this->config);
        $component->border = true;
        $component->variant = 'danger';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('border', $options['cardClasses']);
        $this->assertStringContainsString('border-danger', $options['cardClasses']);
    }
}

