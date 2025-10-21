<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:carousel:item', template: '@NeuralGlitchUxBootstrap/components/bootstrap/carousel-item.html.twig')]
final class CarouselItem extends AbstractStimulus
{
    // State
    public bool $active = false;

    // Image
    public ?string $imgSrc = null;
    public ?string $imgAlt = null;
    public ?string $imgClass = 'd-block w-100';

    // Caption
    public ?string $captionTitle = null;
    public ?string $captionText = null;

    // Individual slide interval (optional)
    public ?int $interval = null;

    public function mount(): void
    {
        $d = $this->config->for('carousel_item');

        $this->applyStimulusDefaults($d);

        // Apply base class defaults
        $this->applyClassDefaults($d);

        // Apply component-specific defaults
        $this->active = $this->active || ($d['active'] ?? false);
        // For imgClass, only apply default if it's still 'd-block w-100' (the default value)
        if ($this->imgClass === 'd-block w-100') {
            $this->imgClass = $d['img_class'] ?? 'd-block w-100';

        
        // Initialize controller with default
        $this->initializeController();
    }
    }

    protected function getComponentName(): string
    {
        return 'carousel_item';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = $this->buildClasses(
            ['carousel-item'],
            $this->active ? ['active'] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = [];
        
        if ($this->interval !== null) {
            $attrs['data-bs-interval'] = (string) $this->interval;
        }

        $attrs = $this->mergeAttributes($attrs, $this->attr);

        return [
            'classes' => $classes,
            'attrs' => $attrs,
            'imgSrc' => $this->imgSrc,
            'imgAlt' => $this->imgAlt,
            'imgClass' => $this->imgClass,
            'captionTitle' => $this->captionTitle,
            'captionText' => $this->captionText,
        ];
    }
}

