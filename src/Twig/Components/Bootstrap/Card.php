<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\VariantTrait;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:card', template: '@NeuralGlitchUxBootstrap/components/bootstrap/card.html.twig')]
final class Card extends AbstractStimulus
{
    use VariantTrait;

    public ?string $title = null;
    public ?string $subtitle = null;
    public ?string $text = null;

    /** Image source URL */
    public ?string $img = null;

    /** Image alt text for accessibility */
    public ?string $imgAlt = null;

    /** Image position: 'top' | 'bottom' | 'overlay' */
    public ?string $imgPosition = 'top';

    /** Card header text */
    public ?string $header = null;

    /** Card footer text */
    public ?string $footer = null;

    /** Text alignment: 'start' | 'center' | 'end' */
    public ?string $textAlign = null;

    /** Card border style: true for border, false for no border */
    public bool $border = true;

    /** Background color variant */
    public ?string $bg = null;

    /** Text color variant */
    public ?string $textColor = null;

    /** Card width - e.g., '18rem', '20rem' */
    public ?string $width = null;

    public ?string $id = null;

    public function mount(): void
    {
        $d = $this->config->for('card');

        $this->applyStimulusDefaults($d);

        $this->applyVariantDefaults($d);
        $this->applyClassDefaults($d);

        // Apply defaults from config
        $this->border = $this->border && ($d['border'] ?? true);
        $this->imgPosition ??= $d['img_position'] ?? 'top';
        $this->textAlign ??= $d['text_align'] ?? null;
        $this->bg ??= $d['bg'] ?? null;
        $this->textColor ??= $d['text_color'] ?? null;
        $this->width ??= $d['width'] ?? null;
        $this->id ??= $d['id'] ?? null;

        
        // Initialize controller with default
        $this->initializeController();
    }

    protected function getComponentName(): string
    {
        return 'card';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = ['card'];

        // Add border classes
        if (!$this->border) {
            $classes[] = 'border-0';
        }

        // Add variant/color classes
        if ($this->variant && $this->outline) {
            $classes[] = "border-{$this->variant}";
        } elseif ($this->variant) {
            $classes[] = "text-bg-{$this->variant}";
        }

        // Add background color
        if ($this->bg) {
            $classes[] = "bg-{$this->bg}";
        }

        // Add text color
        if ($this->textColor) {
            $classes[] = "text-{$this->textColor}";
        }

        // Add text alignment
        if ($this->textAlign) {
            $classes[] = "text-{$this->textAlign}";
        }

        // Add custom classes
        $classesString = $this->buildClasses(
            $classes,
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = [];

        if ($this->id) {
            $attrs['id'] = $this->id;
        }

        // Add width as inline style if specified
        if ($this->width) {
            $attrs['style'] = "width: {$this->width};";
        }

        $attrs = $this->mergeAttributes($attrs, $this->attr);

        return [
            'classes' => $classesString,
            'attrs' => $attrs,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'text' => $this->text,
            'img' => $this->img,
            'imgAlt' => $this->imgAlt ?? '',
            'imgPosition' => $this->imgPosition,
            'header' => $this->header,
            'footer' => $this->footer,
        ];
    }
}

