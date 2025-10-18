<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Dropdown;
use PHPUnit\Framework\TestCase;

final class DropdownTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'dropdown' => [
                'label' => 'Dropdown',
                'variant' => 'secondary',
                'outline' => false,
                'size' => null,
                'direction' => null,
                'menu_align' => null,
                'dark' => false,
                'split' => false,
                'split_label' => null,
                'auto_close' => null,
                'toggle_class' => null,
                'menu_class' => null,
                'menu_attr' => [],
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new Dropdown($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('dropdown', $options['wrapperClasses']);
        $this->assertStringContainsString('btn', $options['toggleClasses']);
        $this->assertStringContainsString('dropdown-toggle', $options['toggleClasses']);
        $this->assertStringContainsString('btn-secondary', $options['toggleClasses']);
        $this->assertStringContainsString('dropdown-menu', $options['menuClasses']);
        $this->assertSame('Dropdown', $options['label']);
        $this->assertFalse($options['split']);
    }

    public function testVariantOption(): void
    {
        $component = new Dropdown($this->config);
        $component->variant = 'primary';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('btn-primary', $options['toggleClasses']);
    }

    public function testOutlineOption(): void
    {
        $component = new Dropdown($this->config);
        $component->variant = 'danger';
        $component->outline = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('btn-outline-danger', $options['toggleClasses']);
        $this->assertStringNotContainsString('btn-danger', $options['toggleClasses']);
    }

    public function testSizeOption(): void
    {
        $component = new Dropdown($this->config);
        $component->size = 'lg';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('btn-lg', $options['toggleClasses']);
    }

    public function testSmallSizeOption(): void
    {
        $component = new Dropdown($this->config);
        $component->size = 'sm';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('btn-sm', $options['toggleClasses']);
    }

    public function testDropupDirection(): void
    {
        $component = new Dropdown($this->config);
        $component->direction = 'dropup';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('dropup', $options['wrapperClasses']);
    }

    public function testDropendDirection(): void
    {
        $component = new Dropdown($this->config);
        $component->direction = 'dropend';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('dropend', $options['wrapperClasses']);
    }

    public function testDropstartDirection(): void
    {
        $component = new Dropdown($this->config);
        $component->direction = 'dropstart';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('dropstart', $options['wrapperClasses']);
    }

    public function testMenuAlignment(): void
    {
        $component = new Dropdown($this->config);
        $component->menuAlign = 'end';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('dropdown-menu-end', $options['menuClasses']);
    }

    public function testResponsiveMenuAlignment(): void
    {
        $component = new Dropdown($this->config);
        $component->menuAlign = 'lg-end';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('dropdown-menu-lg-end', $options['menuClasses']);
    }

    public function testDarkOption(): void
    {
        $component = new Dropdown($this->config);
        $component->dark = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('dropdown-menu-dark', $options['menuClasses']);
    }

    public function testSplitButton(): void
    {
        $component = new Dropdown($this->config);
        $component->split = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['split']);
        $this->assertStringContainsString('btn-group', $options['wrapperClasses']);
        $this->assertStringContainsString('dropdown-toggle-split', $options['toggleClasses']);
    }

    public function testSplitButtonWithLabel(): void
    {
        $component = new Dropdown($this->config);
        $component->label = 'Action';
        $component->split = true;
        $component->splitLabel = 'Primary Action';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Primary Action', $options['splitLabel']);
    }

    public function testAutoCloseOption(): void
    {
        $component = new Dropdown($this->config);
        $component->autoClose = 'inside';
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-bs-auto-close', $options['toggleAttrs']);
        $this->assertSame('inside', $options['toggleAttrs']['data-bs-auto-close']);
    }

    public function testCustomToggleClass(): void
    {
        $component = new Dropdown($this->config);
        $component->toggleClass = 'custom-toggle-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-toggle-class', $options['toggleClasses']);
    }

    public function testCustomMenuClass(): void
    {
        $component = new Dropdown($this->config);
        $component->menuClass = 'custom-menu-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-menu-class', $options['menuClasses']);
    }

    public function testCustomClasses(): void
    {
        $component = new Dropdown($this->config);
        $component->class = 'custom-wrapper-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-wrapper-class', $options['wrapperClasses']);
    }

    public function testCustomAttributes(): void
    {
        $component = new Dropdown($this->config);
        $component->attr = [
            'data-test' => 'value',
            'id' => 'my-dropdown',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['wrapperAttrs']);
        $this->assertSame('value', $options['wrapperAttrs']['data-test']);
        $this->assertArrayHasKey('id', $options['wrapperAttrs']);
    }

    public function testCustomMenuAttributes(): void
    {
        $component = new Dropdown($this->config);
        $component->menuAttr = [
            'data-test' => 'menu-value',
            'aria-label' => 'Menu',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['menuAttrs']);
        $this->assertSame('menu-value', $options['menuAttrs']['data-test']);
    }

    public function testCombinedOptions(): void
    {
        $component = new Dropdown($this->config);
        $component->label = 'Actions';
        $component->variant = 'success';
        $component->size = 'lg';
        $component->direction = 'dropup';
        $component->menuAlign = 'end';
        $component->dark = true;
        $component->mount();
        $options = $component->options();

        $this->assertSame('Actions', $options['label']);
        $this->assertStringContainsString('dropup', $options['wrapperClasses']);
        $this->assertStringContainsString('btn-success', $options['toggleClasses']);
        $this->assertStringContainsString('btn-lg', $options['toggleClasses']);
        $this->assertStringContainsString('dropdown-menu-end', $options['menuClasses']);
        $this->assertStringContainsString('dropdown-menu-dark', $options['menuClasses']);
    }

    public function testToggleAttributesArePresent(): void
    {
        $component = new Dropdown($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('type', $options['toggleAttrs']);
        $this->assertSame('button', $options['toggleAttrs']['type']);
        $this->assertArrayHasKey('data-bs-toggle', $options['toggleAttrs']);
        $this->assertSame('dropdown', $options['toggleAttrs']['data-bs-toggle']);
        $this->assertArrayHasKey('aria-expanded', $options['toggleAttrs']);
        $this->assertSame('false', $options['toggleAttrs']['aria-expanded']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'dropdown' => [
                'label' => 'Custom Default',
                'variant' => 'primary',
                'size' => 'sm',
                'dark' => true,
                'class' => 'default-class',
            ],
        ]);

        $component = new Dropdown($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('Custom Default', $component->label);
        $this->assertSame('primary', $component->variant);
        $this->assertSame('sm', $component->size);
        $this->assertTrue($component->dark);
        $this->assertStringContainsString('default-class', $options['wrapperClasses']);
    }

    public function testGetComponentName(): void
    {
        $component = new Dropdown($this->config);
        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('dropdown', $method->invoke($component));
    }
}

