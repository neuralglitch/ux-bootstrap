<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits;

trait TooltipPopoverTrait
{
    // Tooltip properties - accept mixed types and convert to strings
    public mixed $tooltip = null;
    public string $tooltipPlacement = 'top';
    public string $tooltipTrigger = 'hover';
    public ?bool $tooltipHtml = null;
    public ?int $tooltipDelay = null;
    public ?string $tooltipContainer = null;
    public ?string $tooltipCustomClass = null;

    // Popover properties - accept mixed types and convert to strings
    public mixed $popover = null;
    public ?string $popoverTitle = null;
    public string $popoverPlacement = 'top';
    public string $popoverTrigger = 'click';
    public ?bool $popoverHtml = null;
    public ?int $popoverDelay = null;
    public ?string $popoverContainer = null;
    public ?string $popoverCustomClass = null;

    /**
     * Apply tooltip/popover defaults from configuration
     *
     * @param array<string, mixed> $defaults
     */
    protected function applyTooltipPopoverDefaults(array $defaults): void
    {
        // Tooltip defaults - convert arrays to strings if needed
        $tooltipValue = $defaults['tooltip'] ?? null;
        if (is_string($tooltipValue)) {
            $this->tooltip ??= $tooltipValue;
        } elseif (is_array($tooltipValue) && isset($tooltipValue['text']) && is_string($tooltipValue['text'])) {
            $this->tooltip ??= $tooltipValue['text'];
        }
        $this->tooltipPlacement = $this->tooltipPlacement ?: $this->configStringWithFallback($defaults, 'tooltip_placement', 'top');
        $this->tooltipTrigger = $this->tooltipTrigger ?: $this->configStringWithFallback($defaults, 'tooltip_trigger', 'hover');
        $this->tooltipHtml ??= $this->configBool($defaults, 'tooltip_html');
        $this->tooltipDelay ??= $this->configInt($defaults, 'tooltip_delay');
        $this->tooltipContainer ??= $this->configString($defaults, 'tooltip_container');

        // Popover defaults - convert arrays to strings if needed
        $popoverValue = $defaults['popover'] ?? null;
        if (is_string($popoverValue)) {
            $this->popover ??= $popoverValue;
        } elseif (is_array($popoverValue)) {
            if (isset($popoverValue['content']) && is_string($popoverValue['content'])) {
                $this->popover ??= $popoverValue['content'];
            }
            if (isset($popoverValue['title']) && is_string($popoverValue['title'])) {
                $this->popoverTitle ??= $popoverValue['title'];
            }
        }
        $this->popoverTitle ??= $this->configString($defaults, 'popover_title');
        $this->popoverPlacement = $this->popoverPlacement ?: $this->configStringWithFallback($defaults, 'popover_placement', 'top');
        $this->popoverTrigger = $this->popoverTrigger ?: $this->configStringWithFallback($defaults, 'popover_trigger', 'click');
        $this->popoverHtml ??= $this->configBool($defaults, 'popover_html');
        $this->popoverDelay ??= $this->configInt($defaults, 'popover_delay');
        $this->popoverContainer ??= $this->configString($defaults, 'popover_container');
    }

    /**
     * Build tooltip/popover attributes for HTML output
     *
     * @return array<string, mixed>
     */
    protected function buildTooltipPopoverAttributes(): array
    {
        $attrs = [];

        // Tooltip attributes (priority over popover if both are set)
        if ($this->tooltip) {
            $tooltipText = $this->convertToString($this->tooltip);
            
            // Only set tooltip attributes if there's actual content
            if (!empty(trim($tooltipText))) {
                $attrs['data-bs-toggle'] = 'tooltip';
                $attrs['data-bs-title'] = $tooltipText;
                $attrs['data-bs-placement'] = $this->tooltipPlacement;
                $attrs['data-bs-trigger'] = $this->tooltipTrigger;
                
                $html = $this->tooltipHtml;
                if ($html === null) {
                    $html = (bool)preg_match('/<[^>]+>/', $tooltipText);
                }
                $attrs['data-bs-html'] = $html ? 'true' : 'false';
                if ($this->tooltipDelay !== null) {
                    $attrs['data-bs-delay'] = (string)$this->tooltipDelay;
                }
                if ($this->tooltipContainer) {
                    $attrs['data-bs-container'] = $this->tooltipContainer;
                }
            }
        }
        // Popover attributes (only if no tooltip)
        elseif ($this->popover) {
            $popoverContent = $this->convertToString($this->popover);
            
            // Only set popover attributes if there's actual content
            if (!empty(trim($popoverContent))) {
                $attrs['data-bs-toggle'] = 'popover';
                $attrs['data-bs-content'] = $popoverContent;
                $attrs['data-bs-placement'] = $this->popoverPlacement;
                $attrs['data-bs-trigger'] = $this->popoverTrigger;
                
                if ($this->popoverTitle) {
                    $attrs['data-bs-title'] = $this->popoverTitle;
                }
                
                $html = $this->popoverHtml;
                if ($html === null) {
                    $html = (bool)preg_match('/<[^>]+>/', $popoverContent);
                }
                $attrs['data-bs-html'] = $html ? 'true' : 'false';
                
                if ($this->popoverDelay !== null) {
                    $attrs['data-bs-delay'] = (string)$this->popoverDelay;
                }
                if ($this->popoverContainer) {
                    $attrs['data-bs-container'] = $this->popoverContainer;
                }
            }
        }

        return $attrs;
    }

    /**
     * Check if tooltip or popover is configured
     */
    protected function hasTooltipOrPopover(): bool
    {
        return $this->tooltip !== null || $this->popover !== null;
    }

    /**
     * Convert mixed value to string
     */
    private function convertToString(mixed $value): string
    {
        if (is_string($value)) {
            return $value;
        }
        if (is_array($value) && isset($value['text']) && is_string($value['text'])) {
            return $value['text'];
        }
        if (is_array($value) && isset($value['content']) && is_string($value['content'])) {
            return $value['content'];
        }
        return is_scalar($value) ? (string)$value : '';
    }
}
