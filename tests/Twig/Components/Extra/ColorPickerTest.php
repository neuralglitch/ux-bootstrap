<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\ColorPicker;
use PHPUnit\Framework\TestCase;

final class ColorPickerTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'color_picker' => [
                'name' => 'color',
                'value' => null,
                'label' => null,
                'required' => false,
                'disabled' => false,
                'presets' => [],
                'show_presets' => true,
                'show_input' => true,
                'show_hex' => true,
                'allow_custom' => true,
                'size' => 'default',
                'swatch_size' => 'default',
                'columns' => 6,
                'placeholder' => null,
                'help_text' => null,
                'inline' => false,
                'class' => null,
                'attr' => [],
                'input_attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new ColorPicker($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('color-picker', $options['classes']);
        $this->assertStringContainsString('mb-3', $options['classes']);
        $this->assertSame('color', $options['name']);
        $this->assertNull($options['value']);
        $this->assertTrue($options['showInput']);
        $this->assertTrue($options['showHex']);
        $this->assertTrue($options['allowCustom']);
        $this->assertFalse($options['showPresets']); // false because presets array is empty
    }

    public function testNameOption(): void
    {
        $component = new ColorPicker($this->config);
        $component->name = 'primary_color';
        $component->mount();
        $options = $component->options();

        $this->assertSame('primary_color', $options['name']);
        $this->assertArrayHasKey('name', $options['inputAttrs']);
        $this->assertSame('primary_color', $options['inputAttrs']['name']);
    }

    public function testValueOption(): void
    {
        $component = new ColorPicker($this->config);
        $component->value = '#FF0000';
        $component->mount();
        $options = $component->options();

        $this->assertSame('#FF0000', $options['value']);
        $this->assertArrayHasKey('value', $options['inputAttrs']);
        $this->assertSame('#FF0000', $options['inputAttrs']['value']);
    }

    public function testLabelOption(): void
    {
        $component = new ColorPicker($this->config);
        $component->label = 'Select Color';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Select Color', $options['label']);
    }

    public function testRequiredOption(): void
    {
        $component = new ColorPicker($this->config);
        $component->required = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['required']);
        $this->assertArrayHasKey('required', $options['inputAttrs']);
        $this->assertTrue($options['inputAttrs']['required']);
    }

    public function testDisabledOption(): void
    {
        $component = new ColorPicker($this->config);
        $component->disabled = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['disabled']);
        $this->assertArrayHasKey('disabled', $options['inputAttrs']);
        $this->assertTrue($options['inputAttrs']['disabled']);
    }

    public function testPresetsOption(): void
    {
        $presets = ['#FF0000', '#00FF00', '#0000FF'];
        $component = new ColorPicker($this->config);
        $component->presets = $presets;
        $component->mount();
        $options = $component->options();

        $this->assertSame($presets, $options['presets']);
        $this->assertTrue($options['showPresets']); // true because presets array is not empty
    }

    public function testShowPresetsOption(): void
    {
        $component = new ColorPicker($this->config);
        $component->presets = ['#FF0000', '#00FF00'];
        $component->showPresets = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['showPresets']);
    }

    public function testShowInputOption(): void
    {
        $component = new ColorPicker($this->config);
        $component->showInput = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['showInput']);
    }

    public function testShowHexOption(): void
    {
        $component = new ColorPicker($this->config);
        $component->showHex = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['showHex']);
    }

    public function testAllowCustomOption(): void
    {
        $component = new ColorPicker($this->config);
        $component->allowCustom = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['allowCustom']);
    }

    public function testSizeSmall(): void
    {
        $component = new ColorPicker($this->config);
        $component->size = 'sm';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('color-picker-sm', $options['classes']);
        $this->assertStringContainsString('form-control-sm', $options['inputClasses']);
    }

    public function testSizeLarge(): void
    {
        $component = new ColorPicker($this->config);
        $component->size = 'lg';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('color-picker-lg', $options['classes']);
        $this->assertStringContainsString('form-control-lg', $options['inputClasses']);
    }

    public function testSwatchSizeSmall(): void
    {
        $component = new ColorPicker($this->config);
        $component->swatchSize = 'sm';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('color-picker-swatch-sm', $options['swatchClasses']);
    }

    public function testSwatchSizeLarge(): void
    {
        $component = new ColorPicker($this->config);
        $component->swatchSize = 'lg';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('color-picker-swatch-lg', $options['swatchClasses']);
    }

    public function testColumnsOption(): void
    {
        $component = new ColorPicker($this->config);
        $component->columns = 4;
        $component->mount();
        $options = $component->options();

        $this->assertSame(4, $options['columns']);
    }

    public function testPlaceholderOption(): void
    {
        $component = new ColorPicker($this->config);
        $component->placeholder = 'Enter hex color';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Enter hex color', $options['inputAttrs']['placeholder']);
    }

    public function testHelpTextOption(): void
    {
        $component = new ColorPicker($this->config);
        $component->helpText = 'Choose a color for your theme';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Choose a color for your theme', $options['helpText']);
    }

    public function testInlineOption(): void
    {
        $component = new ColorPicker($this->config);
        $component->inline = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['inline']);
        $this->assertStringContainsString('d-inline-flex', $options['classes']);
        $this->assertStringContainsString('align-items-center', $options['classes']);
        $this->assertStringNotContainsString('mb-3', $options['classes']);
    }

    public function testCustomClasses(): void
    {
        $component = new ColorPicker($this->config);
        $component->class = 'custom-picker my-picker';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-picker', $options['classes']);
        $this->assertStringContainsString('my-picker', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new ColorPicker($this->config);
        $component->attr = [
            'data-test' => 'color-picker',
            'aria-label' => 'Color Picker',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('color-picker', $options['attrs']['data-test']);
        $this->assertArrayHasKey('aria-label', $options['attrs']);
        $this->assertSame('Color Picker', $options['attrs']['aria-label']);
    }

    public function testInputAttributes(): void
    {
        $component = new ColorPicker($this->config);
        $component->inputAttr = [
            'data-custom' => 'value',
            'maxlength' => '10',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-custom', $options['inputAttrs']);
        $this->assertSame('value', $options['inputAttrs']['data-custom']);
        $this->assertArrayHasKey('maxlength', $options['inputAttrs']);
        $this->assertSame('10', $options['inputAttrs']['maxlength']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'color_picker' => [
                'name' => 'theme_color',
                'value' => '#0000FF',
                'label' => 'Theme Color',
                'required' => true,
                'presets' => ['#FF0000', '#00FF00', '#0000FF'],
                'size' => 'lg',
                'columns' => 4,
                'class' => 'default-picker',
                'placeholder' => 'Pick a color',
                'show_presets' => true,
                'show_input' => true,
                'show_hex' => true,
                'allow_custom' => true,
                'swatch_size' => 'default',
                'help_text' => null,
                'inline' => false,
                'disabled' => false,
                'attr' => [],
                'input_attr' => [],
            ],
        ]);

        $component = new ColorPicker($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('theme_color', $options['name']);
        $this->assertSame('#0000FF', $options['value']);
        $this->assertSame('Theme Color', $options['label']);
        $this->assertTrue($options['required']);
        $this->assertSame(['#FF0000', '#00FF00', '#0000FF'], $options['presets']);
        $this->assertStringContainsString('color-picker-lg', $options['classes']);
        $this->assertSame(4, $options['columns']);
        $this->assertStringContainsString('default-picker', $options['classes']);
    }

    public function testCombinedOptions(): void
    {
        $component = new ColorPicker($this->config);
        $component->name = 'brand_color';
        $component->value = '#FF5733';
        $component->label = 'Brand Color';
        $component->required = true;
        $component->presets = ['#FF5733', '#C70039', '#900C3F'];
        $component->size = 'lg';
        $component->swatchSize = 'lg';
        $component->columns = 3;
        $component->helpText = 'Select your brand color';
        $component->class = 'brand-picker';
        $component->mount();
        $options = $component->options();

        $this->assertSame('brand_color', $options['name']);
        $this->assertSame('#FF5733', $options['value']);
        $this->assertSame('Brand Color', $options['label']);
        $this->assertTrue($options['required']);
        $this->assertSame(['#FF5733', '#C70039', '#900C3F'], $options['presets']);
        $this->assertStringContainsString('color-picker-lg', $options['classes']);
        $this->assertStringContainsString('color-picker-swatch-lg', $options['swatchClasses']);
        $this->assertSame(3, $options['columns']);
        $this->assertSame('Select your brand color', $options['helpText']);
        $this->assertStringContainsString('brand-picker', $options['classes']);
    }

    public function testWithNullValues(): void
    {
        $component = new ColorPicker($this->config);
        $component->value = null;
        $component->label = null;
        $component->placeholder = null;
        $component->helpText = null;
        $component->mount();
        $options = $component->options();

        $this->assertNull($options['value']);
        $this->assertNull($options['label']);
        $this->assertNull($options['inputAttrs']['placeholder']);
        $this->assertNull($options['helpText']);
    }

    public function testWithEmptyPresets(): void
    {
        $component = new ColorPicker($this->config);
        $component->presets = [];
        $component->mount();
        $options = $component->options();

        $this->assertEmpty($options['presets']);
        $this->assertFalse($options['showPresets']); // Should be false when presets are empty
    }

    public function testGetComponentName(): void
    {
        $component = new ColorPicker($this->config);
        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('color_picker', $method->invoke($component));
    }

    public function testHexPatternInInput(): void
    {
        $component = new ColorPicker($this->config);
        $component->showHex = true;
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('pattern', $options['inputAttrs']);
        $this->assertSame('^#[0-9A-Fa-f]{6}$', $options['inputAttrs']['pattern']);
    }

    public function testNoHexPatternWhenHexDisabled(): void
    {
        $component = new ColorPicker($this->config);
        $component->showHex = false;
        $component->mount();
        $options = $component->options();

        $this->assertNull($options['inputAttrs']['pattern']);
    }
}

