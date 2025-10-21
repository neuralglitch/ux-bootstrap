<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:pricing-card', template: '@NeuralGlitchUxBootstrap/components/extra/pricing-card.html.twig')]
final class PricingCard extends AbstractStimulus
{
    // Plan Details
    public ?string $planName = null;
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
        $d = $this->config->for('pricing_card');

        $this->applyStimulusDefaults($d);
        
        // Apply defaults
        $this->applyClassDefaults($d);
        
        // Plan details
        $this->planName ??= $d['plan_name'] ?? 'Free';
        $this->planDescription ??= $d['plan_description'] ?? null;
        
        // Pricing
        $this->price ??= $d['price'] ?? '0';
        $this->currency ??= $d['currency'] ?? '$';
        $this->period ??= $d['period'] ?? 'month';
        $this->showPeriod ??= $d['show_period'] ?? true;
        
        // Badge
        $this->badge ??= $d['badge'] ?? null;
        $this->badgeVariant ??= $d['badge_variant'] ?? 'primary';
        
        // Features
        if (empty($this->features) && isset($d['features']) && is_array($d['features'])) {
            $this->features = $d['features'];

        
        // Initialize controller with default
        $this->initializeController();
    }
        $this->showCheckmarks ??= $d['show_checkmarks'] ?? true;
        
        // CTA
        $this->ctaLabel ??= $d['cta_label'] ?? 'Get Started';
        $this->ctaHref ??= $d['cta_href'] ?? null;
        $this->ctaVariant ??= $d['cta_variant'] ?? 'primary';
        $this->ctaSize ??= $d['cta_size'] ?? 'lg';
        $this->ctaOutline ??= $d['cta_outline'] ?? false;
        $this->ctaBlock ??= $d['cta_block'] ?? true;
        
        // Styling
        $this->featured ??= $d['featured'] ?? false;
        $this->shadow ??= $d['shadow'] ?? false;
        $this->variant ??= $d['variant'] ?? null;
        $this->border ??= $d['border'] ?? true;
        $this->textAlign ??= $d['text_align'] ?? 'center';
        
        // Merge attr defaults
        if (isset($d['attr']) && is_array($d['attr'])) {
            $this->attr = array_merge($d['attr'], $this->attr);
        }
    }
    
    protected function getComponentName(): string
    {
        return 'pricing_card';
    }
    
    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = $this->buildClasses(
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
            'planName' => $this->planName,
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

