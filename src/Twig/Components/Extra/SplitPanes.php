<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:split-panes', template: '@NeuralGlitchUxBootstrap/components/extra/split-panes.html.twig')]
final class SplitPanes extends AbstractStimulus
{
    public string $stimulusController = 'bs-split-panes';

    /**
     * Orientation: 'horizontal' (left/right) or 'vertical' (top/bottom)
     */
    public string $orientation = 'horizontal';

    /**
     * Initial size of the first pane (%, px, or default)
     */
    public ?string $initialSize = null;

    /**
     * Minimum size of the first pane (%, px)
     */
    public ?string $minSize = null;

    /**
     * Maximum size of the first pane (%, px)
     */
    public ?string $maxSize = null;

    /**
     * Enable resizing
     */
    public bool $resizable = true;

    /**
     * Enable collapsible panes
     */
    public bool $collapsible = false;

    /**
     * Persist size to localStorage (requires unique id)
     */
    public bool $persistent = false;

    /**
     * Unique identifier for persistent storage
     */
    public ?string $id = null;

    /**
     * Divider size in pixels
     */
    public int $dividerSize = 4;

    /**
     * Snap threshold in pixels
     */
    public int $snapThreshold = 50;

    /**
     * Initial pane that should be collapsed ('first' | 'second' | null)
     */
    public ?string $collapsed = null;

    public function mount(): void
    {
        $d = $this->config->for('split-panes');

        $this->applyStimulusDefaults($d);

        $this->applyClassDefaults($d);

        // Apply defaults
        $this->orientation = ($this->orientation !== 'horizontal') ? $this->orientation : $this->configStringWithFallback($d, 'orientation', 'horizontal');
        $this->initialSize = $this->configString($d, 'initial_size');
        $this->minSize = $this->configString($d, 'min_size');
        $this->maxSize = $this->configString($d, 'max_size');

        // Boolean properties: config overrides default only if explicitly set
        if ($this->resizable === true && isset($d['resizable']) && $d['resizable'] === false) {
            $this->resizable = false;
        }
        if ($this->collapsible === false && isset($d['collapsible']) && $d['collapsible'] === true) {
            $this->collapsible = true;
        }
        if ($this->persistent === false && isset($d['persistent']) && $d['persistent'] === true) {
            $this->persistent = true;
        }

        // Integers: use config if default value
        $this->dividerSize = ($this->dividerSize !== 4) ? $this->dividerSize : $this->configIntWithFallback($d, 'divider_size', 4);
        $this->snapThreshold = ($this->snapThreshold !== 50) ? $this->snapThreshold : $this->configIntWithFallback($d, 'snap_threshold', 50);

        $this->collapsed = $this->configString($d, 'collapsed');

        // Generate ID if persistent and no ID provided
        if ($this->persistent && !$this->id) {
            $this->id = 'split-panes-' . uniqid();
        }

        // Initialize controller with default
        $this->initializeController();
    }

    protected function getComponentName(): string
    {
        return 'split-panes';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $isHorizontal = $this->orientation === 'horizontal';

        $containerClasses = $this->buildClasses(
            ['split-panes', "split-panes-{$this->orientation}"],
            $this->resizable ? ['split-panes-resizable'] : [],
            $this->collapsible ? ['split-panes-collapsible'] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = $this->buildStimulusAttributes();
        $attrs = $this->mergeAttributes($attrs, $this->attr);

        if ($this->id) {
            $attrs['id'] = $this->id;
            $attrs['data-bs-split-panes-storage-key-value'] = $this->id;
        }

        if ($this->initialSize) {
            $attrs['data-bs-split-panes-initial-size-value'] = $this->initialSize;
        }

        if ($this->minSize) {
            $attrs['data-bs-split-panes-min-size-value'] = $this->minSize;
        }

        if ($this->maxSize) {
            $attrs['data-bs-split-panes-max-size-value'] = $this->maxSize;
        }

        if ($this->collapsed) {
            $attrs['data-bs-split-panes-collapsed-value'] = $this->collapsed;
        }

        return [
            'containerClasses' => $containerClasses,
            'attrs' => $attrs,
            'isHorizontal' => $isHorizontal,
            'dividerSize' => $this->dividerSize,
        ];
    }
}

