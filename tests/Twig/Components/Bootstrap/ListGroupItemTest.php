<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\ListGroupItem;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class ListGroupItemTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'list_group_item' => [
                'tag' => 'li',
                'action' => false,
                'active' => false,
                'disabled' => false,
                'variant' => null,
                'target' => null,
                'rel' => null,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new ListGroupItem($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('li', $options['tag']);
        $this->assertStringContainsString('list-group-item', $options['classes']);
        $this->assertStringNotContainsString('list-group-item-action', $options['classes']);
        $this->assertStringNotContainsString('active', $options['classes']);
        $this->assertStringNotContainsString('disabled', $options['classes']);
    }

    public function testActionOption(): void
    {
        $component = new ListGroupItem($this->config);
        $component->action = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('list-group-item-action', $options['classes']);
    }

    public function testActiveOption(): void
    {
        $component = new ListGroupItem($this->config);
        $component->active = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('active', $options['classes']);
        $this->assertArrayHasKey('aria-current', $options['attrs']);
        $this->assertSame('true', $options['attrs']['aria-current']);
    }

    public function testDisabledOptionForButton(): void
    {
        $component = new ListGroupItem($this->config);
        $component->tag = 'button';
        $component->disabled = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('disabled', $options['classes']);
        $this->assertArrayHasKey('disabled', $options['attrs']);
        $this->assertTrue($options['attrs']['disabled']);
    }

    public function testDisabledOptionForLink(): void
    {
        $component = new ListGroupItem($this->config);
        $component->tag = 'a';
        $component->disabled = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('disabled', $options['classes']);
        $this->assertArrayHasKey('aria-disabled', $options['attrs']);
        $this->assertSame('true', $options['attrs']['aria-disabled']);
    }

    public function testVariantOptions(): void
    {
        $variants = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'];

        foreach ($variants as $variant) {
            $component = new ListGroupItem($this->config);
            $component->variant = $variant;
            $component->mount();
            $options = $component->options();

            $this->assertStringContainsString("list-group-item-{$variant}", $options['classes']);
        }
    }

    public function testLinkWithHref(): void
    {
        $component = new ListGroupItem($this->config);
        $component->href = '/test-url';
        $component->mount();
        $options = $component->options();

        $this->assertSame('a', $options['tag']);
        $this->assertStringContainsString('list-group-item-action', $options['classes']);
        $this->assertArrayHasKey('href', $options['attrs']);
        $this->assertSame('/test-url', $options['attrs']['href']);
    }

    public function testLinkWithTarget(): void
    {
        $component = new ListGroupItem($this->config);
        $component->href = '/test-url';
        $component->target = '_blank';
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('target', $options['attrs']);
        $this->assertSame('_blank', $options['attrs']['target']);
    }

    public function testLinkWithRel(): void
    {
        $component = new ListGroupItem($this->config);
        $component->href = '/test-url';
        $component->rel = 'noopener noreferrer';
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('rel', $options['attrs']);
        $this->assertSame('noopener noreferrer', $options['attrs']['rel']);
    }

    public function testButtonTypeAttribute(): void
    {
        $component = new ListGroupItem($this->config);
        $component->tag = 'button';
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('type', $options['attrs']);
        $this->assertSame('button', $options['attrs']['type']);
        $this->assertStringContainsString('list-group-item-action', $options['classes']);
    }

    public function testAutoActionForLinks(): void
    {
        $component = new ListGroupItem($this->config);
        $component->href = '/test';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('list-group-item-action', $options['classes']);
    }

    public function testAutoActionForButtons(): void
    {
        $component = new ListGroupItem($this->config);
        $component->action = true;
        $component->tag = 'button';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('list-group-item-action', $options['classes']);
    }

    public function testLabelProp(): void
    {
        $component = new ListGroupItem($this->config);
        $component->label = 'Test Label';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Test Label', $options['label']);
    }

    public function testAriaLabel(): void
    {
        $component = new ListGroupItem($this->config);
        $component->ariaLabel = 'Accessible Label';
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('aria-label', $options['attrs']);
        $this->assertSame('Accessible Label', $options['attrs']['aria-label']);
    }

    public function testCustomAriaCurrent(): void
    {
        $component = new ListGroupItem($this->config);
        $component->active = true;
        $component->ariaCurrent = 'page';
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('aria-current', $options['attrs']);
        $this->assertSame('page', $options['attrs']['aria-current']);
    }

    public function testCustomClasses(): void
    {
        $component = new ListGroupItem($this->config);
        $component->class = 'd-flex justify-content-between';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('d-flex', $options['classes']);
        $this->assertStringContainsString('justify-content-between', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new ListGroupItem($this->config);
        $component->attr = [
            'data-bs-toggle' => 'list',
            'role' => 'tab',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-bs-toggle', $options['attrs']);
        $this->assertSame('list', $options['attrs']['data-bs-toggle']);
        $this->assertArrayHasKey('role', $options['attrs']);
        $this->assertSame('tab', $options['attrs']['role']);
    }

    public function testCombinedOptions(): void
    {
        $component = new ListGroupItem($this->config);
        $component->href = '/test';
        $component->active = true;
        $component->variant = 'primary';
        $component->class = 'custom-item';
        $component->mount();
        $options = $component->options();

        $this->assertSame('a', $options['tag']);
        $this->assertStringContainsString('list-group-item', $options['classes']);
        $this->assertStringContainsString('list-group-item-action', $options['classes']);
        $this->assertStringContainsString('active', $options['classes']);
        $this->assertStringContainsString('list-group-item-primary', $options['classes']);
        $this->assertStringContainsString('custom-item', $options['classes']);
        $this->assertArrayHasKey('href', $options['attrs']);
        $this->assertArrayHasKey('aria-current', $options['attrs']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'list_group_item' => [
                'tag' => 'button',
                'action' => true,
                'active' => true,
                'variant' => 'success',
                'class' => 'default-class',
            ],
        ]);

        $component = new ListGroupItem($config);
        $component->mount();
        $options = $component->options();

        $this->assertTrue($component->action);
        $this->assertTrue($component->active);
        $this->assertSame('success', $component->variant);
        $this->assertStringContainsString('default-class', $options['classes']);
    }

    public function testGetComponentName(): void
    {
        $component = new ListGroupItem($this->config);
        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('list_group_item', $method->invoke($component));
    }
}

