<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\TooltipPopoverTrait;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\VariantTrait;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\StateTrait;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\IconTrait;

/**
 * Abstract base class for interactive components (buttons, links, etc.)
 * that support tooltips, popovers, variants, state, and icons.
 * 
 * Uses Bootstrap's native JavaScript - no Stimulus controllers needed!
 */
abstract class AbstractInteractive extends AbstractStimulus
{
    use TooltipPopoverTrait;
    use VariantTrait;
    use StateTrait;
    use IconTrait;

    public ?string $label = null;
    public ?string $ariaLabel = null;

    /**
     * Apply common defaults for interactive components
     *
     * @param array<string, mixed> $defaults
     */
    protected function applyInteractiveDefaults(array $defaults): void
    {
        $this->applyVariantDefaults($defaults);
        $this->applyStateDefaults($defaults);
        $this->applyStimulusDefaults($defaults);
        $this->applyTooltipPopoverDefaults($defaults);
        
        // Apply icon defaults
        if (array_key_exists('icon_only', $defaults)) {
            $this->iconOnly = $this->iconOnly || (bool)$defaults['icon_only'];
        }
        if (array_key_exists('icon_gap', $defaults) && $this->iconGap === null) {
            $this->iconGap = is_int($defaults['icon_gap']) ? $defaults['icon_gap'] : null;
        }
        $this->iconGap = $this->toIntOrNull($this->iconGap);
    }

    /**
     * Build common attributes for interactive components
     *
     * @return array<string, mixed>
     */
    protected function buildInteractiveAttributes(bool $isAnchor = true): array
    {
        $attrs = [];

        // Aria attributes
        if ($this->ariaLabel) {
            $attrs['aria-label'] = $this->ariaLabel;
        }

        // Tooltip/Popover attributes (Bootstrap native)
        $attrs = $this->mergeAttributes($attrs, $this->buildTooltipPopoverAttributes());

        // Stimulus controller attributes
        $attrs = $this->mergeAttributes($attrs, $this->buildStimulusAttributes());

        // State attributes
        $attrs = $this->mergeAttributes($attrs, $this->stateAttributesFor($this->getComponentType(), $isAnchor));

        // Icon-only aria attributes
        $attrs = $this->applyIconOnlyAria($attrs, $this->label, $this->ariaLabel);

        // Merge custom attributes
        $attrs = $this->mergeAttributes($attrs, $this->attr);

        return $attrs;
    }

    /**
     * Get component type for CSS class generation (e.g., 'button', 'link')
     */
    abstract protected function getComponentType(): string;
}
