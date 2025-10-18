<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\DropdownHeader;
use PHPUnit\Framework\TestCase;

final class DropdownHeaderTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'dropdown_header' => [
                'label' => null,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new DropdownHeader($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('dropdown-header', $options['classes']);
        $this->assertIsArray($options['attrs']);
    }

    public function testLabelOption(): void
    {
        $component = new DropdownHeader($this->config);
        $component->label = 'Section Header';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Section Header', $options['label']);
    }

    public function testCustomClasses(): void
    {
        $component = new DropdownHeader($this->config);
        $component->class = 'custom-header-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-header-class', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new DropdownHeader($this->config);
        $component->attr = [
            'data-test' => 'header',
            'id' => 'menu-header',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('header', $options['attrs']['data-test']);
        $this->assertArrayHasKey('id', $options['attrs']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'dropdown_header' => [
                'label' => 'Default Header',
                'class' => 'default-header-class',
            ],
        ]);

        $component = new DropdownHeader($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('Default Header', $component->label);
        $this->assertStringContainsString('default-header-class', $options['classes']);
    }

    public function testGetComponentName(): void
    {
        $component = new DropdownHeader($this->config);
        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('dropdown_header', $method->invoke($component));
    }
}

