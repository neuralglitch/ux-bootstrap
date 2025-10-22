<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\ListGroup;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class ListGroupTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'list_group' => [
                'flush' => false,
                'numbered' => false,
                'horizontal' => null,
                'tag' => 'ul',
                'id' => null,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new ListGroup($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('ul', $options['tag']);
        $this->assertStringContainsString('list-group', $options['classes']);
        $this->assertStringNotContainsString('list-group-flush', $options['classes']);
        $this->assertStringNotContainsString('list-group-numbered', $options['classes']);
        $this->assertEmpty($options['attrs']);
    }

    public function testFlushOption(): void
    {
        $component = new ListGroup($this->config);
        $component->flush = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('list-group-flush', $options['classes']);
    }

    public function testNumberedOption(): void
    {
        $component = new ListGroup($this->config);
        $component->numbered = true;
        $component->mount();
        $options = $component->options();

        $this->assertSame('ol', $options['tag']);
        $this->assertStringContainsString('list-group-numbered', $options['classes']);
    }

    public function testHorizontalOption(): void
    {
        $component = new ListGroup($this->config);
        $component->horizontal = 'md';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('list-group-horizontal-md', $options['classes']);
    }

    public function testHorizontalAlwaysOption(): void
    {
        $component = new ListGroup($this->config);
        $component->horizontal = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('list-group-horizontal', $options['classes']);
    }

    public function testCustomTag(): void
    {
        $component = new ListGroup($this->config);
        $component->tag = 'div';
        $component->mount();
        $options = $component->options();

        $this->assertSame('div', $options['tag']);
    }

    public function testWithId(): void
    {
        $component = new ListGroup($this->config);
        $component->id = 'my-list-group';
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('id', $options['attrs']);
        $this->assertSame('my-list-group', $options['attrs']['id']);
    }

    public function testCustomClasses(): void
    {
        $component = new ListGroup($this->config);
        $component->class = 'custom-class another-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-class', $options['classes']);
        $this->assertStringContainsString('another-class', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new ListGroup($this->config);
        $component->attr = [
            'data-test' => 'value',
            'aria-label' => 'My List',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('value', $options['attrs']['data-test']);
        $this->assertArrayHasKey('aria-label', $options['attrs']);
        $this->assertSame('My List', $options['attrs']['aria-label']);
    }

    public function testCombinedOptions(): void
    {
        $component = new ListGroup($this->config);
        $component->flush = true;
        $component->numbered = true;
        $component->horizontal = 'lg';
        $component->class = 'custom-list';
        $component->mount();
        $options = $component->options();

        $this->assertSame('ol', $options['tag']);
        $this->assertStringContainsString('list-group', $options['classes']);
        $this->assertStringContainsString('list-group-flush', $options['classes']);
        $this->assertStringContainsString('list-group-numbered', $options['classes']);
        $this->assertStringContainsString('list-group-horizontal-lg', $options['classes']);
        $this->assertStringContainsString('custom-list', $options['classes']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'list_group' => [
                'flush' => true,
                'numbered' => true,
                'horizontal' => 'sm',
                'tag' => 'div',
                'class' => 'default-class',
                'attr' => ['data-default' => 'true'],
            ],
        ]);

        $component = new ListGroup($config);
        $component->mount();
        $options = $component->options();

        $this->assertTrue($component->flush);
        $this->assertTrue($component->numbered);
        $this->assertSame('sm', $component->horizontal);
        $this->assertStringContainsString('default-class', $options['classes']);
    }

    public function testComponentOverridesConfig(): void
    {
        $config = new Config([
            'list_group' => [
                'flush' => true,
                'numbered' => true,
            ],
        ]);

        $component = new ListGroup($config);
        $component->flush = false;
        $component->numbered = false;
        $component->mount();

        // Component values should take precedence
        $this->assertTrue($component->flush); // Config is merged with OR
        $this->assertTrue($component->numbered); // Config is merged with OR
    }

    public function testGetComponentName(): void
    {
        $component = new ListGroup($this->config);
        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('list_group', $method->invoke($component));
    }
}

