<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\Cta;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class CtaTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'cta' => [
                'variant' => 'centered',
                'title' => 'Ready to get started?',
                'description' => null,
                'icon' => null,
                'cta_variant' => 'primary',
                'cta_size' => 'lg',
                'cta_outline' => false,
                'secondary_cta_variant' => 'outline-secondary',
                'secondary_cta_size' => 'lg',
                'secondary_cta_outline' => false,
                'alignment' => 'center',
                'container' => 'container',
                'bg' => null,
                'text_color' => null,
                'border' => false,
                'shadow' => false,
                'rounded' => true,
                'padding' => 'py-5',
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new Cta($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('centered', $options['variant']);
        $this->assertSame('Ready to get started?', $options['title']);
        $this->assertNull($options['description']);
        $this->assertSame('center', $options['alignment']);
        $this->assertSame('container', $options['container']);
        $this->assertStringContainsString('py-5', $options['classes']);
    }

    public function testVariantOption(): void
    {
        $component = new Cta($this->config);
        $component->variant = 'split';
        $component->mount();
        $options = $component->options();

        $this->assertSame('split', $options['variant']);
    }

    public function testBorderedVariant(): void
    {
        $component = new Cta($this->config);
        $component->variant = 'bordered';
        $component->mount();
        $options = $component->options();

        $this->assertSame('bordered', $options['variant']);
    }

    public function testBackgroundVariant(): void
    {
        $component = new Cta($this->config);
        $component->variant = 'background';
        $component->bg = 'primary';
        $component->textColor = 'white';
        $component->mount();
        $options = $component->options();

        $this->assertSame('background', $options['variant']);
        $this->assertStringContainsString('bg-primary', $options['classes']);
        $this->assertStringContainsString('text-white', $options['classes']);
    }

    public function testMinimalVariant(): void
    {
        $component = new Cta($this->config);
        $component->variant = 'minimal';
        $component->mount();
        $options = $component->options();

        $this->assertSame('minimal', $options['variant']);
    }

    public function testTitleAndDescription(): void
    {
        $component = new Cta($this->config);
        $component->title = 'Custom Title';
        $component->description = 'Custom description text';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Custom Title', $options['title']);
        $this->assertSame('Custom description text', $options['description']);
    }

    public function testIcon(): void
    {
        $component = new Cta($this->config);
        $component->icon = '🚀';
        $component->mount();
        $options = $component->options();

        $this->assertSame('🚀', $options['icon']);
    }

    public function testPrimaryCtaOptions(): void
    {
        $component = new Cta($this->config);
        $component->ctaLabel = 'Get Started';
        $component->ctaHref = '/signup';
        $component->ctaVariant = 'success';
        $component->ctaSize = 'sm';
        $component->ctaOutline = true;
        $component->mount();
        $options = $component->options();

        $this->assertSame('Get Started', $options['ctaLabel']);
        $this->assertSame('/signup', $options['ctaHref']);
        $this->assertSame('success', $options['ctaVariant']);
        $this->assertSame('sm', $options['ctaSize']);
        $this->assertTrue($options['ctaOutline']);
    }

    public function testSecondaryCtaOptions(): void
    {
        $component = new Cta($this->config);
        $component->secondaryCtaLabel = 'Learn More';
        $component->secondaryCtaHref = '/docs';
        $component->secondaryCtaVariant = 'secondary';
        $component->secondaryCtaSize = 'md';
        $component->secondaryCtaOutline = true;
        $component->mount();
        $options = $component->options();

        $this->assertSame('Learn More', $options['secondaryCtaLabel']);
        $this->assertSame('/docs', $options['secondaryCtaHref']);
        $this->assertSame('secondary', $options['secondaryCtaVariant']);
        $this->assertSame('md', $options['secondaryCtaSize']);
        $this->assertTrue($options['secondaryCtaOutline']);
    }

    public function testAlignmentOptions(): void
    {
        $component = new Cta($this->config);
        $component->alignment = 'start';
        $component->mount();
        $options = $component->options();

        $this->assertSame('start', $options['alignment']);
    }

    public function testContainerOptions(): void
    {
        $component = new Cta($this->config);
        $component->container = 'container-fluid';
        $component->mount();
        $options = $component->options();

        $this->assertSame('container-fluid', $options['container']);
    }

    public function testBackgroundAndTextColor(): void
    {
        $component = new Cta($this->config);
        $component->bg = 'dark';
        $component->textColor = 'white';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('bg-dark', $options['classes']);
        $this->assertStringContainsString('text-white', $options['classes']);
    }

    public function testBorderOption(): void
    {
        $component = new Cta($this->config);
        $component->border = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('border', $options['classes']);
    }

    public function testShadowOption(): void
    {
        $component = new Cta($this->config);
        $component->shadow = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('shadow', $options['classes']);
    }

    public function testRoundedOption(): void
    {
        $component = new Cta($this->config);
        $component->rounded = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('rounded-3', $options['classes']);
    }

    public function testRoundedDisabled(): void
    {
        $component = new Cta($this->config);
        $component->rounded = false;
        $component->mount();
        $options = $component->options();

        $this->assertStringNotContainsString('rounded', $options['classes']);
    }

    public function testPaddingOption(): void
    {
        $component = new Cta($this->config);
        $component->padding = 'p-4';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('p-4', $options['classes']);
    }

    public function testCustomClasses(): void
    {
        $component = new Cta($this->config);
        $component->class = 'custom-class another-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-class', $options['classes']);
        $this->assertStringContainsString('another-class', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new Cta($this->config);
        $component->attr = [
            'data-test' => 'cta-block',
            'id' => 'main-cta',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('cta-block', $options['attrs']['data-test']);
        $this->assertArrayHasKey('id', $options['attrs']);
        $this->assertSame('main-cta', $options['attrs']['id']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'cta' => [
                'variant' => 'split',
                'title' => 'Join Us Today',
                'cta_variant' => 'success',
                'cta_size' => 'sm',
                'alignment' => 'start',
                'bg' => 'light',
                'border' => true,
                'shadow' => true,
                'class' => 'default-cta-class',
                'attr' => [],
            ],
        ]);

        $component = new Cta($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('split', $options['variant']);
        $this->assertSame('Join Us Today', $options['title']);
        $this->assertSame('success', $options['ctaVariant']);
        $this->assertSame('sm', $options['ctaSize']);
        $this->assertSame('start', $options['alignment']);
        $this->assertStringContainsString('bg-light', $options['classes']);
        $this->assertStringContainsString('border', $options['classes']);
        $this->assertStringContainsString('shadow', $options['classes']);
        $this->assertStringContainsString('default-cta-class', $options['classes']);
    }

    public function testCombinedOptions(): void
    {
        $component = new Cta($this->config);
        $component->variant = 'background';
        $component->title = 'Start Your Journey';
        $component->description = 'Join thousands of satisfied customers';
        $component->icon = '🎉';
        $component->ctaLabel = 'Sign Up';
        $component->ctaHref = '/register';
        $component->ctaVariant = 'success';
        $component->secondaryCtaLabel = 'Learn More';
        $component->secondaryCtaHref = '/about';
        $component->bg = 'primary';
        $component->textColor = 'white';
        $component->shadow = true;
        $component->rounded = true;
        $component->mount();
        $options = $component->options();

        $this->assertSame('background', $options['variant']);
        $this->assertSame('Start Your Journey', $options['title']);
        $this->assertSame('Join thousands of satisfied customers', $options['description']);
        $this->assertSame('🎉', $options['icon']);
        $this->assertSame('Sign Up', $options['ctaLabel']);
        $this->assertSame('/register', $options['ctaHref']);
        $this->assertSame('success', $options['ctaVariant']);
        $this->assertSame('Learn More', $options['secondaryCtaLabel']);
        $this->assertSame('/about', $options['secondaryCtaHref']);
        $this->assertStringContainsString('bg-primary', $options['classes']);
        $this->assertStringContainsString('text-white', $options['classes']);
        $this->assertStringContainsString('shadow', $options['classes']);
        $this->assertStringContainsString('rounded-3', $options['classes']);
    }

    public function testGetComponentName(): void
    {
        $component = new Cta($this->config);
        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('cta', $method->invoke($component));
    }
}

