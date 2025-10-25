<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:cta', template: '@NeuralGlitchUxBootstrap/components/extra/cta.html.twig')]
final class Cta extends AbstractStimulus
{
    // Layout variant
    public ?string $variant = null;  // 'centered' | 'split' | 'bordered' | 'background' | 'minimal'

    // Content
    public ?string $title = null;
    public ?string $description = null;
    public ?string $icon = null;

    // Call-to-Action
    public ?string $ctaLabel = null;
    public ?string $ctaHref = null;
    public ?string $ctaVariant = null;
    public ?string $ctaSize = null;
    public bool $ctaOutline = false;

    // Secondary CTA
    public ?string $secondaryCtaLabel = null;
    public ?string $secondaryCtaHref = null;
    public ?string $secondaryCtaVariant = null;
    public ?string $secondaryCtaSize = null;
    public bool $secondaryCtaOutline = false;

    // Layout & Styling
    public ?string $alignment = null;  // 'start' | 'center' | 'end'
    public ?string $container = null;  // 'container' | 'container-fluid' | 'container-{breakpoint}'
    public ?string $bg = null;  // Background variant: 'primary' | 'secondary' | 'light' | 'dark' | 'body-tertiary' | etc.
    public ?string $textColor = null;  // Text color variant
    public bool $border = false;
    public bool $shadow = false;
    public bool $rounded = true;
    public ?string $padding = null;  // Padding class

    public function mount(): void
    {
        $d = $this->config->for('cta');

        $this->applyStimulusDefaults($d);

        // Apply defaults from config
        $this->variant ??= $this->configStringWithFallback($d, 'variant', 'centered');
        $this->title ??= $this->configStringWithFallback($d, 'title', 'Ready to get started?');
        $this->description ??= $this->configString($d, 'description');
        $this->icon ??= $this->configString($d, 'icon');

        // CTA defaults
        $this->ctaVariant ??= $this->configStringWithFallback($d, 'cta_variant', 'primary');
        $this->ctaSize ??= $this->configStringWithFallback($d, 'cta_size', 'lg');
        $this->ctaOutline = $this->ctaOutline || $this->configBoolWithFallback($d, 'cta_outline', false);

        // Secondary CTA defaults
        $this->secondaryCtaVariant ??= $this->configStringWithFallback($d, 'secondary_cta_variant', 'outline-secondary');
        $this->secondaryCtaSize ??= $this->configStringWithFallback($d, 'secondary_cta_size', 'lg');
        $this->secondaryCtaOutline = $this->secondaryCtaOutline || $this->configBoolWithFallback($d, 'secondary_cta_outline', false);

        // Layout defaults
        $this->alignment ??= $this->configStringWithFallback($d, 'alignment', 'center');
        $this->container ??= $this->configStringWithFallback($d, 'container', 'container');
        $this->bg ??= $this->configString($d, 'bg');
        $this->textColor ??= $this->configString($d, 'text_color');
        $this->border = $this->border || $this->configBoolWithFallback($d, 'border', false);
        $this->shadow = $this->shadow || $this->configBoolWithFallback($d, 'shadow', false);
        $this->rounded = $this->rounded && $this->configBoolWithFallback($d, 'rounded', true);
        $this->padding ??= $this->configStringWithFallback($d, 'padding', 'py-5');

        $this->applyClassDefaults($d);

        // Merge attr defaults
        if (isset($d['attr']) && is_array($d['attr'])) {
            $this->attr = array_merge($d['attr'], $this->attr);


            // Initialize controller with default
            $this->initializeController();
        }
    }

    protected function getComponentName(): string
    {
        return 'cta';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classArray = $this->class ? array_filter(explode(' ', trim($this->class)), fn($v) => $v !== '') : [];
        /** @var array<string> $classArray */
        
        $paddingArray = $this->padding ? [$this->padding] : [];
        
        $classes = $this->buildClassesFromArrays(
            $paddingArray,
            $this->bg ? ["bg-{$this->bg}"] : [],
            $this->textColor ? ["text-{$this->textColor}"] : [],
            $this->border ? ['border'] : [],
            $this->shadow ? ['shadow'] : [],
            $this->rounded ? ['rounded-3'] : [],
            $classArray
        );

        $attrs = $this->mergeAttributes([], $this->attr);

        return [
            'variant' => $this->variant,
            'title' => $this->title,
            'description' => $this->description,
            'icon' => $this->icon,
            'ctaLabel' => $this->ctaLabel,
            'ctaHref' => $this->ctaHref,
            'ctaVariant' => $this->ctaVariant,
            'ctaSize' => $this->ctaSize,
            'ctaOutline' => $this->ctaOutline,
            'secondaryCtaLabel' => $this->secondaryCtaLabel,
            'secondaryCtaHref' => $this->secondaryCtaHref,
            'secondaryCtaVariant' => $this->secondaryCtaVariant,
            'secondaryCtaSize' => $this->secondaryCtaSize,
            'secondaryCtaOutline' => $this->secondaryCtaOutline,
            'alignment' => $this->alignment,
            'container' => $this->container,
            'classes' => $classes,
            'attrs' => $attrs,
        ];
    }
}

