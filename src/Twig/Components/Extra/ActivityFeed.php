<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractBootstrap;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * ActivityFeed Component
 *
 * Displays a timeline-style activity feed suitable for:
 * - Social media feeds
 * - Audit logs
 * - Team activity
 * - System events
 *
 * Example usage:
 * ```twig
 * <twig:bs:activity-feed>
 *     <twig:bs:activity-feed-item
 *         icon="bi-person-plus"
 *         title="John Doe joined the team"
 *         timestamp="2 hours ago"
 *     />
 * </twig:bs:activity-feed>
 * ```
 */
#[AsTwigComponent(name: 'bs:activity-feed', template: '@NeuralGlitchUxBootstrap/components/extra/activity-feed.html.twig')]
final class ActivityFeed extends AbstractBootstrap
{
    /**
     * Display mode: 'default' or 'compact'
     */
    public ?string $mode = null;

    /**
     * Whether to show timestamps
     */
    public ?bool $showTimestamps = null;

    /**
     * Whether to show avatars/icons
     */
    public ?bool $showIcons = null;

    /**
     * Border style: null, 'start' (left border), 'end' (right border)
     */
    public ?string $border = null;

    /**
     * Whether to group items by date
     */
    public ?bool $groupByDate = null;

    /**
     * Maximum height with scroll (e.g., '400px', null for no limit)
     */
    public ?string $maxHeight = null;

    /**
     * Container tag
     */
    public string $tag = 'div';

    public function mount(): void
    {
        $d = $this->config->for('activity_feed');

        $this->applyClassDefaults($d);

        $this->mode ??= $d['mode'] ?? 'default';
        $this->showTimestamps ??= $d['show_timestamps'] ?? true;
        $this->showIcons ??= $d['show_icons'] ?? true;
        
        // Handle border: if explicitly set in config (even to null), use that value
        if ($this->border === null && array_key_exists('border', $d)) {
            $this->border = $d['border'];
        } elseif ($this->border === null) {
            $this->border = 'start';
        }
        
        $this->groupByDate ??= $d['group_by_date'] ?? false;
        $this->maxHeight ??= $d['max_height'] ?? null;
        $this->tag ??= $d['tag'] ?? 'div';
    }

    protected function getComponentName(): string
    {
        return 'activity_feed';
    }

    public function options(): array
    {
        $classes = $this->buildClasses(
            ['activity-feed'],
            $this->mode === 'compact' ? ['activity-feed-compact'] : [],
            $this->border === 'start' ? ['border-start', 'border-3'] : [],
            $this->border === 'end' ? ['border-end', 'border-3'] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = $this->mergeAttributes([], $this->attr);

        // Add inline styles for maxHeight if set
        if ($this->maxHeight) {
            $style = ($attrs['style'] ?? '') . " max-height: {$this->maxHeight}; overflow-y: auto;";
            $attrs['style'] = trim($style);
        }

        return [
            'tag' => $this->tag,
            'classes' => $classes,
            'attrs' => $attrs,
            'showTimestamps' => $this->showTimestamps,
            'showIcons' => $this->showIcons,
            'groupByDate' => $this->groupByDate,
            'mode' => $this->mode,
        ];
    }
}

