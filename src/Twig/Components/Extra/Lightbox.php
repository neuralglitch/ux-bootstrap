<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Lightbox component for displaying images in a modal overlay.
 *
 * Supports image galleries, portfolios, product galleries, and photo albums.
 */
#[AsTwigComponent(name: 'bs:lightbox', template: '@NeuralGlitchUxBootstrap/components/extra/lightbox.html.twig')]
final class Lightbox extends AbstractStimulus
{
    // Stimulus controller
    public string $stimulusController = 'bs-lightbox';

    /**
     * Array of images to display in the lightbox.
     * Each image should be an array with keys: 'src', 'alt', 'caption', 'thumbnail'
     *
     * @var array<int, array{src: string, alt?: string, caption?: string, thumbnail?: string}>
     */
    public array $images = [];

    /**
     * Index of the image to display initially (0-based).
     */
    public int $startIndex = 0;

    /**
     * Show thumbnails navigation bar.
     */
    public bool $showThumbnails = false;

    /**
     * Show image counter (e.g., "1 / 5").
     */
    public bool $showCounter = true;

    /**
     * Show captions below images.
     */
    public bool $showCaptions = true;

    /**
     * Enable zoom functionality.
     */
    public bool $enableZoom = true;

    /**
     * Enable keyboard navigation (arrows, escape).
     */
    public bool $enableKeyboard = true;

    /**
     * Enable swipe gestures on touch devices.
     */
    public bool $enableSwipe = true;

    /**
     * Close lightbox when clicking outside the image.
     */
    public bool $closeOnBackdrop = true;

    /**
     * Animation effect when changing images.
     * Options: 'fade', 'slide', 'zoom', 'none'
     */
    public ?string $transition = null;

    /**
     * Transition duration in milliseconds.
     */
    public int $transitionDuration = 300;

    /**
     * Auto-play slideshow.
     */
    public bool $autoplay = false;

    /**
     * Auto-play interval in milliseconds.
     */
    public int $autoplayInterval = 3000;

    /**
     * Show download button.
     */
    public bool $showDownload = false;

    /**
     * Show fullscreen button.
     */
    public bool $showFullscreen = true;

    /**
     * Show close button.
     */
    public bool $showClose = true;

    /**
     * Unique ID for the lightbox instance.
     */
    public ?string $id = null;

    public function mount(): void
    {
        $d = $this->config->for('lightbox');

        $this->applyStimulusDefaults($d);

        // Apply base class defaults
        $this->applyClassDefaults($d);

        // Apply component-specific defaults
        $this->showThumbnails = $this->showThumbnails || ($d['show_thumbnails'] ?? false);
        $this->showCounter = $this->showCounter && ($d['show_counter'] ?? true);
        $this->showCaptions = $this->showCaptions && ($d['show_captions'] ?? true);
        $this->enableZoom = $this->enableZoom && ($d['enable_zoom'] ?? true);
        $this->enableKeyboard = $this->enableKeyboard && ($d['enable_keyboard'] ?? true);
        $this->enableSwipe = $this->enableSwipe && ($d['enable_swipe'] ?? true);
        $this->closeOnBackdrop = $this->closeOnBackdrop && ($d['close_on_backdrop'] ?? true);
        $this->transition ??= $this->configStringWithFallback($d, 'transition', 'fade');
        $this->transitionDuration = $this->transitionDuration ?: $this->configIntWithFallback($d, 'transition_duration', 300);
        $this->autoplay = $this->autoplay || $this->configBoolWithFallback($d, 'autoplay', false);
        $this->autoplayInterval = $this->autoplayInterval ?: $this->configIntWithFallback($d, 'autoplay_interval', 3000);
        $this->showDownload = $this->showDownload || $this->configBoolWithFallback($d, 'show_download', false);
        $this->showFullscreen = $this->showFullscreen && $this->configBoolWithFallback($d, 'show_fullscreen', true);
        $this->showClose = $this->showClose && $this->configBoolWithFallback($d, 'show_close', true);
        $this->id ??= $this->configString($d, 'id');

        // Generate ID if not provided
        if (!$this->id) {
            $this->id = 'lightbox-' . uniqid();


            // Initialize controller with default
            $this->initializeController();
        }

        // Validate images array
        if (empty($this->images)) {
            $images = $this->configArray($d, 'images', []) ?? [];
            /** @var array<int, array{src: string, alt?: string, caption?: string, thumbnail?: string}> $images */
            $this->images = $images;
        }

        // Ensure startIndex is within bounds
        if ($this->startIndex < 0 || $this->startIndex >= count($this->images)) {
            $this->startIndex = 0;
        }
    }

    protected function getComponentName(): string
    {
        return 'lightbox';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        // Controller wrapper attributes
        $controllerAttrs = $this->mergeAttributes([
            'id' => $this->id,
            'data-controller' => $this->stimulusController,
            'data-bs-lightbox-start-index-value' => (string)$this->startIndex,
            'data-bs-lightbox-enable-zoom-value' => $this->enableZoom ? 'true' : 'false',
            'data-bs-lightbox-enable-keyboard-value' => $this->enableKeyboard ? 'true' : 'false',
            'data-bs-lightbox-enable-swipe-value' => $this->enableSwipe ? 'true' : 'false',
            'data-bs-lightbox-close-on-backdrop-value' => $this->closeOnBackdrop ? 'true' : 'false',
            'data-bs-lightbox-transition-value' => $this->transition,
            'data-bs-lightbox-transition-duration-value' => (string)$this->transitionDuration,
            'data-bs-lightbox-autoplay-value' => $this->autoplay ? 'true' : 'false',
            'data-bs-lightbox-autoplay-interval-value' => (string)$this->autoplayInterval,
        ], $this->attr);

        $classes = $this->buildClasses(
            ['lightbox'],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        return [
            'id' => $this->id,
            'classes' => $classes,
            'attrs' => $controllerAttrs,
            'images' => $this->images,
            'showThumbnails' => $this->showThumbnails,
            'showCounter' => $this->showCounter,
            'showCaptions' => $this->showCaptions,
            'showDownload' => $this->showDownload,
            'showFullscreen' => $this->showFullscreen,
            'showClose' => $this->showClose,
            'imageCount' => count($this->images),
        ];
    }
}

