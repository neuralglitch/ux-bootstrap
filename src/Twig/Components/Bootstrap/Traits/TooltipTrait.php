<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits;

use function is_array;
use function preg_match;

trait TooltipTrait
{
    /**
     * @var string|array<string, mixed>|null
     */
    public string|array|null $tooltip = null;

    public ?string $tooltipPlacement = null;
    public ?string $tooltipTrigger = null;
    public ?string $tooltipContainer = null;
    public ?bool $tooltipHtml = null; // null=auto, true/false erzwingen

    /**
     * @param array<string, mixed> $defaults
     */
    protected function applyTooltipDefaults(array $defaults): void
    {
        $this->tooltip ??= $defaults['text'] ?? null;
        $this->tooltipPlacement ??= $defaults['placement'] ?? null;
        $this->tooltipTrigger ??= $defaults['trigger'] ?? null;
        $this->tooltipContainer ??= $defaults['container'] ?? null;
        $this->tooltipHtml ??= isset($defaults['html']) ? (bool)$defaults['html'] : null;
    }

    /** Array→Properties normalisieren, falls tooltip als Array übergeben wurde */
    private function normalizeTooltipInput(): void
    {
        if (!is_array($this->tooltip)) {
            return;
        }
        $arr = $this->tooltip;

        if (isset($arr['text'])) {
            $this->tooltip = (string)$arr['text'];
        } else {
            $this->tooltip = null;
        }

        if (isset($arr['placement'])) {
            $this->tooltipPlacement = (string)$arr['placement'];
        }
        if (isset($arr['trigger'])) {
            $this->tooltipTrigger = (string)$arr['trigger'];
        }
        if (isset($arr['container'])) {
            $this->tooltipContainer = (string)$arr['container'];
        }
        if (isset($arr['html'])) {
            $this->tooltipHtml = (bool)$arr['html'];
        }
    }

    /**
     * @return array<string, mixed>
     */
    protected function tooltipAttributes(): array
    {
        $this->normalizeTooltipInput();

        if (!$this->tooltip) {
            return [];
        }

        $attrs = [
            'data-bs-toggle' => 'tooltip',
            'data-bs-title' => $this->tooltip,
        ];

        if ($this->tooltipPlacement) {
            $attrs['data-bs-placement'] = $this->tooltipPlacement;
        }
        if ($this->tooltipTrigger) {
            $attrs['data-bs-trigger'] = $this->tooltipTrigger;
        }
        if ($this->tooltipContainer) {
            $attrs['data-bs-container'] = $this->tooltipContainer;
        }

        $html = $this->tooltipHtml;
        if ($html === null) {
            $html = (bool)preg_match('/<[^>]+>/', (string)$this->tooltip);
        }
        $attrs['data-bs-html'] = $html ? 'true' : 'false';

        return $attrs;
    }
}
