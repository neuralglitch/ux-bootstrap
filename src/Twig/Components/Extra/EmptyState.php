<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:empty-state', template: '@NeuralGlitchUxBootstrap/components/extra/empty-state.html.twig')]
final class EmptyState extends AbstractStimulus
{
    // Content
    public ?string $title = null;
    public ?string $description = null;

    // Icon/Image
    public ?string $icon = null;
    public ?string $iconClass = null;
    public ?string $imageSrc = null;
    public ?string $imageAlt = null;

    // Call-to-Action
    public ?string $ctaLabel = null;
    public ?string $ctaHref = null;
    public ?string $ctaVariant = 'primary';
    public ?string $ctaSize = null;

    // Secondary CTA
    public ?string $secondaryCtaLabel = null;
    public ?string $secondaryCtaHref = null;
    public ?string $secondaryCtaVariant = 'outline-secondary';
    public ?string $secondaryCtaSize = null;

    // Styling
    public ?string $variant = null; // null, 'info', 'warning', 'success', 'danger'
    public ?string $size = null;    // null, 'sm', 'lg'
    public string $container = 'container';
    public bool $centered = true;

    public function mount(): void
    {
        $d = $this->config->for('empty-state');

        $this->applyStimulusDefaults($d);

        // Apply base class defaults
        $this->applyClassDefaults($d);

        // Apply component-specific defaults
        $this->title ??= $this->configStringWithFallback($d, 'title', 'No items found');
        $this->description ??= $this->configString($d, 'description');
        $this->icon ??= $this->configString($d, 'icon');
        $this->iconClass ??= $this->configString($d, 'icon_class');
        $this->imageSrc ??= $this->configString($d, 'image_src');
        $this->imageAlt ??= $this->configString($d, 'image_alt');
        $this->ctaLabel ??= $this->configString($d, 'cta_label');
        $this->ctaHref ??= $this->configString($d, 'cta_href');
        $this->ctaVariant ??= $this->configStringWithFallback($d, 'cta_variant', 'primary');
        $this->ctaSize ??= $this->configString($d, 'cta_size');
        $this->secondaryCtaLabel ??= $this->configString($d, 'secondary_cta_label');
        $this->secondaryCtaHref ??= $this->configString($d, 'secondary_cta_href');
        $this->secondaryCtaVariant ??= $this->configStringWithFallback($d, 'secondary_cta_variant', 'outline-secondary');
        $this->secondaryCtaSize ??= $this->configString($d, 'secondary_cta_size');
        $this->variant ??= $this->configString($d, 'variant');
        $this->size ??= $this->configString($d, 'size');
        $this->container ??= $this->configStringWithFallback($d, 'container', 'container');
        $this->centered = $this->centered && $this->configBoolWithFallback($d, 'centered', true);


        // Initialize controller with default
        $this->initializeController();
    }

    protected function getComponentName(): string
    {
        return 'empty-state';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $containerClasses = $this->buildClassesFromArrays(
            [$this->container],
            $this->centered ? ['text-center'] : [],
            ['py-5']
        );

        $classArray = $this->class ? array_filter(explode(' ', trim($this->class)), fn($v) => $v !== '') : [];
        /** @var array<string> $classArray */
        
        $wrapperClasses = $this->buildClassesFromArrays(
            ['empty-state'],
            $this->size === 'sm' ? ['empty-state-sm'] : [],
            $this->size === 'lg' ? ['empty-state-lg'] : [],
            $this->variant ? ["empty-state-{$this->variant}"] : [],
            $classArray
        );

        $iconClasses = $this->buildClassesFromArrays(
            ['empty-state-icon'],
            $this->size === 'sm' ? ['fs-1'] : [],
            $this->size === 'lg' ? ['fs-display-1'] : ['fs-2'],
            $this->variant ? ["text-{$this->variant}"] : ['text-muted'],
            ['mb-3'],
            $this->iconClass ? array_filter(explode(' ', trim($this->iconClass)), fn($v) => $v !== '') : []
        );

        $titleClasses = $this->buildClasses(
            ['empty-state-title'],
            $this->size === 'sm' ? ['h5'] : [],
            $this->size === 'lg' ? ['display-5'] : ['h4'],
            ['mb-2']
        );

        $descriptionClasses = $this->buildClasses(
            ['empty-state-description', 'text-muted', 'mb-4'],
            $this->size === 'sm' ? ['small'] : [],
            $this->size === 'lg' ? ['fs-5'] : []
        );

        $imageClasses = $this->buildClasses(
            ['empty-state-image', 'mb-4'],
            $this->size === 'sm' ? ['w-25'] : [],
            $this->size === 'lg' ? ['w-50'] : ['w-50', 'w-md-25']
        );

        $attrs = $this->mergeAttributes([], $this->attr);

        return [
            'title' => $this->title,
            'description' => $this->description,
            'icon' => $this->icon,
            'iconClasses' => $iconClasses,
            'imageSrc' => $this->imageSrc,
            'imageAlt' => $this->imageAlt,
            'imageClasses' => $imageClasses,
            'ctaLabel' => $this->ctaLabel,
            'ctaHref' => $this->ctaHref,
            'ctaVariant' => $this->ctaVariant,
            'ctaSize' => $this->ctaSize,
            'secondaryCtaLabel' => $this->secondaryCtaLabel,
            'secondaryCtaHref' => $this->secondaryCtaHref,
            'secondaryCtaVariant' => $this->secondaryCtaVariant,
            'secondaryCtaSize' => $this->secondaryCtaSize,
            'containerClasses' => $containerClasses,
            'wrapperClasses' => $wrapperClasses,
            'titleClasses' => $titleClasses,
            'descriptionClasses' => $descriptionClasses,
            'attrs' => $attrs,
        ];
    }
}

