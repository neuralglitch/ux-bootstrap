<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\DropdownDivider;
use PHPUnit\Framework\TestCase;

final class DropdownDividerTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'dropdown_divider' => [
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new DropdownDivider($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('dropdown-divider', $options['classes']);
        $this->assertIsArray($options['attrs']);
    }

    public function testCustomClasses(): void
    {
        $component = new DropdownDivider($this->config);
        $component->class = 'custom-divider-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-divider-class', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new DropdownDivider($this->config);
        $component->attr = [
            'data-test' => 'divider',
            'role' => 'separator',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('divider', $options['attrs']['data-test']);
        $this->assertArrayHasKey('role', $options['attrs']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'dropdown_divider' => [
                'class' => 'default-divider-class',
            ],
        ]);

        $component = new DropdownDivider($config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('default-divider-class', $options['classes']);
    }

    public function testGetComponentName(): void
    {
        $component = new DropdownDivider($this->config);
        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('dropdown_divider', $method->invoke($component));
    }
}

