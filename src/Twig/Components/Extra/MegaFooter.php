<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:mega-footer', template: '@NeuralGlitchUxBootstrap/components/extra/mega-footer.html.twig')]
final class MegaFooter extends AbstractStimulus
{
    public ?string $variant = null; // 'default' | 'minimal' | 'centered' | 'compact'

    // Branding
    public ?string $brandName = null;
    public ?string $brandLogo = null;
    public ?string $brandHref = null;
    public ?string $brandDescription = null;

    // Social Links (array of ['icon' => 'bi-facebook', 'href' => '#', 'label' => 'Facebook'])
    /** @var array<int, array<string, string>> */
    public array $socialLinks = [];

    // Copyright
    public ?string $copyrightText = null;
    public ?bool $showCopyright = null;

    // Newsletter
    public ?bool $showNewsletter = null;
    public ?string $newsletterTitle = null;
    public ?string $newsletterPlaceholder = null;
    public ?string $newsletterButtonText = null;

    // Layout
    public ?string $backgroundColor = null; // 'dark' | 'light' | 'body' | 'body-tertiary'
    public ?string $textColor = null; // 'white' | 'dark' | 'body' | 'body-secondary'
    public ?string $container = null; // 'container' | 'container-fluid' | 'container-{breakpoint}'

    // Divider above footer
    public ?bool $showDivider = null;

    public function mount(): void
    {
        $d = $this->config->for('mega-footer');

        $this->applyStimulusDefaults($d);

        // Apply defaults from config
        $this->variant ??= $d['variant'] ?? 'default';
        $this->brandName ??= $d['brand_name'] ?? null;
        $this->brandLogo ??= $d['brand_logo'] ?? null;
        $this->brandHref ??= $d['brand_href'] ?? '/';
        $this->brandDescription ??= $d['brand_description'] ?? null;

        // Social links (merge with config defaults)
        if (empty($this->socialLinks) && isset($d['social_links']) && is_array($d['social_links'])) {
            $this->socialLinks = $d['social_links'];


            // Initialize controller with default
            $this->initializeController();
        }

        // Copyright
        $this->copyrightText ??= $d['copyright_text'] ?? null;
        $this->showCopyright ??= $d['show_copyright'] ?? true;

        // Newsletter
        $this->showNewsletter ??= $d['show_newsletter'] ?? false;
        $this->newsletterTitle ??= $d['newsletter_title'] ?? 'Subscribe to our newsletter';
        $this->newsletterPlaceholder ??= $d['newsletter_placeholder'] ?? 'Email address';
        $this->newsletterButtonText ??= $d['newsletter_button_text'] ?? 'Subscribe';

        // Layout
        $this->backgroundColor ??= $d['background_color'] ?? 'dark';
        $this->textColor ??= $d['text_color'] ?? 'white';
        $this->container ??= $d['container'] ?? 'container';
        $this->showDivider ??= $d['show_divider'] ?? true;

        $this->applyClassDefaults($d);

        // Merge attr defaults
        if (isset($d['attr']) && is_array($d['attr'])) {
            $this->attr = array_merge($d['attr'], $this->attr);
        }
    }

    protected function getComponentName(): string
    {
        return 'mega-footer';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = $this->buildClasses(
            ['footer', 'mt-auto'],
            ["bg-{$this->backgroundColor}"],
            ["text-{$this->textColor}"],
            $this->showDivider ? ['border-top'] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = $this->mergeAttributes([], $this->attr);

        // Auto-generate copyright if not provided
        $copyright = $this->copyrightText;
        if ($this->showCopyright && !$copyright && $this->brandName) {
            $year = date('Y');
            $copyright = "© {$year} {$this->brandName}. All rights reserved.";
        }

        return [
            'variant' => $this->variant,
            'brandName' => $this->brandName,
            'brandLogo' => $this->brandLogo,
            'brandHref' => $this->brandHref,
            'brandDescription' => $this->brandDescription,
            'socialLinks' => $this->socialLinks,
            'copyrightText' => $copyright,
            'showCopyright' => $this->showCopyright,
            'showNewsletter' => $this->showNewsletter,
            'newsletterTitle' => $this->newsletterTitle,
            'newsletterPlaceholder' => $this->newsletterPlaceholder,
            'newsletterButtonText' => $this->newsletterButtonText,
            'container' => $this->container,
            'classes' => $classes,
            'attrs' => $attrs,
        ];
    }
}

