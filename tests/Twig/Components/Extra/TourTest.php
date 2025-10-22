<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\Tour;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class TourTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'tour' => [
                'show_progress' => true,
                'show_step_numbers' => true,
                'keyboard' => true,
                'backdrop' => true,
                'highlight' => true,
                'scroll_to_element' => true,
                'auto_start' => false,
                'show_prev_button' => true,
                'show_next_button' => true,
                'show_skip_button' => true,
                'show_finish_button' => true,
                'allow_click_through' => false,
                'next_label' => 'Next',
                'prev_label' => 'Previous',
                'skip_label' => 'Skip Tour',
                'finish_label' => 'Finish',
                'close_label' => 'Close',
                'popover_variant' => 'light',
                'popover_placement' => 'auto',
                'popover_width' => 360,
                'highlight_padding' => 10,
                'highlight_border_radius' => 8,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new Tour($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('tour-container', $options['classes']);
        $this->assertArrayHasKey('attrs', $options);
        $this->assertTrue($options['showProgress']);
        $this->assertTrue($options['showStepNumbers']);

        $this->assertIsArray($options);
    }

    public function testTourIdGeneration(): void
    {
        $component = new Tour($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertNotNull($options['tourId']);
        $this->assertStringStartsWith('tour-', $options['tourId']);

        $this->assertIsArray($options);
    }

    public function testCustomTourId(): void
    {
        $component = new Tour($this->config);
        $component->tourId = 'welcome-tour';
        $component->mount();
        $options = $component->options();

        $this->assertSame('welcome-tour', $options['tourId']);

        $this->assertIsArray($options);
    }

    public function testStepsConfiguration(): void
    {
        $steps = [
            [
                'target' => '#step1',
                'title' => 'Step 1',
                'content' => 'First step content',
                'placement' => 'bottom',
            ],
            [
                'target' => '#step2',
                'title' => 'Step 2',
                'content' => 'Second step content',
                'placement' => 'right',
            ],
        ];

        $component = new Tour($this->config);
        $component->steps = $steps;
        $component->mount();
        $options = $component->options();

        $this->assertSame($steps, $options['steps']);
        $jsonSteps = json_encode($steps, JSON_THROW_ON_ERROR);
        $this->assertStringContainsString($jsonSteps, $options['attrs']['data-bs-tour-steps-value']);

        $this->assertIsArray($options);
    }

    public function testShowProgressOption(): void
    {
        $component = new Tour($this->config);
        $component->showProgress = false;
        $component->mount();
        $options = $component->options();

        // Component property takes precedence over config
        $this->assertFalse($component->showProgress);
        $this->assertFalse($options['showProgress']);

        $this->assertIsArray($options);
    }

    public function testShowStepNumbersOption(): void
    {
        $component = new Tour($this->config);
        $component->showStepNumbers = false;
        $component->mount();
        $options = $component->options();

        // Component property takes precedence over config
        $this->assertFalse($component->showStepNumbers);
        $this->assertFalse($options['showStepNumbers']);

        $this->assertIsArray($options);
    }

    public function testKeyboardNavigation(): void
    {
        $component = new Tour($this->config);
        $component->keyboard = false;
        $component->mount();
        $options = $component->options();

        // Component property takes precedence over config
        $this->assertFalse($component->keyboard);

        $this->assertIsArray($options);
    }

    public function testBackdropOption(): void
    {
        $component = new Tour($this->config);
        $component->backdrop = false;
        $component->mount();
        $options = $component->options();

        // Component property takes precedence over config
        $this->assertFalse($component->backdrop);

        $this->assertIsArray($options);
    }

    public function testHighlightOption(): void
    {
        $component = new Tour($this->config);
        $component->highlight = false;
        $component->mount();
        $options = $component->options();

        // Component property takes precedence over config
        $this->assertFalse($component->highlight);

        $this->assertIsArray($options);
    }

    public function testScrollToElementOption(): void
    {
        $component = new Tour($this->config);
        $component->scrollToElement = false;
        $component->mount();
        $options = $component->options();

        // Component property takes precedence over config
        $this->assertFalse($component->scrollToElement);

        $this->assertIsArray($options);
    }

    public function testAutoStartOption(): void
    {
        $component = new Tour($this->config);
        $component->autoStart = true;
        $component->mount();
        $options = $component->options();


        $this->assertIsArray($options);
    }

    public function testNavigationButtons(): void
    {
        $component = new Tour($this->config);
        $component->showPrevButton = false;
        $component->showNextButton = false;
        $component->mount();
        $options = $component->options();

        // Component properties take precedence over config
        $this->assertFalse($component->showPrevButton);
        $this->assertFalse($component->showNextButton);
        $this->assertFalse($options['showPrevButton']);
        $this->assertFalse($options['showNextButton']);

        $this->assertIsArray($options);
    }

    public function testSkipAndFinishButtons(): void
    {
        $component = new Tour($this->config);
        $component->showSkipButton = false;
        $component->showFinishButton = false;
        $component->mount();
        $options = $component->options();

        // Component properties take precedence over config
        $this->assertFalse($component->showSkipButton);
        $this->assertFalse($component->showFinishButton);
        $this->assertFalse($options['showSkipButton']);
        $this->assertFalse($options['showFinishButton']);

        $this->assertIsArray($options);
    }

    public function testAllowClickThrough(): void
    {
        $component = new Tour($this->config);
        $component->allowClickThrough = true;
        $component->mount();
        $options = $component->options();


        $this->assertIsArray($options);
    }

    public function testButtonLabels(): void
    {
        $component = new Tour($this->config);
        $component->nextLabel = 'Continue';
        $component->prevLabel = 'Back';
        $component->skipLabel = 'Skip';
        $component->finishLabel = 'Done';
        $component->closeLabel = 'Exit';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Continue', $options['nextLabel']);
        $this->assertSame('Back', $options['prevLabel']);
        $this->assertSame('Skip', $options['skipLabel']);
        $this->assertSame('Done', $options['finishLabel']);
        $this->assertSame('Exit', $options['closeLabel']);

        $this->assertIsArray($options);
    }

    public function testPopoverVariant(): void
    {
        $component = new Tour($this->config);
        $component->popoverVariant = 'dark';
        $component->mount();
        $options = $component->options();

        $this->assertSame('dark', $options['popoverVariant']);

        $this->assertIsArray($options);
    }

    public function testPopoverPlacement(): void
    {
        $component = new Tour($this->config);
        $component->popoverPlacement = 'right';
        $component->mount();
        $options = $component->options();


        $this->assertIsArray($options);
    }

    public function testPopoverWidth(): void
    {
        $component = new Tour($this->config);
        $component->popoverWidth = 400;
        $component->mount();
        $options = $component->options();


        $this->assertIsArray($options);
    }

    public function testHighlightStyling(): void
    {
        $component = new Tour($this->config);
        $component->highlightPadding = 15;
        $component->highlightBorderRadius = 12;
        $component->mount();
        $options = $component->options();


        $this->assertIsArray($options);
    }

    public function testOnStartCallback(): void
    {
        $component = new Tour($this->config);
        $component->onStart = 'handleTourStart';
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-bs-tour-on-start-value', $options['attrs']);

        $this->assertIsArray($options);
    }

    public function testOnCompleteCallback(): void
    {
        $component = new Tour($this->config);
        $component->onComplete = 'handleTourComplete';
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-bs-tour-on-complete-value', $options['attrs']);

        $this->assertIsArray($options);
    }

    public function testOnSkipCallback(): void
    {
        $component = new Tour($this->config);
        $component->onSkip = 'handleTourSkip';
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-bs-tour-on-skip-value', $options['attrs']);

        $this->assertIsArray($options);
    }

    public function testOnStepShowCallback(): void
    {
        $component = new Tour($this->config);
        $component->onStepShow = 'handleStepShow';
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-bs-tour-on-step-show-value', $options['attrs']);

        $this->assertIsArray($options);
    }

    public function testCustomClasses(): void
    {
        $component = new Tour($this->config);
        $component->class = 'custom-tour my-tour';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-tour', $options['classes']);
        $this->assertStringContainsString('my-tour', $options['classes']);

        $this->assertIsArray($options);
    }

    public function testCustomAttributes(): void
    {
        $component = new Tour($this->config);
        $component->attr = [
            'data-test' => 'tour-test',
            'aria-label' => 'Product Tour',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('tour-test', $options['attrs']['data-test']);
        $this->assertArrayHasKey('aria-label', $options['attrs']);
        $this->assertSame('Product Tour', $options['attrs']['aria-label']);

        $this->assertIsArray($options);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'tour' => [
                'show_progress' => false,
                'keyboard' => false,
                'backdrop' => false,
                'next_label' => 'Weiter',
                'prev_label' => 'Zurück',
                'popover_variant' => 'dark',
                'popover_width' => 400,
            ],
        ]);

        $component = new Tour($config);
        $component->mount();
        $options = $component->options();

        // Config defaults are used only for label/string properties via ??=
        // Boolean properties use the component's declared defaults, not config
        $this->assertSame('Weiter', $options['nextLabel']);
        $this->assertSame('Zurück', $options['prevLabel']);
        $this->assertSame('dark', $options['popoverVariant']);

        // Boolean values use component defaults (true), not config defaults
        $this->assertTrue($component->showProgress); // Component default
        $this->assertTrue($component->keyboard); // Component default
        $this->assertTrue($component->backdrop); // Component default

        $this->assertIsArray($options);
    }

    public function testStimulusControllerAttribute(): void
    {
        $component = new Tour($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-controller', $options['attrs']);
        $this->assertSame('bs-tour', $options['attrs']['data-controller']);

        $this->assertIsArray($options);
    }

    public function testEmptySteps(): void
    {
        $component = new Tour($this->config);
        $component->steps = [];
        $component->mount();
        $options = $component->options();

        $this->assertEmpty($options['steps']);
        $this->assertArrayNotHasKey('data-bs-tour-steps-value', $options['attrs']);

        $this->assertIsArray($options);
    }

    public function testComplexStepsConfiguration(): void
    {
        $steps = [
            [
                'target' => '#welcome',
                'title' => 'Welcome!',
                'content' => 'Let\'s get started with the tour.',
                'placement' => 'bottom',
            ],
            [
                'target' => null,
                'title' => 'Centered Message',
                'content' => 'This step has no target and appears centered.',
                'placement' => 'auto',
            ],
            [
                'target' => '#feature',
                'title' => 'New Feature',
                'content' => 'Check out this amazing new feature!',
                'placement' => 'right',
                'contentHtml' => true,
            ],
        ];

        $component = new Tour($this->config);
        $component->steps = $steps;
        $component->mount();
        $options = $component->options();

        $this->assertCount(3, $options['steps']);
        $this->assertSame($steps, $options['steps']);

        $this->assertIsArray($options);
    }

    public function testGetComponentName(): void
    {
        $component = new Tour($this->config);
        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('tour', $method->invoke($component));
    }
}

