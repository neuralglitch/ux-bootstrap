<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap\Traits;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\SizeTrait;
use PHPUnit\Framework\TestCase;

final class SizeTraitTest extends TestCase
{
    private function createTestClass(): object
    {
        return new class {
            use SizeTrait;
            
            /**
             * @param array<string, mixed> $defaults
             */
            public function testApplySizeDefaults(array $defaults): void
            {
                $this->applySizeDefaults($defaults);
            }
            
            /**
             * @return array<int, string>
             */
            public function testSizeClassesFor(string $type): array
            {
                return $this->sizeClassesFor($type);
            }
        };
    }

    public function testSizeDefaultsToNull(): void
    {
        $obj = $this->createTestClass();

        self::assertNull($obj->size);
    }

    public function testApplySizeDefaultsWithEmptyDefaults(): void
    {
        $obj = $this->createTestClass();
        $obj->testApplySizeDefaults([]);

        self::assertNull($obj->size);
    }

    public function testApplySizeDefaultsWithSize(): void
    {
        $obj = $this->createTestClass();
        $obj->testApplySizeDefaults(['size' => 'lg']);

        self::assertSame('lg', $obj->size);
    }

    public function testApplySizeDefaultsDoesNotOverrideExistingSize(): void
    {
        $obj = $this->createTestClass();
        $obj->size = 'sm';
        $obj->testApplySizeDefaults(['size' => 'lg']);

        self::assertSame('sm', $obj->size); // Not overridden
    }

    public function testSizeClassesForButtonWithNull(): void
    {
        $obj = $this->createTestClass();
        $obj->size = null;

        $classes = $obj->testSizeClassesFor('button');

        self::assertSame([], $classes);
    }

    public function testSizeClassesForButtonSmall(): void
    {
        $obj = $this->createTestClass();
        $obj->size = 'sm';

        $classes = $obj->testSizeClassesFor('button');

        self::assertSame(['btn-sm'], $classes);
    }

    public function testSizeClassesForButtonLarge(): void
    {
        $obj = $this->createTestClass();
        $obj->size = 'lg';

        $classes = $obj->testSizeClassesFor('button');

        self::assertSame(['btn-lg'], $classes);
    }

    public function testSizeClassesForInputSmall(): void
    {
        $obj = $this->createTestClass();
        $obj->size = 'sm';

        $classes = $obj->testSizeClassesFor('input');

        self::assertSame(['form-control-sm'], $classes);
    }

    public function testSizeClassesForInputLarge(): void
    {
        $obj = $this->createTestClass();
        $obj->size = 'lg';

        $classes = $obj->testSizeClassesFor('input');

        self::assertSame(['form-control-lg'], $classes);
    }

    public function testSizeClassesForUnknownType(): void
    {
        $obj = $this->createTestClass();
        $obj->size = 'lg';

        $classes = $obj->testSizeClassesFor('unknown');

        self::assertSame([], $classes);
    }

    public function testSizeClassesForInputWithNull(): void
    {
        $obj = $this->createTestClass();
        $obj->size = null;

        $classes = $obj->testSizeClassesFor('input');

        self::assertSame([], $classes);
    }

    public function testSizeClassesForBtnGroupSmall(): void
    {
        $obj = $this->createTestClass();
        $obj->size = 'sm';

        $classes = $obj->testSizeClassesFor('btn-group');

        self::assertSame(['btn-group-sm'], $classes);
    }

    public function testSizeClassesForBtnGroupLarge(): void
    {
        $obj = $this->createTestClass();
        $obj->size = 'lg';

        $classes = $obj->testSizeClassesFor('btn-group');

        self::assertSame(['btn-group-lg'], $classes);
    }

    public function testSizeClassesForPaginationSmall(): void
    {
        $obj = $this->createTestClass();
        $obj->size = 'sm';

        $classes = $obj->testSizeClassesFor('pagination');

        self::assertSame(['pagination-sm'], $classes);
    }

    public function testSizeClassesForPaginationLarge(): void
    {
        $obj = $this->createTestClass();
        $obj->size = 'lg';

        $classes = $obj->testSizeClassesFor('pagination');

        self::assertSame(['pagination-lg'], $classes);
    }

    public function testSizeClassesForModalSmall(): void
    {
        $obj = $this->createTestClass();
        $obj->size = 'sm';

        $classes = $obj->testSizeClassesFor('modal');

        self::assertSame(['modal-sm'], $classes);
    }

    public function testSizeClassesForModalLarge(): void
    {
        $obj = $this->createTestClass();
        $obj->size = 'lg';

        $classes = $obj->testSizeClassesFor('modal');

        self::assertSame(['modal-lg'], $classes);
    }

    public function testSizeClassesForModalExtraLarge(): void
    {
        $obj = $this->createTestClass();
        $obj->size = 'xl';

        $classes = $obj->testSizeClassesFor('modal');

        self::assertSame(['modal-xl'], $classes);
    }

    public function testSizeClassesForModalInvalidSize(): void
    {
        $obj = $this->createTestClass();
        $obj->size = 'md'; // Not supported for modal

        $classes = $obj->testSizeClassesFor('modal');

        self::assertSame([], $classes);
    }

    public function testSizeClassesForModalWithNull(): void
    {
        $obj = $this->createTestClass();
        $obj->size = null;

        $classes = $obj->testSizeClassesFor('modal');

        self::assertSame([], $classes);
    }
}

