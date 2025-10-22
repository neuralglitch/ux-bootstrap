<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\Faq;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class FaqTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'faq' => [
                'variant' => 'accordion',
                'title' => null,
                'lead' => null,
                'flush' => false,
                'always_open' => false,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new Faq($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('accordion', $options['variant']);
        $this->assertNull($options['title']);
        $this->assertNull($options['lead']);
        $this->assertFalse($options['flush']);
        $this->assertFalse($options['alwaysOpen']);
        $this->assertIsArray($options['items']);
        $this->assertEmpty($options['items']);
    }

    public function testAccordionVariant(): void
    {
        $component = new Faq($this->config);
        $component->variant = 'accordion';
        $component->mount();
        $options = $component->options();

        $this->assertSame('accordion', $options['variant']);
    }

    public function testSimpleVariant(): void
    {
        $component = new Faq($this->config);
        $component->variant = 'simple';
        $component->mount();
        $options = $component->options();

        $this->assertSame('simple', $options['variant']);
    }

    public function testCardVariant(): void
    {
        $component = new Faq($this->config);
        $component->variant = 'card';
        $component->mount();
        $options = $component->options();

        $this->assertSame('card', $options['variant']);
    }

    public function testBorderedVariant(): void
    {
        $component = new Faq($this->config);
        $component->variant = 'bordered';
        $component->mount();
        $options = $component->options();

        $this->assertSame('bordered', $options['variant']);
    }

    public function testWithTitle(): void
    {
        $component = new Faq($this->config);
        $component->title = 'Frequently Asked Questions';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Frequently Asked Questions', $options['title']);
    }

    public function testWithLead(): void
    {
        $component = new Faq($this->config);
        $component->lead = 'Find answers to common questions';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Find answers to common questions', $options['lead']);
    }

    public function testWithTitleAndLead(): void
    {
        $component = new Faq($this->config);
        $component->title = 'FAQ';
        $component->lead = 'Common questions';
        $component->mount();
        $options = $component->options();

        $this->assertSame('FAQ', $options['title']);
        $this->assertSame('Common questions', $options['lead']);
    }

    public function testFlushOption(): void
    {
        $component = new Faq($this->config);
        $component->flush = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['flush']);
    }

    public function testAlwaysOpenOption(): void
    {
        $component = new Faq($this->config);
        $component->alwaysOpen = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['alwaysOpen']);
    }

    public function testWithItems(): void
    {
        $items = [
            ['question' => 'What is this?', 'answer' => 'This is a FAQ.'],
            ['question' => 'How does it work?', 'answer' => 'It works great!'],
        ];

        $component = new Faq($this->config);
        $component->items = $items;
        $component->mount();
        $options = $component->options();

        $this->assertCount(2, $options['items']);
        $this->assertSame('What is this?', $options['items'][0]['question']);
        $this->assertSame('This is a FAQ.', $options['items'][0]['answer']);
        $this->assertSame('How does it work?', $options['items'][1]['question']);
        $this->assertSame('It works great!', $options['items'][1]['answer']);
    }

    public function testItemsWithCustomIds(): void
    {
        $items = [
            ['question' => 'Q1', 'answer' => 'A1', 'id' => 'custom-id-1'],
            ['question' => 'Q2', 'answer' => 'A2', 'id' => 'custom-id-2'],
        ];

        $component = new Faq($this->config);
        $component->items = $items;
        $component->mount();
        $options = $component->options();

        $this->assertSame('custom-id-1', $options['items'][0]['id']);
        $this->assertSame('custom-id-2', $options['items'][1]['id']);
    }

    public function testItemsWithAutoGeneratedIds(): void
    {
        $items = [
            ['question' => 'Q1', 'answer' => 'A1'],
            ['question' => 'Q2', 'answer' => 'A2'],
        ];

        $component = new Faq($this->config);
        $component->items = $items;
        $component->mount();
        $options = $component->options();

        $this->assertStringStartsWith('faq-', $options['items'][0]['id']);
        $this->assertStringStartsWith('faq-', $options['items'][1]['id']);
        $this->assertStringContainsString('-item-0', $options['items'][0]['id']);
        $this->assertStringContainsString('-item-1', $options['items'][1]['id']);
    }

    public function testAccordionIdGeneration(): void
    {
        $component = new Faq($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringStartsWith('faq-', $options['accordionId']);
    }

    public function testCustomAccordionId(): void
    {
        $component = new Faq($this->config);
        $component->accordionId = 'my-custom-faq';
        $component->mount();
        $options = $component->options();

        $this->assertSame('my-custom-faq', $options['accordionId']);
    }

    public function testCustomClasses(): void
    {
        $component = new Faq($this->config);
        $component->class = 'custom-class another-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-class', $options['classes']);
        $this->assertStringContainsString('another-class', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new Faq($this->config);
        $component->attr = [
            'data-test' => 'faq',
            'data-category' => 'support',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('faq', $options['attrs']['data-test']);
        $this->assertArrayHasKey('data-category', $options['attrs']);
        $this->assertSame('support', $options['attrs']['data-category']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'faq' => [
                'variant' => 'simple',
                'title' => 'Default FAQ Title',
                'flush' => true,
                'class' => 'default-class',
                'attr' => ['data-default' => 'value'],
            ],
        ]);

        $component = new Faq($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('simple', $options['variant']);
        $this->assertSame('Default FAQ Title', $options['title']);
        $this->assertTrue($options['flush']);
        $this->assertStringContainsString('default-class', $options['classes']);
        $this->assertArrayHasKey('data-default', $options['attrs']);
    }

    public function testEmptyItemsArray(): void
    {
        $component = new Faq($this->config);
        $component->items = [];
        $component->mount();
        $options = $component->options();

        $this->assertIsArray($options['items']);
        $this->assertEmpty($options['items']);
    }

    public function testCombinedOptions(): void
    {
        $component = new Faq($this->config);
        $component->variant = 'card';
        $component->title = 'FAQ Section';
        $component->lead = 'Get your answers';
        $component->flush = true;
        $component->alwaysOpen = true;
        $component->items = [
            ['question' => 'Q?', 'answer' => 'A!'],
        ];
        $component->class = 'my-faq';
        $component->mount();
        $options = $component->options();

        $this->assertSame('card', $options['variant']);
        $this->assertSame('FAQ Section', $options['title']);
        $this->assertSame('Get your answers', $options['lead']);
        $this->assertTrue($options['flush']);
        $this->assertTrue($options['alwaysOpen']);
        $this->assertCount(1, $options['items']);
        $this->assertStringContainsString('my-faq', $options['classes']);
    }

    public function testGetComponentName(): void
    {
        $component = new Faq($this->config);
        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('faq', $method->invoke($component));
    }
}

