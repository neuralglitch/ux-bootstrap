<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap\Traits;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\IconTrait;
use PHPUnit\Framework\TestCase;

final class IconTraitTest extends TestCase
{
    private function createTestClass(): object
    {
        return new class {
            use IconTrait;

            public ?string $size = null; // For effectiveIconGap test

            public function testHasIconStart(): bool
            {
                return $this->hasIconStart();
            }

            public function testHasIconEnd(): bool
            {
                return $this->hasIconEnd();
            }

            public function testEffectiveIconGap(): int
            {
                return $this->effectiveIconGap();
            }

            /**
             * @return array<string, array<int, string>>
             */
            public function testIconSpacingClasses(string $context = 'button'): array
            {
                return $this->iconSpacingClasses($context);
            }

            /**
             * @param array<string, mixed> $attrs
             * @return array<string, mixed>
             */
            public function testApplyIconOnlyAria(array $attrs, ?string $visibleLabel, ?string $ariaLabel): array
            {
                return $this->applyIconOnlyAria($attrs, $visibleLabel, $ariaLabel);
            }

            public function testEffectiveIconSize(): string
            {
                return $this->effectiveIconSize();
            }

            public function testToIntOrNull(int|string|null $v): ?int
            {
                return $this->toIntOrNull($v);
            }
        };
    }

    public function testIconStartDefaultsToNull(): void
    {
        $obj = $this->createTestClass();

        self::assertNull($obj->iconStart);
    }

    public function testIconEndDefaultsToNull(): void
    {
        $obj = $this->createTestClass();

        self::assertNull($obj->iconEnd);
    }

    public function testIconOnlyDefaultsToFalse(): void
    {
        $obj = $this->createTestClass();

        self::assertFalse($obj->iconOnly);
    }

    public function testIconSizeDefaultsToNull(): void
    {
        $obj = $this->createTestClass();

        self::assertNull($obj->iconSize);
    }

    public function testIconGapDefaultsToNull(): void
    {
        $obj = $this->createTestClass();

        self::assertNull($obj->iconGap);
    }

    public function testHasIconStartReturnsFalseWhenNull(): void
    {
        $obj = $this->createTestClass();
        $obj->iconStart = null;

        self::assertFalse($obj->testHasIconStart());
    }

    public function testHasIconStartReturnsFalseWhenEmpty(): void
    {
        $obj = $this->createTestClass();
        $obj->iconStart = '';

        self::assertFalse($obj->testHasIconStart());
    }

    public function testHasIconStartReturnsTrueWhenSet(): void
    {
        $obj = $this->createTestClass();
        $obj->iconStart = 'bi:star';

        self::assertTrue($obj->testHasIconStart());
    }

    public function testHasIconEndReturnsFalseWhenNull(): void
    {
        $obj = $this->createTestClass();
        $obj->iconEnd = null;

        self::assertFalse($obj->testHasIconEnd());
    }

    public function testHasIconEndReturnsTrueWhenSet(): void
    {
        $obj = $this->createTestClass();
        $obj->iconEnd = 'bi:arrow-right';

        self::assertTrue($obj->testHasIconEnd());
    }

    public function testEffectiveIconGapDefaultsTo2(): void
    {
        $obj = $this->createTestClass();

        $gap = $obj->testEffectiveIconGap();

        self::assertSame(2, $gap);
    }

    public function testEffectiveIconGapReturnsCustomValue(): void
    {
        $obj = $this->createTestClass();
        $obj->iconGap = 3;

        $gap = $obj->testEffectiveIconGap();

        self::assertSame(3, $gap);
    }

    public function testEffectiveIconGapClampsToMinimum(): void
    {
        $obj = $this->createTestClass();
        $obj->iconGap = -5;

        $gap = $obj->testEffectiveIconGap();

        self::assertSame(0, $gap);
    }

    public function testEffectiveIconGapClampsToMaximum(): void
    {
        $obj = $this->createTestClass();
        $obj->iconGap = 10;

        $gap = $obj->testEffectiveIconGap();

        self::assertSame(5, $gap);
    }

    public function testEffectiveIconGapForSmallSize(): void
    {
        $obj = $this->createTestClass();
        $obj->size = 'sm';
        $obj->iconGap = null;

        $gap = $obj->testEffectiveIconGap();

        self::assertSame(1, $gap); // Small buttons use gap of 1
    }

    public function testIconSpacingClassesWithDefaultGap(): void
    {
        $obj = $this->createTestClass();

        $spacing = $obj->testIconSpacingClasses('button');

        self::assertSame(['me-2'], $spacing['start']);
        self::assertSame(['ms-2'], $spacing['end']);
    }

    public function testIconSpacingClassesWithCustomGap(): void
    {
        $obj = $this->createTestClass();
        $obj->iconGap = 3;

        $spacing = $obj->testIconSpacingClasses('button');

        self::assertSame(['me-3'], $spacing['start']);
        self::assertSame(['ms-3'], $spacing['end']);
    }

    public function testIconSpacingClassesWithZeroGap(): void
    {
        $obj = $this->createTestClass();
        $obj->iconGap = 0;

        $spacing = $obj->testIconSpacingClasses('button');

        self::assertSame([], $spacing['start']);
        self::assertSame([], $spacing['end']);
    }

    public function testApplyIconOnlyAriaWithIconOnly(): void
    {
        $obj = $this->createTestClass();
        $obj->iconOnly = true;

        $attrs = $obj->testApplyIconOnlyAria([], 'Button Label', null);

        self::assertArrayHasKey('aria-label', $attrs);
        self::assertSame('Button Label', $attrs['aria-label']);
    }

    public function testApplyIconOnlyAriaPrefersAriaLabel(): void
    {
        $obj = $this->createTestClass();
        $obj->iconOnly = true;

        $attrs = $obj->testApplyIconOnlyAria([], 'Visible Label', 'Aria Label');

        self::assertArrayHasKey('aria-label', $attrs);
        self::assertSame('Aria Label', $attrs['aria-label']);
    }

    public function testApplyIconOnlyAriaWithoutIconOnly(): void
    {
        $obj = $this->createTestClass();
        $obj->iconOnly = false;

        $attrs = $obj->testApplyIconOnlyAria([], 'Label', null);

        self::assertArrayNotHasKey('aria-label', $attrs);
    }

    public function testEffectiveIconSizeDefaultsTo1em(): void
    {
        $obj = $this->createTestClass();
        $obj->iconSize = null;

        $size = $obj->testEffectiveIconSize();

        self::assertSame('1em', $size);
    }

    public function testEffectiveIconSizeWithNumericValue(): void
    {
        $obj = $this->createTestClass();
        $obj->iconSize = 2;

        $size = $obj->testEffectiveIconSize();

        self::assertSame('2em', $size);
    }

    public function testEffectiveIconSizeWithFloatValue(): void
    {
        $obj = $this->createTestClass();
        $obj->iconSize = 1.5;

        $size = $obj->testEffectiveIconSize();

        self::assertSame('1.5em', $size);
    }

    public function testEffectiveIconSizeWithStringValue(): void
    {
        $obj = $this->createTestClass();
        $obj->iconSize = '24px';

        $size = $obj->testEffectiveIconSize();

        self::assertSame('24px', $size);
    }

    public function testEffectiveIconSizeWithRemValue(): void
    {
        $obj = $this->createTestClass();
        $obj->iconSize = '2rem';

        $size = $obj->testEffectiveIconSize();

        self::assertSame('2rem', $size);
    }

    public function testToIntOrNullWithInteger(): void
    {
        $obj = $this->createTestClass();

        $result = $obj->testToIntOrNull(42);

        self::assertSame(42, $result);
    }

    public function testToIntOrNullWithNumericString(): void
    {
        $obj = $this->createTestClass();

        $result = $obj->testToIntOrNull('123');

        self::assertSame(123, $result);
    }

    public function testToIntOrNullWithNonNumericString(): void
    {
        $obj = $this->createTestClass();

        $result = $obj->testToIntOrNull('abc');

        self::assertNull($result);
    }

    public function testToIntOrNullWithNull(): void
    {
        $obj = $this->createTestClass();

        $result = $obj->testToIntOrNull(null);

        self::assertNull($result);
    }

    public function testToIntOrNullWithZero(): void
    {
        $obj = $this->createTestClass();

        $result = $obj->testToIntOrNull(0);

        self::assertSame(0, $result);
    }
}

