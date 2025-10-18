<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Service\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use PHPUnit\Framework\TestCase;

final class ConfigTest extends TestCase
{
    public function testConstructorAcceptsArray(): void
    {
        $config = new Config([
            'button' => ['variant' => 'primary'],
            'badge' => ['pill' => true],
        ]);

        self::assertInstanceOf(Config::class, $config);
    }

    public function testForReturnsEmptyArrayWhenComponentNotFound(): void
    {
        $config = new Config([]);

        self::assertSame([], $config->for('nonexistent'));
    }

    public function testForReturnsComponentConfiguration(): void
    {
        $buttonConfig = [
            'variant' => 'primary',
            'size' => 'lg',
            'disabled' => false,
        ];

        $config = new Config(['button' => $buttonConfig]);

        self::assertSame($buttonConfig, $config->for('button'));
    }

    public function testForReturnsMultipleComponentConfigurations(): void
    {
        $buttonConfig = ['variant' => 'primary'];
        $badgeConfig = ['pill' => true];

        $config = new Config([
            'button' => $buttonConfig,
            'badge' => $badgeConfig,
        ]);

        self::assertSame($buttonConfig, $config->for('button'));
        self::assertSame($badgeConfig, $config->for('badge'));
    }

    public function testForWithNestedConfiguration(): void
    {
        $config = new Config([
            'button' => [
                'variant' => 'primary',
                'tooltip' => [
                    'text' => 'Click me',
                    'placement' => 'top',
                ],
            ],
        ]);

        $result = $config->for('button');

        self::assertArrayHasKey('tooltip', $result);
        self::assertSame('Click me', $result['tooltip']['text']);
        self::assertSame('top', $result['tooltip']['placement']);
    }

    public function testMergeReturnsEmptyArrayWhenComponentNotFound(): void
    {
        $config = new Config([]);

        $result = $config->merge('nonexistent', ['variant' => 'primary']);

        self::assertSame(['variant' => 'primary'], $result);
    }

    public function testMergeOverridesConfigWithUserValues(): void
    {
        $config = new Config([
            'button' => [
                'variant' => 'primary',
                'size' => 'md',
                'disabled' => false,
            ],
        ]);

        $result = $config->merge('button', [
            'variant' => 'danger',
            'disabled' => true,
        ]);

        self::assertSame('danger', $result['variant']);
        self::assertSame('md', $result['size']); // Not overridden
        self::assertTrue($result['disabled']);
    }

    public function testMergeFiltersNullValues(): void
    {
        $config = new Config([
            'button' => [
                'variant' => 'primary',
                'size' => 'md',
            ],
        ]);

        $result = $config->merge('button', [
            'variant' => null, // Should be filtered out
            'size' => 'lg',
        ]);

        self::assertSame('primary', $result['variant']); // Original value preserved
        self::assertSame('lg', $result['size']); // Overridden
    }

    public function testMergeFiltersEmptyArrays(): void
    {
        $config = new Config([
            'button' => [
                'attr' => ['class' => 'btn'],
            ],
        ]);

        $result = $config->merge('button', [
            'attr' => [], // Should be filtered out
        ]);

        self::assertSame(['class' => 'btn'], $result['attr']); // Original value preserved
    }

    public function testMergeWithNestedArrays(): void
    {
        $config = new Config([
            'button' => [
                'tooltip' => [
                    'text' => 'Default',
                    'placement' => 'bottom',
                ],
            ],
        ]);

        $result = $config->merge('button', [
            'tooltip' => [
                'text' => 'Custom',
            ],
        ]);

        self::assertSame('Custom', $result['tooltip']['text']); // Overridden
        self::assertSame('bottom', $result['tooltip']['placement']); // Preserved
    }

    public function testMergeRecursivelyMergesNestedArrays(): void
    {
        $config = new Config([
            'component' => [
                'level1' => [
                    'level2' => [
                        'a' => 1,
                        'b' => 2,
                    ],
                ],
            ],
        ]);

        $result = $config->merge('component', [
            'level1' => [
                'level2' => [
                    'b' => 99, // Override
                    'c' => 3,  // Add new
                ],
            ],
        ]);

        self::assertSame(1, $result['level1']['level2']['a']); // Preserved
        self::assertSame(99, $result['level1']['level2']['b']); // Overridden
        self::assertSame(3, $result['level1']['level2']['c']); // Added
    }

    public function testMergeWithEmptyOverrides(): void
    {
        $buttonConfig = ['variant' => 'primary'];
        $config = new Config(['button' => $buttonConfig]);

        $result = $config->merge('button', []);

        self::assertSame($buttonConfig, $result);
    }

    public function testMergeWithOnlyNullAndEmptyOverrides(): void
    {
        $buttonConfig = [
            'variant' => 'primary',
            'attr' => ['class' => 'btn'],
        ];
        $config = new Config(['button' => $buttonConfig]);

        $result = $config->merge('button', [
            'variant' => null,
            'attr' => [],
            'size' => null,
        ]);

        self::assertSame($buttonConfig, $result);
    }

    public function testMergePreservesArrayKeysWithZeroValue(): void
    {
        $config = new Config([
            'component' => [
                'count' => 10,
            ],
        ]);

        $result = $config->merge('component', [
            'count' => 0, // Zero is not null or empty array
        ]);

        self::assertSame(0, $result['count']);
    }

    public function testMergePreservesArrayKeysWithFalseValue(): void
    {
        $config = new Config([
            'component' => [
                'enabled' => true,
            ],
        ]);

        $result = $config->merge('component', [
            'enabled' => false, // False is not null or empty array
        ]);

        self::assertFalse($result['enabled']);
    }

    public function testMergePreservesArrayKeysWithEmptyString(): void
    {
        $config = new Config([
            'component' => [
                'text' => 'default',
            ],
        ]);

        $result = $config->merge('component', [
            'text' => '', // Empty string is not null or empty array
        ]);

        self::assertSame('', $result['text']);
    }
}

