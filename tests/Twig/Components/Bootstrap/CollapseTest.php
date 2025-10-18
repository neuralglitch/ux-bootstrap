<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Collapse;
use PHPUnit\Framework\TestCase;

final class CollapseTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'collapse' => [
                'show' => false,
                'horizontal' => false,
                'parent' => null,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new Collapse($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('collapse', $options['classes']);
        $this->assertStringNotContainsString('show', $options['classes']);
        $this->assertStringNotContainsString('collapse-horizontal', $options['classes']);
    }

    public function testShowOption(): void
    {
        $component = new Collapse($this->config);
        $component->show = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('collapse', $options['classes']);
        $this->assertStringContainsString('show', $options['classes']);
    }

    public function testHorizontalOption(): void
    {
        $component = new Collapse($this->config);
        $component->horizontal = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('collapse', $options['classes']);
        $this->assertStringContainsString('collapse-horizontal', $options['classes']);
    }

    public function testCombinedOptions(): void
    {
        $component = new Collapse($this->config);
        $component->show = true;
        $component->horizontal = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('collapse', $options['classes']);
        $this->assertStringContainsString('show', $options['classes']);
        $this->assertStringContainsString('collapse-horizontal', $options['classes']);
    }

    public function testIdAttribute(): void
    {
        $component = new Collapse($this->config);
        $component->id = 'collapseExample';
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('id', $options['attrs']);
        $this->assertSame('collapseExample', $options['attrs']['id']);
    }

    public function testParentAttribute(): void
    {
        $component = new Collapse($this->config);
        $component->parent = '#accordionExample';
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-bs-parent', $options['attrs']);
        $this->assertSame('#accordionExample', $options['attrs']['data-bs-parent']);
    }

    public function testWithoutParentAttribute(): void
    {
        $component = new Collapse($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertArrayNotHasKey('data-bs-parent', $options['attrs']);
    }

    public function testCustomClasses(): void
    {
        $component = new Collapse($this->config);
        $component->class = 'custom-collapse my-collapse';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('collapse', $options['classes']);
        $this->assertStringContainsString('custom-collapse', $options['classes']);
        $this->assertStringContainsString('my-collapse', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new Collapse($this->config);
        $component->attr = [
            'data-custom' => 'value',
            'aria-labelledby' => 'headingOne',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-custom', $options['attrs']);
        $this->assertSame('value', $options['attrs']['data-custom']);
        $this->assertArrayHasKey('aria-labelledby', $options['attrs']);
        $this->assertSame('headingOne', $options['attrs']['aria-labelledby']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'collapse' => [
                'show' => true,
                'horizontal' => false,
                'parent' => '#accordion',
                'class' => 'default-collapse',
            ],
        ]);

        $component = new Collapse($config);
        $component->mount();
        $options = $component->options();

        $this->assertTrue($component->show);
        $this->assertStringContainsString('show', $options['classes']);
        $this->assertStringContainsString('default-collapse', $options['classes']);
        $this->assertArrayHasKey('data-bs-parent', $options['attrs']);
        $this->assertSame('#accordion', $options['attrs']['data-bs-parent']);
    }

    public function testComponentPropsOverrideConfigDefaults(): void
    {
        $config = new Config([
            'collapse' => [
                'show' => true,
                'horizontal' => true,
                'parent' => '#config-parent',
            ],
        ]);

        $component = new Collapse($config);
        $component->show = false;
        $component->horizontal = false;
        $component->parent = '#override-parent';
        $component->mount();
        $options = $component->options();

        $this->assertFalse($component->show);
        $this->assertFalse($component->horizontal);
        $this->assertStringNotContainsString('show', $options['classes']);
        $this->assertStringNotContainsString('collapse-horizontal', $options['classes']);
        $this->assertSame('#override-parent', $options['attrs']['data-bs-parent']);
    }

    public function testGetComponentName(): void
    {
        $component = new Collapse($this->config);
        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('collapse', $method->invoke($component));
    }

    public function testAllAttributesCombined(): void
    {
        $component = new Collapse($this->config);
        $component->id = 'multiCollapse';
        $component->show = true;
        $component->horizontal = true;
        $component->parent = '#multiParent';
        $component->class = 'multi-collapse';
        $component->attr = [
            'data-test' => 'multi',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('collapse', $options['classes']);
        $this->assertStringContainsString('show', $options['classes']);
        $this->assertStringContainsString('collapse-horizontal', $options['classes']);
        $this->assertStringContainsString('multi-collapse', $options['classes']);
        $this->assertSame('multiCollapse', $options['attrs']['id']);
        $this->assertSame('#multiParent', $options['attrs']['data-bs-parent']);
        $this->assertSame('multi', $options['attrs']['data-test']);
    }

    public function testWithEmptyClass(): void
    {
        $component = new Collapse($this->config);
        $component->class = '';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('collapse', $options['classes']);
        $this->assertStringNotContainsString('  ', $options['classes']); // No double spaces
    }

    public function testWithNullParent(): void
    {
        $component = new Collapse($this->config);
        $component->parent = null;
        $component->mount();
        $options = $component->options();

        $this->assertArrayNotHasKey('data-bs-parent', $options['attrs']);
    }

    public function testExplicitTrueOverridesConfigFalse(): void
    {
        $config = new Config([
            'collapse' => [
                'show' => false,
                'horizontal' => false,
            ],
        ]);

        $component = new Collapse($config);
        $component->show = true;
        $component->horizontal = true;
        $component->mount();

        $this->assertTrue($component->show);
        $this->assertTrue($component->horizontal);
    }

    public function testConfigDefaultsWhenNotSet(): void
    {
        $config = new Config([
            'collapse' => [
                'show' => true,
                'horizontal' => true,
            ],
        ]);

        $component = new Collapse($config);
        $component->mount();

        $this->assertTrue($component->show);
        $this->assertTrue($component->horizontal);
    }

    public function testNullPropertiesUseConfigDefaults(): void
    {
        $config = new Config([
            'collapse' => [
                'show' => true,
                'horizontal' => false,
            ],
        ]);

        $component = new Collapse($config);
        $component->show = null;
        $component->horizontal = null;
        $component->mount();

        $this->assertTrue($component->show);
        $this->assertFalse($component->horizontal);
    }
}

