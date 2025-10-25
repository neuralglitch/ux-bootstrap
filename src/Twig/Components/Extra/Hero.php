<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:hero', template: '@NeuralGlitchUxBootstrap/components/extra/hero.html.twig')]
final class Hero extends AbstractStimulus
{

    public string $variant = 'centered';

    // Standard-Props
    public string $title = 'Build something great';
    public ?string $lead = null;

    // Call-to-Action
    public ?string $ctaLabel = null;
    public ?string $ctaHref = null;
    public ?string $ctaVariant = 'primary'; // Bootstrap Btn-Variante (primary, secondary, …)
    public ?string $ctaSize = 'lg';

    // Optional zweite Aktion
    public ?string $secondaryCtaLabel = null;
    public ?string $secondaryCtaHref = null;
    public ?string $secondaryCtaVariant = 'outline-secondary';
    public ?string $secondaryCtaSize = 'lg';

    // Bilder / Media
    public ?string $imageSrc = null;        // Für IMAGE_LEFT / BORDER_IMAGE
    public ?string $imageAlt = null;
    public ?string $screenshotSrc = null;   // Für SCREENSHOT_CENTERED

    // Layout/Styling
    public bool $fullHeight = false;        // 100vh
    public string $container = 'container'; // 'container' | 'container-lg' | 'container-fluid'

    public function mount(): void
    {
        $d = $this->config->for('hero');

        $this->applyStimulusDefaults($d);

        // Apply defaults from config
        $this->variant ??= $this->configStringWithFallback($d, 'variant', 'centered');
        $this->title ??= $this->configStringWithFallback($d, 'title', 'Build something great');
        $this->lead ??= $this->configString($d, 'lead');

        // CTA defaults
        $this->ctaVariant ??= $this->configStringWithFallback($d, 'cta_variant', 'primary');
        $this->ctaSize ??= $this->configStringWithFallback($d, 'cta_size', 'lg');
        $this->secondaryCtaVariant ??= $this->configStringWithFallback($d, 'secondary_cta_variant', 'outline-secondary');
        $this->secondaryCtaSize ??= $this->configStringWithFallback($d, 'secondary_cta_size', 'lg');

        // Layout defaults
        $this->fullHeight = $this->fullHeight || $this->configBoolWithFallback($d, 'full_height', false);
        $this->container ??= $this->configStringWithFallback($d, 'container', 'container');

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
        return 'hero';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = $this->buildClasses(
            ['py-5'],
            $this->fullHeight ? ['min-vh-100', 'd-flex', 'align-items-center'] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = $this->mergeAttributes([], $this->attr);

        return [
            'variant' => $this->variant,
            'title' => $this->title,
            'lead' => $this->lead,
            'ctaLabel' => $this->ctaLabel,
            'ctaHref' => $this->ctaHref,
            'ctaVariant' => $this->ctaVariant,
            'ctaSize' => $this->ctaSize,
            'secondaryCtaLabel' => $this->secondaryCtaLabel,
            'secondaryCtaHref' => $this->secondaryCtaHref,
            'secondaryCtaVariant' => $this->secondaryCtaVariant,
            'secondaryCtaSize' => $this->secondaryCtaSize,
            'imageSrc' => $this->imageSrc,
            'imageAlt' => $this->imageAlt,
            'screenshotSrc' => $this->screenshotSrc,
            'container' => $this->container,
            'classes' => $classes,
            'attrs' => $attrs,
        ];
    }
}
