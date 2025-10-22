<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\IconTrait;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\PopoverTrait;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\StateTrait;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\TooltipTrait;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\VariantTrait;

use function array_key_exists;
use function is_int;

/**
 * Base class for interactive components (buttons, links, etc.)
 * that share common functionality like tooltips, popovers, icons, and state.
 *
 * Extends AbstractStimulus for automatic Stimulus controller management.
 */
abstract class AbstractInteraction extends AbstractStimulus
{
    use TooltipTrait;
    use PopoverTrait;
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
    protected function applyCommonDefaults(array $defaults): void
    {
        $this->applyVariantDefaults($defaults);
        $this->applyStateDefaults($defaults);
        $this->applyStimulusDefaults($defaults);  // Use new pattern

        $this->applyTooltipDefaults($defaults['tooltip'] ?? []);
        $this->applyPopoverDefaults($defaults['popover'] ?? []);

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
    protected function buildCommonAttributes(bool $isAnchor = true): array
    {
        $attrs = [];

        if ($this->ariaLabel) {
            $attrs['aria-label'] = $this->ariaLabel;
        }

        // Add tooltip/popover attributes (these may trigger controllers)
        $attrs = $this->mergeAttributes($attrs, $this->tooltipAttributes());
        $attrs = $this->mergeAttributes($attrs, $this->popoverAttributes());

        // Add Stimulus controller attributes using new pattern
        $attrs = $this->mergeAttributes($attrs, $this->buildStimulusAttributes());

        // Add state attributes
        $attrs = $this->mergeAttributes($attrs, $this->stateAttributesFor($this->getComponentType(), $isAnchor));

        // Apply icon-only aria attributes
        $attrs = $this->applyIconOnlyAria($attrs, $this->label, $this->ariaLabel);

        // Merge custom attributes
        $attrs = $this->mergeAttributes($attrs, $this->attr);

        return $attrs;
    }

    /**
     * Check if tooltips or popovers are enabled (for conditional controller attachment)
     */
    protected function hasTooltipOrPopover(): bool
    {
        return $this->tooltip !== null || $this->popover !== null;
    }

    /**
     * Get component type for CSS class generation (e.g., 'button', 'link')
     */
    abstract protected function getComponentType(): string;
}

