<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * NotificationBadge Component
 *
 * A small indicator badge for showing notifications, counts, or status on elements
 * like nav items, avatars, buttons, and icons.
 */
#[AsTwigComponent(name: 'bs:notification-badge', template: '@NeuralGlitchUxBootstrap/components/extra/notification-badge.html.twig')]
final class NotificationBadge extends AbstractStimulus
{
    /**
     * The content to display (number, text, or null for dot)
     */
    public ?string $content = null;

    /**
     * Badge variant (primary, secondary, success, danger, warning, info, light, dark)
     */
    public ?string $variant = null;

    /**
     * Position relative to parent (top-start, top-end, bottom-start, bottom-end)
     */
    public ?string $position = null;

    /**
     * Size of the badge (sm, md, lg)
     */
    public ?string $size = null;

    /**
     * Whether to show as a dot (ignores content)
     */
    public bool $dot = false;

    /**
     * Whether to show a pulse animation
     */
    public bool $pulse = false;

    /**
     * Whether the badge is bordered (with white border)
     */
    public bool $bordered = true;

    /**
     * Whether to use pill style (rounded)
     */
    public bool $pill = true;

    /**
     * Maximum number to display (e.g., 99 shows "99+")
     */
    public ?int $max = null;

    /**
     * Whether to show the badge inline instead of positioned
     */
    public bool $inline = false;

    public function mount(): void
    {
        $d = $this->config->for('notification-badge');

        $this->applyStimulusDefaults($d);

        $this->applyClassDefaults($d);

        // Apply defaults
        $this->variant ??= $this->configStringWithFallback($d, 'variant', 'danger');
        $this->position ??= $this->configStringWithFallback($d, 'position', 'top-end');
        $this->size ??= $this->configStringWithFallback($d, 'size', 'md');
        $this->dot = $this->dot || $this->configBoolWithFallback($d, 'dot', false);
        $this->pulse = $this->pulse || $this->configBoolWithFallback($d, 'pulse', false);
        $this->bordered = $this->bordered && $this->configBoolWithFallback($d, 'bordered', true);
        $this->pill = $this->pill && $this->configBoolWithFallback($d, 'pill', true);
        $this->max ??= $this->configInt($d, 'max');
        $this->inline = $this->inline || $this->configBoolWithFallback($d, 'inline', false);


        // Initialize controller with default
        $this->initializeController();
    }

    protected function getComponentName(): string
    {
        return 'notification-badge';
    }

    /**
     * @return array{content: ?string, classes: string, attrs: array<string, mixed>, isDot: bool, isPulse: bool}
     */
    public function options(): array
    {
        // Process content
        $displayContent = $this->getDisplayContent();

        // Ensure variant has a value
        $variant = $this->variant ?? 'danger';
        $position = $this->position ?? 'top-end';

        // Build classes
        $classArray = $this->class ? array_filter(explode(' ', trim($this->class)), fn($v) => $v !== '') : [];
        /** @var array<string> $classArray */

        $classes = $this->buildClassesFromArrays(
            ['badge', "text-bg-{$variant}"],
            $this->pill ? ['rounded-pill'] : [],
            $this->dot ? ['p-1'] : [],
            !$this->inline ? ['position-absolute', "badge-{$position}"] : [],
            $this->bordered ? ['border', 'border-light'] : [],
            [$this->getSizeClass()],
            $this->pulse ? ['badge-pulse'] : [],
            $classArray
        );

        // Build attributes
        $attrs = $this->mergeAttributes(
            [],
            $this->attr
        );

        return [
            'content' => $displayContent,
            'classes' => $classes,
            'attrs' => $attrs,
            'isDot' => $this->dot,
            'isPulse' => $this->pulse,
        ];
    }

    /**
     * Get the display content, applying max limit if set
     */
    private function getDisplayContent(): ?string
    {
        if ($this->dot) {
            return null;
        }

        if ($this->content === null || $this->content === '') {
            return null;
        }

        // If max is set and content is numeric
        if ($this->max !== null && is_numeric($this->content)) {
            $num = (int)$this->content;
            if ($num > $this->max) {
                return $this->max . '+';
            }
        }

        return $this->content;
    }

    /**
     * Get the size-specific class
     */
    private function getSizeClass(): string
    {
        return match ($this->size ?? 'md') {
            'sm' => 'badge-notification-sm',
            'lg' => 'badge-notification-lg',
            default => 'badge-notification-md',
        };
    }
}

