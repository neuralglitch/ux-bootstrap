<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\ButtonGroup;
use PHPUnit\Framework\TestCase;

final class ButtonGroupTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'button_group' => [
                'vertical' => false,
                'size' => null,
                'role' => 'group',
                'aria_label' => null,
                'aria_labelledby' => null,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new ButtonGroup($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('btn-group', $options['classes']);
        $this->assertArrayHasKey('role', $options['attrs']);
        $this->assertSame('group', $options['attrs']['role']);
    }

    public function testVerticalOption(): void
    {
        $component = new ButtonGroup($this->config);
        $component->vertical = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('btn-group-vertical', $options['classes']);
        $this->assertStringNotContainsString('btn-group ', $options['classes']);
    }

    public function testSizeLarge(): void
    {
        $component = new ButtonGroup($this->config);
        $component->size = 'lg';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('btn-group-lg', $options['classes']);
    }

    public function testSizeSmall(): void
    {
        $component = new ButtonGroup($this->config);
        $component->size = 'sm';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('btn-group-sm', $options['classes']);
    }

    public function testVerticalSizeLarge(): void
    {
        $component = new ButtonGroup($this->config);
        $component->vertical = true;
        $component->size = 'lg';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('btn-group-vertical', $options['classes']);
        // Size class is applied separately via SizeTrait
        $this->assertStringContainsString('btn-group-lg', $options['classes']);
    }

    public function testToolbarRole(): void
    {
        $component = new ButtonGroup($this->config);
        $component->role = 'toolbar';
        $component->mount();
        $options = $component->options();

        $this->assertSame('toolbar', $options['attrs']['role']);
    }

    public function testAriaLabel(): void
    {
        $component = new ButtonGroup($this->config);
        $component->ariaLabel = 'Button group example';
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('aria-label', $options['attrs']);
        $this->assertSame('Button group example', $options['attrs']['aria-label']);
    }

    public function testAriaLabelledby(): void
    {
        $component = new ButtonGroup($this->config);
        $component->ariaLabelledby = 'button-group-label';
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('aria-labelledby', $options['attrs']);
        $this->assertSame('button-group-label', $options['attrs']['aria-labelledby']);
    }

    public function testCustomClasses(): void
    {
        $component = new ButtonGroup($this->config);
        $component->class = 'custom-class another-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-class', $options['classes']);
        $this->assertStringContainsString('another-class', $options['classes']);
        $this->assertStringContainsString('btn-group', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new ButtonGroup($this->config);
        $component->attr = [
            'data-test' => 'value',
            'id' => 'button-group-1',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('value', $options['attrs']['data-test']);
        $this->assertArrayHasKey('id', $options['attrs']);
        $this->assertSame('button-group-1', $options['attrs']['id']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'button_group' => [
                'vertical' => true,
                'size' => 'lg',
                'role' => 'group',  // Role uses :? so default 'group' is kept unless explicitly set
                'aria_label' => 'Default label',
                'class' => 'default-class',
                'attr' => [],
            ],
        ]);

        $component = new ButtonGroup($config);
        $component->mount();
        $options = $component->options();

        $this->assertTrue($component->vertical);
        $this->assertSame('lg', $component->size);
        $this->assertSame('group', $component->role);  // Property default takes precedence with :?
        $this->assertSame('Default label', $component->ariaLabel);
        $this->assertStringContainsString('default-class', $options['classes']);
    }

    public function testOverrideConfigDefaults(): void
    {
        $config = new Config([
            'button_group' => [
                'vertical' => true,
                'size' => 'lg',
                'role' => 'toolbar',
                'aria_label' => 'Default label',
                'class' => null,
                'attr' => [],
            ],
        ]);

        $component = new ButtonGroup($config);
        $component->vertical = false;  // Will be overridden to true by OR logic
        $component->size = 'sm';       // Will override config (uses ??)
        $component->role = 'group';    // Property default 'group' takes precedence (uses :?)
        $component->ariaLabel = 'Custom label';  // Will override config (uses ??)
        $component->mount();
        $options = $component->options();

        // vertical uses OR logic, so config true always wins
        $this->assertTrue($component->vertical);
        // size uses ??, so property value wins
        $this->assertSame('sm', $component->size);
        // role uses :?, property default 'group' takes precedence
        $this->assertSame('group', $component->role);
        // ariaLabel uses ??, so property value wins
        $this->assertSame('Custom label', $component->ariaLabel);
    }

    public function testGetComponentName(): void
    {
        $component = new ButtonGroup($this->config);
        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('button_group', $method->invoke($component));
    }

    public function testWithoutAriaLabels(): void
    {
        $component = new ButtonGroup($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertArrayNotHasKey('aria-label', $options['attrs']);
        $this->assertArrayNotHasKey('aria-labelledby', $options['attrs']);
        $this->assertArrayHasKey('role', $options['attrs']);
    }

    public function testEmptyCustomClass(): void
    {
        $component = new ButtonGroup($this->config);
        $component->class = '';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('btn-group', $options['classes']);
        $this->assertStringNotContainsString('  ', $options['classes']); // No double spaces
    }
}

