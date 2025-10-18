<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap\Traits;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\TooltipTrait;
use PHPUnit\Framework\TestCase;

final class TooltipTraitTest extends TestCase
{
    private function createTestClass(): object
    {
        return new class {
            use TooltipTrait;
            
            /**
             * @param array<string, mixed> $defaults
             */
            public function testApplyTooltipDefaults(array $defaults): void
            {
                $this->applyTooltipDefaults($defaults);
            }
            
            /**
             * @return array<string, mixed>
             */
            public function testTooltipAttributes(): array
            {
                return $this->tooltipAttributes();
            }
        };
    }

    public function testTooltipDefaultsToNull(): void
    {
        $obj = $this->createTestClass();

        self::assertNull($obj->tooltip);
    }

    public function testTooltipPlacementDefaultsToNull(): void
    {
        $obj = $this->createTestClass();

        self::assertNull($obj->tooltipPlacement);
    }

    public function testApplyTooltipDefaultsWithEmptyDefaults(): void
    {
        $obj = $this->createTestClass();
        $obj->testApplyTooltipDefaults([]);

        self::assertNull($obj->tooltip);
        self::assertNull($obj->tooltipPlacement);
    }

    public function testApplyTooltipDefaultsWithText(): void
    {
        $obj = $this->createTestClass();
        $obj->testApplyTooltipDefaults(['text' => 'Tooltip text']);

        self::assertSame('Tooltip text', $obj->tooltip);
    }

    public function testApplyTooltipDefaultsWithAllOptions(): void
    {
        $obj = $this->createTestClass();
        $obj->testApplyTooltipDefaults([
            'text' => 'Tooltip',
            'placement' => 'top',
            'trigger' => 'click',
            'container' => 'body',
            'html' => true,
        ]);

        self::assertSame('Tooltip', $obj->tooltip);
        self::assertSame('top', $obj->tooltipPlacement);
        self::assertSame('click', $obj->tooltipTrigger);
        self::assertSame('body', $obj->tooltipContainer);
        self::assertTrue($obj->tooltipHtml);
    }

    public function testTooltipAttributesReturnsEmptyWhenNoTooltip(): void
    {
        $obj = $this->createTestClass();
        $obj->tooltip = null;

        $attrs = $obj->testTooltipAttributes();

        self::assertSame([], $attrs);
    }

    public function testTooltipAttributesWithSimpleString(): void
    {
        $obj = $this->createTestClass();
        $obj->tooltip = 'Click me';

        $attrs = $obj->testTooltipAttributes();

        self::assertArrayHasKey('data-bs-toggle', $attrs);
        self::assertSame('tooltip', $attrs['data-bs-toggle']);
        self::assertArrayHasKey('data-bs-title', $attrs);
        self::assertSame('Click me', $attrs['data-bs-title']);
        self::assertArrayHasKey('data-bs-html', $attrs);
        self::assertSame('false', $attrs['data-bs-html']);
    }

    public function testTooltipAttributesWithHtmlContent(): void
    {
        $obj = $this->createTestClass();
        $obj->tooltip = '<strong>Bold</strong> text';

        $attrs = $obj->testTooltipAttributes();

        self::assertArrayHasKey('data-bs-html', $attrs);
        self::assertSame('true', $attrs['data-bs-html']); // Auto-detected
    }

    public function testTooltipAttributesWithPlacement(): void
    {
        $obj = $this->createTestClass();
        $obj->tooltip = 'Test';
        $obj->tooltipPlacement = 'top';

        $attrs = $obj->testTooltipAttributes();

        self::assertArrayHasKey('data-bs-placement', $attrs);
        self::assertSame('top', $attrs['data-bs-placement']);
    }

    public function testTooltipAttributesWithTrigger(): void
    {
        $obj = $this->createTestClass();
        $obj->tooltip = 'Test';
        $obj->tooltipTrigger = 'click';

        $attrs = $obj->testTooltipAttributes();

        self::assertArrayHasKey('data-bs-trigger', $attrs);
        self::assertSame('click', $attrs['data-bs-trigger']);
    }

    public function testTooltipAttributesWithContainer(): void
    {
        $obj = $this->createTestClass();
        $obj->tooltip = 'Test';
        $obj->tooltipContainer = 'body';

        $attrs = $obj->testTooltipAttributes();

        self::assertArrayHasKey('data-bs-container', $attrs);
        self::assertSame('body', $attrs['data-bs-container']);
    }

    public function testTooltipAttributesWithExplicitHtmlTrue(): void
    {
        $obj = $this->createTestClass();
        $obj->tooltip = 'Plain text';
        $obj->tooltipHtml = true;

        $attrs = $obj->testTooltipAttributes();

        self::assertSame('true', $attrs['data-bs-html']);
    }

    public function testTooltipAttributesWithExplicitHtmlFalse(): void
    {
        $obj = $this->createTestClass();
        $obj->tooltip = '<strong>HTML</strong>';
        $obj->tooltipHtml = false;

        $attrs = $obj->testTooltipAttributes();

        self::assertSame('false', $attrs['data-bs-html']); // Overrides auto-detection
    }

    public function testTooltipAttributesWithArrayInput(): void
    {
        $obj = $this->createTestClass();
        $obj->tooltip = [
            'text' => 'Tooltip text',
            'placement' => 'bottom',
            'trigger' => 'hover',
            'container' => 'body',
            'html' => true,
        ];

        $attrs = $obj->testTooltipAttributes();

        self::assertArrayHasKey('data-bs-title', $attrs);
        self::assertSame('Tooltip text', $attrs['data-bs-title']);
        self::assertSame('bottom', $attrs['data-bs-placement']);
        self::assertSame('hover', $attrs['data-bs-trigger']);
        self::assertSame('body', $attrs['data-bs-container']);
        self::assertSame('true', $attrs['data-bs-html']);
    }

    public function testTooltipAttributesArrayInputNormalizesProperties(): void
    {
        $obj = $this->createTestClass();
        $obj->tooltip = ['text' => 'Test', 'placement' => 'top'];

        $obj->testTooltipAttributes();

        // After normalization, tooltip should be string
        self::assertIsString($obj->tooltip);
        self::assertSame('Test', $obj->tooltip);
        self::assertSame('top', $obj->tooltipPlacement);
    }

    public function testTooltipAttributesWithEmptyString(): void
    {
        $obj = $this->createTestClass();
        $obj->tooltip = '';

        $attrs = $obj->testTooltipAttributes();

        self::assertSame([], $attrs);
    }
}

