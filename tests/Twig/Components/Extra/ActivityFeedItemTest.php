<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\ActivityFeedItem;
use PHPUnit\Framework\TestCase;

final class ActivityFeedItemTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'activity_feed_item' => [
                'icon' => null,
                'avatar' => null,
                'icon_variant' => 'primary',
                'title' => null,
                'description' => null,
                'timestamp' => null,
                'metadata' => [],
                'href' => null,
                'action_label' => null,
                'action_href' => null,
                'highlighted' => false,
                'unread' => false,
                'type' => null,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new ActivityFeedItem($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('activity-feed-item', $options['classes']);
        $this->assertStringContainsString('d-flex', $options['classes']);
        $this->assertStringContainsString('gap-3', $options['classes']);
        $this->assertStringContainsString('py-3', $options['classes']);
        $this->assertNull($options['icon']);
        $this->assertNull($options['avatar']);
        $this->assertSame('primary', $options['iconVariant']);
        $this->assertFalse($options['highlighted']);
        $this->assertFalse($options['unread']);
    }

    public function testWithIcon(): void
    {
        $component = new ActivityFeedItem($this->config);
        $component->icon = 'bi-person-plus';
        $component->mount();
        $options = $component->options();

        $this->assertSame('bi-person-plus', $options['icon']);
    }

    public function testWithAvatar(): void
    {
        $component = new ActivityFeedItem($this->config);
        $component->avatar = '/path/to/avatar.jpg';
        $component->mount();
        $options = $component->options();

        $this->assertSame('/path/to/avatar.jpg', $options['avatar']);
    }

    public function testIconVariant(): void
    {
        $component = new ActivityFeedItem($this->config);
        $component->iconVariant = 'success';
        $component->mount();
        $options = $component->options();

        $this->assertSame('success', $options['iconVariant']);
    }

    public function testWithTitle(): void
    {
        $component = new ActivityFeedItem($this->config);
        $component->title = 'New team member';
        $component->mount();
        $options = $component->options();

        $this->assertSame('New team member', $options['title']);
    }

    public function testWithDescription(): void
    {
        $component = new ActivityFeedItem($this->config);
        $component->description = 'John Doe joined the team';
        $component->mount();
        $options = $component->options();

        $this->assertSame('John Doe joined the team', $options['description']);
    }

    public function testWithTimestamp(): void
    {
        $component = new ActivityFeedItem($this->config);
        $component->timestamp = '2 hours ago';
        $component->mount();
        $options = $component->options();

        $this->assertSame('2 hours ago', $options['timestamp']);
    }

    public function testWithMetadata(): void
    {
        $component = new ActivityFeedItem($this->config);
        $component->metadata = ['Location: New York', 'Role: Developer'];
        $component->mount();
        $options = $component->options();

        $this->assertSame(['Location: New York', 'Role: Developer'], $options['metadata']);
    }

    public function testWithHref(): void
    {
        $component = new ActivityFeedItem($this->config);
        $component->href = '/activity/123';
        $component->mount();
        $options = $component->options();

        $this->assertSame('/activity/123', $options['href']);
        $this->assertStringContainsString('activity-feed-item-link', $options['classes']);
    }

    public function testWithActionButton(): void
    {
        $component = new ActivityFeedItem($this->config);
        $component->actionLabel = 'View Details';
        $component->actionHref = '/details/123';
        $component->mount();
        $options = $component->options();

        $this->assertSame('View Details', $options['actionLabel']);
        $this->assertSame('/details/123', $options['actionHref']);
    }

    public function testHighlighted(): void
    {
        $component = new ActivityFeedItem($this->config);
        $component->highlighted = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['highlighted']);
        $this->assertStringContainsString('bg-light', $options['classes']);
    }

    public function testUnread(): void
    {
        $component = new ActivityFeedItem($this->config);
        $component->unread = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['unread']);
        $this->assertStringContainsString('activity-feed-item-unread', $options['classes']);
    }

    public function testType(): void
    {
        $component = new ActivityFeedItem($this->config);
        $component->type = 'warning';
        $component->mount();
        $options = $component->options();

        $this->assertSame('warning', $options['type']);
    }

    public function testCustomClasses(): void
    {
        $component = new ActivityFeedItem($this->config);
        $component->class = 'custom-item special-item';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-item', $options['classes']);
        $this->assertStringContainsString('special-item', $options['classes']);
        $this->assertStringContainsString('activity-feed-item', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new ActivityFeedItem($this->config);
        $component->attr = [
            'data-id' => '123',
            'data-type' => 'post',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-id', $options['attrs']);
        $this->assertSame('123', $options['attrs']['data-id']);
        $this->assertSame('post', $options['attrs']['data-type']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'activity_feed_item' => [
                'icon' => 'bi-bell',
                'avatar' => null,
                'icon_variant' => 'warning',
                'title' => null,
                'description' => null,
                'timestamp' => null,
                'metadata' => [],
                'href' => null,
                'action_label' => null,
                'action_href' => null,
                'highlighted' => true,
                'unread' => false,
                'type' => null,
                'class' => 'config-item',
                'attr' => [],
            ],
        ]);

        $component = new ActivityFeedItem($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('bi-bell', $component->icon);
        $this->assertSame('warning', $component->iconVariant);
        $this->assertTrue($component->highlighted);
        $this->assertStringContainsString('config-item', $options['classes']);
    }

    public function testComponentNameMethod(): void
    {
        $component = new ActivityFeedItem($this->config);
        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('activity_feed_item', $method->invoke($component));
    }

    public function testCombinedOptions(): void
    {
        $component = new ActivityFeedItem($this->config);
        $component->icon = 'bi-check-circle';
        $component->iconVariant = 'success';
        $component->title = 'Task completed';
        $component->description = 'You completed the onboarding process';
        $component->timestamp = '5 minutes ago';
        $component->metadata = ['Category: Onboarding', 'Progress: 100%'];
        $component->href = '/tasks/456';
        $component->actionLabel = 'View Task';
        $component->actionHref = '/tasks/456/details';
        $component->highlighted = true;
        $component->unread = true;
        $component->type = 'success';
        $component->class = 'important-item';
        $component->mount();
        $options = $component->options();

        $this->assertSame('bi-check-circle', $options['icon']);
        $this->assertSame('success', $options['iconVariant']);
        $this->assertSame('Task completed', $options['title']);
        $this->assertSame('You completed the onboarding process', $options['description']);
        $this->assertSame('5 minutes ago', $options['timestamp']);
        $this->assertCount(2, $options['metadata']);
        $this->assertSame('/tasks/456', $options['href']);
        $this->assertSame('View Task', $options['actionLabel']);
        $this->assertSame('/tasks/456/details', $options['actionHref']);
        $this->assertTrue($options['highlighted']);
        $this->assertTrue($options['unread']);
        $this->assertSame('success', $options['type']);
        $this->assertStringContainsString('important-item', $options['classes']);
        $this->assertStringContainsString('bg-light', $options['classes']);
        $this->assertStringContainsString('activity-feed-item-unread', $options['classes']);
        $this->assertStringContainsString('activity-feed-item-link', $options['classes']);
    }
}

