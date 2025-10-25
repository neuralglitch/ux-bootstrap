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
        $this->variant ??= $this->configStringWithFallback($d, 'variant', 'default');
        $this->brandName ??= $this->configString($d, 'brand_name');
        $this->brandLogo ??= $this->configString($d, 'brand_logo');
        $this->brandHref ??= $this->configStringWithFallback($d, 'brand_href', '/');
        $this->brandDescription ??= $this->configString($d, 'brand_description');

        // Social links (merge with config defaults)
        if (empty($this->socialLinks) && isset($d['social_links']) && is_array($d['social_links'])) {
            $socialLinks = $this->configArray($d, 'social_links', []) ?? [];
            /** @var array<int, array<string, string>> $socialLinks */
            $this->socialLinks = $socialLinks;

            // Initialize controller with default
            $this->initializeController();
        }

        // Copyright
        $this->copyrightText ??= $this->configString($d, 'copyright_text');
        $this->showCopyright ??= $this->configBool($d, 'show_copyright');

        // Newsletter
        $this->showNewsletter ??= $this->configBool($d, 'show_newsletter');
        $this->newsletterTitle ??= $this->configStringWithFallback($d, 'newsletter_title', 'Subscribe to our newsletter');
        $this->newsletterPlaceholder ??= $this->configStringWithFallback($d, 'newsletter_placeholder', 'Email address');
        $this->newsletterButtonText ??= $this->configStringWithFallback($d, 'newsletter_button_text', 'Subscribe');

        // Layout
        $this->backgroundColor ??= $this->configStringWithFallback($d, 'background_color', 'dark');
        $this->textColor ??= $this->configStringWithFallback($d, 'text_color', 'white');
        $this->container ??= $this->configStringWithFallback($d, 'container', 'container');
        $this->showDivider ??= $this->configBool($d, 'show_divider');

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
        $classArray = $this->class ? array_filter(explode(' ', trim($this->class)), fn($v) => $v !== '') : [];
        /** @var array<string> $classArray */

        $classes = $this->buildClassesFromArrays(
            ['footer', 'mt-auto'],
            ["bg-{$this->backgroundColor}"],
            ["text-{$this->textColor}"],
            $this->showDivider ? ['border-top'] : [],
            $classArray
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

