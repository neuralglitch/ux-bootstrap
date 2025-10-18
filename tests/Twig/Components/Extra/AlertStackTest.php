<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\AlertStack;
use PHPUnit\Framework\TestCase;

final class AlertStackTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'alert_stack' => [
                'position' => 'top-end',
                'max_alerts' => 0,
                'default_variant' => 'info',
                'dismissible' => true,
                'auto_hide' => false,
                'auto_hide_delay' => 5000,
                'fade' => true,
                'z_index' => 1080,
                'gap' => 0.75,
                'auto_load_flash_messages' => false,
                'stimulus_controller' => 'bs-alert-stack',
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new AlertStack($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('alert-stack', $options['classes']);
        $this->assertStringContainsString('position-fixed', $options['classes']);
        $this->assertStringContainsString('top-0', $options['classes']);
        $this->assertStringContainsString('end-0', $options['classes']);
        $this->assertSame('top-end', $options['position']);
        $this->assertSame(1080, $options['zIndex']);
        $this->assertSame(0.75, $options['gap']);
    }

    public function testPositionTopEnd(): void
    {
        $component = new AlertStack($this->config);
        $component->position = 'top-end';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('top-0', $options['classes']);
        $this->assertStringContainsString('end-0', $options['classes']);
    }

    public function testPositionTopStart(): void
    {
        $component = new AlertStack($this->config);
        $component->position = 'top-start';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('top-0', $options['classes']);
        $this->assertStringContainsString('start-0', $options['classes']);
    }

    public function testPositionTopCenter(): void
    {
        $component = new AlertStack($this->config);
        $component->position = 'top-center';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('top-0', $options['classes']);
        $this->assertStringContainsString('start-50', $options['classes']);
        $this->assertStringContainsString('translate-middle-x', $options['classes']);
    }

    public function testPositionBottomEnd(): void
    {
        $component = new AlertStack($this->config);
        $component->position = 'bottom-end';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('bottom-0', $options['classes']);
        $this->assertStringContainsString('end-0', $options['classes']);
    }

    public function testPositionBottomStart(): void
    {
        $component = new AlertStack($this->config);
        $component->position = 'bottom-start';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('bottom-0', $options['classes']);
        $this->assertStringContainsString('start-0', $options['classes']);
    }

    public function testPositionBottomCenter(): void
    {
        $component = new AlertStack($this->config);
        $component->position = 'bottom-center';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('bottom-0', $options['classes']);
        $this->assertStringContainsString('start-50', $options['classes']);
        $this->assertStringContainsString('translate-middle-x', $options['classes']);
    }

    public function testEmptyAlertsArray(): void
    {
        $component = new AlertStack($this->config);
        $component->alerts = [];
        $component->mount();
        $options = $component->options();

        $this->assertIsArray($options['alerts']);
        $this->assertCount(0, $options['alerts']);
    }

    public function testAlertsAsArrayOfStrings(): void
    {
        $component = new AlertStack($this->config);
        $component->alerts = [
            'First message',
            'Second message',
            'Third message',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertCount(3, $options['alerts']);
        $this->assertSame('First message', $options['alerts'][0]['message']);
        $this->assertSame('Second message', $options['alerts'][1]['message']);
        $this->assertSame('info', $options['alerts'][0]['variant']); // Uses default variant
    }

    public function testAlertsAsArrayOfArrays(): void
    {
        $component = new AlertStack($this->config);
        $component->alerts = [
            ['message' => 'Success!', 'variant' => 'success'],
            ['message' => 'Error!', 'variant' => 'danger'],
            ['message' => 'Warning!', 'variant' => 'warning'],
        ];
        $component->mount();
        $options = $component->options();

        $this->assertCount(3, $options['alerts']);
        $this->assertSame('Success!', $options['alerts'][0]['message']);
        $this->assertSame('success', $options['alerts'][0]['variant']);
        $this->assertSame('Error!', $options['alerts'][1]['message']);
        $this->assertSame('danger', $options['alerts'][1]['variant']);
    }

    public function testMaxAlertsLimit(): void
    {
        $component = new AlertStack($this->config);
        $component->alerts = [
            'Alert 1',
            'Alert 2',
            'Alert 3',
            'Alert 4',
            'Alert 5',
        ];
        $component->maxAlerts = 3;
        $component->mount();
        $options = $component->options();

        $this->assertCount(3, $options['alerts']);
        $this->assertSame('Alert 1', $options['alerts'][0]['message']);
        $this->assertSame('Alert 2', $options['alerts'][1]['message']);
        $this->assertSame('Alert 3', $options['alerts'][2]['message']);
    }

    public function testMaxAlertsZeroMeansUnlimited(): void
    {
        $component = new AlertStack($this->config);
        $component->alerts = [
            'Alert 1',
            'Alert 2',
            'Alert 3',
            'Alert 4',
            'Alert 5',
        ];
        $component->maxAlerts = 0;
        $component->mount();
        $options = $component->options();

        $this->assertCount(5, $options['alerts']);
    }

    public function testDefaultVariantApplied(): void
    {
        $component = new AlertStack($this->config);
        $component->defaultVariant = 'warning';
        $component->alerts = [
            'Message without variant',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertSame('warning', $options['alerts'][0]['variant']);
    }

    public function testPerAlertVariantOverridesDefault(): void
    {
        $component = new AlertStack($this->config);
        $component->defaultVariant = 'info';
        $component->alerts = [
            ['message' => 'Custom variant', 'variant' => 'danger'],
        ];
        $component->mount();
        $options = $component->options();

        $this->assertSame('danger', $options['alerts'][0]['variant']);
    }

    public function testDismissibleDefault(): void
    {
        $component = new AlertStack($this->config);
        $component->dismissible = true;
        $component->alerts = [
            'Test message',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['alerts'][0]['dismissible']);
    }

    public function testPerAlertDismissibleOverridesDefault(): void
    {
        $component = new AlertStack($this->config);
        $component->dismissible = true;
        $component->alerts = [
            ['message' => 'Not dismissible', 'dismissible' => false],
        ];
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['alerts'][0]['dismissible']);
    }

    public function testAutoHideDefault(): void
    {
        $component = new AlertStack($this->config);
        $component->autoHide = true;
        $component->autoHideDelay = 3000;
        $component->alerts = [
            'Auto-hide message',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['alerts'][0]['autoHide']);
        $this->assertSame(3000, $options['alerts'][0]['autoHideDelay']);
    }

    public function testPerAlertAutoHideOverridesDefault(): void
    {
        $component = new AlertStack($this->config);
        $component->autoHide = false;
        $component->autoHideDelay = 5000;
        $component->alerts = [
            ['message' => 'Custom auto-hide', 'autoHide' => true, 'autoHideDelay' => 2000],
        ];
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['alerts'][0]['autoHide']);
        $this->assertSame(2000, $options['alerts'][0]['autoHideDelay']);
    }

    public function testAlertIdsAreGenerated(): void
    {
        $component = new AlertStack($this->config);
        $component->alerts = [
            'Alert 1',
            'Alert 2',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('id', $options['alerts'][0]);
        $this->assertArrayHasKey('id', $options['alerts'][1]);
        $this->assertNotEquals($options['alerts'][0]['id'], $options['alerts'][1]['id']);
    }

    public function testCustomAlertIds(): void
    {
        $component = new AlertStack($this->config);
        $component->alerts = [
            ['message' => 'Custom ID', 'id' => 'my-custom-alert'],
        ];
        $component->mount();
        $options = $component->options();

        $this->assertSame('my-custom-alert', $options['alerts'][0]['id']);
    }

    public function testCustomZIndex(): void
    {
        $component = new AlertStack($this->config);
        $component->zIndex = 2000;
        $component->mount();
        $options = $component->options();

        $this->assertSame(2000, $options['zIndex']);
    }

    public function testCustomGap(): void
    {
        $component = new AlertStack($this->config);
        $component->gap = 1.5;
        $component->mount();
        $options = $component->options();

        $this->assertSame(1.5, $options['gap']);
    }

    public function testStimulusAttributes(): void
    {
        $component = new AlertStack($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-controller', $options['attrs']);
        $this->assertStringContainsString('bs-alert-stack', $options['attrs']['data-controller']);
        $this->assertArrayHasKey('data-bs-alert-stack-auto-hide-value', $options['attrs']);
        $this->assertArrayHasKey('data-bs-alert-stack-auto-hide-delay-value', $options['attrs']);
        $this->assertArrayHasKey('data-bs-alert-stack-max-alerts-value', $options['attrs']);
    }

    public function testCustomClasses(): void
    {
        $component = new AlertStack($this->config);
        $component->class = 'custom-class another-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-class', $options['classes']);
        $this->assertStringContainsString('another-class', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new AlertStack($this->config);
        $component->attr = [
            'data-test' => 'value',
            'aria-label' => 'Alert Stack',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('value', $options['attrs']['data-test']);
        $this->assertArrayHasKey('aria-label', $options['attrs']);
        $this->assertSame('Alert Stack', $options['attrs']['aria-label']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'alert_stack' => [
                'position' => 'bottom-start',
                'max_alerts' => 5,
                'default_variant' => 'success',
                'dismissible' => false,
                'auto_hide' => true,
                'auto_hide_delay' => 3000,
                'z_index' => 2000,
                'gap' => 1.0,
                'class' => 'default-stack-class',
                'stimulus_controller' => 'bs-alert-stack',
            ],
        ]);

        $component = new AlertStack($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('bottom-start', $component->position);
        $this->assertSame(5, $component->maxAlerts);
        $this->assertSame('success', $component->defaultVariant);
        $this->assertFalse($component->dismissible);
        $this->assertTrue($component->autoHide);
        $this->assertSame(3000, $component->autoHideDelay);
        $this->assertSame(2000, $component->zIndex);
        $this->assertSame(1.0, $component->gap);
        $this->assertStringContainsString('default-stack-class', $options['classes']);
    }

    public function testGetComponentName(): void
    {
        $component = new AlertStack($this->config);
        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('alert_stack', $method->invoke($component));
    }

    public function testMixedAlertFormats(): void
    {
        $component = new AlertStack($this->config);
        $component->alerts = [
            'Simple string message',
            ['message' => 'Array with variant', 'variant' => 'danger'],
            'Another string',
            ['message' => 'Custom ID', 'id' => 'custom-1', 'dismissible' => false],
        ];
        $component->mount();
        $options = $component->options();

        $this->assertCount(4, $options['alerts']);
        $this->assertSame('Simple string message', $options['alerts'][0]['message']);
        $this->assertSame('info', $options['alerts'][0]['variant']);
        $this->assertSame('Array with variant', $options['alerts'][1]['message']);
        $this->assertSame('danger', $options['alerts'][1]['variant']);
        $this->assertSame('custom-1', $options['alerts'][3]['id']);
        $this->assertFalse($options['alerts'][3]['dismissible']);
    }
}

