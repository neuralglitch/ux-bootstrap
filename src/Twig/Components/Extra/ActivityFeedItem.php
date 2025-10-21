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
        $d = $this->config->for('activity_feed_item');

        $this->applyStimulusDefaults($d);

        $this->applyClassDefaults($d);

        $this->icon ??= $d['icon'] ?? null;
        $this->avatar ??= $d['avatar'] ?? null;
        $this->iconVariant ??= $d['icon_variant'] ?? 'primary';
        $this->title ??= $d['title'] ?? null;
        $this->description ??= $d['description'] ?? null;
        $this->timestamp ??= $d['timestamp'] ?? null;
        $this->metadata = $this->metadata ?: ($d['metadata'] ?? []);
        $this->href ??= $d['href'] ?? null;
        $this->actionLabel ??= $d['action_label'] ?? null;
        $this->actionHref ??= $d['action_href'] ?? null;
        $this->highlighted ??= $d['highlighted'] ?? false;
        $this->unread ??= $d['unread'] ?? false;
        $this->type ??= $d['type'] ?? null;

        
        // Initialize controller with default
        $this->initializeController();
    }

    protected function getComponentName(): string
    {
        return 'activity_feed_item';
    }

    public function options(): array
    {
        $classes = $this->buildClasses(
            ['activity-feed-item', 'd-flex', 'gap-3', 'py-3'],
            $this->highlighted ? ['bg-light'] : [],
            $this->unread ? ['activity-feed-item-unread'] : [],
            $this->href ? ['activity-feed-item-link'] : [],
            $this->class ? explode(' ', trim($this->class)) : []
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

