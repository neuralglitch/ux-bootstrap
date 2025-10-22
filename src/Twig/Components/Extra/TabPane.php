<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:tab-pane', template: '@NeuralGlitchUxBootstrap/components/extra/tab-pane.html.twig')]
final class TabPane extends AbstractStimulus
{
    // Identification
    public ?string $id = null;
    public ?string $labelledBy = null;

    // State
    public bool $active = false;
    public bool $fade = true;

    // Content
    public ?string $title = null;

    public function mount(): void
    {
        $d = $this->config->for('tab-pane');

        $this->applyStimulusDefaults($d);

        // Apply defaults
        $this->active = $this->active || ($d['active'] ?? false);
        $this->fade = $this->fade && ($d['fade'] ?? true);

        // Generate ID if not provided
        if (!$this->id && $this->title) {
            $this->id = 'tab-' . preg_replace('/[^a-z0-9]+/', '-', strtolower($this->title));
        }

        // Auto-generate labelledBy if not provided
        if (!$this->labelledBy && $this->id) {
            $this->labelledBy = $this->id . '-tab';
        }

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
        return 'tab-pane';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = $this->buildClasses(
            ['tab-pane'],
            $this->fade ? ['fade'] : [],
            $this->active ? ['show', 'active'] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = $this->mergeAttributes(
            [
                'role' => 'tabpanel',
                'aria-labelledby' => $this->labelledBy,
            ],
            $this->attr
        );

        return [
            'id' => $this->id,
            'title' => $this->title,
            'classes' => $classes,
            'attrs' => $attrs,
        ];
    }
}

