<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractBootstrap;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:empty-state', template: '@NeuralGlitchUxBootstrap/components/extra/empty-state.html.twig')]
final class EmptyState extends AbstractBootstrap
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
        $d = $this->config->for('empty_state');

        // Apply base class defaults
        $this->applyClassDefaults($d);

        // Apply component-specific defaults
        $this->title ??= $d['title'] ?? 'No items found';
        $this->description ??= $d['description'] ?? null;
        $this->icon ??= $d['icon'] ?? null;
        $this->iconClass ??= $d['icon_class'] ?? null;
        $this->imageSrc ??= $d['image_src'] ?? null;
        $this->imageAlt ??= $d['image_alt'] ?? null;
        $this->ctaLabel ??= $d['cta_label'] ?? null;
        $this->ctaHref ??= $d['cta_href'] ?? null;
        $this->ctaVariant ??= $d['cta_variant'] ?? 'primary';
        $this->ctaSize ??= $d['cta_size'] ?? null;
        $this->secondaryCtaLabel ??= $d['secondary_cta_label'] ?? null;
        $this->secondaryCtaHref ??= $d['secondary_cta_href'] ?? null;
        $this->secondaryCtaVariant ??= $d['secondary_cta_variant'] ?? 'outline-secondary';
        $this->secondaryCtaSize ??= $d['secondary_cta_size'] ?? null;
        $this->variant ??= $d['variant'] ?? null;
        $this->size ??= $d['size'] ?? null;
        $this->container ??= $d['container'] ?? 'container';
        $this->centered = $this->centered && ($d['centered'] ?? true);
    }

    protected function getComponentName(): string
    {
        return 'empty_state';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $containerClasses = $this->buildClasses(
            [$this->container],
            $this->centered ? ['text-center'] : [],
            ['py-5']
        );

        $wrapperClasses = $this->buildClasses(
            ['empty-state'],
            $this->size === 'sm' ? ['empty-state-sm'] : [],
            $this->size === 'lg' ? ['empty-state-lg'] : [],
            $this->variant ? ["empty-state-{$this->variant}"] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $iconClasses = $this->buildClasses(
            ['empty-state-icon'],
            $this->size === 'sm' ? ['fs-1'] : [],
            $this->size === 'lg' ? ['fs-display-1'] : ['fs-2'],
            $this->variant ? ["text-{$this->variant}"] : ['text-muted'],
            ['mb-3'],
            $this->iconClass ? explode(' ', trim($this->iconClass)) : []
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

