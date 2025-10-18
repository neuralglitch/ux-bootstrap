<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits;

use function is_array;
use function preg_match;

trait PopoverTrait
{
    public ?string $popoverTitle = null;
    public ?string $popoverContent = null;

    /**
     * @var array<string, mixed>|null
     */
    public array|null $popover = null;
    public ?string $popoverPlacement = null;
    public ?string $popoverTrigger = null;
    public ?string $popoverBoundary = null;
    public ?bool $popoverHtml = null;

    /**
     * @param array<string, mixed> $defaults
     */
    protected function applyPopoverDefaults(array $defaults): void
    {
        $this->popoverTitle ??= $defaults['title'] ?? null;
        $this->popoverContent ??= $defaults['content'] ?? null;
        $this->popoverPlacement ??= $defaults['placement'] ?? null;
        $this->popoverTrigger ??= $defaults['trigger'] ?? null;
        $this->popoverBoundary ??= $defaults['boundary'] ?? null;
        $this->popoverHtml ??= isset($defaults['html']) ? (bool)$defaults['html'] : null;
    }

    private function normalizePopoverInput(): void
    {
        if (!is_array($this->popover)) {
            return;
        }
        $p = $this->popover;

        if (isset($p['title'])) {
            $this->popoverTitle = (string)$p['title'];
        }
        if (isset($p['content'])) {
            $this->popoverContent = (string)$p['content'];
        }
        if (isset($p['placement'])) {
            $this->popoverPlacement = (string)$p['placement'];
        }
        if (isset($p['trigger'])) {
            $this->popoverTrigger = (string)$p['trigger'];
        }
        if (isset($p['boundary'])) {
            $this->popoverBoundary = (string)$p['boundary'];
        }
        if (isset($p['html'])) {
            $this->popoverHtml = (bool)$p['html'];
        }
    }

    /**
     * @return array<string, mixed>
     */
    protected function popoverAttributes(): array
    {
        $this->normalizePopoverInput();

        if ($this->popoverContent === null && $this->popoverTitle === null) {
            return [];
        }

        $attrs = ['data-bs-toggle' => 'popover'];

        if ($this->popoverTitle !== null) {
            $attrs['data-bs-title'] = $this->popoverTitle;
        }
        if ($this->popoverContent !== null) {
            $attrs['data-bs-content'] = $this->popoverContent;
        }
        if ($this->popoverPlacement) {
            $attrs['data-bs-placement'] = $this->popoverPlacement;
        }
        if ($this->popoverTrigger) {
            $attrs['data-bs-trigger'] = $this->popoverTrigger;
        }
        if ($this->popoverBoundary) {
            $attrs['data-bs-boundary'] = $this->popoverBoundary;
        }

        $html = $this->popoverHtml;
        if ($html === null) {
            $html = (bool)preg_match('/<[^>]+>/', (string)($this->popoverContent ?? $this->popoverTitle ?? ''));
        }
        $attrs['data-bs-html'] = $html ? 'true' : 'false';

        return $attrs;
    }
}
