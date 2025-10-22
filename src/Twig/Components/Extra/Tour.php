<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:tour', template: '@NeuralGlitchUxBootstrap/components/extra/tour.html.twig')]
final class Tour extends AbstractStimulus
{
    public string $stimulusController = 'bs-tour';

    // Tour identification
    public ?string $tourId = null;

    // Steps configuration (array of step definitions)
    /** @var array<int, array<string, mixed>> */
    public array $steps = [];

    // Behavior options
    public bool $showProgress = true;
    public bool $showStepNumbers = true;
    public bool $keyboard = true;           // Enable keyboard navigation
    public bool $backdrop = true;           // Show backdrop/overlay
    public bool $highlight = true;          // Highlight target elements
    public bool $scrollToElement = true;    // Auto-scroll to target
    public bool $autoStart = false;         // Start tour automatically on mount

    // Navigation options
    public bool $showPrevButton = true;
    public bool $showNextButton = true;
    public bool $showSkipButton = true;
    public bool $showFinishButton = true;
    public bool $allowClickThrough = false; // Allow clicking through backdrop

    // Button labels (initialized in mount() from config)
    public ?string $nextLabel = null;
    public ?string $prevLabel = null;
    public ?string $skipLabel = null;
    public ?string $finishLabel = null;
    public ?string $closeLabel = null;

    // Styling (initialized in mount() from config)
    public ?string $popoverVariant = null;    // 'light' | 'dark'
    public ?string $popoverPlacement = null;  // 'auto' | 'top' | 'right' | 'bottom' | 'left'
    public int $popoverWidth = 360;           // Width in pixels
    public int $highlightPadding = 10;        // Padding around highlighted element
    public int $highlightBorderRadius = 8;    // Border radius of highlight

    // Advanced options
    public ?string $onStart = null;           // JavaScript callback
    public ?string $onComplete = null;        // JavaScript callback
    public ?string $onSkip = null;            // JavaScript callback
    public ?string $onStepShow = null;        // JavaScript callback

    public function mount(): void
    {
        $d = $this->config->for('tour');

        $this->applyStimulusDefaults($d);

        // Generate unique ID if not provided
        $this->tourId ??= 'tour-' . uniqid();

        // Note: For boolean properties, we can't use ??= or || because they don't distinguish
        // between "false" and "not set". Since Twig components always initialize properties
        // to their declared defaults, we just keep the current values.

        // Apply label defaults (only if not set)
        $this->nextLabel ??= $d['next_label'] ?? 'Next';
        $this->prevLabel ??= $d['prev_label'] ?? 'Previous';
        $this->skipLabel ??= $d['skip_label'] ?? 'Skip Tour';
        $this->finishLabel ??= $d['finish_label'] ?? 'Finish';
        $this->closeLabel ??= $d['close_label'] ?? 'Close';

        // Apply styling defaults (only if not set)
        $this->popoverVariant ??= $d['popover_variant'] ?? 'light';
        $this->popoverPlacement ??= $d['popover_placement'] ?? 'auto';

        $this->applyClassDefaults($d);

        // Merge attr defaults
        if (isset($d['attr']) && is_array($d['attr'])) {
            $this->attr = array_merge($d['attr'], $this->attr);


            // Initialize controller with default
            $this->initializeController();
        }
    }

    protected function getComponentName(): string
    {
        return 'tour';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = $this->buildClasses(
            ['tour-container'],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = $this->buildStimulusAttributes();
        $attrs = $this->mergeAttributes($attrs, $this->attr);

        // Add steps as JSON data attribute
        if (!empty($this->steps)) {
            $attrs['data-bs-tour-steps-value'] = json_encode($this->steps, JSON_THROW_ON_ERROR);
        }

        // Add callbacks if provided
        if ($this->onStart !== null) {
            $attrs['data-bs-tour-on-start-value'] = $this->onStart;
        }
        if ($this->onComplete !== null) {
            $attrs['data-bs-tour-on-complete-value'] = $this->onComplete;
        }
        if ($this->onSkip !== null) {
            $attrs['data-bs-tour-on-skip-value'] = $this->onSkip;
        }
        if ($this->onStepShow !== null) {
            $attrs['data-bs-tour-on-step-show-value'] = $this->onStepShow;
        }

        return [
            'tourId' => $this->tourId,
            'steps' => $this->steps,
            'showProgress' => $this->showProgress,
            'showStepNumbers' => $this->showStepNumbers,
            'keyboard' => $this->keyboard,
            'backdrop' => $this->backdrop,
            'highlight' => $this->highlight,
            'scrollToElement' => $this->scrollToElement,
            'showPrevButton' => $this->showPrevButton,
            'showNextButton' => $this->showNextButton,
            'showSkipButton' => $this->showSkipButton,
            'showFinishButton' => $this->showFinishButton,
            'allowClickThrough' => $this->allowClickThrough,
            'nextLabel' => $this->nextLabel,
            'prevLabel' => $this->prevLabel,
            'skipLabel' => $this->skipLabel,
            'finishLabel' => $this->finishLabel,
            'closeLabel' => $this->closeLabel,
            'popoverVariant' => $this->popoverVariant,
            'popoverPlacement' => $this->popoverPlacement,
            'popoverWidth' => $this->popoverWidth,
            'highlightPadding' => $this->highlightPadding,
            'highlightBorderRadius' => $this->highlightBorderRadius,
            'classes' => $classes,
            'attrs' => $attrs,
        ];
    }
}

