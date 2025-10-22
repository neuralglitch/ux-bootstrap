<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap\Traits;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\VariantTrait;
use PHPUnit\Framework\TestCase;

final class VariantTraitTest extends TestCase
{
    private function createTestClass(): object
    {
        return new class {
            use VariantTrait;

            /**
             * @param array<string, mixed> $defaults
             */
            public function testApplyVariantDefaults(array $defaults): void
            {
                $this->applyVariantDefaults($defaults);
            }

            /**
             * @return array<int, string>
             */
            public function testVariantClassesFor(string $type): array
            {
                return $this->variantClassesFor($type);
            }
        };
    }

    public function testVariantDefaultsToNull(): void
    {
        $obj = $this->createTestClass();

        self::assertNull($obj->variant);
    }

    public function testOutlineDefaultsToFalse(): void
    {
        $obj = $this->createTestClass();

        self::assertFalse($obj->outline);
    }

    public function testApplyVariantDefaultsWithEmptyDefaults(): void
    {
        $obj = $this->createTestClass();
        $obj->testApplyVariantDefaults([]);

        self::assertNull($obj->variant);
        self::assertFalse($obj->outline);
    }

    public function testApplyVariantDefaultsWithVariant(): void
    {
        $obj = $this->createTestClass();
        $obj->testApplyVariantDefaults(['variant' => 'primary']);

        self::assertSame('primary', $obj->variant);
    }

    public function testApplyVariantDefaultsWithOutline(): void
    {
        $obj = $this->createTestClass();
        $obj->testApplyVariantDefaults(['outline' => true]);

        self::assertTrue($obj->outline);
    }

    public function testApplyVariantDefaultsDoesNotOverrideExistingVariant(): void
    {
        $obj = $this->createTestClass();
        $obj->variant = 'danger';
        $obj->testApplyVariantDefaults(['variant' => 'primary']);

        self::assertSame('danger', $obj->variant); // Not overridden
    }

    public function testApplyVariantDefaultsUsesOrLogicForOutline(): void
    {
        $obj = $this->createTestClass();
        $obj->outline = false;
        $obj->testApplyVariantDefaults(['outline' => true]);

        self::assertTrue($obj->outline); // OR logic
    }

    public function testVariantClassesForButton(): void
    {
        $obj = $this->createTestClass();
        $obj->variant = 'primary';

        $classes = $obj->testVariantClassesFor('button');

        self::assertSame(['btn-primary'], $classes);
    }

    public function testVariantClassesForButtonOutline(): void
    {
        $obj = $this->createTestClass();
        $obj->variant = 'success';
        $obj->outline = true;

        $classes = $obj->testVariantClassesFor('button');

        self::assertSame(['btn-outline-success'], $classes);
    }

    public function testVariantClassesForLink(): void
    {
        $obj = $this->createTestClass();
        $obj->variant = 'primary';

        $classes = $obj->testVariantClassesFor('link');

        self::assertSame(['link-primary'], $classes);
    }

    public function testVariantClassesForLinkWithNullVariant(): void
    {
        $obj = $this->createTestClass();
        $obj->variant = null;

        $classes = $obj->testVariantClassesFor('link');

        self::assertSame([], $classes); // Special case for links
    }

    public function testVariantClassesForBadge(): void
    {
        $obj = $this->createTestClass();
        $obj->variant = 'danger';

        $classes = $obj->testVariantClassesFor('badge');

        self::assertSame(['text-bg-danger'], $classes);
    }

    public function testVariantClassesForAlert(): void
    {
        $obj = $this->createTestClass();
        $obj->variant = 'warning';

        $classes = $obj->testVariantClassesFor('alert');

        self::assertSame(['alert-warning'], $classes);
    }

    public function testVariantClassesForUnknownType(): void
    {
        $obj = $this->createTestClass();
        $obj->variant = 'primary';

        $classes = $obj->testVariantClassesFor('unknown');

        self::assertSame([], $classes);
    }

    public function testVariantClassesForAllVariants(): void
    {
        $variants = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'];

        foreach ($variants as $variant) {
            $obj = $this->createTestClass();
            $obj->variant = $variant;

            $classes = $obj->testVariantClassesFor('button');

            self::assertSame(["btn-{$variant}"], $classes);
        }
    }

    public function testVariantClassesForOutlineAllVariants(): void
    {
        $variants = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'];

        foreach ($variants as $variant) {
            $obj = $this->createTestClass();
            $obj->variant = $variant;
            $obj->outline = true;

            $classes = $obj->testVariantClassesFor('button');

            self::assertSame(["btn-outline-{$variant}"], $classes);
        }
    }

    public function testVariantClassesForButtonWithNullVariantUsesPrimary(): void
    {
        $obj = $this->createTestClass();
        $obj->variant = null;

        $classes = $obj->testVariantClassesFor('button');

        self::assertSame(['btn-primary'], $classes);
    }

    public function testVariantClassesForBadgeWithNullVariantUsesPrimary(): void
    {
        $obj = $this->createTestClass();
        $obj->variant = null;

        $classes = $obj->testVariantClassesFor('badge');

        self::assertSame(['text-bg-primary'], $classes);
    }

    public function testVariantClassesForListGroupItem(): void
    {
        $obj = $this->createTestClass();
        $obj->variant = 'danger';

        $classes = $obj->testVariantClassesFor('list-group-item');

        self::assertSame(['list-group-item-danger'], $classes);
    }

    public function testVariantClassesForListGroupItemAllVariants(): void
    {
        $variants = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'];

        foreach ($variants as $variant) {
            $obj = $this->createTestClass();
            $obj->variant = $variant;

            $classes = $obj->testVariantClassesFor('list-group-item');

            self::assertSame(["list-group-item-{$variant}"], $classes);
        }
    }

    public function testVariantClassesForListGroupItemWithNullVariant(): void
    {
        $obj = $this->createTestClass();
        $obj->variant = null;

        $classes = $obj->testVariantClassesFor('list-group-item');

        self::assertSame(['list-group-item-primary'], $classes);
    }
}

