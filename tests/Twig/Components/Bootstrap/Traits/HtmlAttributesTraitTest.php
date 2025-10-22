<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap\Traits;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\HtmlAttributesTrait;
use PHPUnit\Framework\TestCase;

final class HtmlAttributesTraitTest extends TestCase
{
    private function createTestClass(): object
    {
        return new class {
            use HtmlAttributesTrait;

            /**
             * @param array<string, mixed> $base
             * @param array<string, mixed> $extra
             * @return array<string, mixed>
             */
            public function testMergeAttributes(array $base, array $extra): array
            {
                return $this->mergeAttributes($base, $extra);
            }

            /**
             * @param array<string, mixed> $attributes
             */
            public function testRenderHtmlAttributes(array $attributes): string
            {
                return $this->renderHtmlAttributes($attributes);
            }
        };
    }

    public function testMergeAttributesWithEmptyArrays(): void
    {
        $obj = $this->createTestClass();

        $result = $obj->testMergeAttributes([], []);

        self::assertSame([], $result);
    }

    public function testMergeAttributesWithBaseOnly(): void
    {
        $obj = $this->createTestClass();
        $base = ['id' => 'test', 'class' => 'btn'];

        $result = $obj->testMergeAttributes($base, []);

        self::assertSame($base, $result);
    }

    public function testMergeAttributesWithExtraOnly(): void
    {
        $obj = $this->createTestClass();
        $extra = ['id' => 'test', 'data-value' => '123'];

        $result = $obj->testMergeAttributes([], $extra);

        self::assertSame($extra, $result);
    }

    public function testMergeAttributesOverridesBaseWithExtra(): void
    {
        $obj = $this->createTestClass();

        $result = $obj->testMergeAttributes(
            ['id' => 'base-id', 'class' => 'btn'],
            ['id' => 'extra-id', 'data-test' => 'value']
        );

        self::assertSame('extra-id', $result['id']); // Overridden
        self::assertSame('btn', $result['class']); // Preserved
        self::assertSame('value', $result['data-test']); // Added
    }

    public function testMergeAttributesPreservesAllBaseAttributes(): void
    {
        $obj = $this->createTestClass();

        $result = $obj->testMergeAttributes(
            ['a' => '1', 'b' => '2', 'c' => '3'],
            ['d' => '4']
        );

        self::assertArrayHasKey('a', $result);
        self::assertArrayHasKey('b', $result);
        self::assertArrayHasKey('c', $result);
        self::assertArrayHasKey('d', $result);
    }

    public function testRenderHtmlAttributesWithEmptyArray(): void
    {
        $obj = $this->createTestClass();

        $result = $obj->testRenderHtmlAttributes([]);

        self::assertSame('', $result);
    }

    public function testRenderHtmlAttributesWithStringValue(): void
    {
        $obj = $this->createTestClass();

        $result = $obj->testRenderHtmlAttributes(['id' => 'test']);

        self::assertSame(' id="test"', $result);
    }

    public function testRenderHtmlAttributesWithMultipleAttributes(): void
    {
        $obj = $this->createTestClass();

        $result = $obj->testRenderHtmlAttributes([
            'id' => 'test',
            'class' => 'btn btn-primary',
            'data-value' => '123',
        ]);

        self::assertStringContainsString('id="test"', $result);
        self::assertStringContainsString('class="btn btn-primary"', $result);
        self::assertStringContainsString('data-value="123"', $result);
    }

    public function testRenderHtmlAttributesWithTrueValue(): void
    {
        $obj = $this->createTestClass();

        $result = $obj->testRenderHtmlAttributes(['disabled' => true]);

        self::assertSame(' disabled', $result);
    }

    public function testRenderHtmlAttributesWithFalseValue(): void
    {
        $obj = $this->createTestClass();

        $result = $obj->testRenderHtmlAttributes(['disabled' => false]);

        self::assertSame('', $result);
    }

    public function testRenderHtmlAttributesWithNullValue(): void
    {
        $obj = $this->createTestClass();

        $result = $obj->testRenderHtmlAttributes(['data-value' => null]);

        self::assertSame('', $result);
    }

    public function testRenderHtmlAttributesEscapesSpecialCharacters(): void
    {
        $obj = $this->createTestClass();

        $result = $obj->testRenderHtmlAttributes([
            'data-value' => '<script>alert("xss")</script>',
        ]);

        self::assertStringContainsString('&lt;script&gt;', $result);
        self::assertStringNotContainsString('<script>', $result);
    }

    public function testRenderHtmlAttributesEscapesQuotes(): void
    {
        $obj = $this->createTestClass();

        $result = $obj->testRenderHtmlAttributes([
            'title' => 'Test "quoted" value',
        ]);

        self::assertStringContainsString('&quot;', $result);
    }

    public function testRenderHtmlAttributesWithNumericValue(): void
    {
        $obj = $this->createTestClass();

        $result = $obj->testRenderHtmlAttributes([
            'data-count' => 42,
            'data-price' => 19.99,
        ]);

        self::assertStringContainsString('data-count="42"', $result);
        self::assertStringContainsString('data-price="19.99"', $result);
    }

    public function testRenderHtmlAttributesWithZeroValue(): void
    {
        $obj = $this->createTestClass();

        $result = $obj->testRenderHtmlAttributes(['data-count' => 0]);

        self::assertStringContainsString('data-count="0"', $result);
    }

    public function testRenderHtmlAttributesWithEmptyStringValue(): void
    {
        $obj = $this->createTestClass();

        $result = $obj->testRenderHtmlAttributes(['data-value' => '']);

        self::assertStringContainsString('data-value=""', $result);
    }

    public function testRenderHtmlAttributesMixedValues(): void
    {
        $obj = $this->createTestClass();

        $result = $obj->testRenderHtmlAttributes([
            'id' => 'test',
            'disabled' => true,
            'hidden' => false,
            'data-null' => null,
            'data-count' => 5,
        ]);

        self::assertStringContainsString('id="test"', $result);
        self::assertStringContainsString(' disabled', $result);
        self::assertStringNotContainsString('hidden', $result);
        self::assertStringNotContainsString('data-null', $result);
        self::assertStringContainsString('data-count="5"', $result);
    }

    public function testRenderHtmlAttributesPreservesOrder(): void
    {
        $obj = $this->createTestClass();

        $result = $obj->testRenderHtmlAttributes([
            'z' => 'last',
            'a' => 'first',
            'm' => 'middle',
        ]);

        $posZ = strpos($result, 'z=');
        $posA = strpos($result, 'a=');
        $posM = strpos($result, 'm=');

        // Should maintain insertion order
        self::assertLessThan($posA, $posZ);
        self::assertLessThan($posM, $posA);
    }
}

