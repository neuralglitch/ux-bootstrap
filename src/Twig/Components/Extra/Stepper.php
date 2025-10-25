<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:stepper', template: '@NeuralGlitchUxBootstrap/components/extra/stepper.html.twig')]
final class Stepper extends AbstractStimulus
{
    /**
     * @var array<int, array{label: string, description?: string, icon?: string, clickable?: bool, href?: string}>
     */
    public array $steps = [];

    public ?int $currentStep = null;

    public ?string $variant = null; // 'horizontal' | 'vertical'

    public ?string $style = null; // 'default' | 'progress' | 'minimal' | 'numbered' | 'icon'

    public ?bool $clickableCompleted = null;

    public ?bool $showLabels = null;

    public ?bool $showDescriptions = null;

    public ?bool $showProgressBar = null;

    public ?string $completedIcon = null; // e.g., '✓' or '<i class="bi bi-check"></i>'

    public ?string $activeIcon = null;

    public ?string $pendingIcon = null;

    public ?string $completedVariant = null;

    public ?string $activeVariant = null;

    public ?string $pendingVariant = null;

    public ?string $size = null; // 'sm' | 'default' | 'lg'

    public ?bool $responsive = null; // Automatically switch to vertical on mobile

    public function mount(): void
    {
        $d = $this->config->for('stepper');

        $this->applyStimulusDefaults($d);

        // Apply defaults from config
        $this->variant = $this->variant ?? $this->configStringWithFallback($d, 'variant', 'horizontal');
        $this->style = $this->style ?? $this->configStringWithFallback($d, 'style', 'default');
        $this->currentStep = $this->currentStep ?? $this->configIntWithFallback($d, 'current_step', 1);
        $this->clickableCompleted = $this->clickableCompleted ?? $this->configBoolWithFallback($d, 'clickable_completed', true);
        $this->showLabels = $this->showLabels ?? $this->configBoolWithFallback($d, 'show_labels', true);
        $this->showDescriptions = $this->showDescriptions ?? $this->configBoolWithFallback($d, 'show_descriptions', false);
        $this->showProgressBar = $this->showProgressBar ?? $this->configBoolWithFallback($d, 'show_progress_bar', false);
        $this->completedIcon = $this->completedIcon ?? $this->configString($d, 'completed_icon');
        $this->activeIcon = $this->activeIcon ?? $this->configString($d, 'active_icon');
        $this->pendingIcon = $this->pendingIcon ?? $this->configString($d, 'pending_icon');
        $this->completedVariant = $this->completedVariant ?? $this->configStringWithFallback($d, 'completed_variant', 'success');
        $this->activeVariant = $this->activeVariant ?? $this->configStringWithFallback($d, 'active_variant', 'primary');
        $this->pendingVariant = $this->pendingVariant ?? $this->configStringWithFallback($d, 'pending_variant', 'secondary');
        $this->size = $this->size ?? $this->configStringWithFallback($d, 'size', 'default');
        $this->responsive = $this->responsive ?? $this->configBoolWithFallback($d, 'responsive', true);

        $this->applyClassDefaults($d);

        // Merge attr defaults
        if (isset($d['attr']) && is_array($d['attr'])) {
            $this->attr = array_merge($d['attr'], $this->attr);
        }

        // Initialize controller with default
        $this->initializeController();
    }

    protected function getComponentName(): string
    {
        return 'stepper';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = $this->buildClassesFromArrays(
            ['stepper'],
            ["stepper--{$this->variant}"],
            ["stepper--{$this->style}"],
            $this->size !== 'default' ? ["stepper--{$this->size}"] : [],
            $this->responsive ? ['stepper--responsive'] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = $this->mergeAttributes([], $this->attr);

        // Process steps to add state information
        $processedSteps = $this->processSteps();

        // Calculate progress percentage
        $progressPercentage = $this->calculateProgress();

        return [
            'steps' => $processedSteps,
            'currentStep' => $this->currentStep,
            'variant' => $this->variant,
            'style' => $this->style,
            'clickableCompleted' => $this->clickableCompleted,
            'showLabels' => $this->showLabels,
            'showDescriptions' => $this->showDescriptions,
            'showProgressBar' => $this->showProgressBar,
            'completedIcon' => $this->completedIcon,
            'activeIcon' => $this->activeIcon,
            'pendingIcon' => $this->pendingIcon,
            'completedVariant' => $this->completedVariant,
            'activeVariant' => $this->activeVariant,
            'pendingVariant' => $this->pendingVariant,
            'progressPercentage' => $progressPercentage,
            'totalSteps' => count($this->steps),
            'classes' => $classes,
            'attrs' => $attrs,
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function processSteps(): array
    {
        $processed = [];

        foreach ($this->steps as $index => $step) {
            $stepNumber = $index + 1;
            $state = $this->getStepState($stepNumber);

            $processed[] = [
                'number' => $stepNumber,
                'label' => $step['label'],
                'description' => $step['description'] ?? null,
                'icon' => $step['icon'] ?? null,
                'href' => $step['href'] ?? null,
                'clickable' => $step['clickable'] ?? ($state === 'completed' && $this->clickableCompleted),
                'state' => $state,
                'variant' => $this->getStepVariant($state),
            ];
        }

        return $processed;
    }

    private function getStepState(int $stepNumber): string
    {
        if ($stepNumber < $this->currentStep) {
            return 'completed';
        } elseif ($stepNumber === $this->currentStep) {
            return 'active';
        } else {
            return 'pending';
        }
    }

    private function getStepVariant(string $state): string
    {
        return match ($state) {
            'completed' => $this->completedVariant ?? 'success',
            'active' => $this->activeVariant ?? 'primary',
            'pending' => $this->pendingVariant ?? 'secondary',
            default => 'secondary',
        };
    }

    private function calculateProgress(): float
    {
        if (count($this->steps) === 0) {
            return 0;
        }

        $completedSteps = $this->currentStep - 1;
        return ($completedSteps / count($this->steps)) * 100;
    }
}

