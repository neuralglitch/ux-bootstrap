<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:carousel', template: '@NeuralGlitchUxBootstrap/components/bootstrap/carousel.html.twig')]
final class Carousel extends AbstractBootstrap
{
    // Carousel ID (required for controls and indicators)
    public ?string $id = null;

    // Visual options
    public bool $indicators = false;
    public bool $controls = true;
    public bool $fade = false;
    public bool $dark = false;

    // Behavior options
    public string|bool $ride = false; // false, true, or "carousel"
    public int $interval = 5000;
    public bool $keyboard = true;
    public string|bool $pause = 'hover'; // "hover" or false
    public bool $touch = true;
    public bool $wrap = true;

    // Content
    /**
     * @var array<int, array<string, mixed>>
     */
    public array $items = []; // Array of slide data if not using slots

    public function mount(): void
    {
        $d = $this->config->for('carousel');

        // Apply base class defaults
        $this->applyClassDefaults($d);

        // Apply component-specific defaults
        $this->indicators = $this->indicators || ($d['indicators'] ?? false);
        $this->controls = $this->controls && ($d['controls'] ?? true);
        $this->fade = $this->fade || ($d['fade'] ?? false);
        $this->dark = $this->dark || ($d['dark'] ?? false);

        // Behavior defaults
        $this->ride = $this->ride !== false ? $this->ride : ($d['ride'] ?? false);
        $this->interval ??= $d['interval'] ?? 5000;
        $this->keyboard = $this->keyboard && ($d['keyboard'] ?? true);
        // For pause, only apply default if it's still 'hover' (the default value)
        if ($this->pause === 'hover') {
            $this->pause = $d['pause'] ?? 'hover';
        }
        $this->touch = $this->touch && ($d['touch'] ?? true);
        $this->wrap = $this->wrap && ($d['wrap'] ?? true);

        // Generate ID if not provided
        $this->id ??= $d['id'] ?? 'carousel-' . uniqid();
    }

    protected function getComponentName(): string
    {
        return 'carousel';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = $this->buildClasses(
            ['carousel', 'slide'],
            $this->fade ? ['carousel-fade'] : [],
            $this->dark ? ['carousel-dark'] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        // Build data attributes
        $dataAttrs = [];

        if ($this->ride === 'carousel' || $this->ride === true) {
            $dataAttrs['data-bs-ride'] = 'carousel';
        }

        if ($this->interval !== 5000) {
            $dataAttrs['data-bs-interval'] = (string) $this->interval;
        }

        if (!$this->keyboard) {
            $dataAttrs['data-bs-keyboard'] = 'false';
        }

        if ($this->pause === false) {
            $dataAttrs['data-bs-pause'] = 'false';
        } elseif ($this->pause !== 'hover') {
            $dataAttrs['data-bs-pause'] = $this->pause;
        }

        if (!$this->touch) {
            $dataAttrs['data-bs-touch'] = 'false';
        }

        if (!$this->wrap) {
            $dataAttrs['data-bs-wrap'] = 'false';
        }

        $attrs = $this->mergeAttributes($dataAttrs, $this->attr);

        return [
            'id' => $this->id,
            'classes' => $classes,
            'attrs' => $attrs,
            'indicators' => $this->indicators,
            'controls' => $this->controls,
            'items' => $this->items,
        ];
    }
}

