<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Alert;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class AlertTest extends TestCase
{
    /** @param array<string, mixed> $config */
    private function createConfig(array $config = []): Config
    {
        return new Config(['alert' => $config]);
    }

    private function createAlert(?Config $config = null): Alert
    {
        return new Alert($config ?? $this->createConfig());
    }

    public function testComponentHasCorrectDefaults(): void
    {
        $alert = $this->createAlert();
        $alert->mount(); // Controller is set in mount()

        self::assertNull($alert->message);
        self::assertFalse($alert->dismissible);
        self::assertTrue($alert->fade);
        self::assertTrue($alert->show);
        self::assertFalse($alert->autoHide);
        self::assertSame(5000, $alert->autoHideDelay);
        self::assertSame('alert', $alert->role);
        // Controller not attached by default (only when autoHide=true)
        self::assertSame('', $alert->controller);
        self::assertNull($alert->variant);
        self::assertFalse($alert->outline);
        self::assertSame('', $alert->class);
        self::assertSame([], $alert->attr);
    }

    public function testMountAppliesConfigDefaults(): void
    {
        $config = $this->createConfig([
            'variant' => 'danger',
            'dismissible' => true,
            'fade' => false,
            'show' => false,
            'auto_hide' => true,
            'auto_hide_delay' => 3000,
            'role' => 'status',
            'controller' => 'custom-alert',
        ]);

        $alert = $this->createAlert($config);
        // For these to use config, we need to set them to falsy values first
        $alert->autoHideDelay = 0;
        $alert->role = '';
        $alert->mount();

        self::assertSame('danger', $alert->variant);
        self::assertTrue($alert->dismissible);
        self::assertFalse($alert->fade);
        self::assertFalse($alert->show);
        self::assertTrue($alert->autoHide);
        self::assertSame(3000, $alert->autoHideDelay);
        self::assertSame('status', $alert->role);
        self::assertSame('custom-alert', $alert->controller);
    }

    public function testMountRespectsPropertyOverrides(): void
    {
        $config = $this->createConfig([
            'variant' => 'danger',
            'dismissible' => true,
            'auto_hide' => true,
        ]);

        $alert = $this->createAlert($config);
        $alert->variant = 'success';
        $alert->dismissible = false;
        $alert->autoHide = false;
        $alert->mount();

        // Properties already set should take precedence
        self::assertSame('success', $alert->variant);
        // But these use OR logic, so config true always wins
        self::assertTrue($alert->dismissible);
        self::assertTrue($alert->autoHide);
    }

    public function testMountAppliesVariantDefaults(): void
    {
        $config = $this->createConfig([
            'variant' => 'warning',
            'outline' => true,
        ]);

        $alert = $this->createAlert($config);
        $alert->mount();

        self::assertSame('warning', $alert->variant);
        self::assertTrue($alert->outline);
    }

    public function testMountWithFadeFalseInConfig(): void
    {
        $config = $this->createConfig(['fade' => false]);
        $alert = $this->createAlert($config);
        $alert->mount();

        self::assertFalse($alert->fade);
    }

    public function testMountWithShowFalseInConfig(): void
    {
        $config = $this->createConfig(['show' => false]);
        $alert = $this->createAlert($config);
        $alert->mount();

        self::assertFalse($alert->show);
    }

    public function testMountAppliesClassDefaults(): void
    {
        $config = $this->createConfig(['class' => 'custom-class']);
        $alert = $this->createAlert($config);
        $alert->mount();

        self::assertSame('custom-class', $alert->class);
    }

    public function testMountMergesClassWithExisting(): void
    {
        $config = $this->createConfig(['class' => 'config-class']);
        $alert = $this->createAlert($config);
        $alert->class = 'user-class';
        $alert->mount();

        self::assertSame('user-class config-class', $alert->class);
    }

    public function testGetComponentName(): void
    {
        $alert = $this->createAlert();

        $reflection = new ReflectionClass($alert);
        $method = $reflection->getMethod('getComponentName');
        $method->setAccessible(true);

        self::assertSame('alert', $method->invoke($alert));
    }

    public function testOptionsReturnsCorrectStructure(): void
    {
        $alert = $this->createAlert();
        $alert->message = 'Test message';
        $alert->dismissible = true;
        $alert->fade = true;
        $alert->show = true;
        $alert->autoHide = false;
        $alert->autoHideDelay = 5000;
        $alert->mount();

        $options = $alert->options();

        self::assertIsArray($options);
        self::assertArrayHasKey('message', $options);
        self::assertArrayHasKey('dismissible', $options);
        self::assertArrayHasKey('fade', $options);
        self::assertArrayHasKey('show', $options);
        self::assertArrayHasKey('autoHide', $options);
        self::assertArrayHasKey('autoHideDelay', $options);
        self::assertArrayHasKey('classes', $options);
        self::assertArrayHasKey('attrs', $options);
    }

    public function testOptionsBuildsCorrectClasses(): void
    {
        $config = $this->createConfig(['variant' => 'primary']);
        $alert = $this->createAlert($config);
        $alert->dismissible = true;
        $alert->fade = true;
        $alert->show = true;
        $alert->mount();

        $options = $alert->options();

        self::assertStringContainsString('alert', $options['classes']);
        self::assertStringContainsString('alert-primary', $options['classes']);
        self::assertStringContainsString('alert-dismissible', $options['classes']);
        self::assertStringContainsString('fade', $options['classes']);
        self::assertStringContainsString('show', $options['classes']);
    }

    public function testOptionsWithoutDismissible(): void
    {
        $alert = $this->createAlert();
        $alert->dismissible = false;
        $alert->mount();

        $options = $alert->options();

        self::assertStringNotContainsString('alert-dismissible', $options['classes']);
    }

    public function testOptionsWithoutFade(): void
    {
        $alert = $this->createAlert();
        $alert->fade = false;
        $alert->mount();

        $options = $alert->options();

        self::assertStringNotContainsString('fade', $options['classes']);
    }

    public function testOptionsWithoutShow(): void
    {
        $alert = $this->createAlert();
        $alert->show = false;
        $alert->mount();

        $options = $alert->options();

        self::assertStringNotContainsString('show', $options['classes']);
    }

    public function testOptionsIncludesCustomClass(): void
    {
        $alert = $this->createAlert();
        $alert->class = 'my-custom-class another-class';
        $alert->mount();

        $options = $alert->options();

        self::assertStringContainsString('my-custom-class', $options['classes']);
        self::assertStringContainsString('another-class', $options['classes']);
    }

    public function testOptionsAttrsIncludesRole(): void
    {
        $alert = $this->createAlert();
        $alert->role = 'status';
        $alert->mount();

        $options = $alert->options();

        self::assertArrayHasKey('role', $options['attrs']);
        self::assertSame('status', $options['attrs']['role']);
    }

    public function testOptionsAttrsWithoutAutoHide(): void
    {
        $alert = $this->createAlert();
        $alert->autoHide = false;
        $alert->mount();

        $options = $alert->options();

        self::assertArrayNotHasKey('data-controller', $options['attrs']);
        self::assertArrayNotHasKey('data-bs-alert-auto-hide-value', $options['attrs']);
        self::assertArrayNotHasKey('data-bs-alert-auto-hide-delay-value', $options['attrs']);
    }

    public function testOptionsAttrsWithAutoHide(): void
    {
        $alert = $this->createAlert();
        $alert->autoHide = true;
        $alert->autoHideDelay = 3000;
        $alert->controller = 'bs-alert';
        $alert->mount();

        $options = $alert->options();

        self::assertArrayHasKey('data-controller', $options['attrs']);
        self::assertSame('bs-alert', $options['attrs']['data-controller']);
        self::assertArrayHasKey('data-bs-alert-auto-hide-value', $options['attrs']);
        self::assertSame('true', $options['attrs']['data-bs-alert-auto-hide-value']);
        self::assertArrayHasKey('data-bs-alert-auto-hide-delay-value', $options['attrs']);
        self::assertSame('3000', $options['attrs']['data-bs-alert-auto-hide-delay-value']);
    }

    public function testOptionsMergesCustomAttributes(): void
    {
        $alert = $this->createAlert();
        $alert->attr = [
            'id' => 'my-alert',
            'data-custom' => 'value',
        ];
        $alert->mount();

        $options = $alert->options();

        self::assertArrayHasKey('id', $options['attrs']);
        self::assertSame('my-alert', $options['attrs']['id']);
        self::assertArrayHasKey('data-custom', $options['attrs']);
        self::assertSame('value', $options['attrs']['data-custom']);
    }

    public function testOptionsCustomAttributesOverrideDefaults(): void
    {
        $alert = $this->createAlert();
        $alert->role = 'alert';
        $alert->attr = ['role' => 'status'];
        $alert->mount();

        $options = $alert->options();

        self::assertSame('status', $options['attrs']['role']);
    }

    public function testVariantClassesForDifferentVariants(): void
    {
        $variants = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'];

        foreach ($variants as $variant) {
            $config = $this->createConfig(['variant' => $variant]);
            $alert = $this->createAlert($config);
            $alert->mount();

            $options = $alert->options();

            self::assertStringContainsString("alert-{$variant}", $options['classes']);
        }
    }

    public function testAlertWithAllFeaturesEnabled(): void
    {
        $config = $this->createConfig([
            'variant' => 'warning',
            'dismissible' => true,
            'auto_hide' => true,
            'auto_hide_delay' => 2000,
        ]);

        $alert = $this->createAlert($config);
        $alert->message = 'Warning message';
        $alert->class = 'custom-alert';
        $alert->attr = ['id' => 'test-alert'];
        $alert->autoHideDelay = 0; // Set to 0 to use config value
        $alert->mount();

        $options = $alert->options();

        self::assertSame('Warning message', $options['message']);
        self::assertTrue($options['dismissible']);
        self::assertTrue($options['autoHide']);
        self::assertSame(2000, $options['autoHideDelay']);
        self::assertStringContainsString('alert', $options['classes']);
        self::assertStringContainsString('alert-warning', $options['classes']);
        self::assertStringContainsString('alert-dismissible', $options['classes']);
        self::assertStringContainsString('custom-alert', $options['classes']);
        self::assertArrayHasKey('id', $options['attrs']);
        self::assertArrayHasKey('data-controller', $options['attrs']);
        self::assertArrayHasKey('data-bs-alert-auto-hide-value', $options['attrs']);
    }

    public function testOptionsReturnsMessageValue(): void
    {
        $alert = $this->createAlert();
        $alert->message = 'Test message content';
        $alert->mount();

        $options = $alert->options();

        self::assertSame('Test message content', $options['message']);
    }

    public function testOptionsReturnsNullMessageWhenNotSet(): void
    {
        $alert = $this->createAlert();
        $alert->mount();

        $options = $alert->options();

        self::assertNull($options['message']);
    }

    public function testDismissibleOrLogicWithConfig(): void
    {
        // Config says true, property says false -> should be true (OR logic)
        $config = $this->createConfig(['dismissible' => true]);
        $alert = $this->createAlert($config);
        $alert->dismissible = false;
        $alert->mount();

        self::assertTrue($alert->dismissible);
    }

    public function testAutoHideOrLogicWithConfig(): void
    {
        // Config says true, property says false -> should be true (OR logic)
        $config = $this->createConfig(['auto_hide' => true]);
        $alert = $this->createAlert($config);
        $alert->autoHide = false;
        $alert->mount();

        self::assertTrue($alert->autoHide);
    }

    public function testFadeAndLogicWithConfig(): void
    {
        // Config says false, property says true -> should be false (AND logic)
        $config = $this->createConfig(['fade' => false]);
        $alert = $this->createAlert($config);
        $alert->fade = true;
        $alert->mount();

        self::assertFalse($alert->fade);
    }

    public function testShowAndLogicWithConfig(): void
    {
        // Config says false, property says true -> should be false (AND logic)
        $config = $this->createConfig(['show' => false]);
        $alert = $this->createAlert($config);
        $alert->show = true;
        $alert->mount();

        self::assertFalse($alert->show);
    }

    public function testAutoHideDelayUsesPropertyIfSet(): void
    {
        $config = $this->createConfig(['auto_hide_delay' => 3000]);
        $alert = $this->createAlert($config);
        $alert->autoHideDelay = 7000;
        $alert->mount();

        self::assertSame(7000, $alert->autoHideDelay);
    }

    public function testAutoHideDelayUsesConfigIfPropertyIsFalsy(): void
    {
        $config = $this->createConfig(['auto_hide_delay' => 8000]);
        $alert = $this->createAlert($config);
        // Set to 0 (falsy) so config value is used
        $alert->autoHideDelay = 0;
        $alert->mount();

        self::assertSame(8000, $alert->autoHideDelay);
    }

    public function testRoleUsesPropertyIfSet(): void
    {
        $config = $this->createConfig(['role' => 'status']);
        $alert = $this->createAlert($config);
        $alert->role = 'banner';
        $alert->mount();

        self::assertSame('banner', $alert->role);
    }

    public function testEmptyConfigUsesAllDefaults(): void
    {
        $alert = $this->createAlert($this->createConfig([]));
        $alert->mount();

        self::assertNull($alert->variant);
        self::assertFalse($alert->dismissible);
        self::assertTrue($alert->fade);
        self::assertTrue($alert->show);
        self::assertFalse($alert->autoHide);
        self::assertSame(5000, $alert->autoHideDelay);
        self::assertSame('alert', $alert->role);
    }
}

