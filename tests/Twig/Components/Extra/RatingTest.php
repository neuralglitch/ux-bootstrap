<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\Rating;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class RatingTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'rating' => [
                'value' => 0,
                'max' => 5,
                'mode' => 'stars',
                'readonly' => false,
                'half_stars' => false,
                'size' => 'default',
                'variant' => null,
                'empty_variant' => 'secondary',
                'show_value' => false,
                'show_count' => false,
                'show_text' => false,
                'text_position' => 'end',
                'aria_live' => false,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new Rating($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertIsString($options['classes']);
        $this->assertStringContainsString('rating', $options['classes']);
        $this->assertStringContainsString('rating-stars', $options['classes']);
        $this->assertStringContainsString('rating-interactive', $options['classes']);
        $this->assertSame(0.0, $options['value']);
        $this->assertSame(5, $options['max']);
    }

    public function testReadonlyMode(): void
    {
        $component = new Rating($this->config);
        $component->readonly = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('rating-readonly', $options['classes']);
        $this->assertStringNotContainsString('rating-interactive', $options['classes']);
    }

    public function testValueOption(): void
    {
        $component = new Rating($this->config);
        $component->value = 3.5;
        $component->mount();
        $options = $component->options();

        $this->assertSame(3.5, $options['value']);
    }

    public function testMaxOption(): void
    {
        $component = new Rating($this->config);
        $component->max = 10;
        $component->mount();
        $options = $component->options();

        $this->assertSame(10, $options['max']);
        $this->assertCount(10, $options['items']);
    }

    public function testModeStars(): void
    {
        $component = new Rating($this->config);
        $component->mode = 'stars';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('rating-stars', $options['classes']);
        $this->assertSame('stars', $options['mode']);
    }

    public function testModeHearts(): void
    {
        $component = new Rating($this->config);
        $component->mode = 'hearts';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('rating-hearts', $options['classes']);
        $this->assertSame('hearts', $options['mode']);
    }

    public function testModeCircles(): void
    {
        $component = new Rating($this->config);
        $component->mode = 'circles';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('rating-circles', $options['classes']);
        $this->assertSame('circles', $options['mode']);
    }

    public function testHalfStarsEnabled(): void
    {
        $component = new Rating($this->config);
        $component->halfStars = true;
        $component->value = 3.5;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['halfStars']);

        // Check that we have half-star item
        $halfStarItems = array_filter($options['items'], fn($item) => $item['state'] === 'half');
        $this->assertNotEmpty($halfStarItems);
    }

    public function testSizeSmall(): void
    {
        $component = new Rating($this->config);
        $component->size = 'sm';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('rating-sm', $options['classes']);
    }

    public function testSizeLarge(): void
    {
        $component = new Rating($this->config);
        $component->size = 'lg';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('rating-lg', $options['classes']);
    }

    public function testVariantOption(): void
    {
        $component = new Rating($this->config);
        $component->variant = 'danger';
        $component->value = 3;
        $component->mount();
        $options = $component->options();

        $this->assertSame('danger', $options['variant']);

        // Check filled items have the variant color
        $filledItems = array_filter($options['items'], fn($item) => $item['state'] === 'filled');
        foreach ($filledItems as $item) {
            $this->assertStringContainsString('text-danger', $item['classes']);
        }
    }

    public function testEmptyVariantOption(): void
    {
        $component = new Rating($this->config);
        $component->emptyVariant = 'light';
        $component->value = 2;
        $component->mount();
        $options = $component->options();

        $this->assertSame('light', $options['emptyVariant']);

        // Check empty items have the empty variant color
        $emptyItems = array_filter($options['items'], fn($item) => $item['state'] === 'empty');
        foreach ($emptyItems as $item) {
            $this->assertStringContainsString('text-light', $item['classes']);
        }
    }

    public function testShowValue(): void
    {
        $component = new Rating($this->config);
        $component->showValue = true;
        $component->value = 4.5;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['showValue']);
    }

    public function testShowCount(): void
    {
        $component = new Rating($this->config);
        $component->showCount = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['showCount']);
    }

    public function testShowText(): void
    {
        $component = new Rating($this->config);
        $component->showText = true;
        $component->text = 'Excellent';
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['showText']);
        $this->assertSame('Excellent', $options['text']);
    }

    public function testTextPositionStart(): void
    {
        $component = new Rating($this->config);
        $component->textPosition = 'start';
        $component->mount();
        $options = $component->options();

        $this->assertSame('start', $options['textPosition']);
    }

    public function testTextPositionEnd(): void
    {
        $component = new Rating($this->config);
        $component->textPosition = 'end';
        $component->mount();
        $options = $component->options();

        $this->assertSame('end', $options['textPosition']);
    }

    public function testAriaLabelGeneration(): void
    {
        $component = new Rating($this->config);
        $component->value = 4;
        $component->max = 5;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('Rating: 4 out of 5', $options['attrs']['aria-label']);
    }

    public function testAriaLabelGenerationWithHalfStars(): void
    {
        $component = new Rating($this->config);
        $component->value = 4.5;
        $component->halfStars = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('Rating: 4.5 out of 5', $options['attrs']['aria-label']);
    }

    public function testCustomAriaLabel(): void
    {
        $component = new Rating($this->config);
        $component->ariaLabel = 'Custom rating label';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Custom rating label', $options['attrs']['aria-label']);
    }

    public function testAriaLiveForInteractive(): void
    {
        $component = new Rating($this->config);
        $component->ariaLive = true;
        $component->readonly = false;
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('aria-live', $options['attrs']);
        $this->assertSame('polite', $options['attrs']['aria-live']);
    }

    public function testAriaLiveNotSetForReadonly(): void
    {
        $component = new Rating($this->config);
        $component->ariaLive = true;
        $component->readonly = true;
        $component->mount();
        $options = $component->options();

        $this->assertArrayNotHasKey('aria-live', $options['attrs']);
    }

    public function testRatingItemsGeneration(): void
    {
        $component = new Rating($this->config);
        $component->value = 3;
        $component->max = 5;
        $component->mount();
        $options = $component->options();

        $this->assertCount(5, $options['items']);

        // Check first 3 are filled
        $this->assertSame('filled', $options['items'][0]['state']);
        $this->assertSame('filled', $options['items'][1]['state']);
        $this->assertSame('filled', $options['items'][2]['state']);

        // Check last 2 are empty
        $this->assertSame('empty', $options['items'][3]['state']);
        $this->assertSame('empty', $options['items'][4]['state']);
    }

    public function testRatingItemsWithHalfStar(): void
    {
        $component = new Rating($this->config);
        $component->value = 3.5;
        $component->halfStars = true;
        $component->max = 5;
        $component->mount();
        $options = $component->options();

        $this->assertSame('filled', $options['items'][0]['state']);
        $this->assertSame('filled', $options['items'][1]['state']);
        $this->assertSame('filled', $options['items'][2]['state']);
        $this->assertSame('half', $options['items'][3]['state']);
        $this->assertSame('empty', $options['items'][4]['state']);
    }

    public function testCustomClasses(): void
    {
        $component = new Rating($this->config);
        $component->class = 'my-custom-class another-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('my-custom-class', $options['classes']);
        $this->assertStringContainsString('another-class', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new Rating($this->config);
        $component->attr = [
            'data-test' => 'value',
            'data-rating-id' => '123',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('value', $options['attrs']['data-test']);
        $this->assertArrayHasKey('data-rating-id', $options['attrs']);
        $this->assertSame('123', $options['attrs']['data-rating-id']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'rating' => [
                'value' => 4,
                'max' => 5,
                'mode' => 'hearts',
                'readonly' => true,
                'size' => 'lg',
                'variant' => 'danger',
                'class' => 'default-class',
            ],
        ]);

        $component = new Rating($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame(4.0, $options['value']);
        $this->assertSame(5, $options['max']);
        $this->assertSame('hearts', $options['mode']);
        $this->assertTrue($options['readonly']);
        $this->assertSame('danger', $options['variant']);
        $this->assertStringContainsString('rating-lg', $options['classes']);
        $this->assertStringContainsString('default-class', $options['classes']);
    }

    public function testGetComponentName(): void
    {
        $component = new Rating($this->config);
        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('rating', $method->invoke($component));
    }
}

