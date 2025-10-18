<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractInteraction;
use PHPUnit\Framework\TestCase;

final class AbstractInteractionTest extends TestCase
{
    private function createTestComponent(Config $config): AbstractInteraction
    {
        return new class($config) extends AbstractInteraction {
            protected function getComponentType(): string
            {
                return 'test';
            }
        };
    }

    public function testConstructorAcceptsConfig(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);

        self::assertInstanceOf(AbstractInteraction::class, $component);
    }

    public function testLabelDefaultsToNull(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);

        self::assertNull($component->label);
    }

    public function testStimulusControllerDefaultsToBsLink(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);

        self::assertSame('bs-link', $component->stimulusController);
    }

    public function testApplyCommonDefaultsWithEmptyDefaults(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);

        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('applyCommonDefaults');
        $method->setAccessible(true);
        $method->invoke($component, []);

        self::assertNull($component->variant);
        self::assertFalse($component->block);
        self::assertFalse($component->active);
    }

    public function testApplyCommonDefaultsWithVariantDefaults(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);

        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('applyCommonDefaults');
        $method->setAccessible(true);
        $method->invoke($component, [
            'variant' => 'primary',
            'outline' => true,
        ]);

        self::assertSame('primary', $component->variant);
        self::assertTrue($component->outline);
    }

    public function testApplyCommonDefaultsWithStateDefaults(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);

        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('applyCommonDefaults');
        $method->setAccessible(true);
        $method->invoke($component, [
            'block' => true,
            'active' => true,
            'disabled' => true,
        ]);

        self::assertTrue($component->block);
        self::assertTrue($component->active);
        self::assertTrue($component->disabled);
    }

    public function testApplyCommonDefaultsWithTooltip(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);

        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('applyCommonDefaults');
        $method->setAccessible(true);
        $method->invoke($component, [
            'tooltip' => [
                'text' => 'Tooltip text',
                'placement' => 'top',
            ],
        ]);

        self::assertSame('Tooltip text', $component->tooltip);
        self::assertSame('top', $component->tooltipPlacement);
    }

    public function testApplyCommonDefaultsWithPopover(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);

        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('applyCommonDefaults');
        $method->setAccessible(true);
        $method->invoke($component, [
            'popover' => [
                'title' => 'Popover Title',
                'content' => 'Popover content',
            ],
        ]);

        self::assertSame('Popover Title', $component->popoverTitle);
        self::assertSame('Popover content', $component->popoverContent);
    }

    public function testApplyCommonDefaultsWithStimulusController(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);

        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('applyCommonDefaults');
        $method->setAccessible(true);
        $method->invoke($component, [
            'stimulus_controller' => 'custom-controller',
        ]);

        self::assertSame('custom-controller', $component->stimulusController);
    }

    public function testApplyCommonDefaultsWithIconOnly(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);

        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('applyCommonDefaults');
        $method->setAccessible(true);
        $method->invoke($component, [
            'icon_only' => true,
        ]);

        self::assertTrue($component->iconOnly);
    }

    public function testApplyCommonDefaultsWithIconGap(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);

        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('applyCommonDefaults');
        $method->setAccessible(true);
        $method->invoke($component, [
            'icon_gap' => 3,
        ]);

        self::assertSame(3, $component->iconGap);
    }

    public function testBuildCommonAttributesWithEmptyComponent(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);

        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('buildCommonAttributes');
        $method->setAccessible(true);
        $attrs = $method->invoke($component, false);

        self::assertIsArray($attrs);
        // Should at least have stimulus controller
        self::assertArrayHasKey('data-controller', $attrs);
    }

    public function testBuildCommonAttributesWithAriaLabel(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);
        $component->ariaLabel = 'Test Label';

        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('buildCommonAttributes');
        $method->setAccessible(true);
        $attrs = $method->invoke($component, false);

        self::assertArrayHasKey('aria-label', $attrs);
        self::assertSame('Test Label', $attrs['aria-label']);
    }

    public function testBuildCommonAttributesWithTooltip(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);
        $component->tooltip = 'Tooltip text';

        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('buildCommonAttributes');
        $method->setAccessible(true);
        $attrs = $method->invoke($component, false);

        self::assertArrayHasKey('data-bs-toggle', $attrs);
        self::assertSame('tooltip', $attrs['data-bs-toggle']);
        self::assertArrayHasKey('data-bs-title', $attrs);
    }

    public function testBuildCommonAttributesWithDisabled(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);
        $component->disabled = true;

        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('buildCommonAttributes');
        $method->setAccessible(true);
        $attrs = $method->invoke($component, false);

        self::assertArrayHasKey('aria-disabled', $attrs);
        self::assertArrayHasKey('disabled', $attrs);
    }

    public function testBuildCommonAttributesMergesCustomAttrs(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);
        $component->attr = [
            'id' => 'custom-id',
            'data-test' => 'value',
        ];

        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('buildCommonAttributes');
        $method->setAccessible(true);
        $attrs = $method->invoke($component, false);

        self::assertArrayHasKey('id', $attrs);
        self::assertSame('custom-id', $attrs['id']);
        self::assertArrayHasKey('data-test', $attrs);
        self::assertSame('value', $attrs['data-test']);
    }

    public function testBuildCommonAttributesForAnchor(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);
        $component->disabled = true;

        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('buildCommonAttributes');
        $method->setAccessible(true);
        $attrs = $method->invoke($component, true);

        self::assertArrayHasKey('tabindex', $attrs);
        self::assertSame('-1', $attrs['tabindex']);
        self::assertArrayNotHasKey('disabled', $attrs); // Anchors don't have disabled
    }

    public function testGetComponentTypeIsAbstract(): void
    {
        $reflection = new \ReflectionClass(AbstractInteraction::class);
        $method = $reflection->getMethod('getComponentType');

        self::assertTrue($method->isAbstract());
    }
}

