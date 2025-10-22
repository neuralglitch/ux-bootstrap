<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\VariantTrait;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:theme', template: '@NeuralGlitchUxBootstrap/components/extra/theme.html.twig')]
final class Theme extends AbstractStimulus
{
    use VariantTrait;

    public string $stimulusController = 'bs-theme';

    public ?string $initial = null;
    public ?string $mode = null;

    public function mount(): void
    {
        $d = $this->config->for('theme-toggle');

        $this->applyStimulusDefaults($d);
        $this->applyVariantDefaults($d);
        $this->applyClassDefaults($d);

        // Apply mode default if not explicitly set
        if ($this->mode === null && isset($d['mode'])) {
            $this->mode = (string)$d['mode'];
        }

        // Initialize controller with default
        $this->initializeController();
    }

    protected function getComponentName(): string
    {
        return 'theme';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        // Wrapper div should only have user-defined classes, not button variant classes
        $classes = $this->buildClasses(
            $this->class ? explode(' ', trim($this->class)) : []
        );

        // Build Stimulus attributes using new pattern
        $attrs = $this->buildStimulusAttributes();

        // Merge with custom attributes
        $attrs = $this->mergeAttributes($attrs, $this->attr);

        return [
            'mode' => $this->mode ?? 'button-icon',
            'variant' => $this->variant ?? 'outline-secondary',
            'initial' => $this->initial,
            'classes' => $classes,
            'attrs' => $attrs,
        ];
    }
}

