<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\CookieBanner;
use PHPUnit\Framework\TestCase;

final class CookieBannerTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'cookie_banner' => [
                'position' => 'bottom',
                'title' => 'We use cookies',
                'message' => 'We use cookies to ensure you get the best experience on our website.',
                'privacy_url' => null,
                'privacy_link_text' => 'Privacy Policy',
                'cookie_policy_url' => null,
                'cookie_policy_link_text' => 'Cookie Policy',
                'accept_text' => 'Accept',
                'reject_text' => 'Reject',
                'customize_text' => 'Customize',
                'show_reject' => true,
                'show_customize' => false,
                'accept_variant' => 'primary',
                'reject_variant' => 'secondary',
                'customize_variant' => 'outline-secondary',
                'cookie_name' => 'cookie_consent',
                'expiry_days' => 365,
                'dismissible' => false,
                'backdrop' => false,
                'variant' => 'light',
                'shadow' => 'shadow-lg',
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new CookieBanner($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('cookie-banner', $options['classes']);
        $this->assertStringContainsString('bg-light', $options['classes']);
        $this->assertStringContainsString('shadow-lg', $options['classes']);
        $this->assertStringContainsString('cookie-banner-bottom', $options['classes']);
        $this->assertSame('We use cookies', $options['title']);
        $this->assertTrue($options['showReject']);
        $this->assertFalse($options['showCustomize']);
    }

    public function testPositionBottom(): void
    {
        $component = new CookieBanner($this->config);
        $component->position = 'bottom';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('cookie-banner-bottom', $options['classes']);
        $this->assertStringContainsString('position-relative', $options['classes']);
        $this->assertStringNotContainsString('position-fixed', $options['classes']);
    }

    public function testPositionTop(): void
    {
        $component = new CookieBanner($this->config);
        $component->position = 'top';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('cookie-banner-top', $options['classes']);
        $this->assertStringContainsString('position-relative', $options['classes']);
        $this->assertStringNotContainsString('position-fixed', $options['classes']);
    }

    public function testPositionBottomFixed(): void
    {
        $component = new CookieBanner($this->config);
        $component->position = 'bottom-fixed';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('cookie-banner-bottom', $options['classes']);
        $this->assertStringContainsString('position-fixed', $options['classes']);
        $this->assertStringContainsString('bottom-0', $options['classes']);
        $this->assertStringContainsString('start-0', $options['classes']);
        $this->assertStringContainsString('end-0', $options['classes']);
    }

    public function testPositionTopFixed(): void
    {
        $component = new CookieBanner($this->config);
        $component->position = 'top-fixed';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('cookie-banner-top', $options['classes']);
        $this->assertStringContainsString('position-fixed', $options['classes']);
        $this->assertStringContainsString('top-0', $options['classes']);
        $this->assertStringContainsString('start-0', $options['classes']);
        $this->assertStringContainsString('end-0', $options['classes']);
    }

    public function testCustomTitle(): void
    {
        $component = new CookieBanner($this->config);
        $component->title = 'Cookie Consent';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Cookie Consent', $options['title']);
    }

    public function testCustomMessage(): void
    {
        $component = new CookieBanner($this->config);
        $component->message = 'Custom cookie message';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Custom cookie message', $options['message']);
    }

    public function testPrivacyUrls(): void
    {
        $component = new CookieBanner($this->config);
        $component->privacyUrl = '/privacy';
        $component->cookiePolicyUrl = '/cookies';
        $component->mount();
        $options = $component->options();

        $this->assertSame('/privacy', $options['privacyUrl']);
        $this->assertSame('/cookies', $options['cookiePolicyUrl']);
        $this->assertSame('Privacy Policy', $options['privacyLinkText']);
        $this->assertSame('Cookie Policy', $options['cookiePolicyLinkText']);
    }

    public function testCustomLinkText(): void
    {
        $component = new CookieBanner($this->config);
        $component->privacyLinkText = 'Our Privacy';
        $component->cookiePolicyLinkText = 'Our Cookies';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Our Privacy', $options['privacyLinkText']);
        $this->assertSame('Our Cookies', $options['cookiePolicyLinkText']);
    }

    public function testCustomButtonText(): void
    {
        $component = new CookieBanner($this->config);
        $component->acceptText = 'Accept All';
        $component->rejectText = 'Decline';
        $component->customizeText = 'Settings';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Accept All', $options['acceptText']);
        $this->assertSame('Decline', $options['rejectText']);
        $this->assertSame('Settings', $options['customizeText']);
    }

    public function testShowRejectFalse(): void
    {
        $component = new CookieBanner($this->config);
        $component->showReject = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['showReject']);
    }

    public function testShowCustomizeTrue(): void
    {
        $component = new CookieBanner($this->config);
        $component->showCustomize = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['showCustomize']);
    }

    public function testCustomButtonVariants(): void
    {
        $component = new CookieBanner($this->config);
        $component->acceptVariant = 'success';
        $component->rejectVariant = 'danger';
        $component->customizeVariant = 'outline-primary';
        $component->mount();
        $options = $component->options();

        $this->assertSame('success', $options['acceptVariant']);
        $this->assertSame('danger', $options['rejectVariant']);
        $this->assertSame('outline-primary', $options['customizeVariant']);
    }

    public function testCustomCookieName(): void
    {
        $component = new CookieBanner($this->config);
        $component->cookieName = 'my_consent';
        $component->mount();
        $options = $component->options();

        $this->assertSame('my_consent', $options['attrs']['data-bs-cookie-banner-cookie-name-value']);
    }

    public function testCustomExpiryDays(): void
    {
        $component = new CookieBanner($this->config);
        $component->expiryDays = 90;
        $component->mount();
        $options = $component->options();

        $this->assertSame('90', $options['attrs']['data-bs-cookie-banner-expiry-days-value']);
    }

    public function testDismissibleTrue(): void
    {
        $component = new CookieBanner($this->config);
        $component->dismissible = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['dismissible']);
    }

    public function testBackdropTrue(): void
    {
        $component = new CookieBanner($this->config);
        $component->backdrop = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['backdrop']);
        $this->assertSame('true', $options['attrs']['data-bs-cookie-banner-backdrop-value']);
    }

    public function testBackdropFalse(): void
    {
        $component = new CookieBanner($this->config);
        $component->backdrop = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['backdrop']);
        $this->assertSame('false', $options['attrs']['data-bs-cookie-banner-backdrop-value']);
    }

    public function testCustomVariant(): void
    {
        $component = new CookieBanner($this->config);
        $component->variant = 'dark';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('bg-dark', $options['classes']);
        $this->assertStringNotContainsString('bg-light', $options['classes']);
    }

    public function testCustomShadow(): void
    {
        $component = new CookieBanner($this->config);
        $component->shadow = 'shadow-sm';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('shadow-sm', $options['classes']);
        $this->assertStringNotContainsString('shadow-lg', $options['classes']);
    }

    public function testStimulusController(): void
    {
        $component = new CookieBanner($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-controller', $options['attrs']);
        $this->assertSame('bs-cookie_banner', $options['attrs']['data-controller']);
    }

    public function testCustomClasses(): void
    {
        $component = new CookieBanner($this->config);
        $component->class = 'custom-banner border-top';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-banner', $options['classes']);
        $this->assertStringContainsString('border-top', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new CookieBanner($this->config);
        $component->attr = [
            'data-custom' => 'value',
            'aria-label' => 'Cookie Consent Banner',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-custom', $options['attrs']);
        $this->assertSame('value', $options['attrs']['data-custom']);
        $this->assertArrayHasKey('aria-label', $options['attrs']);
        $this->assertSame('Cookie Consent Banner', $options['attrs']['aria-label']);
    }

    public function testGetComponentName(): void
    {
        $component = new CookieBanner($this->config);
        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('cookie_banner', $method->invoke($component));
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'cookie_banner' => [
                'position' => 'top-fixed',
                'title' => 'Cookie Notice',
                'accept_variant' => 'success',
                'variant' => 'dark',
                'class' => 'custom-default',
            ],
        ]);

        $component = new CookieBanner($config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('cookie-banner-top', $options['classes']);
        $this->assertStringContainsString('position-fixed', $options['classes']);
        $this->assertSame('Cookie Notice', $options['title']);
        $this->assertSame('success', $options['acceptVariant']);
        $this->assertStringContainsString('bg-dark', $options['classes']);
        $this->assertStringContainsString('custom-default', $options['classes']);
    }
}

