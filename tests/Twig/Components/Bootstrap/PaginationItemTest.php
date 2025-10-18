<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\PaginationItem;
use PHPUnit\Framework\TestCase;

final class PaginationItemTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'pagination_item' => [
                'active' => false,
                'disabled' => false,
                'aria_current' => 'page',
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new PaginationItem($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('page-item', $options['itemClasses']);
        $this->assertSame('page-link', $options['linkClasses']);
        $this->assertArrayHasKey('itemAttrs', $options);
        $this->assertArrayHasKey('linkAttrs', $options);
    }

    public function testWithHref(): void
    {
        $component = new PaginationItem($this->config);
        $component->href = '/page/2';
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['hasHref']);
        $this->assertSame('/page/2', $options['href']);
        $this->assertArrayHasKey('href', $options['linkAttrs']);
        $this->assertSame('/page/2', $options['linkAttrs']['href']);
    }

    public function testWithoutHref(): void
    {
        $component = new PaginationItem($this->config);
        $component->href = null;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['hasHref']);
        $this->assertArrayNotHasKey('href', $options['linkAttrs']);
    }

    public function testActiveState(): void
    {
        $component = new PaginationItem($this->config);
        $component->active = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('active', $options['itemClasses']);
    }

    public function testActiveWithHref(): void
    {
        $component = new PaginationItem($this->config);
        $component->active = true;
        $component->href = '/page/2';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('active', $options['itemClasses']);
        $this->assertArrayHasKey('aria-current', $options['linkAttrs']);
        $this->assertSame('page', $options['linkAttrs']['aria-current']);
    }

    public function testActiveWithoutHref(): void
    {
        $component = new PaginationItem($this->config);
        $component->active = true;
        $component->href = null;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('active', $options['itemClasses']);
        $this->assertArrayNotHasKey('aria-current', $options['linkAttrs']);
    }

    public function testDisabledState(): void
    {
        $component = new PaginationItem($this->config);
        $component->disabled = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('disabled', $options['itemClasses']);
        $this->assertArrayHasKey('tabindex', $options['linkAttrs']);
        $this->assertSame('-1', $options['linkAttrs']['tabindex']);
    }

    public function testAriaLabel(): void
    {
        $component = new PaginationItem($this->config);
        $component->ariaLabel = 'Previous page';
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('aria-label', $options['linkAttrs']);
        $this->assertSame('Previous page', $options['linkAttrs']['aria-label']);
    }

    public function testCustomAriaCurrent(): void
    {
        $component = new PaginationItem($this->config);
        $component->active = true;
        $component->href = '/page/2';
        $component->ariaCurrent = 'step';
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('aria-current', $options['linkAttrs']);
        $this->assertSame('step', $options['linkAttrs']['aria-current']);
    }

    public function testLabel(): void
    {
        $component = new PaginationItem($this->config);
        $component->label = 'Page 1';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Page 1', $options['label']);
    }

    public function testCombinedOptions(): void
    {
        $component = new PaginationItem($this->config);
        $component->href = '/page/3';
        $component->label = '3';
        $component->ariaLabel = 'Go to page 3';
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['hasHref']);
        $this->assertSame('/page/3', $options['href']);
        $this->assertSame('3', $options['label']);
        $this->assertSame('Go to page 3', $options['linkAttrs']['aria-label']);
    }

    public function testCustomClasses(): void
    {
        $component = new PaginationItem($this->config);
        $component->class = 'custom-item another-item';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-item', $options['itemClasses']);
        $this->assertStringContainsString('another-item', $options['itemClasses']);
    }

    public function testCustomAttributes(): void
    {
        $component = new PaginationItem($this->config);
        $component->attr = [
            'data-page' => '5',
            'data-test' => 'page-item',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-page', $options['itemAttrs']);
        $this->assertSame('5', $options['itemAttrs']['data-page']);
        $this->assertArrayHasKey('data-test', $options['itemAttrs']);
        $this->assertSame('page-item', $options['itemAttrs']['data-test']);
    }

    public function testConfigDefaults(): void
    {
        $config = new Config([
            'pagination_item' => [
                'active' => true,
                'disabled' => false,
                'aria_current' => 'location',
                'class' => 'default-class',
                'attr' => [],
            ],
        ]);

        $component = new PaginationItem($config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('active', $options['itemClasses']);
        $this->assertStringContainsString('default-class', $options['itemClasses']);
    }

    public function testDisabledAndActive(): void
    {
        $component = new PaginationItem($this->config);
        $component->disabled = true;
        $component->active = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('disabled', $options['itemClasses']);
        $this->assertStringContainsString('active', $options['itemClasses']);
    }

    public function testGetComponentName(): void
    {
        $component = new PaginationItem($this->config);
        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('pagination_item', $method->invoke($component));
    }
}

