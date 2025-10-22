<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\Lightbox;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class LightboxTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'lightbox' => [
                'images' => [],
                'start_index' => 0,
                'show_thumbnails' => false,
                'show_counter' => true,
                'show_captions' => true,
                'enable_zoom' => true,
                'enable_keyboard' => true,
                'enable_swipe' => true,
                'close_on_backdrop' => true,
                'transition' => 'fade',
                'transition_duration' => 300,
                'autoplay' => false,
                'autoplay_interval' => 3000,
                'show_download' => false,
                'show_fullscreen' => true,
                'show_close' => true,
                'id' => null,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new Lightbox($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('lightbox', $options['classes']);
        $this->assertIsArray($options['images']);
        $this->assertTrue($options['showCounter']);
        $this->assertTrue($options['showCaptions']);
        $this->assertFalse($options['showThumbnails']);
        $this->assertTrue($options['showClose']);
        $this->assertTrue($options['showFullscreen']);
        $this->assertFalse($options['showDownload']);
    }

    public function testWithImages(): void
    {
        $images = [
            ['src' => '/images/photo1.jpg', 'alt' => 'Photo 1', 'caption' => 'First photo'],
            ['src' => '/images/photo2.jpg', 'alt' => 'Photo 2', 'caption' => 'Second photo'],
            ['src' => '/images/photo3.jpg', 'alt' => 'Photo 3', 'caption' => 'Third photo'],
        ];

        $component = new Lightbox($this->config);
        $component->images = $images;
        $component->mount();
        $options = $component->options();

        $this->assertSame($images, $options['images']);
        $this->assertSame(3, $options['imageCount']);
    }

    public function testStartIndex(): void
    {
        $images = [
            ['src' => '/images/photo1.jpg'],
            ['src' => '/images/photo2.jpg'],
            ['src' => '/images/photo3.jpg'],
        ];

        $component = new Lightbox($this->config);
        $component->images = $images;
        $component->startIndex = 1;
        $component->mount();
        $options = $component->options();

        $this->assertSame('1', $options['attrs']['data-bs-lightbox-start-index-value']);
    }

    public function testStartIndexOutOfBounds(): void
    {
        $images = [
            ['src' => '/images/photo1.jpg'],
            ['src' => '/images/photo2.jpg'],
        ];

        $component = new Lightbox($this->config);
        $component->images = $images;
        $component->startIndex = 10; // Out of bounds
        $component->mount();

        $this->assertSame(0, $component->startIndex); // Should reset to 0
    }

    public function testShowThumbnails(): void
    {
        $component = new Lightbox($this->config);
        $component->showThumbnails = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['showThumbnails']);
    }

    public function testHideCounter(): void
    {
        $component = new Lightbox($this->config);
        $component->showCounter = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['showCounter']);
    }

    public function testHideCaptions(): void
    {
        $component = new Lightbox($this->config);
        $component->showCaptions = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['showCaptions']);
    }

    public function testDisableZoom(): void
    {
        $component = new Lightbox($this->config);
        $component->enableZoom = false;
        $component->mount();
        $options = $component->options();

        $this->assertSame('false', $options['attrs']['data-bs-lightbox-enable-zoom-value']);
    }

    public function testDisableKeyboard(): void
    {
        $component = new Lightbox($this->config);
        $component->enableKeyboard = false;
        $component->mount();
        $options = $component->options();

        $this->assertSame('false', $options['attrs']['data-bs-lightbox-enable-keyboard-value']);
    }

    public function testDisableSwipe(): void
    {
        $component = new Lightbox($this->config);
        $component->enableSwipe = false;
        $component->mount();
        $options = $component->options();

        $this->assertSame('false', $options['attrs']['data-bs-lightbox-enable-swipe-value']);
    }

    public function testDisableCloseOnBackdrop(): void
    {
        $component = new Lightbox($this->config);
        $component->closeOnBackdrop = false;
        $component->mount();
        $options = $component->options();

        $this->assertSame('false', $options['attrs']['data-bs-lightbox-close-on-backdrop-value']);
    }

    public function testTransitionSlide(): void
    {
        $component = new Lightbox($this->config);
        $component->transition = 'slide';
        $component->mount();
        $options = $component->options();

        $this->assertSame('slide', $options['attrs']['data-bs-lightbox-transition-value']);
    }

    public function testTransitionZoom(): void
    {
        $component = new Lightbox($this->config);
        $component->transition = 'zoom';
        $component->mount();
        $options = $component->options();

        $this->assertSame('zoom', $options['attrs']['data-bs-lightbox-transition-value']);
    }

    public function testTransitionNone(): void
    {
        $component = new Lightbox($this->config);
        $component->transition = 'none';
        $component->mount();
        $options = $component->options();

        $this->assertSame('none', $options['attrs']['data-bs-lightbox-transition-value']);
    }

    public function testCustomTransitionDuration(): void
    {
        $component = new Lightbox($this->config);
        $component->transitionDuration = 500;
        $component->mount();
        $options = $component->options();

        $this->assertSame('500', $options['attrs']['data-bs-lightbox-transition-duration-value']);
    }

    public function testEnableAutoplay(): void
    {
        $component = new Lightbox($this->config);
        $component->autoplay = true;
        $component->mount();
        $options = $component->options();

        $this->assertSame('true', $options['attrs']['data-bs-lightbox-autoplay-value']);
    }

    public function testCustomAutoplayInterval(): void
    {
        $component = new Lightbox($this->config);
        $component->autoplay = true;
        $component->autoplayInterval = 5000;
        $component->mount();
        $options = $component->options();

        $this->assertSame('5000', $options['attrs']['data-bs-lightbox-autoplay-interval-value']);
    }

    public function testShowDownloadButton(): void
    {
        $component = new Lightbox($this->config);
        $component->showDownload = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['showDownload']);
    }

    public function testHideFullscreenButton(): void
    {
        $component = new Lightbox($this->config);
        $component->showFullscreen = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['showFullscreen']);
    }

    public function testHideCloseButton(): void
    {
        $component = new Lightbox($this->config);
        $component->showClose = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['showClose']);
    }

    public function testCustomId(): void
    {
        $component = new Lightbox($this->config);
        $component->id = 'my-lightbox';
        $component->mount();
        $options = $component->options();

        $this->assertSame('my-lightbox', $options['id']);
        $this->assertSame('my-lightbox', $options['attrs']['id']);
    }

    public function testAutoGeneratedId(): void
    {
        $component = new Lightbox($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertNotNull($options['id']);
        $this->assertStringStartsWith('lightbox-', $options['id']);
    }

    public function testCustomClasses(): void
    {
        $component = new Lightbox($this->config);
        $component->class = 'custom-lightbox extra-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-lightbox', $options['classes']);
        $this->assertStringContainsString('extra-class', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new Lightbox($this->config);
        $component->attr = [
            'data-test' => 'value',
            'aria-label' => 'Image gallery',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('value', $options['attrs']['data-test']);
        $this->assertArrayHasKey('aria-label', $options['attrs']);
        $this->assertSame('Image gallery', $options['attrs']['aria-label']);
    }

    public function testStimulusControllerAttribute(): void
    {
        $component = new Lightbox($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-controller', $options['attrs']);
        $this->assertSame('bs-lightbox', $options['attrs']['data-controller']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'lightbox' => [
                'images' => [
                    ['src' => '/default1.jpg'],
                    ['src' => '/default2.jpg'],
                ],
                'start_index' => 1,
                'show_thumbnails' => true,
                'show_counter' => false,
                'enable_zoom' => false,
                'transition' => 'slide',
                'class' => 'default-lightbox',
            ],
        ]);

        $component = new Lightbox($config);
        $component->mount();
        $options = $component->options();

        $this->assertCount(2, $options['images']);
        $this->assertTrue($options['showThumbnails']);
        $this->assertFalse($options['showCounter']);
        $this->assertSame('slide', $options['attrs']['data-bs-lightbox-transition-value']);
        $this->assertStringContainsString('default-lightbox', $options['classes']);
    }

    public function testEmptyImagesArray(): void
    {
        $component = new Lightbox($this->config);
        $component->images = [];
        $component->mount();
        $options = $component->options();

        $this->assertIsArray($options['images']);
        $this->assertEmpty($options['images']);
        $this->assertSame(0, $options['imageCount']);
    }

    public function testGetComponentName(): void
    {
        $component = new Lightbox($this->config);
        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('lightbox', $method->invoke($component));
    }
}

