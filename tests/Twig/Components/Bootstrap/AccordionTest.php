<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Accordion;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class AccordionTest extends TestCase
{
    /** @param array<string, mixed> $config */
    private function createConfig(array $config = []): Config
    {
        return new Config(['accordion' => $config]);
    }

    private function createAccordion(?Config $config = null): Accordion
    {
        return new Accordion($config ?? $this->createConfig());
    }

    public function testComponentHasCorrectDefaults(): void
    {
        $accordion = $this->createAccordion();

        self::assertNull($accordion->id);
        self::assertFalse($accordion->flush);
        self::assertFalse($accordion->alwaysOpen);
        self::assertSame('', $accordion->class);
        self::assertSame([], $accordion->attr);
    }

    public function testMountAppliesConfigDefaults(): void
    {
        $config = $this->createConfig([
            'flush' => true,
            'always_open' => true,
            'id' => 'config-accordion',
        ]);

        $accordion = $this->createAccordion($config);
        $accordion->mount();

        self::assertTrue($accordion->flush);
        self::assertTrue($accordion->alwaysOpen);
        self::assertSame('config-accordion', $accordion->id);
    }

    public function testMountRespectsPropertyOverrides(): void
    {
        $config = $this->createConfig([
            'flush' => true,
            'always_open' => true,
        ]);

        $accordion = $this->createAccordion($config);
        $accordion->flush = false;
        $accordion->alwaysOpen = false;
        $accordion->mount();

        // Properties use OR logic, so config true always wins
        self::assertTrue($accordion->flush);
        self::assertTrue($accordion->alwaysOpen);
    }

    public function testMountGeneratesUniqueIdIfNotProvided(): void
    {
        $accordion = $this->createAccordion();
        $accordion->mount();

        self::assertNotNull($accordion->id);
        self::assertStringStartsWith('accordion-', $accordion->id);
    }

    public function testMountUsesProvidedId(): void
    {
        $accordion = $this->createAccordion();
        $accordion->id = 'custom-accordion';
        $accordion->mount();

        self::assertSame('custom-accordion', $accordion->id);
    }

    public function testMountAppliesClassDefaults(): void
    {
        $config = $this->createConfig(['class' => 'custom-class']);
        $accordion = $this->createAccordion($config);
        $accordion->mount();

        self::assertSame('custom-class', $accordion->class);
    }

    public function testMountMergesClassWithExisting(): void
    {
        $config = $this->createConfig(['class' => 'config-class']);
        $accordion = $this->createAccordion($config);
        $accordion->class = 'user-class';
        $accordion->mount();

        self::assertSame('user-class config-class', $accordion->class);
    }

    public function testGetComponentName(): void
    {
        $accordion = $this->createAccordion();

        $reflection = new ReflectionClass($accordion);
        $method = $reflection->getMethod('getComponentName');
        $method->setAccessible(true);

        self::assertSame('accordion', $method->invoke($accordion));
    }

    public function testOptionsReturnsCorrectStructure(): void
    {
        $accordion = $this->createAccordion();
        $accordion->mount();

        $options = $accordion->options();

        self::assertIsArray($options);
        self::assertArrayHasKey('id', $options);
        self::assertArrayHasKey('flush', $options);
        self::assertArrayHasKey('alwaysOpen', $options);
        self::assertArrayHasKey('classes', $options);
        self::assertArrayHasKey('attrs', $options);
    }

    public function testOptionsBuildsCorrectClasses(): void
    {
        $accordion = $this->createAccordion();
        $accordion->mount();

        $options = $accordion->options();

        self::assertStringContainsString('accordion', $options['classes']);
    }

    public function testOptionsIncludesFlushClassWhenEnabled(): void
    {
        $accordion = $this->createAccordion();
        $accordion->flush = true;
        $accordion->mount();

        $options = $accordion->options();

        self::assertStringContainsString('accordion', $options['classes']);
        self::assertStringContainsString('accordion-flush', $options['classes']);
    }

    public function testOptionsExcludesFlushClassWhenDisabled(): void
    {
        $accordion = $this->createAccordion();
        $accordion->flush = false;
        $accordion->mount();

        $options = $accordion->options();

        self::assertStringContainsString('accordion', $options['classes']);
        self::assertStringNotContainsString('accordion-flush', $options['classes']);
    }

    public function testOptionsIncludesCustomClass(): void
    {
        $accordion = $this->createAccordion();
        $accordion->class = 'my-custom-class another-class';
        $accordion->mount();

        $options = $accordion->options();

        self::assertStringContainsString('my-custom-class', $options['classes']);
        self::assertStringContainsString('another-class', $options['classes']);
    }

    public function testOptionsAttrsIncludesId(): void
    {
        $accordion = $this->createAccordion();
        $accordion->id = 'test-accordion';
        $accordion->mount();

        $options = $accordion->options();

        self::assertArrayHasKey('id', $options['attrs']);
        self::assertSame('test-accordion', $options['attrs']['id']);
    }

    public function testOptionsMergesCustomAttributes(): void
    {
        $accordion = $this->createAccordion();
        $accordion->attr = [
            'data-custom' => 'value',
            'aria-label' => 'Accordion',
        ];
        $accordion->mount();

        $options = $accordion->options();

        self::assertArrayHasKey('data-custom', $options['attrs']);
        self::assertSame('value', $options['attrs']['data-custom']);
        self::assertArrayHasKey('aria-label', $options['attrs']);
        self::assertSame('Accordion', $options['attrs']['aria-label']);
    }

    public function testOptionsCustomAttributesOverrideDefaults(): void
    {
        $accordion = $this->createAccordion();
        $accordion->id = 'default-id';
        $accordion->attr = ['id' => 'override-id'];
        $accordion->mount();

        $options = $accordion->options();

        self::assertSame('override-id', $options['attrs']['id']);
    }

    public function testAccordionWithAllFeaturesEnabled(): void
    {
        $config = $this->createConfig([
            'flush' => true,
            'always_open' => true,
        ]);

        $accordion = $this->createAccordion($config);
        $accordion->id = 'feature-accordion';
        $accordion->class = 'custom-accordion';
        $accordion->attr = ['data-test' => 'accordion'];
        $accordion->mount();

        $options = $accordion->options();

        self::assertSame('feature-accordion', $options['id']);
        self::assertTrue($options['flush']);
        self::assertTrue($options['alwaysOpen']);
        self::assertStringContainsString('accordion', $options['classes']);
        self::assertStringContainsString('accordion-flush', $options['classes']);
        self::assertStringContainsString('custom-accordion', $options['classes']);
        self::assertArrayHasKey('id', $options['attrs']);
        self::assertArrayHasKey('data-test', $options['attrs']);
    }

    public function testEmptyConfigUsesAllDefaults(): void
    {
        $accordion = $this->createAccordion($this->createConfig([]));
        $accordion->mount();

        self::assertFalse($accordion->flush);
        self::assertFalse($accordion->alwaysOpen);
        self::assertNotNull($accordion->id); // ID should be auto-generated
    }

    public function testFlushOrLogicWithConfig(): void
    {
        // Config says true, property says false -> should be true (OR logic)
        $config = $this->createConfig(['flush' => true]);
        $accordion = $this->createAccordion($config);
        $accordion->flush = false;
        $accordion->mount();

        self::assertTrue($accordion->flush);
    }

    public function testAlwaysOpenOrLogicWithConfig(): void
    {
        // Config says true, property says false -> should be true (OR logic)
        $config = $this->createConfig(['always_open' => true]);
        $accordion = $this->createAccordion($config);
        $accordion->alwaysOpen = false;
        $accordion->mount();

        self::assertTrue($accordion->alwaysOpen);
    }

    public function testGeneratedIdIsUnique(): void
    {
        $accordion1 = $this->createAccordion();
        $accordion1->mount();

        $accordion2 = $this->createAccordion();
        $accordion2->mount();

        self::assertNotSame($accordion1->id, $accordion2->id);
    }
}

