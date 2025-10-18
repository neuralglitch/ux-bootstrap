<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Badge;
use PHPUnit\Framework\TestCase;

final class BadgeTest extends TestCase
{
    /** @param array<string, mixed> $config */
    private function createConfig(array $config = []): Config
    {
        return new Config(['badge' => $config]);
    }

    private function createBadge(?Config $config = null): Badge
    {
        return new Badge($config ?? $this->createConfig());
    }

    public function testComponentHasCorrectDefaults(): void
    {
        $badge = $this->createBadge();

        self::assertNull($badge->label);
        self::assertNull($badge->href);
        self::assertNull($badge->target);
        self::assertNull($badge->rel);
        self::assertNull($badge->title);
        self::assertNull($badge->id);
        self::assertNull($badge->text);
        self::assertFalse($badge->pill);
        self::assertFalse($badge->positioned);
        self::assertNull($badge->position);
        self::assertTrue($badge->translate);
        self::assertNull($badge->variant);
        self::assertFalse($badge->outline);
        self::assertSame('', $badge->class);
        self::assertSame([], $badge->attr);
    }

    public function testMountAppliesConfigDefaults(): void
    {
        $config = $this->createConfig([
            'variant' => 'primary',
            'pill' => true,
            'href' => '/test',
            'target' => '_blank',
            'rel' => 'noopener',
            'title' => 'Test Title',
            'id' => 'test-badge',
            'text' => 'white',
            'positioned' => true,
            'position' => 'top-0 start-100',
            'translate' => false,
        ]);

        $badge = $this->createBadge($config);
        $badge->mount();

        self::assertSame('primary', $badge->variant);
        self::assertTrue($badge->pill);
        self::assertSame('/test', $badge->href);
        self::assertSame('_blank', $badge->target);
        self::assertSame('noopener', $badge->rel);
        self::assertSame('Test Title', $badge->title);
        self::assertSame('test-badge', $badge->id);
        self::assertSame('white', $badge->text);
        self::assertTrue($badge->positioned);
        self::assertSame('top-0 start-100', $badge->position);
        self::assertFalse($badge->translate);
    }

    public function testMountRespectsPropertyOverrides(): void
    {
        $config = $this->createConfig([
            'variant' => 'danger',
            'pill' => true,
        ]);

        $badge = $this->createBadge($config);
        $badge->variant = 'success';
        $badge->pill = false;
        $badge->mount();

        self::assertSame('success', $badge->variant);
        self::assertTrue($badge->pill); // OR logic
    }

    public function testGetComponentName(): void
    {
        $badge = $this->createBadge();

        $reflection = new \ReflectionClass($badge);
        $method = $reflection->getMethod('getComponentName');
        $method->setAccessible(true);

        self::assertSame('badge', $method->invoke($badge));
    }

    public function testOptionsReturnsCorrectStructure(): void
    {
        $badge = $this->createBadge();
        $badge->label = 'Test';
        $badge->mount();

        $options = $badge->options();

        self::assertIsArray($options);
        self::assertArrayHasKey('tag', $options);
        self::assertArrayHasKey('href', $options);
        self::assertArrayHasKey('label', $options);
        self::assertArrayHasKey('classes', $options);
        self::assertArrayHasKey('attrs', $options);
    }

    public function testOptionsTagIsSpanByDefault(): void
    {
        $badge = $this->createBadge();
        $badge->mount();

        $options = $badge->options();

        self::assertSame('span', $options['tag']);
        self::assertNull($options['href']);
    }

    public function testOptionsTagIsAnchorWhenHrefProvided(): void
    {
        $badge = $this->createBadge();
        $badge->href = '/link';
        $badge->mount();

        $options = $badge->options();

        self::assertSame('a', $options['tag']);
        self::assertSame('/link', $options['href']);
    }

    public function testOptionsBuildsCorrectClasses(): void
    {
        $config = $this->createConfig(['variant' => 'primary']);
        $badge = $this->createBadge($config);
        $badge->mount();

        $options = $badge->options();

        self::assertStringContainsString('badge', $options['classes']);
        self::assertStringContainsString('text-bg-primary', $options['classes']);
    }

    public function testOptionsWithPill(): void
    {
        $badge = $this->createBadge();
        $badge->pill = true;
        $badge->mount();

        $options = $badge->options();

        self::assertStringContainsString('rounded-pill', $options['classes']);
    }

    public function testOptionsWithTextColor(): void
    {
        $badge = $this->createBadge();
        $badge->text = 'white';
        $badge->mount();

        $options = $badge->options();

        self::assertStringContainsString('text-white', $options['classes']);
    }

    public function testOptionsWithPositioned(): void
    {
        $badge = $this->createBadge();
        $badge->positioned = true;
        $badge->mount();

        $options = $badge->options();

        self::assertStringContainsString('position-absolute', $options['classes']);
        self::assertStringContainsString('translate-middle', $options['classes']);
    }

    public function testOptionsWithPositionedAndCustomPosition(): void
    {
        $badge = $this->createBadge();
        $badge->positioned = true;
        $badge->position = 'top-0 start-100';
        $badge->mount();

        $options = $badge->options();

        self::assertStringContainsString('position-absolute', $options['classes']);
        self::assertStringContainsString('top-0', $options['classes']);
        self::assertStringContainsString('start-100', $options['classes']);
        self::assertStringContainsString('translate-middle', $options['classes']);
    }

    public function testOptionsWithPositionedButNoTranslate(): void
    {
        $badge = $this->createBadge();
        $badge->positioned = true;
        $badge->translate = false;
        $badge->mount();

        $options = $badge->options();

        self::assertStringContainsString('position-absolute', $options['classes']);
        self::assertStringNotContainsString('translate-middle', $options['classes']);
    }

    public function testOptionsIncludesCustomClass(): void
    {
        $badge = $this->createBadge();
        $badge->class = 'my-custom-class another-class';
        $badge->mount();

        $options = $badge->options();

        self::assertStringContainsString('my-custom-class', $options['classes']);
        self::assertStringContainsString('another-class', $options['classes']);
    }

    public function testOptionsIncludesIdAttribute(): void
    {
        $badge = $this->createBadge();
        $badge->id = 'my-badge';
        $badge->mount();

        $options = $badge->options();

        self::assertArrayHasKey('id', $options['attrs']);
        self::assertSame('my-badge', $options['attrs']['id']);
    }

    public function testOptionsIncludesTitleAttribute(): void
    {
        $badge = $this->createBadge();
        $badge->title = 'Tooltip text';
        $badge->mount();

        $options = $badge->options();

        self::assertArrayHasKey('title', $options['attrs']);
        self::assertSame('Tooltip text', $options['attrs']['title']);
    }

    public function testOptionsIncludesLinkAttributes(): void
    {
        $badge = $this->createBadge();
        $badge->href = '/link';
        $badge->target = '_blank';
        $badge->rel = 'noopener noreferrer';
        $badge->mount();

        $options = $badge->options();

        self::assertArrayHasKey('target', $options['attrs']);
        self::assertSame('_blank', $options['attrs']['target']);
        self::assertArrayHasKey('rel', $options['attrs']);
        self::assertSame('noopener noreferrer', $options['attrs']['rel']);
    }

    public function testOptionsDoesNotIncludeLinkAttributesWhenNotLink(): void
    {
        $badge = $this->createBadge();
        $badge->target = '_blank';
        $badge->rel = 'noopener';
        $badge->mount();

        $options = $badge->options();

        self::assertArrayNotHasKey('target', $options['attrs']);
        self::assertArrayNotHasKey('rel', $options['attrs']);
    }

    public function testOptionsMergesCustomAttributes(): void
    {
        $badge = $this->createBadge();
        $badge->attr = [
            'data-test' => 'value',
            'aria-label' => 'Badge label',
        ];
        $badge->mount();

        $options = $badge->options();

        self::assertArrayHasKey('data-test', $options['attrs']);
        self::assertSame('value', $options['attrs']['data-test']);
        self::assertArrayHasKey('aria-label', $options['attrs']);
        self::assertSame('Badge label', $options['attrs']['aria-label']);
    }

    public function testVariantClassesForDifferentVariants(): void
    {
        $variants = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'];

        foreach ($variants as $variant) {
            $config = $this->createConfig(['variant' => $variant]);
            $badge = $this->createBadge($config);
            $badge->mount();

            $options = $badge->options();

            self::assertStringContainsString("text-bg-{$variant}", $options['classes']);
        }
    }

    public function testBadgeWithAllFeaturesEnabled(): void
    {
        $config = $this->createConfig([
            'variant' => 'danger',
            'pill' => true,
            'text' => 'white',
            'positioned' => true,
            'position' => 'top-0 end-0',
        ]);

        $badge = $this->createBadge($config);
        $badge->label = 'New';
        $badge->href = '/notifications';
        $badge->target = '_blank';
        $badge->class = 'custom-badge';
        $badge->attr = ['data-count' => '5'];
        $badge->mount();

        $options = $badge->options();

        self::assertSame('New', $options['label']);
        self::assertSame('a', $options['tag']);
        self::assertSame('/notifications', $options['href']);
        self::assertStringContainsString('badge', $options['classes']);
        self::assertStringContainsString('text-bg-danger', $options['classes']);
        self::assertStringContainsString('rounded-pill', $options['classes']);
        self::assertStringContainsString('text-white', $options['classes']);
        self::assertStringContainsString('position-absolute', $options['classes']);
        self::assertStringContainsString('top-0', $options['classes']);
        self::assertStringContainsString('end-0', $options['classes']);
        self::assertStringContainsString('custom-badge', $options['classes']);
        self::assertArrayHasKey('target', $options['attrs']);
        self::assertArrayHasKey('data-count', $options['attrs']);
    }

    public function testEmptyConfigUsesAllDefaults(): void
    {
        $badge = $this->createBadge($this->createConfig([]));
        $badge->mount();

        self::assertNull($badge->variant);
        self::assertFalse($badge->pill);
        self::assertNull($badge->href);
        self::assertFalse($badge->positioned);
        self::assertTrue($badge->translate);
    }
}

