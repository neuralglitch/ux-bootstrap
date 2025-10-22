<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\ActivityFeed;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class ActivityFeedTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'activity-feed' => [
                'mode' => 'default',
                'show_timestamps' => true,
                'show_icons' => true,
                'border' => 'start',
                'group_by_date' => false,
                'max_height' => null,
                'tag' => 'div',
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new ActivityFeed($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('activity-feed', $options['classes']);
        $this->assertStringContainsString('border-start', $options['classes']);
        $this->assertStringContainsString('border-3', $options['classes']);
        $this->assertSame('div', $options['tag']);
        $this->assertTrue($options['showTimestamps']);
        $this->assertTrue($options['showIcons']);
        $this->assertFalse($options['groupByDate']);
        $this->assertSame('default', $options['mode']);
    }

    public function testCompactMode(): void
    {
        $component = new ActivityFeed($this->config);
        $component->mode = 'compact';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('activity-feed-compact', $options['classes']);
        $this->assertSame('compact', $options['mode']);
    }

    public function testNoBorder(): void
    {
        $config = new Config([
            'activity-feed' => [
                'border' => null,
            ],
        ]);

        $component = new ActivityFeed($config);
        $component->mount();
        $options = $component->options();

        $this->assertStringNotContainsString('border-start', $options['classes']);
        $this->assertStringNotContainsString('border-end', $options['classes']);
    }

    public function testBorderEnd(): void
    {
        $component = new ActivityFeed($this->config);
        $component->border = 'end';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('border-end', $options['classes']);
        $this->assertStringContainsString('border-3', $options['classes']);
        $this->assertStringNotContainsString('border-start', $options['classes']);
    }

    public function testShowTimestampsFalse(): void
    {
        $component = new ActivityFeed($this->config);
        $component->showTimestamps = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['showTimestamps']);
    }

    public function testShowIconsFalse(): void
    {
        $component = new ActivityFeed($this->config);
        $component->showIcons = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['showIcons']);
    }

    public function testGroupByDate(): void
    {
        $component = new ActivityFeed($this->config);
        $component->groupByDate = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['groupByDate']);
    }

    public function testMaxHeight(): void
    {
        $component = new ActivityFeed($this->config);
        $component->maxHeight = '400px';
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('style', $options['attrs']);
        $this->assertStringContainsString('max-height: 400px', $options['attrs']['style']);
        $this->assertStringContainsString('overflow-y: auto', $options['attrs']['style']);
    }

    public function testCustomTag(): void
    {
        $component = new ActivityFeed($this->config);
        $component->tag = 'section';
        $component->mount();
        $options = $component->options();

        $this->assertSame('section', $options['tag']);
    }

    public function testCustomClasses(): void
    {
        $component = new ActivityFeed($this->config);
        $component->class = 'custom-class another-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-class', $options['classes']);
        $this->assertStringContainsString('another-class', $options['classes']);
        $this->assertStringContainsString('activity-feed', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new ActivityFeed($this->config);
        $component->attr = [
            'data-testid' => 'activity-feed',
            'role' => 'feed',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-testid', $options['attrs']);
        $this->assertSame('activity-feed', $options['attrs']['data-testid']);
        $this->assertSame('feed', $options['attrs']['role']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'activity-feed' => [
                'mode' => 'compact',
                'show_timestamps' => false,
                'border' => 'end',
                'class' => 'config-class',
            ],
        ]);

        $component = new ActivityFeed($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('compact', $component->mode);
        $this->assertFalse($component->showTimestamps);
        $this->assertSame('end', $component->border);
        $this->assertStringContainsString('config-class', $options['classes']);
    }

    public function testComponentNameMethod(): void
    {
        $component = new ActivityFeed($this->config);
        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('activity-feed', $method->invoke($component));
    }

    public function testCombinedOptions(): void
    {
        $config = new Config([
            'activity-feed' => [
                'border' => null,
            ],
        ]);

        $component = new ActivityFeed($config);
        $component->mode = 'compact';
        $component->showTimestamps = false;
        $component->showIcons = false;
        $component->groupByDate = true;
        $component->maxHeight = '500px';
        $component->tag = 'article';
        $component->class = 'my-feed';
        $component->mount();
        $options = $component->options();

        $this->assertSame('compact', $options['mode']);
        $this->assertFalse($options['showTimestamps']);
        $this->assertFalse($options['showIcons']);
        $this->assertTrue($options['groupByDate']);
        $this->assertSame('article', $options['tag']);
        $this->assertStringContainsString('activity-feed-compact', $options['classes']);
        $this->assertStringContainsString('my-feed', $options['classes']);
        $this->assertStringNotContainsString('border-start', $options['classes']);
        $this->assertStringContainsString('max-height: 500px', $options['attrs']['style']);
    }
}

