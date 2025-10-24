<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Button;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class ButtonTest extends TestCase
{
    /** @param array<string, mixed> $config */
    private function createConfig(array $config = []): Config
    {
        return new Config(['button' => $config]);
    }

    private function createButton(?Config $config = null): Button
    {
        return new Button($config ?? $this->createConfig());
    }

    public function testComponentHasCorrectDefaults(): void
    {
        $button = $this->createButton();

        self::assertNull($button->href);
        self::assertSame('button', $button->type);
        self::assertNull($button->label);
        self::assertNull($button->variant);
        self::assertFalse($button->outline);
        self::assertNull($button->size);
        self::assertFalse($button->block);
        self::assertFalse($button->disabled);
        self::assertFalse($button->active);
        self::assertSame('', $button->class);
        self::assertSame([], $button->attr);
        
        // Tooltip/Popover defaults
        self::assertNull($button->tooltip);
        self::assertNull($button->popover);
        self::assertNull($button->popoverTitle);
    }

    public function testMountAppliesConfigDefaults(): void
    {
        $config = $this->createConfig([
            'variant' => 'primary',
            'outline' => true,
            'size' => 'lg',
            'block' => true,
            'disabled' => true,
            'active' => true,
        ]);

        $button = $this->createButton($config);
        $button->mount();

        self::assertSame('primary', $button->variant);
        self::assertTrue($button->outline);
        self::assertSame('lg', $button->size);
        self::assertTrue($button->block);
        self::assertTrue($button->disabled);
        self::assertTrue($button->active);
    }

    public function testGetComponentType(): void
    {
        $button = $this->createButton();

        $reflection = new ReflectionClass($button);
        $method = $reflection->getMethod('getComponentType');
        $method->setAccessible(true);

        self::assertSame('button', $method->invoke($button));
    }

    public function testOptionsReturnsCorrectStructure(): void
    {
        $button = $this->createButton();
        $button->label = 'Click me';
        $button->mount();

        $options = $button->options();

        self::assertIsArray($options);
        self::assertArrayHasKey('tag', $options);
        self::assertArrayHasKey('href', $options);
        self::assertArrayHasKey('type', $options);
        self::assertArrayHasKey('label', $options);
        self::assertArrayHasKey('iconStart', $options);
        self::assertArrayHasKey('iconEnd', $options);
        self::assertArrayHasKey('iconOnly', $options);
        self::assertArrayHasKey('iconSize', $options);
        self::assertArrayHasKey('classes', $options);
        self::assertArrayHasKey('attrs', $options);
        self::assertArrayHasKey('disabled', $options);
        self::assertArrayHasKey('iconStartClasses', $options);
        self::assertArrayHasKey('iconEndClasses', $options);
    }

    public function testOptionsTagIsButtonByDefault(): void
    {
        $button = $this->createButton();
        $button->mount();

        $options = $button->options();

        self::assertSame('button', $options['tag']);
        self::assertNull($options['href']);
    }

    public function testOptionsTagIsAnchorWhenHrefProvided(): void
    {
        $button = $this->createButton();
        $button->href = '/link';
        $button->mount();

        $options = $button->options();

        self::assertSame('a', $options['tag']);
        self::assertSame('/link', $options['href']);
    }

    public function testOptionsBuildsCorrectClasses(): void
    {
        $config = $this->createConfig(['variant' => 'primary']);
        $button = $this->createButton($config);
        $button->mount();

        $options = $button->options();

        self::assertStringContainsString('btn', $options['classes']);
        self::assertStringContainsString('btn-primary', $options['classes']);
    }

    public function testOptionsWithOutlineVariant(): void
    {
        $button = $this->createButton();
        $button->variant = 'success';
        $button->outline = true;
        $button->mount();

        $options = $button->options();

        self::assertStringContainsString('btn-outline-success', $options['classes']);
    }

    public function testOptionsWithSize(): void
    {
        $sizes = ['sm', 'lg'];

        foreach ($sizes as $size) {
            $button = $this->createButton();
            $button->size = $size;
            $button->mount();

            $options = $button->options();

            self::assertStringContainsString("btn-{$size}", $options['classes']);
        }
    }

    public function testOptionsWithBlock(): void
    {
        $button = $this->createButton();
        $button->block = true;
        $button->mount();

        $options = $button->options();

        self::assertStringContainsString('w-100', $options['classes']);
    }

    public function testOptionsWithActive(): void
    {
        $button = $this->createButton();
        $button->active = true;
        $button->mount();

        $options = $button->options();

        self::assertStringContainsString('active', $options['classes']);
    }

    public function testOptionsWithDisabled(): void
    {
        $button = $this->createButton();
        $button->disabled = true;
        $button->mount();

        $options = $button->options();

        self::assertTrue($options['disabled']);
        self::assertArrayHasKey('disabled', $options['attrs']);
        // The value might be true or 'disabled' depending on implementation
        self::assertTrue(isset($options['attrs']['disabled']));
    }

    public function testOptionsIncludesCustomClass(): void
    {
        $button = $this->createButton();
        $button->class = 'my-custom-class another-class';
        $button->mount();

        $options = $button->options();

        self::assertStringContainsString('my-custom-class', $options['classes']);
        self::assertStringContainsString('another-class', $options['classes']);
    }

    public function testOptionsMergesCustomAttributes(): void
    {
        $button = $this->createButton();
        $button->attr = [
            'id' => 'my-button',
            'data-test' => 'value',
        ];
        $button->mount();

        $options = $button->options();

        self::assertArrayHasKey('id', $options['attrs']);
        self::assertSame('my-button', $options['attrs']['id']);
        self::assertArrayHasKey('data-test', $options['attrs']);
        self::assertSame('value', $options['attrs']['data-test']);
    }

    public function testVariantClassesForDifferentVariants(): void
    {
        $variants = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'];

        foreach ($variants as $variant) {
            $config = $this->createConfig(['variant' => $variant]);
            $button = $this->createButton($config);
            $button->mount();

            $options = $button->options();

            self::assertStringContainsString("btn-{$variant}", $options['classes']);
        }
    }

    public function testButtonWithAllFeaturesEnabled(): void
    {
        $config = $this->createConfig([
            'variant' => 'success',
            'outline' => true,
            'size' => 'lg',
            'block' => true,
            'active' => true,
        ]);

        $button = $this->createButton($config);
        $button->label = 'Submit';
        $button->class = 'custom-button';
        $button->attr = ['data-action' => 'submit'];
        $button->mount();

        $options = $button->options();

        self::assertSame('Submit', $options['label']);
        self::assertStringContainsString('btn', $options['classes']);
        self::assertStringContainsString('btn-outline-success', $options['classes']);
        self::assertStringContainsString('btn-lg', $options['classes']);
        self::assertStringContainsString('w-100', $options['classes']);
        self::assertStringContainsString('active', $options['classes']);
        self::assertStringContainsString('custom-button', $options['classes']);
        self::assertArrayHasKey('data-action', $options['attrs']);
    }

    public function testEmptyConfigUsesAllDefaults(): void
    {
        $button = $this->createButton($this->createConfig([]));
        $button->mount();

        self::assertNull($button->variant);
        self::assertFalse($button->outline);
        self::assertNull($button->size);
        self::assertFalse($button->block);
        self::assertFalse($button->disabled);
        self::assertFalse($button->active);
    }

    public function testOptionsTypeAttribute(): void
    {
        $button = $this->createButton();
        $button->type = 'submit';
        $button->mount();

        $options = $button->options();

        self::assertSame('submit', $options['type']);
    }

    public function testButtonAsAnchor(): void
    {
        $button = $this->createButton();
        $button->href = 'https://example.com';
        $button->variant = 'primary';
        $button->mount();

        $options = $button->options();

        self::assertSame('a', $options['tag']);
        self::assertSame('https://example.com', $options['href']);
        self::assertStringContainsString('btn', $options['classes']);
    }

    public function testTooltipIntegration(): void
    {
        $button = $this->createButton();
        $button->tooltip = 'Save document';
        $button->mount();

        $options = $button->options();
        $attrs = $options['attrs'];

        self::assertSame('tooltip', $attrs['data-bs-toggle']);
        self::assertSame('Save document', $attrs['data-bs-title']);
        self::assertSame('top', $attrs['data-bs-placement']);
        self::assertSame('hover', $attrs['data-bs-trigger']);
    }

    public function testPopoverIntegration(): void
    {
        $button = $this->createButton();
        $button->popover = 'Are you sure you want to delete this item?';
        $button->popoverTitle = 'Confirm Delete';
        $button->mount();

        $options = $button->options();
        $attrs = $options['attrs'];

        self::assertSame('popover', $attrs['data-bs-toggle']);
        self::assertSame('Are you sure you want to delete this item?', $attrs['data-bs-content']);
        self::assertSame('Confirm Delete', $attrs['data-bs-title']);
        self::assertSame('top', $attrs['data-bs-placement']);
        self::assertSame('click', $attrs['data-bs-trigger']);
    }

    public function testTooltipArrayValue(): void
    {
        $button = $this->createButton();
        $button->tooltip = ['text' => 'Array tooltip'];
        $button->mount();

        $options = $button->options();
        $attrs = $options['attrs'];

        self::assertSame('tooltip', $attrs['data-bs-toggle']);
        self::assertSame('Array tooltip', $attrs['data-bs-title']);
    }

    public function testPopoverArrayValue(): void
    {
        $button = $this->createButton();
        $button->popover = ['content' => 'Array popover content'];
        $button->mount();

        $options = $button->options();
        $attrs = $options['attrs'];

        self::assertSame('popover', $attrs['data-bs-toggle']);
        self::assertSame('Array popover content', $attrs['data-bs-content']);
    }

    public function testCustomTooltipPlacementAndTrigger(): void
    {
        $button = $this->createButton();
        $button->tooltip = 'Custom tooltip';
        $button->tooltipPlacement = 'bottom';
        $button->tooltipTrigger = 'click';
        $button->mount();

        $options = $button->options();
        $attrs = $options['attrs'];

        self::assertSame('tooltip', $attrs['data-bs-toggle']);
        self::assertSame('Custom tooltip', $attrs['data-bs-title']);
        self::assertSame('bottom', $attrs['data-bs-placement']);
        self::assertSame('click', $attrs['data-bs-trigger']);
    }

    public function testTooltipHtmlDetection(): void
    {
        $button = $this->createButton();
        $button->tooltip = '<strong>Bold text</strong>';
        $button->mount();

        $options = $button->options();
        $attrs = $options['attrs'];

        self::assertSame('tooltip', $attrs['data-bs-toggle']);
        self::assertSame('<strong>Bold text</strong>', $attrs['data-bs-title']);
        // HTML detection should set data-bs-html to true when HTML tags are present
        self::assertSame('true', $attrs['data-bs-html']);
    }

    public function testTooltipHtmlOverride(): void
    {
        $button = $this->createButton();
        $button->tooltip = 'Plain text';
        $button->tooltipHtml = false;
        $button->mount();

        $options = $button->options();
        $attrs = $options['attrs'];

        self::assertSame('tooltip', $attrs['data-bs-toggle']);
        self::assertSame('Plain text', $attrs['data-bs-title']);
        self::assertSame('false', $attrs['data-bs-html']);
    }
}

