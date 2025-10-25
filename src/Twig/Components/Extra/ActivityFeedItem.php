<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * ActivityFeedItem Component
 *
 * Represents a single item in an activity feed.
 *
 * Example usage:
 * ```twig
 * <twig:bs:activity-feed-item
 *     icon="bi-person-plus"
 *     iconVariant="success"
 *     title="New team member"
 *     description="John Doe joined the team"
 *     timestamp="2 hours ago"
 *     :metadata="['Location: New York', 'Role: Developer']"
 * />
 * ```
 */
#[AsTwigComponent(name: 'bs:activity-feed-item', template: '@NeuralGlitchUxBootstrap/components/extra/activity-feed-item.html.twig')]
final class ActivityFeedItem extends AbstractStimulus
{
    /**
     * Icon class (Bootstrap Icons, Font Awesome, etc.)
     */
    public ?string $icon = null;

    /**
     * Alternative: avatar image URL
     */
    public ?string $avatar = null;

    /**
     * Icon/avatar background variant
     */
    public ?string $iconVariant = null;

    /**
     * Item title (main text)
     */
    public ?string $title = null;

    /**
     * Item description (secondary text)
     */
    public ?string $description = null;

    /**
     * Timestamp text (e.g., "2 hours ago", "2024-01-15 10:30")
     */
    public ?string $timestamp = null;

    /**
     * Additional metadata array
     * @var array<string>
     */
    public array $metadata = [];

    /**
     * Link URL for the entire item
     */
    public ?string $href = null;

    /**
     * Action button label
     */
    public ?string $actionLabel = null;

    /**
     * Action button URL
     */
    public ?string $actionHref = null;

    /**
     * Whether this item is highlighted/emphasized
     */
    public ?bool $highlighted = null;

    /**
     * Whether this item is unread
     */
    public ?bool $unread = null;

    /**
     * Item type for semantic styling (e.g., 'post', 'comment', 'system', 'warning')
     */
    public ?string $type = null;

    public function mount(): void
    {
        $d = $this->config->for('activity-feed-item');

        $this->applyStimulusDefaults($d);

        $this->applyClassDefaults($d);

        $this->icon ??= $this->configString($d, 'icon');
        $this->avatar ??= $this->configString($d, 'avatar');
        $this->iconVariant ??= $this->configStringWithFallback($d, 'icon_variant', 'primary');
        $this->title ??= $this->configString($d, 'title');
        $this->description ??= $this->configString($d, 'description');
        $this->timestamp ??= $this->configString($d, 'timestamp');
        $metadata = $this->configArray($d, 'metadata', []) ?? [];
        /** @var array<string> $metadata */
        $this->metadata = $this->metadata ?: $metadata;
        $this->href ??= $this->configString($d, 'href');
        $this->actionLabel ??= $this->configString($d, 'action_label');
        $this->actionHref ??= $this->configString($d, 'action_href');
        $this->highlighted ??= $this->configBool($d, 'highlighted');
        $this->unread ??= $this->configBool($d, 'unread');
        $this->type ??= $this->configString($d, 'type');


        // Initialize controller with default
        $this->initializeController();
    }

    protected function getComponentName(): string
    {
        return 'activity-feed-item';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classArray = $this->class ? array_filter(explode(' ', trim($this->class)), fn($v) => $v !== '') : [];
        /** @var array<string> $classArray */

        $classes = $this->buildClassesFromArrays(
            ['activity-feed-item', 'd-flex', 'gap-3', 'py-3'],
            $this->highlighted ? ['bg-light'] : [],
            $this->unread ? ['activity-feed-item-unread'] : [],
            $this->href ? ['activity-feed-item-link'] : [],
            $classArray
        );

        $attrs = $this->mergeAttributes([], $this->attr);

        return [
            'classes' => $classes,
            'attrs' => $attrs,
            'icon' => $this->icon,
            'avatar' => $this->avatar,
            'iconVariant' => $this->iconVariant,
            'title' => $this->title,
            'description' => $this->description,
            'timestamp' => $this->timestamp,
            'metadata' => $this->metadata,
            'href' => $this->href,
            'actionLabel' => $this->actionLabel,
            'actionHref' => $this->actionHref,
            'highlighted' => $this->highlighted,
            'unread' => $this->unread,
            'type' => $this->type,
        ];
    }
}

