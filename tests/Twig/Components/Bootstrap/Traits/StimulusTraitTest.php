<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap\Traits;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\StimulusTrait;
use PHPUnit\Framework\TestCase;

final class StimulusTraitTest extends TestCase
{
    private function createTestClass(): object
    {
        return new class {
            use StimulusTrait;
            
            /**
             * @return array<string, string>
             */
            public function testStimulusAttributes(string $controller): array
            {
                return $this->stimulusAttributes($controller);
            }
        };
    }

    public function testStimulusAttributesReturnsControllerAttribute(): void
    {
        $obj = $this->createTestClass();

        $attrs = $obj->testStimulusAttributes('test-controller');

        self::assertArrayHasKey('data-controller', $attrs);
        self::assertSame('test-controller', $attrs['data-controller']);
    }

    public function testStimulusAttributesWithEmptyController(): void
    {
        $obj = $this->createTestClass();

        $attrs = $obj->testStimulusAttributes('');

        self::assertArrayHasKey('data-controller', $attrs);
        self::assertSame('', $attrs['data-controller']);
    }

    public function testStimulusAttributesWithMultipleControllers(): void
    {
        $obj = $this->createTestClass();

        $attrs = $obj->testStimulusAttributes('controller-1 controller-2');

        self::assertArrayHasKey('data-controller', $attrs);
        self::assertSame('controller-1 controller-2', $attrs['data-controller']);
    }

    public function testStimulusAttributesWithKebabCase(): void
    {
        $obj = $this->createTestClass();

        $attrs = $obj->testStimulusAttributes('bs-navbar-sticky');

        self::assertArrayHasKey('data-controller', $attrs);
        self::assertSame('bs-navbar-sticky', $attrs['data-controller']);
    }

    public function testStimulusAttributesReturnsOnlyOneAttribute(): void
    {
        $obj = $this->createTestClass();

        $attrs = $obj->testStimulusAttributes('test');

        self::assertCount(1, $attrs);
    }
}

