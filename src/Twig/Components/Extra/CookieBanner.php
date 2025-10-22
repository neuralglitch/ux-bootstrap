<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:cookie-banner', template: '@NeuralGlitchUxBootstrap/components/extra/cookie-banner.html.twig')]
final class CookieBanner extends AbstractStimulus
{
    // Stimulus controller
    public string $stimulusController = 'bs-cookie-banner';

    // Position
    public ?string $position = null; // 'top' | 'bottom' | 'top-fixed' | 'bottom-fixed'

    // Content
    public ?string $title = null;
    public ?string $message = null;
    public ?string $privacyUrl = null;
    public ?string $privacyLinkText = 'Privacy Policy';
    public ?string $cookiePolicyUrl = null;
    public ?string $cookiePolicyLinkText = 'Cookie Policy';

    // Buttons
    public string $acceptText = 'Accept';
    public string $rejectText = 'Reject';
    public ?string $customizeText = 'Customize';
    public ?bool $showReject = null;
    public ?bool $showCustomize = null;

    // Button variants
    public ?string $acceptVariant = null;
    public ?string $rejectVariant = null;
    public ?string $customizeVariant = null;

    // Storage
    public string $cookieName = 'cookie_consent';
    public int $expiryDays = 365;

    // Behavior
    public ?bool $dismissible = null;
    public ?bool $backdrop = null; // Show backdrop overlay

    // Styling
    public ?string $variant = null; // Bootstrap background variant
    public ?string $shadow = null;

    public function mount(): void
    {
        $d = $this->config->for('cookie-banner');

        $this->applyStimulusDefaults($d);

        // Apply base defaults
        $this->applyClassDefaults($d);

        // Apply component-specific defaults
        $this->position ??= $d['position'] ?? 'bottom';
        $this->title ??= $d['title'] ?? 'We use cookies';
        $this->message ??= $d['message'] ?? 'We use cookies to ensure you get the best experience on our website.';
        $this->privacyUrl ??= $d['privacy_url'] ?? null;
        $this->privacyLinkText ??= $d['privacy_link_text'] ?? 'Privacy Policy';
        $this->cookiePolicyUrl ??= $d['cookie_policy_url'] ?? null;
        $this->cookiePolicyLinkText ??= $d['cookie_policy_link_text'] ?? 'Cookie Policy';

        $this->acceptText ??= $d['accept_text'] ?? 'Accept';
        $this->rejectText ??= $d['reject_text'] ?? 'Reject';
        $this->customizeText ??= $d['customize_text'] ?? 'Customize';
        $this->showReject ??= $d['show_reject'] ?? true;
        $this->showCustomize ??= $d['show_customize'] ?? false;

        $this->acceptVariant ??= $d['accept_variant'] ?? 'primary';
        $this->rejectVariant ??= $d['reject_variant'] ?? 'secondary';
        $this->customizeVariant ??= $d['customize_variant'] ?? 'outline-secondary';

        $this->cookieName ??= $d['cookie_name'] ?? 'cookie_consent';
        $this->expiryDays ??= $d['expiry_days'] ?? 365;

        $this->dismissible ??= $d['dismissible'] ?? false;
        $this->backdrop ??= $d['backdrop'] ?? false;

        $this->variant ??= $d['variant'] ?? 'light';
        $this->shadow ??= $d['shadow'] ?? 'shadow-lg';


        // Initialize controller with default
        $this->initializeController();
    }

    protected function getComponentName(): string
    {
        return 'cookie-banner';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = $this->buildClasses(
            ['cookie-banner', "bg-{$this->variant}", 'text-body', 'border-top', $this->shadow],
            $this->getPositionClasses(),
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = $this->mergeAttributes([
            'data-controller' => $this->stimulusController,
            'data-bs-cookie-banner-cookie-name-value' => $this->cookieName,
            'data-bs-cookie-banner-expiry-days-value' => (string)$this->expiryDays,
            'data-bs-cookie-banner-backdrop-value' => $this->backdrop ? 'true' : 'false',
        ], $this->attr);

        return [
            'classes' => $classes,
            'attrs' => $attrs,
            'title' => $this->title,
            'message' => $this->message,
            'privacyUrl' => $this->privacyUrl,
            'privacyLinkText' => $this->privacyLinkText,
            'cookiePolicyUrl' => $this->cookiePolicyUrl,
            'cookiePolicyLinkText' => $this->cookiePolicyLinkText,
            'acceptText' => $this->acceptText,
            'rejectText' => $this->rejectText,
            'customizeText' => $this->customizeText,
            'showReject' => $this->showReject,
            'showCustomize' => $this->showCustomize,
            'acceptVariant' => $this->acceptVariant,
            'rejectVariant' => $this->rejectVariant,
            'customizeVariant' => $this->customizeVariant,
            'dismissible' => $this->dismissible,
            'backdrop' => $this->backdrop,
        ];
    }

    /**
     * @return array<string>
     */
    private function getPositionClasses(): array
    {
        return match ($this->position) {
            'top' => ['cookie-banner-top', 'position-relative'],
            'bottom' => ['cookie-banner-bottom', 'position-relative'],
            'top-fixed' => ['cookie-banner-top', 'position-fixed', 'top-0', 'start-0', 'end-0'],
            'bottom-fixed' => ['cookie-banner-bottom', 'position-fixed', 'bottom-0', 'start-0', 'end-0'],
            default => ['cookie-banner-bottom', 'position-relative'],
        };
    }
}

