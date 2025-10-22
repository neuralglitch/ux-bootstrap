<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Carousel;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class CarouselTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'carousel' => [
                'id' => null,
                'indicators' => false,
                'controls' => true,
                'fade' => false,
                'dark' => false,
                'ride' => false,
                'interval' => 5000,
                'keyboard' => true,
                'pause' => 'hover',
                'touch' => true,
                'wrap' => true,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new Carousel($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('carousel', $options['classes']);
        $this->assertStringContainsString('slide', $options['classes']);
        $this->assertFalse($options['indicators']);
        $this->assertTrue($options['controls']);
        $this->assertNotEmpty($options['id']);
    }

    public function testIdGeneration(): void
    {
        $component = new Carousel($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringStartsWith('carousel-', $options['id']);
    }

    public function testCustomId(): void
    {
        $component = new Carousel($this->config);
        $component->id = 'myCarousel';
        $component->mount();
        $options = $component->options();

        $this->assertSame('myCarousel', $options['id']);
    }

    public function testIndicatorsOption(): void
    {
        $component = new Carousel($this->config);
        $component->indicators = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['indicators']);
    }

    public function testControlsOption(): void
    {
        $component = new Carousel($this->config);
        $component->controls = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['controls']);
    }

    public function testFadeOption(): void
    {
        $component = new Carousel($this->config);
        $component->fade = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('carousel-fade', $options['classes']);
    }

    public function testDarkOption(): void
    {
        $component = new Carousel($this->config);
        $component->dark = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('carousel-dark', $options['classes']);
    }

    public function testRideCarouselAttribute(): void
    {
        $component = new Carousel($this->config);
        $component->ride = 'carousel';
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-bs-ride', $options['attrs']);
        $this->assertSame('carousel', $options['attrs']['data-bs-ride']);
    }

    public function testRideTrueAttribute(): void
    {
        $component = new Carousel($this->config);
        $component->ride = true;
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-bs-ride', $options['attrs']);
        $this->assertSame('carousel', $options['attrs']['data-bs-ride']);
    }

    public function testRideFalseNoAttribute(): void
    {
        $component = new Carousel($this->config);
        $component->ride = false;
        $component->mount();
        $options = $component->options();

        $this->assertArrayNotHasKey('data-bs-ride', $options['attrs']);
    }

    public function testCustomInterval(): void
    {
        $component = new Carousel($this->config);
        $component->interval = 3000;
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-bs-interval', $options['attrs']);
        $this->assertSame('3000', $options['attrs']['data-bs-interval']);
    }

    public function testDefaultIntervalNoAttribute(): void
    {
        $component = new Carousel($this->config);
        $component->interval = 5000;
        $component->mount();
        $options = $component->options();

        $this->assertArrayNotHasKey('data-bs-interval', $options['attrs']);
    }

    public function testKeyboardDisabled(): void
    {
        $component = new Carousel($this->config);
        $component->keyboard = false;
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-bs-keyboard', $options['attrs']);
        $this->assertSame('false', $options['attrs']['data-bs-keyboard']);
    }

    public function testPauseFalse(): void
    {
        $component = new Carousel($this->config);
        $component->pause = false;
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-bs-pause', $options['attrs']);
        $this->assertSame('false', $options['attrs']['data-bs-pause']);
    }

    public function testPauseHoverNoAttribute(): void
    {
        $component = new Carousel($this->config);
        $component->pause = 'hover';
        $component->mount();
        $options = $component->options();

        $this->assertArrayNotHasKey('data-bs-pause', $options['attrs']);
    }

    public function testTouchDisabled(): void
    {
        $component = new Carousel($this->config);
        $component->touch = false;
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-bs-touch', $options['attrs']);
        $this->assertSame('false', $options['attrs']['data-bs-touch']);
    }

    public function testWrapDisabled(): void
    {
        $component = new Carousel($this->config);
        $component->wrap = false;
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-bs-wrap', $options['attrs']);
        $this->assertSame('false', $options['attrs']['data-bs-wrap']);
    }

    public function testCustomClass(): void
    {
        $component = new Carousel($this->config);
        $component->class = 'custom-carousel my-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-carousel', $options['classes']);
        $this->assertStringContainsString('my-class', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new Carousel($this->config);
        $component->attr = [
            'data-test' => 'value',
            'aria-label' => 'Image carousel',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('value', $options['attrs']['data-test']);
        $this->assertArrayHasKey('aria-label', $options['attrs']);
        $this->assertSame('Image carousel', $options['attrs']['aria-label']);
    }

    public function testCombinedOptions(): void
    {
        $component = new Carousel($this->config);
        $component->indicators = true;
        $component->fade = true;
        $component->dark = true;
        $component->ride = 'carousel';
        $component->interval = 2000;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('carousel-fade', $options['classes']);
        $this->assertStringContainsString('carousel-dark', $options['classes']);
        $this->assertTrue($options['indicators']);
        $this->assertArrayHasKey('data-bs-ride', $options['attrs']);
        $this->assertArrayHasKey('data-bs-interval', $options['attrs']);
    }

    public function testItemsArray(): void
    {
        $component = new Carousel($this->config);
        $component->items = [
            ['imgSrc' => '/img1.jpg', 'imgAlt' => 'First'],
            ['imgSrc' => '/img2.jpg', 'imgAlt' => 'Second'],
        ];
        $component->mount();
        $options = $component->options();

        $this->assertCount(2, $options['items']);
        $this->assertSame('/img1.jpg', $options['items'][0]['imgSrc']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'carousel' => [
                'indicators' => true,
                'controls' => false,
                'fade' => true,
                'interval' => 3000,
                'class' => 'config-class',
            ],
        ]);

        $component = new Carousel($config);
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['indicators']);
        $this->assertFalse($options['controls']);
        $this->assertStringContainsString('carousel-fade', $options['classes']);
        $this->assertStringContainsString('config-class', $options['classes']);
    }

    public function testGetComponentName(): void
    {
        $component = new Carousel($this->config);
        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('carousel', $method->invoke($component));
    }
}

