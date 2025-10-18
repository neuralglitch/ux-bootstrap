<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\NavItem;
use PHPUnit\Framework\TestCase;

final class NavItemTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'nav_item' => [
                'label' => null,
                'href' => null,
                'active' => false,
                'disabled' => false,
                'tag' => 'a',
                'id' => null,
                'target' => null,
                'aria_current' => 'page',
                'wrapper' => true,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new NavItem($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('nav-link', $options['classes']);
        $this->assertTrue($options['wrapper']);
    }

    public function testLinkTag(): void
    {
        $component = new NavItem($this->config);
        $component->href = '/test';
        $component->mount();
        $options = $component->options();

        $this->assertSame('a', $options['tag']);
        $this->assertSame('/test', $options['attrs']['href']);
    }

    public function testButtonTagAutoDetection(): void
    {
        $component = new NavItem($this->config);
        // No href, not disabled -> should auto-detect as button
        $component->mount();
        $options = $component->options();

        $this->assertSame('button', $options['tag']);
        $this->assertSame('button', $options['attrs']['type']);
    }

    public function testActiveOption(): void
    {
        $component = new NavItem($this->config);
        $component->active = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('active', $options['classes']);
        $this->assertSame('page', $options['attrs']['aria-current']);
    }

    public function testActiveWithCustomAriaCurrent(): void
    {
        $component = new NavItem($this->config);
        $component->active = true;
        $component->ariaCurrent = 'location';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('active', $options['classes']);
        $this->assertSame('location', $options['attrs']['aria-current']);
    }

    public function testActiveWithBooleanAriaCurrent(): void
    {
        $component = new NavItem($this->config);
        $component->active = true;
        $component->ariaCurrent = true;
        $component->mount();
        $options = $component->options();

        $this->assertSame('true', $options['attrs']['aria-current']);
    }

    public function testDisabledOption(): void
    {
        $component = new NavItem($this->config);
        $component->disabled = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('disabled', $options['classes']);
        $this->assertSame('true', $options['attrs']['aria-disabled']);
        $this->assertSame('-1', $options['attrs']['tabindex']);
    }

    public function testLabelProp(): void
    {
        $component = new NavItem($this->config);
        $component->label = 'Test Label';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Test Label', $options['label']);
    }

    public function testTargetAttribute(): void
    {
        $component = new NavItem($this->config);
        $component->href = 'https://example.com';
        $component->target = '_blank';
        $component->mount();
        $options = $component->options();

        $this->assertSame('_blank', $options['attrs']['target']);
    }

    public function testIdAttribute(): void
    {
        $component = new NavItem($this->config);
        $component->id = 'my-nav-item';
        $component->mount();
        $options = $component->options();

        $this->assertSame('my-nav-item', $options['attrs']['id']);
    }

    public function testWrapperDisabled(): void
    {
        $component = new NavItem($this->config);
        $component->wrapper = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['wrapper']);
    }

    public function testCombinedOptions(): void
    {
        $component = new NavItem($this->config);
        $component->href = '/profile';
        $component->active = true;
        $component->target = '_self';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('nav-link', $options['classes']);
        $this->assertStringContainsString('active', $options['classes']);
        $this->assertSame('/profile', $options['attrs']['href']);
        $this->assertSame('_self', $options['attrs']['target']);
    }

    public function testCustomClasses(): void
    {
        $component = new NavItem($this->config);
        $component->class = 'custom-class another-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-class', $options['classes']);
        $this->assertStringContainsString('another-class', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new NavItem($this->config);
        $component->attr = [
            'data-test' => 'value',
            'data-bs-toggle' => 'tab',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('value', $options['attrs']['data-test']);
        $this->assertSame('tab', $options['attrs']['data-bs-toggle']);
    }

    public function testLinkWithoutHrefBecomesButton(): void
    {
        $component = new NavItem($this->config);
        $component->tag = 'a';
        $component->href = null;
        $component->mount();
        $options = $component->options();

        // Should auto-detect as button when no href
        $this->assertSame('button', $options['tag']);
        $this->assertSame('button', $options['attrs']['type']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'nav_item' => [
                'active' => true,
                'aria_current' => 'location',
                'wrapper' => false,
                'class' => 'default-class',
            ],
        ]);

        $component = new NavItem($config);
        $component->mount();
        $options = $component->options();

        $this->assertTrue($component->active);
        $this->assertSame('location', $component->ariaCurrent);
        $this->assertFalse($component->wrapper);
        $this->assertStringContainsString('default-class', $options['classes']);
    }

    public function testGetComponentName(): void
    {
        $component = new NavItem($this->config);
        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('nav_item', $method->invoke($component));
    }
}

