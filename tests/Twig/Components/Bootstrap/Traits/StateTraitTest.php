<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap\Traits;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\StateTrait;
use PHPUnit\Framework\TestCase;

final class StateTraitTest extends TestCase
{
    private function createTestClass(): object
    {
        return new class {
            use StateTrait;
            
            /**
             * @param array<string, mixed> $defaults
             */
            public function testApplyStateDefaults(array $defaults): void
            {
                $this->applyStateDefaults($defaults);
            }
            
            /**
             * @return array<int, string>
             */
            public function testStateClassesFor(string $type): array
            {
                return $this->stateClassesFor($type);
            }
            
            /**
             * @return array<string, mixed>
             */
            public function testStateAttributesFor(string $type, bool $isAnchor): array
            {
                return $this->stateAttributesFor($type, $isAnchor);
            }
        };
    }

    public function testBlockDefaultsToFalse(): void
    {
        $obj = $this->createTestClass();

        self::assertFalse($obj->block);
    }

    public function testActiveDefaultsToFalse(): void
    {
        $obj = $this->createTestClass();

        self::assertFalse($obj->active);
    }

    public function testDisabledDefaultsToFalse(): void
    {
        $obj = $this->createTestClass();

        self::assertFalse($obj->disabled);
    }

    public function testApplyStateDefaultsWithEmptyDefaults(): void
    {
        $obj = $this->createTestClass();
        $obj->testApplyStateDefaults([]);

        self::assertFalse($obj->block);
        self::assertFalse($obj->active);
        self::assertFalse($obj->disabled);
    }

    public function testApplyStateDefaultsWithAllTrue(): void
    {
        $obj = $this->createTestClass();
        $obj->testApplyStateDefaults([
            'block' => true,
            'active' => true,
            'disabled' => true,
        ]);

        self::assertTrue($obj->block);
        self::assertTrue($obj->active);
        self::assertTrue($obj->disabled);
    }

    public function testApplyStateDefaultsUsesOrLogic(): void
    {
        $obj = $this->createTestClass();
        $obj->block = false;
        $obj->active = false;
        $obj->disabled = false;
        
        $obj->testApplyStateDefaults([
            'block' => true,
            'active' => true,
            'disabled' => true,
        ]);

        // OR logic means config true always wins
        self::assertTrue($obj->block);
        self::assertTrue($obj->active);
        self::assertTrue($obj->disabled);
    }

    public function testStateClassesForButtonWithBlock(): void
    {
        $obj = $this->createTestClass();
        $obj->block = true;

        $classes = $obj->testStateClassesFor('button');

        self::assertContains('w-100', $classes);
    }

    public function testStateClassesForLinkWithBlock(): void
    {
        $obj = $this->createTestClass();
        $obj->block = true;

        $classes = $obj->testStateClassesFor('link');

        self::assertContains('d-block', $classes);
    }

    public function testStateClassesForActive(): void
    {
        $obj = $this->createTestClass();
        $obj->active = true;

        $classes = $obj->testStateClassesFor('button');

        self::assertContains('active', $classes);
    }

    public function testStateClassesForDisabledLink(): void
    {
        $obj = $this->createTestClass();
        $obj->disabled = true;

        $classes = $obj->testStateClassesFor('link');

        self::assertContains('disabled', $classes);
    }

    public function testStateClassesForDisabledButton(): void
    {
        $obj = $this->createTestClass();
        $obj->disabled = true;

        $classes = $obj->testStateClassesFor('button');

        // Disabled class not added for buttons (uses attribute instead)
        self::assertNotContains('disabled', $classes);
    }

    public function testStateClassesForAllStates(): void
    {
        $obj = $this->createTestClass();
        $obj->block = true;
        $obj->active = true;
        $obj->disabled = true;

        $classes = $obj->testStateClassesFor('link');

        self::assertContains('d-block', $classes);
        self::assertContains('active', $classes);
        self::assertContains('disabled', $classes);
    }

    public function testStateAttributesForButtonDisabled(): void
    {
        $obj = $this->createTestClass();
        $obj->disabled = true;

        $attrs = $obj->testStateAttributesFor('button', false);

        self::assertArrayHasKey('aria-disabled', $attrs);
        self::assertSame('true', $attrs['aria-disabled']);
        self::assertArrayHasKey('disabled', $attrs);
        self::assertTrue($attrs['disabled']);
    }

    public function testStateAttributesForAnchorDisabled(): void
    {
        $obj = $this->createTestClass();
        $obj->disabled = true;

        $attrs = $obj->testStateAttributesFor('button', true);

        self::assertArrayHasKey('aria-disabled', $attrs);
        self::assertSame('true', $attrs['aria-disabled']);
        self::assertArrayHasKey('tabindex', $attrs);
        self::assertSame('-1', $attrs['tabindex']);
        self::assertArrayNotHasKey('disabled', $attrs); // Anchors don't have disabled attribute
    }

    public function testStateAttributesForActive(): void
    {
        $obj = $this->createTestClass();
        $obj->active = true;

        $attrs = $obj->testStateAttributesFor('button', false);

        self::assertArrayHasKey('aria-pressed', $attrs);
        self::assertSame('true', $attrs['aria-pressed']);
    }

    public function testStateAttributesForActiveAndDisabled(): void
    {
        $obj = $this->createTestClass();
        $obj->active = true;
        $obj->disabled = true;

        $attrs = $obj->testStateAttributesFor('button', false);

        self::assertArrayHasKey('aria-pressed', $attrs);
        self::assertArrayHasKey('aria-disabled', $attrs);
        self::assertArrayHasKey('disabled', $attrs);
    }

    public function testStateAttributesWithNoStates(): void
    {
        $obj = $this->createTestClass();

        $attrs = $obj->testStateAttributesFor('button', false);

        self::assertSame([], $attrs);
    }
}

