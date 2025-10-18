<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\CarouselItem;
use PHPUnit\Framework\TestCase;

final class CarouselItemTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'carousel_item' => [
                'active' => false,
                'img_class' => 'd-block w-100',
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new CarouselItem($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('carousel-item', $options['classes']);
        $this->assertFalse(str_contains($options['classes'], 'active'));
        $this->assertSame('d-block w-100', $options['imgClass']);
    }

    public function testActiveOption(): void
    {
        $component = new CarouselItem($this->config);
        $component->active = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('active', $options['classes']);
    }

    public function testImageSource(): void
    {
        $component = new CarouselItem($this->config);
        $component->imgSrc = '/images/slide1.jpg';
        $component->mount();
        $options = $component->options();

        $this->assertSame('/images/slide1.jpg', $options['imgSrc']);
    }

    public function testImageAlt(): void
    {
        $component = new CarouselItem($this->config);
        $component->imgAlt = 'First slide';
        $component->mount();
        $options = $component->options();

        $this->assertSame('First slide', $options['imgAlt']);
    }

    public function testCustomImageClass(): void
    {
        $component = new CarouselItem($this->config);
        $component->imgClass = 'img-fluid custom-img';
        $component->mount();
        $options = $component->options();

        $this->assertSame('img-fluid custom-img', $options['imgClass']);
    }

    public function testCaptionTitle(): void
    {
        $component = new CarouselItem($this->config);
        $component->captionTitle = 'Slide Title';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Slide Title', $options['captionTitle']);
    }

    public function testCaptionText(): void
    {
        $component = new CarouselItem($this->config);
        $component->captionText = 'Slide description text';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Slide description text', $options['captionText']);
    }

    public function testBothCaptionTitleAndText(): void
    {
        $component = new CarouselItem($this->config);
        $component->captionTitle = 'Title';
        $component->captionText = 'Text';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Title', $options['captionTitle']);
        $this->assertSame('Text', $options['captionText']);
    }

    public function testCustomInterval(): void
    {
        $component = new CarouselItem($this->config);
        $component->interval = 2000;
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-bs-interval', $options['attrs']);
        $this->assertSame('2000', $options['attrs']['data-bs-interval']);
    }

    public function testNullIntervalNoAttribute(): void
    {
        $component = new CarouselItem($this->config);
        $component->interval = null;
        $component->mount();
        $options = $component->options();

        $this->assertArrayNotHasKey('data-bs-interval', $options['attrs']);
    }

    public function testCustomClass(): void
    {
        $component = new CarouselItem($this->config);
        $component->class = 'custom-item my-slide';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-item', $options['classes']);
        $this->assertStringContainsString('my-slide', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new CarouselItem($this->config);
        $component->attr = [
            'data-test' => 'slide-1',
            'id' => 'slide-first',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('slide-1', $options['attrs']['data-test']);
        $this->assertArrayHasKey('id', $options['attrs']);
        $this->assertSame('slide-first', $options['attrs']['id']);
    }

    public function testCombinedOptions(): void
    {
        $component = new CarouselItem($this->config);
        $component->active = true;
        $component->imgSrc = '/img.jpg';
        $component->imgAlt = 'Image';
        $component->imgClass = 'custom-img';
        $component->captionTitle = 'Title';
        $component->captionText = 'Text';
        $component->interval = 3000;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('active', $options['classes']);
        $this->assertSame('/img.jpg', $options['imgSrc']);
        $this->assertSame('Image', $options['imgAlt']);
        $this->assertSame('custom-img', $options['imgClass']);
        $this->assertSame('Title', $options['captionTitle']);
        $this->assertSame('Text', $options['captionText']);
        $this->assertArrayHasKey('data-bs-interval', $options['attrs']);
    }

    public function testNullValues(): void
    {
        $component = new CarouselItem($this->config);
        $component->imgSrc = null;
        $component->imgAlt = null;
        $component->captionTitle = null;
        $component->captionText = null;
        $component->interval = null;
        $component->mount();
        $options = $component->options();

        $this->assertNull($options['imgSrc']);
        $this->assertNull($options['imgAlt']);
        $this->assertNull($options['captionTitle']);
        $this->assertNull($options['captionText']);
        $this->assertArrayNotHasKey('data-bs-interval', $options['attrs']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'carousel_item' => [
                'active' => true,
                'img_class' => 'rounded img-fluid',
                'class' => 'config-slide',
            ],
        ]);

        $component = new CarouselItem($config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('active', $options['classes']);
        $this->assertSame('rounded img-fluid', $options['imgClass']);
        $this->assertStringContainsString('config-slide', $options['classes']);
    }

    public function testGetComponentName(): void
    {
        $component = new CarouselItem($this->config);
        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('carousel_item', $method->invoke($component));
    }

    public function testActiveWithInterval(): void
    {
        $component = new CarouselItem($this->config);
        $component->active = true;
        $component->interval = 4000;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('active', $options['classes']);
        $this->assertSame('4000', $options['attrs']['data-bs-interval']);
    }

    public function testImageWithoutCaption(): void
    {
        $component = new CarouselItem($this->config);
        $component->imgSrc = '/image.jpg';
        $component->imgAlt = 'Test image';
        $component->mount();
        $options = $component->options();

        $this->assertSame('/image.jpg', $options['imgSrc']);
        $this->assertSame('Test image', $options['imgAlt']);
        $this->assertNull($options['captionTitle']);
        $this->assertNull($options['captionText']);
    }

    public function testCaptionWithoutImage(): void
    {
        $component = new CarouselItem($this->config);
        $component->captionTitle = 'Only Caption';
        $component->captionText = 'No image here';
        $component->mount();
        $options = $component->options();

        $this->assertNull($options['imgSrc']);
        $this->assertSame('Only Caption', $options['captionTitle']);
        $this->assertSame('No image here', $options['captionText']);
    }
}

