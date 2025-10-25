<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
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
final class ActivityFeed extends AbstractStimulus
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
        $d = $this->config->for('activity-feed');

        $this->applyStimulusDefaults($d);

        $this->applyClassDefaults($d);

        $this->mode ??= $this->configStringWithFallback($d, 'mode', 'default');
        $this->showTimestamps ??= $this->configBoolWithFallback($d, 'show_timestamps', true);
        $this->showIcons ??= $this->configBoolWithFallback($d, 'show_icons', true);

        // Handle border: if explicitly set in config (even to null), use that value
        if ($this->border === null && array_key_exists('border', $d)) {
            $this->border = $this->configString($d, 'border');


            // Initialize controller with default
            $this->initializeController();
        } elseif ($this->border === null) {
            $this->border = 'start';
        }

        $this->groupByDate ??= $this->configBoolWithFallback($d, 'group_by_date', false);
        $this->maxHeight ??= $this->configString($d, 'max_height');
        $this->tag ??= $this->configStringWithFallback($d, 'tag', 'div');
    }

    protected function getComponentName(): string
    {
        return 'activity-feed';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classArray = $this->class ? array_filter(explode(' ', trim($this->class)), fn($v) => $v !== '') : [];
        /** @var array<string> $classArray */
        
        $classes = $this->buildClassesFromArrays(
            ['activity-feed'],
            $this->mode === 'compact' ? ['activity-feed-compact'] : [],
            $this->border === 'start' ? ['border-start', 'border-3'] : [],
            $this->border === 'end' ? ['border-end', 'border-3'] : [],
            $classArray
        );

        $attrs = $this->mergeAttributes([], $this->attr);

        // Add inline styles for maxHeight if set
        if ($this->maxHeight) {
            $existingStyle = $attrs['style'] ?? '';
            $existingStyle = is_string($existingStyle) ? $existingStyle : '';
            $style = $existingStyle . " max-height: {$this->maxHeight}; overflow-y: auto;";
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

