<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Nav;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class NavTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'nav' => [
                'variant' => null,
                'fill' => false,
                'justified' => false,
                'vertical' => false,
                'align' => null,
                'tag' => 'ul',
                'id' => null,
                'role' => null,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new Nav($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('nav', $options['classes']);
        $this->assertSame('ul', $options['tag']);
        $this->assertTrue($options['isListTag']);
    }

    public function testTabsVariant(): void
    {
        $component = new Nav($this->config);
        $component->variant = 'tabs';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('nav', $options['classes']);
        $this->assertStringContainsString('nav-tabs', $options['classes']);
    }

    public function testPillsVariant(): void
    {
        $component = new Nav($this->config);
        $component->variant = 'pills';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('nav', $options['classes']);
        $this->assertStringContainsString('nav-pills', $options['classes']);
    }

    public function testUnderlineVariant(): void
    {
        $component = new Nav($this->config);
        $component->variant = 'underline';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('nav', $options['classes']);
        $this->assertStringContainsString('nav-underline', $options['classes']);
    }

    public function testFillOption(): void
    {
        $component = new Nav($this->config);
        $component->fill = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('nav-fill', $options['classes']);
    }

    public function testJustifiedOption(): void
    {
        $component = new Nav($this->config);
        $component->justified = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('nav-justified', $options['classes']);
    }

    public function testVerticalOption(): void
    {
        $component = new Nav($this->config);
        $component->vertical = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('flex-column', $options['classes']);
    }

    public function testVerticalResponsive(): void
    {
        $component = new Nav($this->config);
        $component->vertical = 'md';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('flex-md-column', $options['classes']);
    }

    public function testAlignCenter(): void
    {
        $component = new Nav($this->config);
        $component->align = 'center';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('justify-content-center', $options['classes']);
    }

    public function testAlignEnd(): void
    {
        $component = new Nav($this->config);
        $component->align = 'end';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('justify-content-end', $options['classes']);
    }

    public function testAlignStart(): void
    {
        $component = new Nav($this->config);
        $component->align = 'start';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('justify-content-start', $options['classes']);
    }

    public function testNavTag(): void
    {
        $component = new Nav($this->config);
        $component->tag = 'nav';
        $component->mount();
        $options = $component->options();

        $this->assertSame('nav', $options['tag']);
        $this->assertFalse($options['isListTag']);
        $this->assertSame('navigation', $options['attrs']['role']);
    }

    public function testDivTag(): void
    {
        $component = new Nav($this->config);
        $component->tag = 'div';
        $component->mount();
        $options = $component->options();

        $this->assertSame('div', $options['tag']);
        $this->assertFalse($options['isListTag']);
    }

    public function testOrderedListTag(): void
    {
        $component = new Nav($this->config);
        $component->tag = 'ol';
        $component->mount();
        $options = $component->options();

        $this->assertSame('ol', $options['tag']);
        $this->assertTrue($options['isListTag']);
        $this->assertSame('list', $options['attrs']['role']);
    }

    public function testCombinedOptions(): void
    {
        $component = new Nav($this->config);
        $component->variant = 'pills';
        $component->fill = true;
        $component->align = 'center';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('nav', $options['classes']);
        $this->assertStringContainsString('nav-pills', $options['classes']);
        $this->assertStringContainsString('nav-fill', $options['classes']);
        $this->assertStringContainsString('justify-content-center', $options['classes']);
    }

    public function testCustomClasses(): void
    {
        $component = new Nav($this->config);
        $component->class = 'custom-class another-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-class', $options['classes']);
        $this->assertStringContainsString('another-class', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new Nav($this->config);
        $component->attr = [
            'data-test' => 'value',
            'aria-label' => 'Main navigation',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('value', $options['attrs']['data-test']);
        $this->assertSame('Main navigation', $options['attrs']['aria-label']);
    }

    public function testIdAttribute(): void
    {
        $component = new Nav($this->config);
        $component->id = 'my-nav';
        $component->mount();
        $options = $component->options();

        $this->assertSame('my-nav', $options['attrs']['id']);
    }

    public function testCustomRole(): void
    {
        $component = new Nav($this->config);
        $component->role = 'tablist';
        $component->mount();
        $options = $component->options();

        $this->assertSame('tablist', $options['attrs']['role']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'nav' => [
                'variant' => 'tabs',
                'fill' => true,
                'tag' => 'nav',
                'class' => 'default-class',
            ],
        ]);

        $component = new Nav($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('tabs', $component->variant);
        $this->assertTrue($component->fill);
        $this->assertSame('nav', $component->tag);
        $this->assertStringContainsString('default-class', $options['classes']);
    }

    public function testGetComponentName(): void
    {
        $component = new Nav($this->config);
        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('nav', $method->invoke($component));
    }
}

