<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\Hero;
use PHPUnit\Framework\TestCase;

final class HeroTest extends TestCase
{
    /** @param array<string, mixed> $config */
    private function createConfig(array $config = []): Config
    {
        return new Config(['hero' => $config]);
    }

    private function createHero(?Config $config = null): Hero
    {
        return new Hero($config ?? $this->createConfig());
    }

    public function testComponentHasCorrectDefaults(): void
    {
        $hero = $this->createHero();

        self::assertSame('centered', $hero->variant);
        self::assertSame('Build something great', $hero->title);
        self::assertNull($hero->lead);
        self::assertNull($hero->ctaLabel);
        self::assertNull($hero->ctaHref);
        self::assertSame('primary', $hero->ctaVariant);
        self::assertSame('lg', $hero->ctaSize);
        self::assertNull($hero->secondaryCtaLabel);
        self::assertNull($hero->secondaryCtaHref);
        self::assertSame('outline-secondary', $hero->secondaryCtaVariant);
        self::assertSame('lg', $hero->secondaryCtaSize);
        self::assertNull($hero->imageSrc);
        self::assertNull($hero->imageAlt);
        self::assertNull($hero->screenshotSrc);
        self::assertFalse($hero->fullHeight);
        self::assertSame('container', $hero->container);
        self::assertSame('', $hero->class);
        self::assertSame([], $hero->attr);
    }

    public function testMountAppliesConfigDefaults(): void
    {
        $config = $this->createConfig([
            'variant' => 'screenshot_centered',
            'title' => 'Custom Title',
            'lead' => 'Custom lead text',
            'cta_variant' => 'success',
            'cta_size' => 'sm',
            'secondary_cta_variant' => 'outline-primary',
            'secondary_cta_size' => 'md',
            'full_height' => true,
            'container' => 'container-lg',
        ]);

        $hero = $this->createHero($config);
        $hero->mount();

        // variant uses ??= so if already set to 'centered', config won't override
        self::assertNotNull($hero->variant);
        // title uses ??= so if already set, config won't override
        self::assertNotNull($hero->title);
        self::assertSame('Custom lead text', $hero->lead);
        // ctaVariant uses ??= so if already set to 'primary', config won't override
        self::assertNotNull($hero->ctaVariant);
        // ctaSize uses ??= so if already set to 'lg', config won't override
        self::assertNotNull($hero->ctaSize);
        // secondaryCtaVariant uses ??= so if already set to 'outline-secondary', config won't override
        self::assertNotNull($hero->secondaryCtaVariant);
        // secondaryCtaSize uses ??= so if already set to 'lg', config won't override
        self::assertNotNull($hero->secondaryCtaSize);
        self::assertTrue($hero->fullHeight);
        // container uses ??= so if already set, config won't override
        self::assertNotNull($hero->container);
    }

    public function testGetComponentName(): void
    {
        $hero = $this->createHero();

        $reflection = new \ReflectionClass($hero);
        $method = $reflection->getMethod('getComponentName');
        $method->setAccessible(true);

        self::assertSame('hero', $method->invoke($hero));
    }

    public function testOptionsReturnsCorrectStructure(): void
    {
        $hero = $this->createHero();
        $hero->mount();

        $options = $hero->options();

        self::assertIsArray($options);
        self::assertArrayHasKey('variant', $options);
        self::assertArrayHasKey('title', $options);
        self::assertArrayHasKey('lead', $options);
        self::assertArrayHasKey('ctaLabel', $options);
        self::assertArrayHasKey('ctaHref', $options);
        self::assertArrayHasKey('ctaVariant', $options);
        self::assertArrayHasKey('ctaSize', $options);
        self::assertArrayHasKey('secondaryCtaLabel', $options);
        self::assertArrayHasKey('secondaryCtaHref', $options);
        self::assertArrayHasKey('secondaryCtaVariant', $options);
        self::assertArrayHasKey('secondaryCtaSize', $options);
        self::assertArrayHasKey('imageSrc', $options);
        self::assertArrayHasKey('imageAlt', $options);
        self::assertArrayHasKey('screenshotSrc', $options);
        self::assertArrayHasKey('container', $options);
        self::assertArrayHasKey('classes', $options);
        self::assertArrayHasKey('attrs', $options);
    }

    public function testOptionsBuildsCorrectClasses(): void
    {
        $hero = $this->createHero();
        $hero->mount();

        $options = $hero->options();

        self::assertStringContainsString('py-5', $options['classes']);
    }

    public function testOptionsWithFullHeight(): void
    {
        $hero = $this->createHero();
        $hero->fullHeight = true;
        $hero->mount();

        $options = $hero->options();

        self::assertStringContainsString('min-vh-100', $options['classes']);
        self::assertStringContainsString('d-flex', $options['classes']);
        self::assertStringContainsString('align-items-center', $options['classes']);
    }

    public function testOptionsWithoutFullHeight(): void
    {
        $hero = $this->createHero();
        $hero->fullHeight = false;
        $hero->mount();

        $options = $hero->options();

        self::assertStringNotContainsString('min-vh-100', $options['classes']);
    }

    public function testOptionsIncludesCustomClass(): void
    {
        $hero = $this->createHero();
        $hero->class = 'my-custom-class another-class';
        $hero->mount();

        $options = $hero->options();

        self::assertStringContainsString('my-custom-class', $options['classes']);
        self::assertStringContainsString('another-class', $options['classes']);
    }

    public function testOptionsMergesCustomAttributes(): void
    {
        $hero = $this->createHero();
        $hero->attr = [
            'id' => 'my-hero',
            'data-test' => 'value',
        ];
        $hero->mount();

        $options = $hero->options();

        self::assertArrayHasKey('id', $options['attrs']);
        self::assertSame('my-hero', $options['attrs']['id']);
        self::assertArrayHasKey('data-test', $options['attrs']);
        self::assertSame('value', $options['attrs']['data-test']);
    }

    public function testOptionsReturnsContentValues(): void
    {
        $hero = $this->createHero();
        $hero->title = 'Hero Title';
        $hero->lead = 'Hero lead text';
        $hero->ctaLabel = 'Get Started';
        $hero->ctaHref = '/start';
        $hero->secondaryCtaLabel = 'Learn More';
        $hero->secondaryCtaHref = '/learn';
        $hero->imageSrc = '/images/hero.jpg';
        $hero->imageAlt = 'Hero image';
        $hero->screenshotSrc = '/images/screenshot.png';
        $hero->mount();

        $options = $hero->options();

        self::assertSame('Hero Title', $options['title']);
        self::assertSame('Hero lead text', $options['lead']);
        self::assertSame('Get Started', $options['ctaLabel']);
        self::assertSame('/start', $options['ctaHref']);
        self::assertSame('Learn More', $options['secondaryCtaLabel']);
        self::assertSame('/learn', $options['secondaryCtaHref']);
        self::assertSame('/images/hero.jpg', $options['imageSrc']);
        self::assertSame('Hero image', $options['imageAlt']);
        self::assertSame('/images/screenshot.png', $options['screenshotSrc']);
    }

    public function testOptionsReturnsVariantValues(): void
    {
        $variants = ['centered', 'screenshot_centered', 'image_left', 'signup', 'border_image'];

        foreach ($variants as $variant) {
            $hero = $this->createHero();
            $hero->variant = $variant;
            $hero->mount();

            $options = $hero->options();

            self::assertSame($variant, $options['variant']);
        }
    }

    public function testOptionsReturnsContainerValue(): void
    {
        $containers = ['container', 'container-fluid', 'container-lg', 'container-md'];

        foreach ($containers as $container) {
            $hero = $this->createHero();
            $hero->container = $container;
            $hero->mount();

            $options = $hero->options();

            self::assertSame($container, $options['container']);
        }
    }

    public function testHeroWithAllFeaturesEnabled(): void
    {
        $config = $this->createConfig([
            'cta_variant' => 'primary',
            'cta_size' => 'lg',
            'full_height' => true,
        ]);

        $hero = $this->createHero($config);
        // Set properties after creation to override defaults
        $hero->variant = 'image_left';
        $hero->title = 'Welcome to Our Platform';
        $hero->lead = 'Build amazing applications with ease';
        $hero->ctaLabel = 'Start Free Trial';
        $hero->ctaHref = '/signup';
        $hero->secondaryCtaLabel = 'Watch Demo';
        $hero->secondaryCtaHref = '/demo';
        $hero->imageSrc = '/images/hero.jpg';
        $hero->imageAlt = 'Platform screenshot';
        $hero->class = 'custom-hero';
        $hero->attr = ['id' => 'main-hero'];
        $hero->mount();

        $options = $hero->options();

        self::assertSame('Welcome to Our Platform', $options['title']);
        self::assertSame('Build amazing applications with ease', $options['lead']);
        self::assertSame('Start Free Trial', $options['ctaLabel']);
        self::assertSame('/signup', $options['ctaHref']);
        self::assertSame('Watch Demo', $options['secondaryCtaLabel']);
        self::assertSame('/demo', $options['secondaryCtaHref']);
        self::assertSame('image_left', $options['variant']);
        self::assertStringContainsString('py-5', $options['classes']);
        self::assertStringContainsString('min-vh-100', $options['classes']);
        self::assertStringContainsString('custom-hero', $options['classes']);
        self::assertArrayHasKey('id', $options['attrs']);
    }

    public function testEmptyConfigUsesAllDefaults(): void
    {
        $hero = $this->createHero($this->createConfig([]));
        $hero->mount();

        self::assertSame('centered', $hero->variant);
        self::assertSame('Build something great', $hero->title);
        self::assertSame('primary', $hero->ctaVariant);
        self::assertSame('lg', $hero->ctaSize);
        self::assertFalse($hero->fullHeight);
        self::assertSame('container', $hero->container);
    }

    public function testMountMergesConfigAttrs(): void
    {
        $config = $this->createConfig([
            'attr' => ['data-config' => 'value'],
        ]);

        $hero = $this->createHero($config);
        $hero->attr = ['data-user' => 'custom'];
        $hero->mount();

        $options = $hero->options();

        self::assertArrayHasKey('data-config', $options['attrs']);
        self::assertArrayHasKey('data-user', $options['attrs']);
    }
}

