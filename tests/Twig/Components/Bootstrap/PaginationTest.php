<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Pagination;
use PHPUnit\Framework\TestCase;

final class PaginationTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'pagination' => [
                'aria_label' => 'Page navigation',
                'size' => null,
                'alignment' => null,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new Pagination($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('pagination', $options['classes']);
        $this->assertSame('Page navigation', $options['ariaLabel']);
        $this->assertArrayHasKey('attrs', $options);
    }

    public function testCustomAriaLabel(): void
    {
        $component = new Pagination($this->config);
        $component->ariaLabel = 'Search results pages';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Search results pages', $options['ariaLabel']);
    }

    public function testSizeSmall(): void
    {
        $component = new Pagination($this->config);
        $component->size = 'sm';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('pagination-sm', $options['classes']);
    }

    public function testSizeLarge(): void
    {
        $component = new Pagination($this->config);
        $component->size = 'lg';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('pagination-lg', $options['classes']);
    }

    public function testAlignmentCenter(): void
    {
        $component = new Pagination($this->config);
        $component->alignment = 'center';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('justify-content-center', $options['classes']);
    }

    public function testAlignmentEnd(): void
    {
        $component = new Pagination($this->config);
        $component->alignment = 'end';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('justify-content-end', $options['classes']);
    }

    public function testAlignmentNull(): void
    {
        $component = new Pagination($this->config);
        $component->alignment = null;
        $component->mount();
        $options = $component->options();

        $this->assertStringNotContainsString('justify-content', $options['classes']);
    }

    public function testCombinedOptions(): void
    {
        $component = new Pagination($this->config);
        $component->size = 'lg';
        $component->alignment = 'center';
        $component->ariaLabel = 'Product pages';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('pagination-lg', $options['classes']);
        $this->assertStringContainsString('justify-content-center', $options['classes']);
        $this->assertSame('Product pages', $options['ariaLabel']);
    }

    public function testCustomClasses(): void
    {
        $component = new Pagination($this->config);
        $component->class = 'custom-class another-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-class', $options['classes']);
        $this->assertStringContainsString('another-class', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new Pagination($this->config);
        $component->attr = [
            'data-test' => 'pagination',
            'id' => 'my-pagination',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('pagination', $options['attrs']['data-test']);
        $this->assertArrayHasKey('id', $options['attrs']);
        $this->assertSame('my-pagination', $options['attrs']['id']);
    }

    public function testConfigDefaults(): void
    {
        $config = new Config([
            'pagination' => [
                'aria_label' => 'Custom default label',
                'size' => 'sm',
                'alignment' => 'end',
                'class' => 'default-class',
                'attr' => [],
            ],
        ]);

        $component = new Pagination($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('Custom default label', $options['ariaLabel']);
        $this->assertStringContainsString('pagination-sm', $options['classes']);
        $this->assertStringContainsString('justify-content-end', $options['classes']);
        $this->assertStringContainsString('default-class', $options['classes']);
    }

    public function testGetComponentName(): void
    {
        $component = new Pagination($this->config);
        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('pagination', $method->invoke($component));
    }
}

