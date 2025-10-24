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
        } elseif (is_array($tooltipValue) && isset($tooltipValue['text'])) {
            $this->tooltip ??= (string)$tooltipValue['text'];
        }
        $this->tooltipPlacement = $this->tooltipPlacement ?: ($defaults['tooltip_placement'] ?? 'top');
        $this->tooltipTrigger = $this->tooltipTrigger ?: ($defaults['tooltip_trigger'] ?? 'hover');
        $this->tooltipHtml = $this->tooltipHtml || ($defaults['tooltip_html'] ?? false);
        $this->tooltipDelay ??= $defaults['tooltip_delay'] ?? null;
        $this->tooltipContainer ??= $defaults['tooltip_container'] ?? null;

        // Popover defaults - convert arrays to strings if needed
        $popoverValue = $defaults['popover'] ?? null;
        if (is_string($popoverValue)) {
            $this->popover ??= $popoverValue;
        } elseif (is_array($popoverValue) && isset($popoverValue['content'])) {
            $this->popover ??= (string)$popoverValue['content'];
        }
        $this->popoverTitle ??= $defaults['popover_title'] ?? null;
        $this->popoverPlacement = $this->popoverPlacement ?: ($defaults['popover_placement'] ?? 'top');
        $this->popoverTrigger = $this->popoverTrigger ?: ($defaults['popover_trigger'] ?? 'click');
        $this->popoverHtml = $this->popoverHtml || ($defaults['popover_html'] ?? false);
        $this->popoverDelay ??= $defaults['popover_delay'] ?? null;
        $this->popoverContainer ??= $defaults['popover_container'] ?? null;
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
            $attrs['data-bs-toggle'] = 'tooltip';
            $tooltipText = $this->convertToString($this->tooltip);
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
        // Popover attributes (only if no tooltip)
        elseif ($this->popover) {
            $attrs['data-bs-toggle'] = 'popover';
            $popoverContent = $this->convertToString($this->popover);
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
        if (is_array($value) && isset($value['text'])) {
            return (string)$value['text'];
        }
        if (is_array($value) && isset($value['content'])) {
            return (string)$value['content'];
        }
        return (string)$value;
    }
}
