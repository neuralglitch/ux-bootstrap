<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\DropdownItem;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class DropdownItemTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'dropdown_item' => [
                'label' => null,
                'href' => null,
                'tag' => null,
                'active' => false,
                'disabled' => false,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new DropdownItem($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('dropdown-item', $options['classes']);
        $this->assertSame('button', $options['tag']);
        $this->assertArrayHasKey('type', $options['attrs']);
        $this->assertSame('button', $options['attrs']['type']);
    }

    public function testAutoTagDetectionForLinks(): void
    {
        $component = new DropdownItem($this->config);
        $component->href = '/test';
        $component->mount();
        $options = $component->options();

        $this->assertSame('a', $options['tag']);
        $this->assertArrayHasKey('href', $options['attrs']);
        $this->assertSame('/test', $options['attrs']['href']);
    }

    public function testAutoTagDetectionForButton(): void
    {
        $component = new DropdownItem($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('button', $options['tag']);
    }

    public function testExplicitTag(): void
    {
        $component = new DropdownItem($this->config);
        $component->tag = 'a';
        $component->mount();
        $options = $component->options();

        $this->assertSame('a', $options['tag']);
    }

    public function testLabelOption(): void
    {
        $component = new DropdownItem($this->config);
        $component->label = 'Test Item';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Test Item', $options['label']);
    }

    public function testActiveOption(): void
    {
        $component = new DropdownItem($this->config);
        $component->active = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('active', $options['classes']);
        $this->assertArrayHasKey('aria-current', $options['attrs']);
        $this->assertSame('true', $options['attrs']['aria-current']);
    }

    public function testDisabledOptionForButton(): void
    {
        $component = new DropdownItem($this->config);
        $component->disabled = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('disabled', $options['classes']);
        $this->assertArrayHasKey('disabled', $options['attrs']);
    }

    public function testDisabledOptionForLink(): void
    {
        $component = new DropdownItem($this->config);
        $component->href = '/test';
        $component->disabled = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('disabled', $options['classes']);
        $this->assertArrayHasKey('tabindex', $options['attrs']);
        $this->assertSame('-1', $options['attrs']['tabindex']);
        $this->assertArrayHasKey('aria-disabled', $options['attrs']);
        $this->assertSame('true', $options['attrs']['aria-disabled']);
    }

    public function testHrefOption(): void
    {
        $component = new DropdownItem($this->config);
        $component->href = '/action';
        $component->mount();
        $options = $component->options();

        $this->assertSame('a', $options['tag']);
        $this->assertArrayHasKey('href', $options['attrs']);
        $this->assertSame('/action', $options['attrs']['href']);
    }

    public function testCustomClasses(): void
    {
        $component = new DropdownItem($this->config);
        $component->class = 'custom-class another-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-class', $options['classes']);
        $this->assertStringContainsString('another-class', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new DropdownItem($this->config);
        $component->attr = [
            'data-test' => 'value',
            'data-action' => 'click->handler#method',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('value', $options['attrs']['data-test']);
        $this->assertArrayHasKey('data-action', $options['attrs']);
    }

    public function testCombinedActiveAndDisabled(): void
    {
        $component = new DropdownItem($this->config);
        $component->active = true;
        $component->disabled = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('active', $options['classes']);
        $this->assertStringContainsString('disabled', $options['classes']);
    }

    public function testLinkWithActiveState(): void
    {
        $component = new DropdownItem($this->config);
        $component->href = '/current-page';
        $component->active = true;
        $component->mount();
        $options = $component->options();

        $this->assertSame('a', $options['tag']);
        $this->assertStringContainsString('active', $options['classes']);
        $this->assertArrayHasKey('aria-current', $options['attrs']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'dropdown_item' => [
                'label' => 'Default Label',
                'active' => true,
                'class' => 'default-class',
            ],
        ]);

        $component = new DropdownItem($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('Default Label', $component->label);
        $this->assertTrue($component->active);
        $this->assertStringContainsString('default-class', $options['classes']);
    }

    public function testGetComponentName(): void
    {
        $component = new DropdownItem($this->config);
        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('dropdown_item', $method->invoke($component));
    }
}

