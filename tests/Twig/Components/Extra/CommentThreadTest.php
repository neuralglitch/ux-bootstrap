<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\CommentThread;
use PHPUnit\Framework\TestCase;

final class CommentThreadTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'comment_thread' => [
                'max_depth' => 3,
                'show_reply' => true,
                'show_edit' => true,
                'show_delete' => true,
                'show_like' => true,
                'date_format' => 'relative',
                'avatar_size' => 'md',
                'highlight_author' => false,
                'compact' => false,
                'show_thread_lines' => true,
                'collapsible' => true,
                'default_collapsed' => false,
                'container_class' => null,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new CommentThread($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('comment-thread', $options['classes']);
        $this->assertSame(3, $options['maxDepth']);
        $this->assertTrue($options['showReply']);
        $this->assertTrue($options['showEdit']);
        $this->assertTrue($options['showDelete']);
        $this->assertTrue($options['showLike']);
        $this->assertSame('relative', $options['dateFormat']);
        $this->assertSame('md', $options['avatarSize']);
        $this->assertFalse($options['highlightAuthor']);
        $this->assertTrue($options['showThreadLines']);
        $this->assertTrue($options['collapsible']);
        $this->assertFalse($options['defaultCollapsed']);
    }

    public function testMaxDepthOption(): void
    {
        $component = new CommentThread($this->config);
        $component->maxDepth = 5;
        $component->mount();
        $options = $component->options();

        $this->assertSame(5, $options['maxDepth']);
    }

    public function testUnlimitedDepth(): void
    {
        $component = new CommentThread($this->config);
        $component->maxDepth = 0;
        $component->mount();

        $this->assertTrue($component->canReply(10));
        $this->assertTrue($component->canReply(100));
    }

    public function testCanReplyWithinLimit(): void
    {
        $component = new CommentThread($this->config);
        $component->maxDepth = 3;
        $component->mount();

        $this->assertTrue($component->canReply(0));
        $this->assertTrue($component->canReply(1));
        $this->assertTrue($component->canReply(2));
        $this->assertFalse($component->canReply(3));
        $this->assertFalse($component->canReply(4));
    }

    public function testShowReplyOption(): void
    {
        $component = new CommentThread($this->config);
        $component->showReply = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['showReply']);
    }

    public function testShowEditOption(): void
    {
        $component = new CommentThread($this->config);
        $component->showEdit = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['showEdit']);
    }

    public function testShowDeleteOption(): void
    {
        $component = new CommentThread($this->config);
        $component->showDelete = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['showDelete']);
    }

    public function testShowLikeOption(): void
    {
        $component = new CommentThread($this->config);
        $component->showLike = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['showLike']);
    }

    public function testDateFormatRelative(): void
    {
        $component = new CommentThread($this->config);
        $component->dateFormat = 'relative';
        $component->mount();

        $timestamp = new \DateTime('-2 hours');
        $formatted = $component->formatDate($timestamp);

        $this->assertStringContainsString('hour', $formatted);
        $this->assertStringContainsString('ago', $formatted);
    }

    public function testDateFormatAbsolute(): void
    {
        $component = new CommentThread($this->config);
        $component->dateFormat = 'absolute';
        $component->mount();

        $timestamp = new \DateTime('2024-01-15 14:30:00');
        $formatted = $component->formatDate($timestamp);

        $this->assertStringContainsString('Jan', $formatted);
        $this->assertStringContainsString('2024', $formatted);
    }

    public function testDateFormatBoth(): void
    {
        $component = new CommentThread($this->config);
        $component->dateFormat = 'both';
        $component->mount();

        $timestamp = new \DateTime('-2 hours');
        $formatted = $component->formatDate($timestamp);

        $this->assertStringContainsString('ago', $formatted);
        $this->assertStringContainsString('(', $formatted);
        $this->assertStringContainsString(')', $formatted);
    }

    public function testFormatDateWithStringTimestamp(): void
    {
        $component = new CommentThread($this->config);
        $component->mount();

        $formatted = $component->formatDate('2024-01-15 14:30:00');

        $this->assertIsString($formatted);
        $this->assertNotEmpty($formatted);
    }

    public function testAvatarSizeOption(): void
    {
        $component = new CommentThread($this->config);
        $component->avatarSize = 'lg';
        $component->mount();
        $options = $component->options();

        $this->assertSame('lg', $options['avatarSize']);
    }

    public function testGetAvatarSizeClassSmall(): void
    {
        $component = new CommentThread($this->config);
        $component->avatarSize = 'sm';
        $component->mount();

        $this->assertSame('avatar-sm', $component->getAvatarSizeClass());
    }

    public function testGetAvatarSizeClassMedium(): void
    {
        $component = new CommentThread($this->config);
        $component->avatarSize = 'md';
        $component->mount();

        $this->assertSame('avatar-md', $component->getAvatarSizeClass());
    }

    public function testGetAvatarSizeClassLarge(): void
    {
        $component = new CommentThread($this->config);
        $component->avatarSize = 'lg';
        $component->mount();

        $this->assertSame('avatar-lg', $component->getAvatarSizeClass());
    }

    public function testGetAvatarSizeClassExtraLarge(): void
    {
        $component = new CommentThread($this->config);
        $component->avatarSize = 'xl';
        $component->mount();

        $this->assertSame('avatar-xl', $component->getAvatarSizeClass());
    }

    public function testHighlightAuthorOption(): void
    {
        $component = new CommentThread($this->config);
        $component->highlightAuthor = true;
        $component->authorUsername = 'john_doe';
        $component->mount();

        $comment = ['username' => 'john_doe'];
        $this->assertTrue($component->isAuthor($comment));
    }

    public function testIsAuthorWithMatchingUsername(): void
    {
        $component = new CommentThread($this->config);
        $component->highlightAuthor = true;
        $component->authorUsername = 'author123';
        $component->mount();

        $this->assertTrue($component->isAuthor(['username' => 'author123']));
        $this->assertFalse($component->isAuthor(['username' => 'other_user']));
    }

    public function testIsAuthorWithMatchingAuthorField(): void
    {
        $component = new CommentThread($this->config);
        $component->highlightAuthor = true;
        $component->authorUsername = 'author123';
        $component->mount();

        $this->assertTrue($component->isAuthor(['author' => 'author123']));
        $this->assertFalse($component->isAuthor(['author' => 'other_user']));
    }

    public function testIsAuthorWhenDisabled(): void
    {
        $component = new CommentThread($this->config);
        $component->highlightAuthor = false;
        $component->authorUsername = 'author123';
        $component->mount();

        $this->assertFalse($component->isAuthor(['username' => 'author123']));
    }

    public function testCompactMode(): void
    {
        $component = new CommentThread($this->config);
        $component->compact = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('comment-thread-compact', $options['classes']);
    }

    public function testShowThreadLines(): void
    {
        $component = new CommentThread($this->config);
        $component->showThreadLines = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('comment-thread-lines', $options['classes']);
    }

    public function testHideThreadLines(): void
    {
        $component = new CommentThread($this->config);
        $component->showThreadLines = false;
        $component->mount();
        $options = $component->options();

        $this->assertStringNotContainsString('comment-thread-lines', $options['classes']);
    }

    public function testCollapsibleOption(): void
    {
        $component = new CommentThread($this->config);
        $component->collapsible = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('comment-thread-collapsible', $options['classes']);
        $this->assertTrue($options['collapsible']);
    }

    public function testDefaultCollapsedOption(): void
    {
        $component = new CommentThread($this->config);
        $component->defaultCollapsed = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['defaultCollapsed']);
    }

    public function testCommentsArray(): void
    {
        $comments = [
            [
                'id' => 1,
                'author' => 'John Doe',
                'content' => 'Great post!',
                'timestamp' => '2024-01-15 10:00:00',
            ],
        ];

        $component = new CommentThread($this->config);
        $component->comments = $comments;
        $component->mount();
        $options = $component->options();

        $this->assertSame($comments, $options['comments']);
    }

    public function testNestedCommentsStructure(): void
    {
        $comments = [
            [
                'id' => 1,
                'author' => 'John Doe',
                'content' => 'Parent comment',
                'replies' => [
                    [
                        'id' => 2,
                        'author' => 'Jane Smith',
                        'content' => 'Reply to parent',
                    ],
                ],
            ],
        ];

        $component = new CommentThread($this->config);
        $component->comments = $comments;
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('replies', $options['comments'][0]);
        $this->assertCount(1, $options['comments'][0]['replies']);
    }

    public function testContainerClassOption(): void
    {
        $component = new CommentThread($this->config);
        $component->containerClass = 'custom-container';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-container', $options['classes']);
    }

    public function testCustomClasses(): void
    {
        $component = new CommentThread($this->config);
        $component->class = 'custom-class another-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-class', $options['classes']);
        $this->assertStringContainsString('another-class', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new CommentThread($this->config);
        $component->attr = [
            'data-test' => 'value',
            'aria-label' => 'Comment Thread',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('value', $options['attrs']['data-test']);
        $this->assertArrayHasKey('aria-label', $options['attrs']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'comment_thread' => [
                'max_depth' => 5,
                'date_format' => 'absolute',
                'avatar_size' => 'lg',
                'compact' => true,
                'class' => 'default-class',
            ],
        ]);

        $component = new CommentThread($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame(5, $component->maxDepth);
        $this->assertSame('absolute', $component->dateFormat);
        $this->assertSame('lg', $component->avatarSize);
        $this->assertTrue($component->compact);
        $this->assertStringContainsString('default-class', $options['classes']);
    }

    public function testGetComponentName(): void
    {
        $component = new CommentThread($this->config);
        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('comment_thread', $method->invoke($component));
    }

    public function testRelativeTimeFormatJustNow(): void
    {
        $component = new CommentThread($this->config);
        $component->dateFormat = 'relative';
        $component->mount();

        $timestamp = new \DateTime('now');
        $formatted = $component->formatDate($timestamp);

        $this->assertSame('just now', $formatted);
    }

    public function testRelativeTimeFormatMinutes(): void
    {
        $component = new CommentThread($this->config);
        $component->dateFormat = 'relative';
        $component->mount();

        $timestamp = new \DateTime('-15 minutes');
        $formatted = $component->formatDate($timestamp);

        $this->assertStringContainsString('minute', $formatted);
        $this->assertStringContainsString('ago', $formatted);
    }

    public function testRelativeTimeFormatDays(): void
    {
        $component = new CommentThread($this->config);
        $component->dateFormat = 'relative';
        $component->mount();

        $timestamp = new \DateTime('-3 days');
        $formatted = $component->formatDate($timestamp);

        $this->assertStringContainsString('day', $formatted);
        $this->assertStringContainsString('ago', $formatted);
    }

    public function testRelativeTimeFormatYears(): void
    {
        $component = new CommentThread($this->config);
        $component->dateFormat = 'relative';
        $component->mount();

        $timestamp = new \DateTime('-2 years');
        $formatted = $component->formatDate($timestamp);

        $this->assertStringContainsString('year', $formatted);
        $this->assertStringContainsString('ago', $formatted);
    }

    public function testCombinedOptions(): void
    {
        $component = new CommentThread($this->config);
        $component->compact = true;
        $component->showThreadLines = true;
        $component->collapsible = true;
        $component->highlightAuthor = true;
        $component->authorUsername = 'admin';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('comment-thread-compact', $options['classes']);
        $this->assertStringContainsString('comment-thread-lines', $options['classes']);
        $this->assertStringContainsString('comment-thread-collapsible', $options['classes']);
        $this->assertTrue($options['highlightAuthor']);
        $this->assertSame('admin', $options['authorUsername']);
    }
}

