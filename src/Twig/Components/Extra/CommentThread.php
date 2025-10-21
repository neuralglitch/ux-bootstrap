<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:comment-thread', template: '@NeuralGlitchUxBootstrap/components/extra/comment-thread.html.twig')]
final class CommentThread extends AbstractStimulus
{
    /**
     * Array of comment data structures
     * Each comment should have: id, author, content, timestamp, avatar, replies (nested array)
     *
     * @var array<int, array<string, mixed>>
     */
    public array $comments = [];

    /**
     * Maximum nesting depth for replies (0 = unlimited)
     */
    public ?int $maxDepth = null;

    /**
     * Show reply button
     */
    public ?bool $showReply = null;

    /**
     * Show edit button
     */
    public ?bool $showEdit = null;

    /**
     * Show delete button
     */
    public ?bool $showDelete = null;

    /**
     * Show like/upvote button
     */
    public ?bool $showLike = null;

    /**
     * Date format for timestamps
     */
    public ?string $dateFormat = null;  // 'relative' | 'absolute' | 'both'

    /**
     * Avatar size (sm, md, lg)
     */
    public ?string $avatarSize = null;

    /**
     * Highlight author comments
     */
    public ?bool $highlightAuthor = null;

    /**
     * Author username/id to highlight
     */
    public ?string $authorUsername = null;

    /**
     * Compact mode (reduced spacing)
     */
    public ?bool $compact = null;

    /**
     * Show thread lines connecting replies
     */
    public ?bool $showThreadLines = null;

    /**
     * Enable collapsible threads
     */
    public ?bool $collapsible = null;

    /**
     * Default collapsed state for threads
     */
    public ?bool $defaultCollapsed = null;

    /**
     * CSS class for the container
     */
    public ?string $containerClass = null;

    /**
     * Custom action buttons template block
     */
    public ?string $actionsTemplate = null;

    public function mount(): void
    {
        $d = $this->config->for('comment_thread');

        $this->applyStimulusDefaults($d);

        $this->applyClassDefaults($d);

        $this->maxDepth ??= $d['max_depth'] ?? 3;
        $this->showReply ??= $d['show_reply'] ?? true;
        $this->showEdit ??= $d['show_edit'] ?? true;
        $this->showDelete ??= $d['show_delete'] ?? true;
        $this->showLike ??= $d['show_like'] ?? true;
        $this->dateFormat ??= $d['date_format'] ?? 'relative';
        $this->avatarSize ??= $d['avatar_size'] ?? 'md';
        $this->highlightAuthor ??= $d['highlight_author'] ?? false;
        $this->compact ??= $d['compact'] ?? false;
        $this->showThreadLines ??= $d['show_thread_lines'] ?? true;
        $this->collapsible ??= $d['collapsible'] ?? true;
        $this->defaultCollapsed ??= $d['default_collapsed'] ?? false;
        $this->containerClass ??= $d['container_class'] ?? null;

        
        // Initialize controller with default
        $this->initializeController();
    }

    protected function getComponentName(): string
    {
        return 'comment_thread';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $compact = $this->compact ?? false;
        $showThreadLines = $this->showThreadLines ?? true;
        $collapsible = $this->collapsible ?? true;
        
        $classes = $this->buildClasses(
            ['comment-thread'],
            $compact ? ['comment-thread-compact'] : [],
            $showThreadLines ? ['comment-thread-lines'] : [],
            $collapsible ? ['comment-thread-collapsible'] : [],
            $this->containerClass ? explode(' ', trim($this->containerClass)) : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = $this->mergeAttributes([], $this->attr);

        return [
            'classes' => $classes,
            'attrs' => $attrs,
            'comments' => $this->comments,
            'maxDepth' => $this->maxDepth ?? 3,
            'showReply' => $this->showReply ?? true,
            'showEdit' => $this->showEdit ?? true,
            'showDelete' => $this->showDelete ?? true,
            'showLike' => $this->showLike ?? true,
            'dateFormat' => $this->dateFormat ?? 'relative',
            'avatarSize' => $this->avatarSize ?? 'md',
            'highlightAuthor' => $this->highlightAuthor ?? false,
            'authorUsername' => $this->authorUsername,
            'showThreadLines' => $showThreadLines,
            'collapsible' => $collapsible,
            'defaultCollapsed' => $this->defaultCollapsed ?? false,
        ];
    }

    /**
     * Format timestamp based on date format setting
     */
    public function formatDate(string|\DateTimeInterface $timestamp): string
    {
        if (is_string($timestamp)) {
            $date = new \DateTime($timestamp);
        } else {
            $date = $timestamp;
        }

        $now = new \DateTime();
        $diff = $now->diff($date);

        if ($this->dateFormat === 'relative') {
            return $this->getRelativeTime($diff);
        }

        if ($this->dateFormat === 'absolute') {
            return $date->format('M j, Y g:i A');
        }

        // both
        return $this->getRelativeTime($diff) . ' (' . $date->format('M j, Y') . ')';
    }

    /**
     * Get relative time string
     */
    private function getRelativeTime(\DateInterval $diff): string
    {
        if ($diff->y > 0) {
            return $diff->y . ' year' . ($diff->y > 1 ? 's' : '') . ' ago';
        }
        if ($diff->m > 0) {
            return $diff->m . ' month' . ($diff->m > 1 ? 's' : '') . ' ago';
        }
        if ($diff->d > 0) {
            return $diff->d . ' day' . ($diff->d > 1 ? 's' : '') . ' ago';
        }
        if ($diff->h > 0) {
            return $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' ago';
        }
        if ($diff->i > 0) {
            return $diff->i . ' minute' . ($diff->i > 1 ? 's' : '') . ' ago';
        }
        return 'just now';
    }

    /**
     * Check if comment author should be highlighted
     * 
     * @param array<string, mixed> $comment
     */
    public function isAuthor(array $comment): bool
    {
        if (($this->highlightAuthor ?? false) === false || !$this->authorUsername) {
            return false;
        }

        return ($comment['username'] ?? $comment['author'] ?? '') === $this->authorUsername;
    }

    /**
     * Check if depth limit is reached
     */
    public function canReply(int $currentDepth): bool
    {
        $maxDepth = $this->maxDepth ?? 3;
        
        if ($maxDepth === 0) {
            return true; // unlimited
        }

        return $currentDepth < $maxDepth;
    }

    /**
     * Get avatar size class
     */
    public function getAvatarSizeClass(): string
    {
        $size = $this->avatarSize ?? 'md';
        
        return match ($size) {
            'sm' => 'avatar-sm',
            'lg' => 'avatar-lg',
            'xl' => 'avatar-xl',
            default => 'avatar-md',
        };
    }
}

