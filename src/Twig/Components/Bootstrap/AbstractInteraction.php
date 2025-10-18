<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\HtmlAttributesTrait;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\IconTrait;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\PopoverTrait;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\StateTrait;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\StimulusTrait;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\TooltipTrait;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\VariantTrait;

use function array_key_exists;
use function is_int;

/**
 * Base class for interactive components (buttons, links, etc.)
 * that share common functionality like tooltips, popovers, icons, and state.
 */
abstract class AbstractInteraction
{
    use StimulusTrait;
    use TooltipTrait;
    use PopoverTrait;
    use HtmlAttributesTrait;
    use VariantTrait;
    use StateTrait;
    use IconTrait;

    public ?string $label = null;
    public string $class = '';

    /**
     * @var array<string, mixed>
     */
    public array $attr = [];
    public ?string $ariaLabel = null;
    public string $stimulusController = 'bs-link';

    public function __construct(protected readonly Config $config)
    {
    }

    /**
     * Apply common defaults for interactive components
     *
     * @param array<string, mixed> $defaults
     */
    protected function applyCommonDefaults(array $defaults): void
    {
        $this->applyVariantDefaults($defaults);
        $this->applyStateDefaults($defaults);

        $this->applyTooltipDefaults($defaults['tooltip'] ?? []);
        $this->applyPopoverDefaults($defaults['popover'] ?? []);

        if (!empty($defaults['stimulus_controller'])) {
            $this->stimulusController = (string)$defaults['stimulus_controller'];
        }

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

        $attrs = $this->mergeAttributes($attrs, $this->tooltipAttributes());
        $attrs = $this->mergeAttributes($attrs, $this->popoverAttributes());
        $attrs = $this->mergeAttributes($attrs, $this->stimulusAttributes($this->stimulusController));
        $attrs = $this->mergeAttributes($attrs, $this->stateAttributesFor($this->getComponentType(), $isAnchor));

        $attrs = $this->applyIconOnlyAria($attrs, $this->label, $this->ariaLabel);

        $attrs = $this->mergeAttributes($attrs, $this->attr);

        return $attrs;
    }

    /**
     * Get component type for CSS class generation (e.g., 'button', 'link')
     */
    abstract protected function getComponentType(): string;
}

