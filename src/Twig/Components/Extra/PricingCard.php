<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:pricing-card', template: '@NeuralGlitchUxBootstrap/components/extra/pricing-card.html.twig')]
final class PricingCard extends AbstractStimulus
{
    // Plan Details
    public ?string $plan = null;
    public ?string $planDescription = null;

    // Pricing
    public ?string $price = null;
    public ?string $currency = null;
    public ?string $period = null;
    public ?bool $showPeriod = null;

    // Badge (e.g., "Popular", "Best Value")
    public ?string $badge = null;
    public ?string $badgeVariant = 'primary';

    // Features
    /** @var array<string> */
    public array $features = [];
    public ?bool $showCheckmarks = null;

    // Call-to-Action
    public ?string $ctaLabel = null;
    public ?string $ctaHref = null;
    public ?string $ctaVariant = null;
    public ?string $ctaSize = null;
    public ?bool $ctaOutline = null;
    public ?bool $ctaBlock = null;

    // Styling
    public ?bool $featured = null;
    public ?bool $shadow = null;
    public ?string $variant = null;
    public ?bool $border = null;
    public ?string $textAlign = null;

    public function mount(): void
    {
        $d = $this->config->for('pricing-card');

        $this->applyStimulusDefaults($d);

        // Apply defaults
        $this->applyClassDefaults($d);

        // Plan details
        $this->plan ??= $this->configStringWithFallback($d, 'plan', 'Free');
        $this->planDescription ??= $this->configString($d, 'plan_description');

        // Pricing
        $this->price ??= $this->configStringWithFallback($d, 'price', '0');
        $this->currency ??= $this->configStringWithFallback($d, 'currency', '$');
        $this->period ??= $this->configStringWithFallback($d, 'period', 'month');
        $this->showPeriod ??= $this->configBoolWithFallback($d, 'show_period', true);

        // Badge
        $this->badge ??= $this->configString($d, 'badge');
        $this->badgeVariant ??= $this->configStringWithFallback($d, 'badge_variant', 'primary');

        // Features
        if (empty($this->features)) {
            $features = $this->configArray($d, 'features');
            if ($features !== null) {
                $this->features = [];
                foreach ($features as $item) {
                    if (is_string($item)) {
                        $this->features[] = $item;
                    }
                }
            }
        }
        $this->showCheckmarks ??= $this->configBoolWithFallback($d, 'show_checkmarks', true);

        // CTA
        $this->ctaLabel ??= $this->configStringWithFallback($d, 'cta_label', 'Get Started');
        $this->ctaHref ??= $this->configString($d, 'cta_href');
        $this->ctaVariant ??= $this->configStringWithFallback($d, 'cta_variant', 'primary');
        $this->ctaSize ??= $this->configStringWithFallback($d, 'cta_size', 'lg');
        $this->ctaOutline ??= $this->configBoolWithFallback($d, 'cta_outline', false);
        $this->ctaBlock ??= $this->configBoolWithFallback($d, 'cta_block', true);

        // Styling
        $this->featured ??= $this->configBoolWithFallback($d, 'featured', false);
        $this->shadow ??= $this->configBoolWithFallback($d, 'shadow', false);
        $this->variant ??= $this->configString($d, 'variant');
        $this->border ??= $this->configBoolWithFallback($d, 'border', true);
        $this->textAlign ??= $this->configStringWithFallback($d, 'text_align', 'center');

        // Merge attr defaults
        if (isset($d['attr']) && is_array($d['attr'])) {
            $this->attr = array_merge($d['attr'], $this->attr);
        }

        // Initialize controller with default
        $this->initializeController();
    }

    protected function getComponentName(): string
    {
        return 'pricing-card';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = $this->buildClassesFromArrays(
            ['card', 'h-100'],
            $this->featured ? ['border-primary', 'border-3'] : [],
            $this->shadow ? ['shadow-lg'] : [],
            !$this->border ? ['border-0'] : [],
            $this->variant ? ["text-bg-{$this->variant}"] : [],
            $this->textAlign ? ["text-{$this->textAlign}"] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = $this->mergeAttributes([], $this->attr);

        // Build button classes
        $btnClasses = ['btn'];
        $btnClasses[] = $this->ctaOutline
            ? "btn-outline-{$this->ctaVariant}"
            : "btn-{$this->ctaVariant}";
        $btnClasses[] = "btn-{$this->ctaSize}";
        if ($this->ctaBlock) {
            $btnClasses[] = 'w-100';
        }

        return [
            'classes' => $classes,
            'attrs' => $attrs,
            'plan' => $this->plan,
            'planDescription' => $this->planDescription,
            'price' => $this->price,
            'currency' => $this->currency,
            'period' => $this->period,
            'showPeriod' => $this->showPeriod,
            'badge' => $this->badge,
            'badgeVariant' => $this->badgeVariant,
            'features' => $this->features,
            'showCheckmarks' => $this->showCheckmarks,
            'ctaLabel' => $this->ctaLabel,
            'ctaHref' => $this->ctaHref,
            'btnClasses' => implode(' ', $btnClasses),
            'featured' => $this->featured,
        ];
    }
}

