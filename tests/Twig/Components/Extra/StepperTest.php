<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\Stepper;
use PHPUnit\Framework\TestCase;

final class StepperTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'stepper' => [
                'variant' => 'horizontal',
                'style' => 'default',
                'current_step' => 1,
                'clickable_completed' => true,
                'show_labels' => true,
                'show_descriptions' => false,
                'show_progress_bar' => false,
                'completed_icon' => null,
                'active_icon' => null,
                'pending_icon' => null,
                'completed_variant' => 'success',
                'active_variant' => 'primary',
                'pending_variant' => 'secondary',
                'size' => 'default',
                'responsive' => true,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new Stepper($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('stepper', $options['classes']);
        $this->assertStringContainsString('stepper--horizontal', $options['classes']);
        $this->assertStringContainsString('stepper--default', $options['classes']);
        $this->assertStringContainsString('stepper--responsive', $options['classes']);
        $this->assertSame(1, $options['currentStep']);
        $this->assertTrue($options['clickableCompleted']);
        $this->assertTrue($options['showLabels']);
        $this->assertFalse($options['showDescriptions']);
        $this->assertFalse($options['showProgressBar']);
    }

    public function testVerticalVariant(): void
    {
        $component = new Stepper($this->config);
        $component->variant = 'vertical';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('stepper--vertical', $options['classes']);
        $this->assertSame('vertical', $options['variant']);
    }

    public function testProgressStyle(): void
    {
        $component = new Stepper($this->config);
        $component->style = 'progress';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('stepper--progress', $options['classes']);
        $this->assertSame('progress', $options['style']);
    }

    public function testMinimalStyle(): void
    {
        $component = new Stepper($this->config);
        $component->style = 'minimal';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('stepper--minimal', $options['classes']);
    }

    public function testWithSteps(): void
    {
        $component = new Stepper($this->config);
        $component->steps = [
            ['label' => 'Account Info'],
            ['label' => 'Shipping Address'],
            ['label' => 'Payment'],
            ['label' => 'Confirm'],
        ];
        $component->currentStep = 2;
        $component->mount();
        $options = $component->options();

        $this->assertCount(4, $options['steps']);
        $this->assertSame(2, $options['currentStep']);
        $this->assertSame(4, $options['totalSteps']);
    }

    public function testStepStates(): void
    {
        $component = new Stepper($this->config);
        $component->steps = [
            ['label' => 'Step 1'],
            ['label' => 'Step 2'],
            ['label' => 'Step 3'],
        ];
        $component->currentStep = 2;
        $component->mount();
        $options = $component->options();

        $this->assertSame('completed', $options['steps'][0]['state']);
        $this->assertSame('active', $options['steps'][1]['state']);
        $this->assertSame('pending', $options['steps'][2]['state']);
    }

    public function testStepVariants(): void
    {
        $component = new Stepper($this->config);
        $component->steps = [
            ['label' => 'Step 1'],
            ['label' => 'Step 2'],
            ['label' => 'Step 3'],
        ];
        $component->currentStep = 2;
        $component->completedVariant = 'success';
        $component->activeVariant = 'primary';
        $component->pendingVariant = 'secondary';
        $component->mount();
        $options = $component->options();

        $this->assertSame('success', $options['steps'][0]['variant']);
        $this->assertSame('primary', $options['steps'][1]['variant']);
        $this->assertSame('secondary', $options['steps'][2]['variant']);
    }

    public function testClickableCompletedSteps(): void
    {
        $component = new Stepper($this->config);
        $component->steps = [
            ['label' => 'Step 1', 'href' => '/step1'],
            ['label' => 'Step 2', 'href' => '/step2'],
            ['label' => 'Step 3', 'href' => '/step3'],
        ];
        $component->currentStep = 3;
        $component->clickableCompleted = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['steps'][0]['clickable']);
        $this->assertTrue($options['steps'][1]['clickable']);
        $this->assertFalse($options['steps'][2]['clickable']); // Active step not clickable
    }

    public function testClickableDisabled(): void
    {
        $component = new Stepper($this->config);
        $component->steps = [
            ['label' => 'Step 1', 'href' => '/step1'],
            ['label' => 'Step 2', 'href' => '/step2'],
        ];
        $component->currentStep = 2;
        $component->clickableCompleted = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['steps'][0]['clickable']);
    }

    public function testStepDescriptions(): void
    {
        $component = new Stepper($this->config);
        $component->steps = [
            ['label' => 'Step 1', 'description' => 'Enter your details'],
            ['label' => 'Step 2', 'description' => 'Review information'],
        ];
        $component->showDescriptions = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['showDescriptions']);
        $this->assertSame('Enter your details', $options['steps'][0]['description']);
        $this->assertSame('Review information', $options['steps'][1]['description']);
    }

    public function testProgressBarEnabled(): void
    {
        $component = new Stepper($this->config);
        $component->steps = [
            ['label' => 'Step 1'],
            ['label' => 'Step 2'],
            ['label' => 'Step 3'],
            ['label' => 'Step 4'],
        ];
        $component->currentStep = 3;
        $component->showProgressBar = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['showProgressBar']);
        $this->assertSame(50.0, $options['progressPercentage']); // 2 completed out of 4
    }

    public function testProgressCalculation(): void
    {
        $component = new Stepper($this->config);
        $component->steps = [
            ['label' => 'Step 1'],
            ['label' => 'Step 2'],
            ['label' => 'Step 3'],
            ['label' => 'Step 4'],
        ];
        $component->currentStep = 1;
        $component->mount();
        $options = $component->options();

        $this->assertSame(0.0, $options['progressPercentage']); // No completed steps

        $component->currentStep = 4;
        $component->mount();
        $options = $component->options();

        $this->assertSame(75.0, $options['progressPercentage']); // 3 out of 4 completed
    }

    public function testCustomIcons(): void
    {
        $component = new Stepper($this->config);
        $component->completedIcon = '✓';
        $component->activeIcon = '◉';
        $component->pendingIcon = '○';
        $component->mount();
        $options = $component->options();

        $this->assertSame('✓', $options['completedIcon']);
        $this->assertSame('◉', $options['activeIcon']);
        $this->assertSame('○', $options['pendingIcon']);
    }

    public function testStepWithCustomIcon(): void
    {
        $component = new Stepper($this->config);
        $component->steps = [
            ['label' => 'Account', 'icon' => '<i class="bi bi-person"></i>'],
            ['label' => 'Shipping', 'icon' => '<i class="bi bi-truck"></i>'],
        ];
        $component->mount();
        $options = $component->options();

        $this->assertSame('<i class="bi bi-person"></i>', $options['steps'][0]['icon']);
        $this->assertSame('<i class="bi bi-truck"></i>', $options['steps'][1]['icon']);
    }

    public function testSmallSize(): void
    {
        $component = new Stepper($this->config);
        $component->size = 'sm';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('stepper--sm', $options['classes']);
    }

    public function testLargeSize(): void
    {
        $component = new Stepper($this->config);
        $component->size = 'lg';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('stepper--lg', $options['classes']);
    }

    public function testResponsiveDisabled(): void
    {
        $component = new Stepper($this->config);
        $component->responsive = false;
        $component->mount();
        $options = $component->options();

        $this->assertStringNotContainsString('stepper--responsive', $options['classes']);
    }

    public function testCustomClasses(): void
    {
        $component = new Stepper($this->config);
        $component->class = 'custom-stepper my-stepper';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-stepper', $options['classes']);
        $this->assertStringContainsString('my-stepper', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new Stepper($this->config);
        $component->attr = [
            'data-test' => 'stepper',
            'data-tracking' => 'checkout-flow',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('stepper', $options['attrs']['data-test']);
        $this->assertArrayHasKey('data-tracking', $options['attrs']);
        $this->assertSame('checkout-flow', $options['attrs']['data-tracking']);
    }

    public function testConfigDefaults(): void
    {
        $config = new Config([
            'stepper' => [
                'variant' => 'vertical',
                'style' => 'minimal',
                'current_step' => 2,
                'clickable_completed' => true,
                'show_labels' => true,
                'show_descriptions' => false,
                'show_progress_bar' => true,
                'completed_icon' => null,
                'active_icon' => null,
                'pending_icon' => null,
                'completed_variant' => 'success',
                'active_variant' => 'primary',
                'pending_variant' => 'secondary',
                'size' => 'lg',
                'responsive' => true,
                'class' => 'default-class',
                'attr' => [],
            ],
        ]);

        $component = new Stepper($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('vertical', $component->variant);
        $this->assertSame('minimal', $component->style);
        $this->assertSame(2, $component->currentStep);
        $this->assertTrue($component->showProgressBar);
        $this->assertSame('lg', $component->size);
        $this->assertStringContainsString('default-class', $options['classes']);
    }

    public function testEmptySteps(): void
    {
        $component = new Stepper($this->config);
        $component->steps = [];
        $component->mount();
        $options = $component->options();

        $this->assertCount(0, $options['steps']);
        $this->assertSame(0, $options['totalSteps']);
        $this->assertSame(0.0, $options['progressPercentage']);
    }

    public function testGetComponentName(): void
    {
        $component = new Stepper($this->config);
        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('stepper', $method->invoke($component));
    }

    public function testExplicitClickableOverride(): void
    {
        $component = new Stepper($this->config);
        $component->steps = [
            ['label' => 'Step 1', 'clickable' => true, 'href' => '/step1'],
            ['label' => 'Step 2', 'clickable' => false],
        ];
        $component->currentStep = 2;
        $component->clickableCompleted = true;
        $component->mount();
        $options = $component->options();

        // Explicit clickable=true should be respected even for completed steps
        $this->assertTrue($options['steps'][0]['clickable']);
        // Explicit clickable=false should be respected
        $this->assertFalse($options['steps'][1]['clickable']);
    }
}

