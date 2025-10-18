<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\PricingCard;
use PHPUnit\Framework\TestCase;

final class PricingCardTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'pricing_card' => [
                'plan_name' => 'Free',
                'plan_description' => null,
                'price' => '0',
                'currency' => '$',
                'period' => 'month',
                'show_period' => true,
                'badge' => null,
                'badge_variant' => 'primary',
                'features' => [],
                'show_checkmarks' => true,
                'cta_label' => 'Get Started',
                'cta_href' => null,
                'cta_variant' => 'primary',
                'cta_size' => 'lg',
                'cta_outline' => false,
                'cta_block' => true,
                'featured' => false,
                'shadow' => false,
                'variant' => null,
                'border' => true,
                'text_align' => 'center',
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new PricingCard($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('card', $options['classes']);
        $this->assertStringContainsString('h-100', $options['classes']);
        $this->assertStringContainsString('text-center', $options['classes']);
        $this->assertSame('Free', $options['planName']);
        $this->assertSame('0', $options['price']);
        $this->assertSame('$', $options['currency']);
        $this->assertSame('month', $options['period']);
        $this->assertTrue($options['showPeriod']);
        $this->assertFalse($options['featured']);
    }

    public function testPlanNameOption(): void
    {
        $component = new PricingCard($this->config);
        $component->planName = 'Enterprise';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Enterprise', $options['planName']);
    }

    public function testPlanDescriptionOption(): void
    {
        $component = new PricingCard($this->config);
        $component->planDescription = 'Perfect for large teams';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Perfect for large teams', $options['planDescription']);
    }

    public function testPriceOption(): void
    {
        $component = new PricingCard($this->config);
        $component->price = '99';
        $component->mount();
        $options = $component->options();

        $this->assertSame('99', $options['price']);
    }

    public function testCurrencyOption(): void
    {
        $component = new PricingCard($this->config);
        $component->currency = '€';
        $component->mount();
        $options = $component->options();

        $this->assertSame('€', $options['currency']);
    }

    public function testPeriodOption(): void
    {
        $component = new PricingCard($this->config);
        $component->period = 'year';
        $component->mount();
        $options = $component->options();

        $this->assertSame('year', $options['period']);
    }

    public function testShowPeriodOption(): void
    {
        $component = new PricingCard($this->config);
        $component->showPeriod = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['showPeriod']);
    }

    public function testBadgeOption(): void
    {
        $component = new PricingCard($this->config);
        $component->badge = 'Popular';
        $component->badgeVariant = 'success';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Popular', $options['badge']);
        $this->assertSame('success', $options['badgeVariant']);
    }

    public function testFeaturesOption(): void
    {
        $component = new PricingCard($this->config);
        $component->features = [
            'Unlimited projects',
            '10 GB storage',
            'Email support',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertCount(3, $options['features']);
        $this->assertSame('Unlimited projects', $options['features'][0]);
    }

    public function testShowCheckmarksOption(): void
    {
        $component = new PricingCard($this->config);
        $component->showCheckmarks = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['showCheckmarks']);
    }

    public function testCtaOptions(): void
    {
        $component = new PricingCard($this->config);
        $component->ctaLabel = 'Subscribe Now';
        $component->ctaHref = '/subscribe';
        $component->ctaVariant = 'success';
        $component->ctaSize = 'sm';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Subscribe Now', $options['ctaLabel']);
        $this->assertSame('/subscribe', $options['ctaHref']);
        $this->assertStringContainsString('btn-success', $options['btnClasses']);
        $this->assertStringContainsString('btn-sm', $options['btnClasses']);
    }

    public function testCtaOutlineOption(): void
    {
        $component = new PricingCard($this->config);
        $component->ctaOutline = true;
        $component->ctaVariant = 'primary';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('btn-outline-primary', $options['btnClasses']);
    }

    public function testCtaBlockOption(): void
    {
        $component = new PricingCard($this->config);
        $component->ctaBlock = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('w-100', $options['btnClasses']);
    }

    public function testCtaNotBlockOption(): void
    {
        $component = new PricingCard($this->config);
        $component->ctaBlock = false;
        $component->mount();
        $options = $component->options();

        $this->assertStringNotContainsString('w-100', $options['btnClasses']);
    }

    public function testFeaturedOption(): void
    {
        $component = new PricingCard($this->config);
        $component->featured = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('border-primary', $options['classes']);
        $this->assertStringContainsString('border-3', $options['classes']);
        $this->assertTrue($options['featured']);
    }

    public function testShadowOption(): void
    {
        $component = new PricingCard($this->config);
        $component->shadow = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('shadow-lg', $options['classes']);
    }

    public function testVariantOption(): void
    {
        $component = new PricingCard($this->config);
        $component->variant = 'dark';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('text-bg-dark', $options['classes']);
    }

    public function testNoBorderOption(): void
    {
        $component = new PricingCard($this->config);
        $component->border = false;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('border-0', $options['classes']);
    }

    public function testTextAlignOption(): void
    {
        $component = new PricingCard($this->config);
        $component->textAlign = 'start';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('text-start', $options['classes']);
    }

    public function testCustomClassOption(): void
    {
        $component = new PricingCard($this->config);
        $component->class = 'custom-pricing my-3';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-pricing', $options['classes']);
        $this->assertStringContainsString('my-3', $options['classes']);
    }

    public function testCustomAttributesOption(): void
    {
        $component = new PricingCard($this->config);
        $component->attr = [
            'data-plan' => 'pro',
            'data-testid' => 'pricing-card',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-plan', $options['attrs']);
        $this->assertSame('pro', $options['attrs']['data-plan']);
        $this->assertArrayHasKey('data-testid', $options['attrs']);
    }

    public function testCombinedFeaturedAndShadow(): void
    {
        $component = new PricingCard($this->config);
        $component->featured = true;
        $component->shadow = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('border-primary', $options['classes']);
        $this->assertStringContainsString('shadow-lg', $options['classes']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'pricing_card' => [
                'plan_name' => 'Starter',
                'price' => '19',
                'currency' => '€',
                'period' => 'year',
                'cta_label' => 'Sign Up',
                'cta_variant' => 'success',
                'featured' => true,
                'shadow' => true,
                'class' => 'mb-4',
                'attr' => ['data-plan' => 'starter'],
            ],
        ]);

        $component = new PricingCard($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('Starter', $options['planName']);
        $this->assertSame('19', $options['price']);
        $this->assertSame('€', $options['currency']);
        $this->assertSame('year', $options['period']);
        $this->assertSame('Sign Up', $options['ctaLabel']);
        $this->assertStringContainsString('btn-success', $options['btnClasses']);
        $this->assertTrue($options['featured']);
        $this->assertStringContainsString('mb-4', $options['classes']);
        $this->assertArrayHasKey('data-plan', $options['attrs']);
    }

    public function testGetComponentName(): void
    {
        $component = new PricingCard($this->config);
        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('pricing_card', $method->invoke($component));
    }

    public function testEmptyFeaturesArray(): void
    {
        $component = new PricingCard($this->config);
        $component->features = [];
        $component->mount();
        $options = $component->options();

        $this->assertEmpty($options['features']);
    }

    public function testNullBadge(): void
    {
        $component = new PricingCard($this->config);
        $component->badge = null;
        $component->mount();
        $options = $component->options();

        $this->assertNull($options['badge']);
    }

    public function testNullPlanDescription(): void
    {
        $component = new PricingCard($this->config);
        $component->planDescription = null;
        $component->mount();
        $options = $component->options();

        $this->assertNull($options['planDescription']);
    }

    public function testMultipleVariants(): void
    {
        $variants = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'dark'];

        foreach ($variants as $variant) {
            $component = new PricingCard($this->config);
            $component->variant = $variant;
            $component->mount();
            $options = $component->options();

            $this->assertStringContainsString("text-bg-{$variant}", $options['classes']);
        }
    }
}

