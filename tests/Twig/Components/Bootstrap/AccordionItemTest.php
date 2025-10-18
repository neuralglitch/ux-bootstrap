<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AccordionItem;
use PHPUnit\Framework\TestCase;

final class AccordionItemTest extends TestCase
{
    /** @param array<string, mixed> $config */
    private function createConfig(array $config = []): Config
    {
        return new Config(['accordion_item' => $config]);
    }

    private function createAccordionItem(?Config $config = null): AccordionItem
    {
        return new AccordionItem($config ?? $this->createConfig());
    }

    public function testComponentHasCorrectDefaults(): void
    {
        $item = $this->createAccordionItem();

        self::assertNull($item->title);
        self::assertNull($item->targetId);
        self::assertNull($item->parentId);
        self::assertFalse($item->show);
        self::assertTrue($item->collapsed);
        self::assertSame('', $item->class);
        self::assertSame([], $item->attr);
    }

    public function testMountAppliesConfigDefaults(): void
    {
        $config = $this->createConfig([
            'show' => true,
            'collapsed' => false,
            'target_id' => 'config-target',
        ]);

        $item = $this->createAccordionItem($config);
        $item->mount();

        self::assertTrue($item->show);
        // collapsed is calculated as !show in mount
        self::assertFalse($item->collapsed);
        self::assertSame('config-target', $item->targetId);
    }

    public function testMountRespectsShowPropertyForCollapsed(): void
    {
        $item = $this->createAccordionItem();
        $item->show = true;
        $item->mount();

        // When show is true, collapsed should be false
        self::assertFalse($item->collapsed);
    }

    public function testMountGeneratesUniqueTargetIdIfNotProvided(): void
    {
        $item = $this->createAccordionItem();
        $item->mount();

        self::assertNotNull($item->targetId);
        self::assertStringStartsWith('collapse-', $item->targetId);
    }

    public function testMountUsesProvidedTargetId(): void
    {
        $item = $this->createAccordionItem();
        $item->targetId = 'custom-target';
        $item->mount();

        self::assertSame('custom-target', $item->targetId);
    }

    public function testMountAppliesClassDefaults(): void
    {
        $config = $this->createConfig(['class' => 'custom-class']);
        $item = $this->createAccordionItem($config);
        $item->mount();

        self::assertSame('custom-class', $item->class);
    }

    public function testGetComponentName(): void
    {
        $item = $this->createAccordionItem();
        
        $reflection = new \ReflectionClass($item);
        $method = $reflection->getMethod('getComponentName');
        $method->setAccessible(true);
        
        self::assertSame('accordion_item', $method->invoke($item));
    }

    public function testOptionsReturnsCorrectStructure(): void
    {
        $item = $this->createAccordionItem();
        $item->mount();

        $options = $item->options();

        self::assertIsArray($options);
        self::assertArrayHasKey('title', $options);
        self::assertArrayHasKey('targetId', $options);
        self::assertArrayHasKey('parentId', $options);
        self::assertArrayHasKey('show', $options);
        self::assertArrayHasKey('collapsed', $options);
        self::assertArrayHasKey('itemClasses', $options);
        self::assertArrayHasKey('buttonClasses', $options);
        self::assertArrayHasKey('collapseClasses', $options);
        self::assertArrayHasKey('attrs', $options);
    }

    public function testOptionsBuildsCorrectItemClasses(): void
    {
        $item = $this->createAccordionItem();
        $item->mount();

        $options = $item->options();

        self::assertStringContainsString('accordion-item', $options['itemClasses']);
    }

    public function testOptionsBuildsCorrectButtonClasses(): void
    {
        $item = $this->createAccordionItem();
        $item->collapsed = true;
        $item->mount();

        $options = $item->options();

        self::assertStringContainsString('accordion-button', $options['buttonClasses']);
        self::assertStringContainsString('collapsed', $options['buttonClasses']);
    }

    public function testOptionsButtonWithoutCollapsedClassWhenNotCollapsed(): void
    {
        $item = $this->createAccordionItem();
        $item->show = true;
        $item->mount();

        $options = $item->options();

        self::assertStringContainsString('accordion-button', $options['buttonClasses']);
        self::assertStringNotContainsString('collapsed', $options['buttonClasses']);
    }

    public function testOptionsBuildsCorrectCollapseClasses(): void
    {
        $item = $this->createAccordionItem();
        $item->mount();

        $options = $item->options();

        self::assertStringContainsString('accordion-collapse', $options['collapseClasses']);
        self::assertStringContainsString('collapse', $options['collapseClasses']);
    }

    public function testOptionsIncludesShowClassWhenShowIsTrue(): void
    {
        $item = $this->createAccordionItem();
        $item->show = true;
        $item->mount();

        $options = $item->options();

        self::assertStringContainsString('show', $options['collapseClasses']);
    }

    public function testOptionsExcludesShowClassWhenShowIsFalse(): void
    {
        $item = $this->createAccordionItem();
        $item->show = false;
        $item->mount();

        $options = $item->options();

        self::assertStringNotContainsString('show', $options['collapseClasses']);
    }

    public function testOptionsIncludesCustomClass(): void
    {
        $item = $this->createAccordionItem();
        $item->class = 'my-custom-class another-class';
        $item->mount();

        $options = $item->options();

        self::assertStringContainsString('my-custom-class', $options['itemClasses']);
        self::assertStringContainsString('another-class', $options['itemClasses']);
    }

    public function testOptionsMergesCustomAttributes(): void
    {
        $item = $this->createAccordionItem();
        $item->attr = [
            'data-custom' => 'value',
            'id' => 'custom-item',
        ];
        $item->mount();

        $options = $item->options();

        self::assertArrayHasKey('data-custom', $options['attrs']);
        self::assertSame('value', $options['attrs']['data-custom']);
        self::assertArrayHasKey('id', $options['attrs']);
        self::assertSame('custom-item', $options['attrs']['id']);
    }

    public function testAccordionItemWithAllFeaturesSet(): void
    {
        $config = $this->createConfig([
            'show' => true,
        ]);

        $item = $this->createAccordionItem($config);
        $item->title = 'Test Item';
        $item->targetId = 'test-target';
        $item->parentId = 'test-parent';
        $item->class = 'custom-item';
        $item->attr = ['data-test' => 'item'];
        $item->mount();

        $options = $item->options();

        self::assertSame('Test Item', $options['title']);
        self::assertSame('test-target', $options['targetId']);
        self::assertSame('test-parent', $options['parentId']);
        self::assertTrue($options['show']);
        self::assertFalse($options['collapsed']);
        self::assertStringContainsString('custom-item', $options['itemClasses']);
        self::assertArrayHasKey('data-test', $options['attrs']);
    }

    public function testEmptyConfigUsesAllDefaults(): void
    {
        $item = $this->createAccordionItem($this->createConfig([]));
        $item->mount();

        self::assertFalse($item->show);
        self::assertTrue($item->collapsed); // Because !show && (config collapsed default true) = true
        self::assertNotNull($item->targetId); // ID should be auto-generated
    }

    public function testGeneratedTargetIdIsUnique(): void
    {
        $item1 = $this->createAccordionItem();
        $item1->mount();
        
        $item2 = $this->createAccordionItem();
        $item2->mount();

        self::assertNotSame($item1->targetId, $item2->targetId);
    }

    public function testShowOrLogicWithConfig(): void
    {
        // Config says true, property says false -> should be true (OR logic)
        $config = $this->createConfig(['show' => true]);
        $item = $this->createAccordionItem($config);
        $item->show = false;
        $item->mount();

        self::assertTrue($item->show);
    }

    public function testCollapsedIsNegationOfShow(): void
    {
        $item = $this->createAccordionItem();
        
        // When show is true, collapsed should be false
        $item->show = true;
        $item->mount();
        self::assertFalse($item->collapsed);
        
        // When show is false, collapsed should be determined by config/default
        $item2 = $this->createAccordionItem();
        $item2->show = false;
        $item2->mount();
        // Logic is: !$this->show && ($d['collapsed'] ?? true) = !false && true = true
        self::assertTrue($item2->collapsed);
    }

    public function testTitleIsPassedToOptions(): void
    {
        $item = $this->createAccordionItem();
        $item->title = 'Custom Title';
        $item->mount();

        $options = $item->options();

        self::assertSame('Custom Title', $options['title']);
    }

    public function testParentIdIsPassedToOptions(): void
    {
        $item = $this->createAccordionItem();
        $item->parentId = 'parent-accordion';
        $item->mount();

        $options = $item->options();

        self::assertSame('parent-accordion', $options['parentId']);
    }
}

