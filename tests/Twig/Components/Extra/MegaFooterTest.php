<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\MegaFooter;
use PHPUnit\Framework\TestCase;

final class MegaFooterTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'mega_footer' => [
                'variant' => 'default',
                'brand_name' => null,
                'brand_logo' => null,
                'brand_href' => '/',
                'brand_description' => null,
                'social_links' => [],
                'copyright_text' => null,
                'show_copyright' => true,
                'show_newsletter' => false,
                'newsletter_title' => 'Subscribe to our newsletter',
                'newsletter_placeholder' => 'Email address',
                'newsletter_button_text' => 'Subscribe',
                'background_color' => 'dark',
                'text_color' => 'white',
                'container' => 'container',
                'show_divider' => true,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new MegaFooter($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('footer', $options['classes']);
        $this->assertStringContainsString('mt-auto', $options['classes']);
        $this->assertStringContainsString('bg-dark', $options['classes']);
        $this->assertStringContainsString('text-white', $options['classes']);
        $this->assertStringContainsString('border-top', $options['classes']);
        $this->assertSame('default', $options['variant']);
        $this->assertSame('container', $options['container']);
    }

    public function testVariantOption(): void
    {
        $variants = ['default', 'minimal', 'centered', 'compact'];

        foreach ($variants as $variant) {
            $component = new MegaFooter($this->config);
            $component->variant = $variant;
            $component->mount();
            $options = $component->options();

            $this->assertSame($variant, $options['variant']);
        }
    }

    public function testBrandName(): void
    {
        $component = new MegaFooter($this->config);
        $component->brandName = 'Acme Corp';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Acme Corp', $options['brandName']);
    }

    public function testBrandLogo(): void
    {
        $component = new MegaFooter($this->config);
        $component->brandLogo = '/logo.png';
        $component->mount();
        $options = $component->options();

        $this->assertSame('/logo.png', $options['brandLogo']);
    }

    public function testBrandHref(): void
    {
        $component = new MegaFooter($this->config);
        $component->brandHref = '/home';
        $component->mount();
        $options = $component->options();

        $this->assertSame('/home', $options['brandHref']);
    }

    public function testBrandDescription(): void
    {
        $component = new MegaFooter($this->config);
        $component->brandDescription = 'Building great things since 2020';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Building great things since 2020', $options['brandDescription']);
    }

    public function testSocialLinks(): void
    {
        $component = new MegaFooter($this->config);
        $component->socialLinks = [
            ['icon' => 'bi-facebook', 'href' => 'https://facebook.com', 'label' => 'Facebook'],
            ['icon' => 'bi-twitter', 'href' => 'https://twitter.com', 'label' => 'Twitter'],
        ];
        $component->mount();
        $options = $component->options();

        $this->assertCount(2, $options['socialLinks']);
        $this->assertSame('bi-facebook', $options['socialLinks'][0]['icon']);
        $this->assertSame('https://facebook.com', $options['socialLinks'][0]['href']);
    }

    public function testSocialLinksFromConfig(): void
    {
        $config = new Config([
            'mega_footer' => [
                'variant' => 'default',
                'social_links' => [
                    ['icon' => 'bi-linkedin', 'href' => 'https://linkedin.com', 'label' => 'LinkedIn'],
                ],
                'brand_name' => null,
                'brand_logo' => null,
                'brand_href' => '/',
                'brand_description' => null,
                'copyright_text' => null,
                'show_copyright' => true,
                'show_newsletter' => false,
                'newsletter_title' => 'Subscribe to our newsletter',
                'newsletter_placeholder' => 'Email address',
                'newsletter_button_text' => 'Subscribe',
                'background_color' => 'dark',
                'text_color' => 'white',
                'container' => 'container',
                'show_divider' => true,
                'class' => null,
                'attr' => [],
            ],
        ]);

        $component = new MegaFooter($config);
        $component->mount();
        $options = $component->options();

        $this->assertCount(1, $options['socialLinks']);
        $this->assertSame('bi-linkedin', $options['socialLinks'][0]['icon']);
    }

    public function testCopyrightText(): void
    {
        $component = new MegaFooter($this->config);
        $component->copyrightText = '© 2025 Custom Copyright';
        $component->mount();
        $options = $component->options();

        $this->assertSame('© 2025 Custom Copyright', $options['copyrightText']);
    }

    public function testCopyrightAutoGeneration(): void
    {
        $component = new MegaFooter($this->config);
        $component->brandName = 'Test Company';
        $component->showCopyright = true;
        $component->copyrightText = null;
        $component->mount();
        $options = $component->options();

        $year = date('Y');
        $this->assertStringContainsString($year, $options['copyrightText']);
        $this->assertStringContainsString('Test Company', $options['copyrightText']);
        $this->assertStringContainsString('All rights reserved', $options['copyrightText']);
    }

    public function testShowCopyright(): void
    {
        $component = new MegaFooter($this->config);
        $component->showCopyright = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['showCopyright']);
    }

    public function testShowNewsletter(): void
    {
        $component = new MegaFooter($this->config);
        $component->showNewsletter = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['showNewsletter']);
        $this->assertSame('Subscribe to our newsletter', $options['newsletterTitle']);
        $this->assertSame('Email address', $options['newsletterPlaceholder']);
        $this->assertSame('Subscribe', $options['newsletterButtonText']);
    }

    public function testNewsletterCustomization(): void
    {
        $component = new MegaFooter($this->config);
        $component->showNewsletter = true;
        $component->newsletterTitle = 'Get Updates';
        $component->newsletterPlaceholder = 'Your email';
        $component->newsletterButtonText = 'Sign Up';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Get Updates', $options['newsletterTitle']);
        $this->assertSame('Your email', $options['newsletterPlaceholder']);
        $this->assertSame('Sign Up', $options['newsletterButtonText']);
    }

    public function testBackgroundColor(): void
    {
        $component = new MegaFooter($this->config);
        $component->backgroundColor = 'light';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('bg-light', $options['classes']);
    }

    public function testTextColor(): void
    {
        $component = new MegaFooter($this->config);
        $component->textColor = 'dark';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('text-dark', $options['classes']);
    }

    public function testContainer(): void
    {
        $component = new MegaFooter($this->config);
        $component->container = 'container-fluid';
        $component->mount();
        $options = $component->options();

        $this->assertSame('container-fluid', $options['container']);
    }

    public function testShowDivider(): void
    {
        $component = new MegaFooter($this->config);
        $component->showDivider = false;
        $component->mount();
        $options = $component->options();

        $this->assertStringNotContainsString('border-top', $options['classes']);
    }

    public function testCustomClass(): void
    {
        $component = new MegaFooter($this->config);
        $component->class = 'custom-footer another-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-footer', $options['classes']);
        $this->assertStringContainsString('another-class', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new MegaFooter($this->config);
        $component->attr = [
            'data-controller' => 'footer',
            'id' => 'main-footer',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-controller', $options['attrs']);
        $this->assertSame('footer', $options['attrs']['data-controller']);
        $this->assertArrayHasKey('id', $options['attrs']);
        $this->assertSame('main-footer', $options['attrs']['id']);
    }

    public function testConfigDefaults(): void
    {
        $config = new Config([
            'mega_footer' => [
                'variant' => 'minimal',
                'brand_name' => 'Default Brand',
                'background_color' => 'body-tertiary',
                'text_color' => 'body',
                'show_divider' => false,
                'brand_logo' => null,
                'brand_href' => '/',
                'brand_description' => null,
                'social_links' => [],
                'copyright_text' => null,
                'show_copyright' => true,
                'show_newsletter' => false,
                'newsletter_title' => 'Subscribe to our newsletter',
                'newsletter_placeholder' => 'Email address',
                'newsletter_button_text' => 'Subscribe',
                'container' => 'container',
                'class' => 'default-class',
                'attr' => ['data-default' => 'true'],
            ],
        ]);

        $component = new MegaFooter($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('minimal', $options['variant']);
        $this->assertSame('Default Brand', $options['brandName']);
        $this->assertStringContainsString('bg-body-tertiary', $options['classes']);
        $this->assertStringContainsString('text-body', $options['classes']);
        $this->assertStringNotContainsString('border-top', $options['classes']);
        $this->assertStringContainsString('default-class', $options['classes']);
        $this->assertArrayHasKey('data-default', $options['attrs']);
    }

    public function testGetComponentName(): void
    {
        $component = new MegaFooter($this->config);
        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('mega_footer', $method->invoke($component));
    }

    public function testCombinedOptions(): void
    {
        $component = new MegaFooter($this->config);
        $component->variant = 'centered';
        $component->brandName = 'Test Brand';
        $component->brandLogo = '/logo.svg';
        $component->brandDescription = 'A great company';
        $component->socialLinks = [
            ['icon' => 'bi-github', 'href' => 'https://github.com', 'label' => 'GitHub'],
        ];
        $component->showNewsletter = true;
        $component->copyrightText = '© 2025 Test Brand';
        $component->backgroundColor = 'primary';
        $component->textColor = 'white';
        $component->container = 'container-lg';
        $component->mount();
        $options = $component->options();

        $this->assertSame('centered', $options['variant']);
        $this->assertSame('Test Brand', $options['brandName']);
        $this->assertSame('/logo.svg', $options['brandLogo']);
        $this->assertSame('A great company', $options['brandDescription']);
        $this->assertCount(1, $options['socialLinks']);
        $this->assertTrue($options['showNewsletter']);
        $this->assertSame('© 2025 Test Brand', $options['copyrightText']);
        $this->assertStringContainsString('bg-primary', $options['classes']);
        $this->assertStringContainsString('text-white', $options['classes']);
        $this->assertSame('container-lg', $options['container']);
    }

    public function testWithEmptyBrandName(): void
    {
        $component = new MegaFooter($this->config);
        $component->brandName = null;
        $component->showCopyright = true;
        $component->mount();
        $options = $component->options();

        // Should not auto-generate copyright without brand name
        $this->assertNull($options['copyrightText']);
    }

    public function testAttrMergingFromConfig(): void
    {
        $config = new Config([
            'mega_footer' => [
                'variant' => 'default',
                'brand_name' => null,
                'brand_logo' => null,
                'brand_href' => '/',
                'brand_description' => null,
                'social_links' => [],
                'copyright_text' => null,
                'show_copyright' => true,
                'show_newsletter' => false,
                'newsletter_title' => 'Subscribe to our newsletter',
                'newsletter_placeholder' => 'Email address',
                'newsletter_button_text' => 'Subscribe',
                'background_color' => 'dark',
                'text_color' => 'white',
                'container' => 'container',
                'show_divider' => true,
                'class' => null,
                'attr' => ['data-from-config' => 'yes'],
            ],
        ]);

        $component = new MegaFooter($config);
        $component->attr = ['data-from-component' => 'yes'];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-from-config', $options['attrs']);
        $this->assertArrayHasKey('data-from-component', $options['attrs']);
    }
}

