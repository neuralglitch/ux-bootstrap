<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap\Traits;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\PopoverTrait;
use PHPUnit\Framework\TestCase;

final class PopoverTraitTest extends TestCase
{
    private function createTestClass(): object
    {
        return new class {
            use PopoverTrait;

            /**
             * @param array<string, mixed> $defaults
             */
            public function testApplyPopoverDefaults(array $defaults): void
            {
                $this->applyPopoverDefaults($defaults);
            }

            /**
             * @return array<string, mixed>
             */
            public function testPopoverAttributes(): array
            {
                return $this->popoverAttributes();
            }
        };
    }

    public function testPopoverTitleDefaultsToNull(): void
    {
        $obj = $this->createTestClass();

        self::assertNull($obj->popoverTitle);
    }

    public function testPopoverContentDefaultsToNull(): void
    {
        $obj = $this->createTestClass();

        self::assertNull($obj->popoverContent);
    }

    public function testApplyPopoverDefaultsWithEmptyDefaults(): void
    {
        $obj = $this->createTestClass();
        $obj->testApplyPopoverDefaults([]);

        self::assertNull($obj->popoverTitle);
        self::assertNull($obj->popoverContent);
    }

    public function testApplyPopoverDefaultsWithAllOptions(): void
    {
        $obj = $this->createTestClass();
        $obj->testApplyPopoverDefaults([
            'title' => 'Popover Title',
            'content' => 'Popover content',
            'placement' => 'right',
            'trigger' => 'click',
            'boundary' => 'viewport',
            'html' => true,
        ]);

        self::assertSame('Popover Title', $obj->popoverTitle);
        self::assertSame('Popover content', $obj->popoverContent);
        self::assertSame('right', $obj->popoverPlacement);
        self::assertSame('click', $obj->popoverTrigger);
        self::assertSame('viewport', $obj->popoverBoundary);
        self::assertTrue($obj->popoverHtml);
    }

    public function testPopoverAttributesReturnsEmptyWhenNoContent(): void
    {
        $obj = $this->createTestClass();
        $obj->popoverTitle = null;
        $obj->popoverContent = null;

        $attrs = $obj->testPopoverAttributes();

        self::assertSame([], $attrs);
    }

    public function testPopoverAttributesWithContentOnly(): void
    {
        $obj = $this->createTestClass();
        $obj->popoverContent = 'Popover content';

        $attrs = $obj->testPopoverAttributes();

        self::assertArrayHasKey('data-bs-toggle', $attrs);
        self::assertSame('popover', $attrs['data-bs-toggle']);
        self::assertArrayHasKey('data-bs-content', $attrs);
        self::assertSame('Popover content', $attrs['data-bs-content']);
    }

    public function testPopoverAttributesWithTitleOnly(): void
    {
        $obj = $this->createTestClass();
        $obj->popoverTitle = 'Popover Title';

        $attrs = $obj->testPopoverAttributes();

        self::assertArrayHasKey('data-bs-toggle', $attrs);
        self::assertSame('popover', $attrs['data-bs-toggle']);
        self::assertArrayHasKey('data-bs-title', $attrs);
        self::assertSame('Popover Title', $attrs['data-bs-title']);
    }

    public function testPopoverAttributesWithTitleAndContent(): void
    {
        $obj = $this->createTestClass();
        $obj->popoverTitle = 'Title';
        $obj->popoverContent = 'Content';

        $attrs = $obj->testPopoverAttributes();

        self::assertArrayHasKey('data-bs-title', $attrs);
        self::assertSame('Title', $attrs['data-bs-title']);
        self::assertArrayHasKey('data-bs-content', $attrs);
        self::assertSame('Content', $attrs['data-bs-content']);
    }

    public function testPopoverAttributesWithPlacement(): void
    {
        $obj = $this->createTestClass();
        $obj->popoverContent = 'Test';
        $obj->popoverPlacement = 'top';

        $attrs = $obj->testPopoverAttributes();

        self::assertArrayHasKey('data-bs-placement', $attrs);
        self::assertSame('top', $attrs['data-bs-placement']);
    }

    public function testPopoverAttributesWithTrigger(): void
    {
        $obj = $this->createTestClass();
        $obj->popoverContent = 'Test';
        $obj->popoverTrigger = 'focus';

        $attrs = $obj->testPopoverAttributes();

        self::assertArrayHasKey('data-bs-trigger', $attrs);
        self::assertSame('focus', $attrs['data-bs-trigger']);
    }

    public function testPopoverAttributesWithBoundary(): void
    {
        $obj = $this->createTestClass();
        $obj->popoverContent = 'Test';
        $obj->popoverBoundary = 'viewport';

        $attrs = $obj->testPopoverAttributes();

        self::assertArrayHasKey('data-bs-boundary', $attrs);
        self::assertSame('viewport', $attrs['data-bs-boundary']);
    }

    public function testPopoverAttributesAutoDetectsHtml(): void
    {
        $obj = $this->createTestClass();
        $obj->popoverContent = '<strong>HTML</strong> content';

        $attrs = $obj->testPopoverAttributes();

        self::assertArrayHasKey('data-bs-html', $attrs);
        self::assertSame('true', $attrs['data-bs-html']);
    }

    public function testPopoverAttributesWithPlainText(): void
    {
        $obj = $this->createTestClass();
        $obj->popoverContent = 'Plain text';

        $attrs = $obj->testPopoverAttributes();

        self::assertArrayHasKey('data-bs-html', $attrs);
        self::assertSame('false', $attrs['data-bs-html']);
    }

    public function testPopoverAttributesWithExplicitHtmlTrue(): void
    {
        $obj = $this->createTestClass();
        $obj->popoverContent = 'Plain text';
        $obj->popoverHtml = true;

        $attrs = $obj->testPopoverAttributes();

        self::assertSame('true', $attrs['data-bs-html']);
    }

    public function testPopoverAttributesWithExplicitHtmlFalse(): void
    {
        $obj = $this->createTestClass();
        $obj->popoverContent = '<strong>HTML</strong>';
        $obj->popoverHtml = false;

        $attrs = $obj->testPopoverAttributes();

        self::assertSame('false', $attrs['data-bs-html']); // Overrides auto-detection
    }

    public function testPopoverAttributesWithArrayInput(): void
    {
        $obj = $this->createTestClass();
        $obj->popover = [
            'title' => 'Popover Title',
            'content' => 'Popover content',
            'placement' => 'bottom',
            'trigger' => 'click',
            'boundary' => 'window',
            'html' => true,
        ];

        $attrs = $obj->testPopoverAttributes();

        self::assertArrayHasKey('data-bs-title', $attrs);
        self::assertSame('Popover Title', $attrs['data-bs-title']);
        self::assertArrayHasKey('data-bs-content', $attrs);
        self::assertSame('Popover content', $attrs['data-bs-content']);
        self::assertSame('bottom', $attrs['data-bs-placement']);
        self::assertSame('click', $attrs['data-bs-trigger']);
        self::assertSame('window', $attrs['data-bs-boundary']);
        self::assertSame('true', $attrs['data-bs-html']);
    }

    public function testPopoverAttributesArrayInputNormalizesProperties(): void
    {
        $obj = $this->createTestClass();
        $obj->popover = [
            'title' => 'Title',
            'content' => 'Content',
        ];

        $obj->testPopoverAttributes();

        // After normalization
        self::assertSame('Title', $obj->popoverTitle);
        self::assertSame('Content', $obj->popoverContent);
    }

    public function testPopoverAttributesWithHtmlInTitle(): void
    {
        $obj = $this->createTestClass();
        $obj->popoverTitle = '<em>Title</em>';

        $attrs = $obj->testPopoverAttributes();

        // HTML detection should work for title
        self::assertSame('true', $attrs['data-bs-html']);
    }
}

