<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Link;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class LinkTest extends TestCase
{
    /** @param array<string, mixed> $config */
    private function createConfig(array $config = []): Config
    {
        return new Config(['link' => $config]);
    }

    private function createLink(?Config $config = null): Link
    {
        return new Link($config ?? $this->createConfig());
    }

    public function testComponentHasCorrectDefaults(): void
    {
        $link = $this->createLink();

        self::assertSame('#', $link->href);
        self::assertSame('_self', $link->target);
        self::assertNull($link->rel);
        self::assertNull($link->underline);
        self::assertNull($link->underlineOpacity);
        self::assertNull($link->underlineOpacityHover);
        self::assertNull($link->offset);
        self::assertFalse($link->stretched);
        self::assertNull($link->label);
        self::assertNull($link->variant);
        self::assertFalse($link->outline);
        self::assertFalse($link->block);
        self::assertFalse($link->active);
        self::assertFalse($link->disabled);
        self::assertSame('', $link->class);
        self::assertSame([], $link->attr);
    }

    public function testMountAppliesConfigDefaults(): void
    {
        $config = $this->createConfig([
            'variant' => 'primary',
            'underline' => 'hover',
            'underline_opacity' => 50,
            'underline_opacity_hover' => 100,
            'offset' => 2,
            'stretched' => true,
        ]);

        $link = $this->createLink($config);
        $link->mount();

        self::assertSame('primary', $link->variant);
        self::assertSame('hover', $link->underline);
        self::assertSame(50, $link->underlineOpacity);
        self::assertSame(100, $link->underlineOpacityHover);
        self::assertSame(2, $link->offset);
        self::assertTrue($link->stretched);
    }

    public function testGetComponentType(): void
    {
        $link = $this->createLink();

        $reflection = new ReflectionClass($link);
        $method = $reflection->getMethod('getComponentType');
        $method->setAccessible(true);

        self::assertSame('link', $method->invoke($link));
    }

    public function testOptionsReturnsCorrectStructure(): void
    {
        $link = $this->createLink();
        $link->label = 'Click me';
        $link->mount();

        $options = $link->options();

        self::assertIsArray($options);
        self::assertArrayHasKey('href', $options);
        self::assertArrayHasKey('label', $options);
        self::assertArrayHasKey('iconStart', $options);
        self::assertArrayHasKey('iconEnd', $options);
        self::assertArrayHasKey('iconOnly', $options);
        self::assertArrayHasKey('iconSize', $options);
        self::assertArrayHasKey('classes', $options);
        self::assertArrayHasKey('attrs', $options);
        self::assertArrayHasKey('disabled', $options);
        self::assertArrayHasKey('iconStartClasses', $options);
        self::assertArrayHasKey('iconEndClasses', $options);
    }

    public function testOptionsReturnsHref(): void
    {
        $link = $this->createLink();
        $link->href = '/about';
        $link->mount();

        $options = $link->options();

        self::assertSame('/about', $options['href']);
    }

    public function testOptionsReturnsJavascriptVoidWhenDisabled(): void
    {
        $link = $this->createLink();
        $link->href = '/about';
        $link->disabled = true;
        $link->mount();

        $options = $link->options();

        self::assertSame('javascript:void(0)', $options['href']);
    }

    public function testOptionsBuildsCorrectClasses(): void
    {
        $config = $this->createConfig(['variant' => 'primary']);
        $link = $this->createLink($config);
        $link->mount();

        $options = $link->options();

        self::assertStringContainsString('link-primary', $options['classes']);
    }

    public function testOptionsWithUnderlineNever(): void
    {
        $link = $this->createLink();
        $link->underline = 'never';
        $link->mount();

        $options = $link->options();

        self::assertStringContainsString('link-underline', $options['classes']);
        self::assertStringContainsString('link-underline-opacity-0', $options['classes']);
    }

    public function testOptionsWithUnderlineAlways(): void
    {
        $link = $this->createLink();
        $link->underline = 'always';
        $link->mount();

        $options = $link->options();

        self::assertStringContainsString('link-underline', $options['classes']);
        self::assertStringNotContainsString('link-underline-opacity-0', $options['classes']);
    }

    public function testOptionsWithUnderlineHover(): void
    {
        $link = $this->createLink();
        $link->underline = 'hover';
        $link->mount();

        $options = $link->options();

        self::assertStringContainsString('link-underline', $options['classes']);
    }

    public function testOptionsWithUnderlineOpacity(): void
    {
        $link = $this->createLink();
        $link->underlineOpacity = 50;
        $link->mount();

        $options = $link->options();

        self::assertStringContainsString('link-underline-opacity-50', $options['classes']);
    }

    public function testOptionsWithUnderlineOpacityHover(): void
    {
        $link = $this->createLink();
        $link->underlineOpacityHover = 75;
        $link->mount();

        $options = $link->options();

        self::assertStringContainsString('link-underline-opacity-75-hover', $options['classes']);
    }

    public function testOptionsWithOffset(): void
    {
        $link = $this->createLink();
        $link->offset = 3;
        $link->mount();

        $options = $link->options();

        self::assertStringContainsString('link-offset-3', $options['classes']);
    }

    public function testOptionsWithStretched(): void
    {
        $link = $this->createLink();
        $link->stretched = true;
        $link->mount();

        $options = $link->options();

        self::assertStringContainsString('stretched-link', $options['classes']);
    }

    public function testOptionsWithBlock(): void
    {
        $link = $this->createLink();
        $link->block = true;
        $link->mount();

        $options = $link->options();

        self::assertStringContainsString('d-block', $options['classes']);
    }

    public function testOptionsWithActive(): void
    {
        $link = $this->createLink();
        $link->active = true;
        $link->mount();

        $options = $link->options();

        self::assertStringContainsString('active', $options['classes']);
    }

    public function testOptionsWithDisabled(): void
    {
        $link = $this->createLink();
        $link->disabled = true;
        $link->mount();

        $options = $link->options();

        self::assertTrue($options['disabled']);
        self::assertStringContainsString('disabled', $options['classes']);
    }

    public function testOptionsIncludesCustomClass(): void
    {
        $link = $this->createLink();
        $link->class = 'my-custom-class another-class';
        $link->mount();

        $options = $link->options();

        self::assertStringContainsString('my-custom-class', $options['classes']);
        self::assertStringContainsString('another-class', $options['classes']);
    }

    public function testOptionsIncludesTargetAttribute(): void
    {
        $link = $this->createLink();
        $link->target = '_blank';
        $link->mount();

        $options = $link->options();

        self::assertArrayHasKey('target', $options['attrs']);
        self::assertSame('_blank', $options['attrs']['target']);
    }

    public function testOptionsIncludesRelAttribute(): void
    {
        $link = $this->createLink();
        $link->rel = 'noopener noreferrer';
        $link->mount();

        $options = $link->options();

        self::assertArrayHasKey('rel', $options['attrs']);
        self::assertSame('noopener noreferrer', $options['attrs']['rel']);
    }

    public function testOptionsMergesCustomAttributes(): void
    {
        $link = $this->createLink();
        $link->attr = [
            'id' => 'my-link',
            'data-test' => 'value',
        ];
        $link->mount();

        $options = $link->options();

        self::assertArrayHasKey('id', $options['attrs']);
        self::assertSame('my-link', $options['attrs']['id']);
        self::assertArrayHasKey('data-test', $options['attrs']);
        self::assertSame('value', $options['attrs']['data-test']);
    }

    public function testVariantClassesForDifferentVariants(): void
    {
        $variants = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'];

        foreach ($variants as $variant) {
            $config = $this->createConfig(['variant' => $variant]);
            $link = $this->createLink($config);
            $link->mount();

            $options = $link->options();

            self::assertStringContainsString("link-{$variant}", $options['classes']);
        }
    }

    public function testLinkWithAllFeaturesEnabled(): void
    {
        $config = $this->createConfig([
            'variant' => 'primary',
            'underline' => 'hover',
            'underline_opacity' => 50,
            'underline_opacity_hover' => 100,
            'offset' => 2,
            'stretched' => true,
        ]);

        $link = $this->createLink($config);
        $link->label = 'Read more';
        $link->href = '/article';
        $link->target = '_blank';
        $link->rel = 'noopener';
        $link->class = 'custom-link';
        $link->attr = ['data-article' => '123'];
        $link->mount();

        $options = $link->options();

        self::assertSame('Read more', $options['label']);
        self::assertSame('/article', $options['href']);
        self::assertStringContainsString('link-primary', $options['classes']);
        self::assertStringContainsString('link-underline', $options['classes']);
        self::assertStringContainsString('link-underline-opacity-50', $options['classes']);
        self::assertStringContainsString('link-underline-opacity-100-hover', $options['classes']);
        self::assertStringContainsString('link-offset-2', $options['classes']);
        self::assertStringContainsString('stretched-link', $options['classes']);
        self::assertStringContainsString('custom-link', $options['classes']);
        self::assertArrayHasKey('target', $options['attrs']);
        self::assertArrayHasKey('rel', $options['attrs']);
        self::assertArrayHasKey('data-article', $options['attrs']);
    }

    public function testEmptyConfigUsesAllDefaults(): void
    {
        $link = $this->createLink($this->createConfig([]));
        $link->mount();

        self::assertNull($link->variant);
        self::assertNull($link->underline);
        self::assertNull($link->underlineOpacity);
        self::assertNull($link->offset);
        self::assertFalse($link->stretched);
    }
}

