<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\Avatar;
use PHPUnit\Framework\TestCase;

final class AvatarTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'avatar' => [
                'size' => 'md',
                'shape' => 'circle',
                'status' => null,
                'border' => false,
                'border_color' => null,
                'variant' => null,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new Avatar($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('avatar', $options['wrapperClasses']);
        $this->assertStringContainsString('avatar-md', $options['wrapperClasses']);
        $this->assertStringContainsString('rounded-circle', $options['wrapperClasses']);
    }

    public function testWithImageSrc(): void
    {
        $component = new Avatar($this->config);
        $component->src = '/path/to/image.jpg';
        $component->alt = 'User Avatar';
        $component->mount();
        $options = $component->options();

        $this->assertSame('/path/to/image.jpg', $options['src']);
        $this->assertSame('User Avatar', $options['alt']);
    }

    public function testWithInitials(): void
    {
        $component = new Avatar($this->config);
        $component->initials = 'JD';
        $component->mount();
        $options = $component->options();

        $this->assertSame('JD', $options['initials']);
        $this->assertStringContainsString('avatar-initials', $options['initialsClasses']);
    }

    public function testAltGeneratedFromInitials(): void
    {
        $component = new Avatar($this->config);
        $component->initials = 'JD';
        $component->mount();
        $options = $component->options();

        $this->assertSame('JD', $options['alt']);
    }

    public function testSizeXs(): void
    {
        $component = new Avatar($this->config);
        $component->size = 'xs';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('avatar-xs', $options['wrapperClasses']);
    }

    public function testSizeSm(): void
    {
        $component = new Avatar($this->config);
        $component->size = 'sm';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('avatar-sm', $options['wrapperClasses']);
    }

    public function testSizeLg(): void
    {
        $component = new Avatar($this->config);
        $component->size = 'lg';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('avatar-lg', $options['wrapperClasses']);
    }

    public function testSizeXl(): void
    {
        $component = new Avatar($this->config);
        $component->size = 'xl';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('avatar-xl', $options['wrapperClasses']);
    }

    public function testSizeXxl(): void
    {
        $component = new Avatar($this->config);
        $component->size = 'xxl';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('avatar-xxl', $options['wrapperClasses']);
    }

    public function testCustomSizeWithPixels(): void
    {
        $component = new Avatar($this->config);
        $component->size = '64px';
        $component->mount();

        $style = $component->getCustomSizeStyle();
        $this->assertSame('width: 64px; height: 64px;', $style);
    }

    public function testCustomSizeWithRem(): void
    {
        $component = new Avatar($this->config);
        $component->size = '3rem';
        $component->mount();

        $style = $component->getCustomSizeStyle();
        $this->assertSame('width: 3rem; height: 3rem;', $style);
    }

    public function testPredefinedSizeHasNoCustomStyle(): void
    {
        $component = new Avatar($this->config);
        $component->size = 'md';
        $component->mount();

        $style = $component->getCustomSizeStyle();
        $this->assertNull($style);
    }

    public function testShapeCircle(): void
    {
        $component = new Avatar($this->config);
        $component->shape = 'circle';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('rounded-circle', $options['wrapperClasses']);
    }

    public function testShapeSquare(): void
    {
        $component = new Avatar($this->config);
        $component->shape = 'square';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('rounded-0', $options['wrapperClasses']);
    }

    public function testShapeRounded(): void
    {
        $component = new Avatar($this->config);
        $component->shape = 'rounded';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('rounded', $options['wrapperClasses']);
        $this->assertStringNotContainsString('rounded-circle', $options['wrapperClasses']);
    }

    public function testStatusOnline(): void
    {
        $component = new Avatar($this->config);
        $component->status = 'online';
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['hasStatus']);
        $this->assertStringContainsString('avatar-status', $options['statusClasses']);
        $this->assertStringContainsString('avatar-status-online', $options['statusClasses']);
    }

    public function testStatusOffline(): void
    {
        $component = new Avatar($this->config);
        $component->status = 'offline';
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['hasStatus']);
        $this->assertStringContainsString('avatar-status-offline', $options['statusClasses']);
    }

    public function testStatusAway(): void
    {
        $component = new Avatar($this->config);
        $component->status = 'away';
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['hasStatus']);
        $this->assertStringContainsString('avatar-status-away', $options['statusClasses']);
    }

    public function testStatusBusy(): void
    {
        $component = new Avatar($this->config);
        $component->status = 'busy';
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['hasStatus']);
        $this->assertStringContainsString('avatar-status-busy', $options['statusClasses']);
    }

    public function testNoStatusByDefault(): void
    {
        $component = new Avatar($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['hasStatus']);
        $this->assertNull($options['statusClasses']);
    }

    public function testBorderEnabled(): void
    {
        $component = new Avatar($this->config);
        $component->border = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('avatar-border', $options['wrapperClasses']);
    }

    public function testBorderWithColor(): void
    {
        $component = new Avatar($this->config);
        $component->border = true;
        $component->borderColor = 'primary';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('avatar-border', $options['wrapperClasses']);
        $this->assertStringContainsString('border-primary', $options['wrapperClasses']);
    }

    public function testVariantForInitials(): void
    {
        $component = new Avatar($this->config);
        $component->initials = 'JD';
        $component->variant = 'primary';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('bg-primary', $options['initialsClasses']);
        $this->assertStringContainsString('text-white', $options['initialsClasses']);
    }

    public function testVariantSuccessForInitials(): void
    {
        $component = new Avatar($this->config);
        $component->initials = 'AB';
        $component->variant = 'success';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('bg-success', $options['initialsClasses']);
    }

    public function testDefaultVariantForInitials(): void
    {
        $component = new Avatar($this->config);
        $component->initials = 'XY';
        $component->mount();
        $options = $component->options();

        // When no variant, should default to secondary
        $this->assertStringContainsString('bg-secondary', $options['initialsClasses']);
    }

    public function testWithHref(): void
    {
        $component = new Avatar($this->config);
        $component->href = '/profile';
        $component->mount();
        $options = $component->options();

        $this->assertSame('/profile', $options['href']);
        $this->assertStringContainsString('avatar-link', $options['wrapperClasses']);
        $this->assertArrayHasKey('href', $options['linkAttrs']);
        $this->assertSame('/profile', $options['linkAttrs']['href']);
    }

    public function testWithHrefAndTarget(): void
    {
        $component = new Avatar($this->config);
        $component->href = '/profile';
        $component->target = '_blank';
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('target', $options['linkAttrs']);
        $this->assertSame('_blank', $options['linkAttrs']['target']);
        $this->assertArrayHasKey('rel', $options['linkAttrs']);
        $this->assertSame('noopener noreferrer', $options['linkAttrs']['rel']);
    }

    public function testWithHrefAndTargetSelf(): void
    {
        $component = new Avatar($this->config);
        $component->href = '/profile';
        $component->target = '_self';
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('target', $options['linkAttrs']);
        $this->assertSame('_self', $options['linkAttrs']['target']);
        $this->assertArrayNotHasKey('rel', $options['linkAttrs']);
    }

    public function testCustomClasses(): void
    {
        $component = new Avatar($this->config);
        $component->class = 'custom-class another-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-class', $options['wrapperClasses']);
        $this->assertStringContainsString('another-class', $options['wrapperClasses']);
    }

    public function testCustomAttributes(): void
    {
        $component = new Avatar($this->config);
        $component->attr = [
            'data-test' => 'avatar',
            'data-id' => '123',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('avatar', $options['attrs']['data-test']);
        $this->assertArrayHasKey('data-id', $options['attrs']);
        $this->assertSame('123', $options['attrs']['data-id']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'avatar' => [
                'size' => 'lg',
                'shape' => 'rounded',
                'border' => true,
                'variant' => 'primary',
                'class' => 'default-class',
            ],
        ]);

        $component = new Avatar($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('lg', $component->size);
        $this->assertSame('rounded', $component->shape);
        $this->assertTrue($component->border);
        $this->assertSame('primary', $component->variant);
        $this->assertStringContainsString('default-class', $options['wrapperClasses']);
    }

    public function testComponentOverridesConfigDefaults(): void
    {
        $config = new Config([
            'avatar' => [
                'size' => 'md',
                'shape' => 'circle',
            ],
        ]);

        $component = new Avatar($config);
        $component->size = 'xl';
        $component->shape = 'square';
        $component->mount();
        $options = $component->options();

        $this->assertSame('xl', $component->size);
        $this->assertSame('square', $component->shape);
        $this->assertStringContainsString('avatar-xl', $options['wrapperClasses']);
        $this->assertStringContainsString('rounded-0', $options['wrapperClasses']);
    }

    public function testGetComponentName(): void
    {
        $component = new Avatar($this->config);
        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('avatar', $method->invoke($component));
    }

    public function testCombinedOptions(): void
    {
        $component = new Avatar($this->config);
        $component->src = '/avatar.jpg';
        $component->alt = 'User';
        $component->size = 'lg';
        $component->shape = 'circle';
        $component->status = 'online';
        $component->border = true;
        $component->borderColor = 'success';
        $component->href = '/profile';
        $component->class = 'custom';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('avatar', $options['wrapperClasses']);
        $this->assertStringContainsString('avatar-lg', $options['wrapperClasses']);
        $this->assertStringContainsString('rounded-circle', $options['wrapperClasses']);
        $this->assertStringContainsString('avatar-border', $options['wrapperClasses']);
        $this->assertStringContainsString('border-success', $options['wrapperClasses']);
        $this->assertStringContainsString('avatar-link', $options['wrapperClasses']);
        $this->assertStringContainsString('custom', $options['wrapperClasses']);
        $this->assertTrue($options['hasStatus']);
        $this->assertStringContainsString('avatar-status-online', $options['statusClasses']);
        $this->assertSame('/avatar.jpg', $options['src']);
        $this->assertSame('/profile', $options['href']);
    }
}

