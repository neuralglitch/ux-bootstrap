<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\NotificationBadge;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class NotificationBadgeTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'notification-badge' => [
                'variant' => 'danger',
                'size' => 'md',
                'position' => 'top-end',
                'dot' => false,
                'pill' => true,
                'bordered' => true,
                'pulse' => false,
                'max' => null,
                'inline' => false,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new NotificationBadge($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('badge', $options['classes']);
        $this->assertStringContainsString('text-bg-danger', $options['classes']);
        $this->assertStringContainsString('rounded-pill', $options['classes']);
        $this->assertStringContainsString('position-absolute', $options['classes']);
        $this->assertStringContainsString('badge-top-end', $options['classes']);
        $this->assertStringContainsString('border', $options['classes']);
        $this->assertStringContainsString('badge-notification-md', $options['classes']);
    }

    public function testVariantOption(): void
    {
        $component = new NotificationBadge($this->config);
        $component->variant = 'primary';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('text-bg-primary', $options['classes']);
        $this->assertStringNotContainsString('text-bg-danger', $options['classes']);
    }

    public function testAllVariants(): void
    {
        $variants = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'];

        foreach ($variants as $variant) {
            $component = new NotificationBadge($this->config);
            $component->variant = $variant;
            $component->mount();
            $options = $component->options();

            $this->assertStringContainsString("text-bg-{$variant}", $options['classes']);
        }
    }

    public function testPositionOptions(): void
    {
        $positions = ['top-start', 'top-end', 'bottom-start', 'bottom-end'];

        foreach ($positions as $position) {
            $component = new NotificationBadge($this->config);
            $component->position = $position;
            $component->mount();
            $options = $component->options();

            $this->assertStringContainsString("badge-{$position}", $options['classes']);
        }
    }

    public function testSizeOptions(): void
    {
        $component = new NotificationBadge($this->config);
        $component->size = 'sm';
        $component->mount();
        $options = $component->options();
        $this->assertStringContainsString('badge-notification-sm', $options['classes']);

        $component = new NotificationBadge($this->config);
        $component->size = 'lg';
        $component->mount();
        $options = $component->options();
        $this->assertStringContainsString('badge-notification-lg', $options['classes']);

        $component = new NotificationBadge($this->config);
        $component->size = 'md';
        $component->mount();
        $options = $component->options();
        $this->assertStringContainsString('badge-notification-md', $options['classes']);
    }

    public function testDotOption(): void
    {
        $component = new NotificationBadge($this->config);
        $component->dot = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('p-1', $options['classes']);
        $this->assertTrue($options['isDot']);
        $this->assertNull($options['content']);
    }

    public function testDotIgnoresContent(): void
    {
        $component = new NotificationBadge($this->config);
        $component->dot = true;
        $component->content = '5';
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['isDot']);
        $this->assertNull($options['content']);
    }

    public function testPulseOption(): void
    {
        $component = new NotificationBadge($this->config);
        $component->pulse = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('badge-pulse', $options['classes']);
        $this->assertTrue($options['isPulse']);
    }

    public function testBorderedOption(): void
    {
        $component = new NotificationBadge($this->config);
        $component->bordered = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('border', $options['classes']);
        $this->assertStringContainsString('border-light', $options['classes']);
    }

    public function testNoBorder(): void
    {
        $component = new NotificationBadge($this->config);
        $component->bordered = false;
        $component->mount();
        $options = $component->options();

        $this->assertStringNotContainsString('border', $options['classes']);
    }

    public function testPillOption(): void
    {
        $component = new NotificationBadge($this->config);
        $component->pill = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('rounded-pill', $options['classes']);
    }

    public function testNoPill(): void
    {
        $component = new NotificationBadge($this->config);
        $component->pill = false;
        $component->mount();
        $options = $component->options();

        $this->assertStringNotContainsString('rounded-pill', $options['classes']);
    }

    public function testInlineOption(): void
    {
        $component = new NotificationBadge($this->config);
        $component->inline = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringNotContainsString('position-absolute', $options['classes']);
        $this->assertStringNotContainsString('translate-middle', $options['classes']);
        $this->assertStringNotContainsString('badge-top-end', $options['classes']);
    }

    public function testContentDisplay(): void
    {
        $component = new NotificationBadge($this->config);
        $component->content = '5';
        $component->mount();
        $options = $component->options();

        $this->assertSame('5', $options['content']);
    }

    public function testMaxOption(): void
    {
        $component = new NotificationBadge($this->config);
        $component->content = '150';
        $component->max = 99;
        $component->mount();
        $options = $component->options();

        $this->assertSame('99+', $options['content']);
    }

    public function testMaxOptionWithLowerNumber(): void
    {
        $component = new NotificationBadge($this->config);
        $component->content = '50';
        $component->max = 99;
        $component->mount();
        $options = $component->options();

        $this->assertSame('50', $options['content']);
    }

    public function testMaxOnlyAppliesToNumeric(): void
    {
        $component = new NotificationBadge($this->config);
        $component->content = 'New';
        $component->max = 99;
        $component->mount();
        $options = $component->options();

        $this->assertSame('New', $options['content']);
    }

    public function testEmptyContentReturnsNull(): void
    {
        $component = new NotificationBadge($this->config);
        $component->content = '';
        $component->mount();
        $options = $component->options();

        $this->assertNull($options['content']);
    }

    public function testNullContentReturnsNull(): void
    {
        $component = new NotificationBadge($this->config);
        $component->content = null;
        $component->mount();
        $options = $component->options();

        $this->assertNull($options['content']);
    }

    public function testCustomClasses(): void
    {
        $component = new NotificationBadge($this->config);
        $component->class = 'custom-class another-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-class', $options['classes']);
        $this->assertStringContainsString('another-class', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new NotificationBadge($this->config);
        $component->attr = [
            'data-test' => 'value',
            'aria-label' => 'Notifications',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('value', $options['attrs']['data-test']);
        $this->assertArrayHasKey('aria-label', $options['attrs']);
        $this->assertSame('Notifications', $options['attrs']['aria-label']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'notification-badge' => [
                'variant' => 'primary',
                'size' => 'lg',
                'position' => 'bottom-start',
                'dot' => true,
                'pulse' => true,
                'bordered' => false,
                'pill' => false,
                'inline' => true,
                'max' => 50,
                'class' => 'config-class',
                'attr' => [],
            ],
        ]);

        $component = new NotificationBadge($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('primary', $component->variant);
        $this->assertSame('lg', $component->size);
        $this->assertSame('bottom-start', $component->position);
        $this->assertTrue($component->dot);
        $this->assertTrue($component->pulse);
        $this->assertFalse($component->bordered);
        $this->assertFalse($component->pill);
        $this->assertTrue($component->inline);
        $this->assertSame(50, $component->max);
        $this->assertStringContainsString('config-class', $options['classes']);
    }

    public function testCombinedOptions(): void
    {
        $component = new NotificationBadge($this->config);
        $component->variant = 'success';
        $component->size = 'sm';
        $component->position = 'bottom-end';
        $component->pulse = true;
        $component->bordered = true;
        $component->pill = true;
        $component->content = '12';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('text-bg-success', $options['classes']);
        $this->assertStringContainsString('badge-notification-sm', $options['classes']);
        $this->assertStringContainsString('badge-bottom-end', $options['classes']);
        $this->assertStringContainsString('badge-pulse', $options['classes']);
        $this->assertStringContainsString('border', $options['classes']);
        $this->assertStringContainsString('rounded-pill', $options['classes']);
        $this->assertSame('12', $options['content']);
    }

    public function testGetComponentName(): void
    {
        $component = new NotificationBadge($this->config);
        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('notification-badge', $method->invoke($component));
    }
}

