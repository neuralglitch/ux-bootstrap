<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\DropdownMulti;
use PHPUnit\Framework\TestCase;

final class DropdownMultiTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'dropdown_multi' => [
                'label' => 'Select options',
                'placeholder' => null,
                'variant' => 'secondary',
                'outline' => false,
                'size' => null,
                'direction' => null,
                'menu_align' => null,
                'dark' => false,
                'auto_close' => 'outside',
                'searchable' => false,
                'search_placeholder' => 'Search...',
                'search_min_chars' => 0,
                'show_select_all' => true,
                'show_clear' => true,
                'show_apply' => false,
                'select_all_label' => 'Select All',
                'clear_label' => 'Clear',
                'apply_label' => 'Apply',
                'show_count' => true,
                'count_format' => '{count} selected',
                'show_checks' => true,
                'max_display' => 3,
                'name' => null,
                'required' => false,
                'toggle_class' => null,
                'menu_class' => null,
                'max_height' => '300px',
                'menu_attr' => [],
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new DropdownMulti($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('dropdown', $options['wrapperClasses']);
        $this->assertStringContainsString('btn', $options['toggleClasses']);
        $this->assertStringContainsString('btn-secondary', $options['toggleClasses']);
        $this->assertStringContainsString('dropdown-toggle', $options['toggleClasses']);
        $this->assertStringContainsString('dropdown-menu', $options['menuClasses']);
        $this->assertSame('Select options', $options['label']);
        $this->assertSame('outside', $options['toggleAttrs']['data-bs-auto-close']);
    }

    public function testWithOptions(): void
    {
        $component = new DropdownMulti($this->config);
        $component->options = [
            ['value' => '1', 'label' => 'Option 1', 'selected' => false],
            ['value' => '2', 'label' => 'Option 2', 'selected' => true],
            ['value' => '3', 'label' => 'Option 3', 'selected' => true],
        ];
        $component->mount();
        $options = $component->options();

        $this->assertCount(3, $options['options']);
        $this->assertSame(2, $options['selectedCount']);
        $this->assertStringContainsString('Option 2', $options['buttonLabel']);
        $this->assertStringContainsString('Option 3', $options['buttonLabel']);
    }

    public function testButtonLabelWithNoSelections(): void
    {
        $component = new DropdownMulti($this->config);
        $component->options = [
            ['value' => '1', 'label' => 'Option 1', 'selected' => false],
            ['value' => '2', 'label' => 'Option 2', 'selected' => false],
        ];
        $component->mount();
        $options = $component->options();

        $this->assertSame('Select options', $options['buttonLabel']);
    }

    public function testButtonLabelWithPlaceholder(): void
    {
        $component = new DropdownMulti($this->config);
        $component->placeholder = 'Choose items';
        $component->options = [
            ['value' => '1', 'label' => 'Option 1', 'selected' => false],
        ];
        $component->mount();
        $options = $component->options();

        $this->assertSame('Choose items', $options['buttonLabel']);
    }

    public function testButtonLabelWithFewSelections(): void
    {
        $component = new DropdownMulti($this->config);
        $component->maxDisplay = 3;
        $component->options = [
            ['value' => '1', 'label' => 'Alpha', 'selected' => true],
            ['value' => '2', 'label' => 'Beta', 'selected' => true],
            ['value' => '3', 'label' => 'Gamma', 'selected' => false],
        ];
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('Alpha', $options['buttonLabel']);
        $this->assertStringContainsString('Beta', $options['buttonLabel']);
    }

    public function testButtonLabelWithManySelections(): void
    {
        $component = new DropdownMulti($this->config);
        $component->maxDisplay = 2;
        $component->options = [
            ['value' => '1', 'label' => 'Option 1', 'selected' => true],
            ['value' => '2', 'label' => 'Option 2', 'selected' => true],
            ['value' => '3', 'label' => 'Option 3', 'selected' => true],
        ];
        $component->mount();
        $options = $component->options();

        $this->assertSame('3 selected', $options['buttonLabel']);
    }

    public function testButtonLabelWithCountFormat(): void
    {
        $component = new DropdownMulti($this->config);
        $component->countFormat = '{count} items chosen';
        $component->maxDisplay = 2;
        $component->options = [
            ['value' => '1', 'label' => 'Option 1', 'selected' => true],
            ['value' => '2', 'label' => 'Option 2', 'selected' => true],
            ['value' => '3', 'label' => 'Option 3', 'selected' => true],
        ];
        $component->mount();
        $options = $component->options();

        $this->assertSame('3 items chosen', $options['buttonLabel']);
    }

    public function testVariantOption(): void
    {
        $component = new DropdownMulti($this->config);
        $component->variant = 'primary';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('btn-primary', $options['toggleClasses']);
    }

    public function testOutlineVariant(): void
    {
        $component = new DropdownMulti($this->config);
        $component->variant = 'danger';
        $component->outline = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('btn-outline-danger', $options['toggleClasses']);
    }

    public function testSizeOption(): void
    {
        $component = new DropdownMulti($this->config);
        $component->size = 'lg';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('btn-lg', $options['toggleClasses']);
    }

    public function testDirectionOption(): void
    {
        $component = new DropdownMulti($this->config);
        $component->direction = 'dropup';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('dropup', $options['wrapperClasses']);
    }

    public function testMenuAlignOption(): void
    {
        $component = new DropdownMulti($this->config);
        $component->menuAlign = 'end';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('dropdown-menu-end', $options['menuClasses']);
    }

    public function testDarkOption(): void
    {
        $component = new DropdownMulti($this->config);
        $component->dark = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('dropdown-menu-dark', $options['menuClasses']);
    }

    public function testSearchableOption(): void
    {
        $component = new DropdownMulti($this->config);
        $component->searchable = true;
        $component->searchPlaceholder = 'Find items...';
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['searchable']);
        $this->assertSame('Find items...', $options['searchPlaceholder']);
    }

    public function testShowApplyOption(): void
    {
        $component = new DropdownMulti($this->config);
        $component->showApply = true;
        $component->applyLabel = 'Confirm';
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['showApply']);
        $this->assertSame('Confirm', $options['applyLabel']);
    }

    public function testFormIntegration(): void
    {
        $component = new DropdownMulti($this->config);
        $component->name = 'categories';
        $component->required = true;
        $component->mount();
        $options = $component->options();

        $this->assertSame('categories', $options['name']);
        $this->assertTrue($options['required']);
    }

    public function testCustomClasses(): void
    {
        $component = new DropdownMulti($this->config);
        $component->class = 'custom-dropdown';
        $component->toggleClass = 'custom-btn';
        $component->menuClass = 'custom-menu';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-dropdown', $options['wrapperClasses']);
        $this->assertStringContainsString('custom-btn', $options['toggleClasses']);
        $this->assertStringContainsString('custom-menu', $options['menuClasses']);
    }

    public function testCustomAttributes(): void
    {
        $component = new DropdownMulti($this->config);
        $component->attr = ['data-test' => 'dropdown'];
        $component->menuAttr = ['data-menu-test' => 'menu'];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['wrapperAttrs']);
        $this->assertSame('dropdown', $options['wrapperAttrs']['data-test']);
        $this->assertArrayHasKey('data-menu-test', $options['menuAttrs']);
        $this->assertSame('menu', $options['menuAttrs']['data-menu-test']);
    }

    public function testMaxHeightApplied(): void
    {
        $component = new DropdownMulti($this->config);
        $component->maxHeight = '400px';
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('style', $options['menuAttrs']);
        $this->assertStringContainsString('400px', $options['menuAttrs']['style']);
    }

    public function testOptionsWithDescription(): void
    {
        $component = new DropdownMulti($this->config);
        $component->options = [
            ['value' => '1', 'label' => 'Option 1', 'description' => 'This is option 1', 'selected' => false],
            ['value' => '2', 'label' => 'Option 2', 'description' => 'This is option 2', 'selected' => false],
        ];
        $component->mount();
        $options = $component->options();

        $this->assertSame('This is option 1', $options['options'][0]['description']);
        $this->assertSame('This is option 2', $options['options'][1]['description']);
    }

    public function testOptionsWithDisabled(): void
    {
        $component = new DropdownMulti($this->config);
        $component->options = [
            ['value' => '1', 'label' => 'Option 1', 'disabled' => false, 'selected' => false],
            ['value' => '2', 'label' => 'Option 2', 'disabled' => true, 'selected' => false],
        ];
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['options'][0]['disabled']);
        $this->assertTrue($options['options'][1]['disabled']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'dropdown_multi' => [
                'label' => 'Custom Default Label',
                'variant' => 'success',
                'searchable' => true,
                'show_apply' => true,
                'max_display' => 5,
            ],
        ]);

        $component = new DropdownMulti($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('Custom Default Label', $options['label']);
        $this->assertStringContainsString('btn-success', $options['toggleClasses']);
        $this->assertTrue($options['searchable']);
        $this->assertTrue($options['showApply']);
        $this->assertSame(5, $options['maxDisplay']);
    }

    public function testGetComponentName(): void
    {
        $component = new DropdownMulti($this->config);
        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('dropdown_multi', $method->invoke($component));
    }

    public function testAutoCloseOption(): void
    {
        $component = new DropdownMulti($this->config);
        $component->autoClose = 'inside';
        $component->mount();
        $options = $component->options();

        $this->assertSame('inside', $options['toggleAttrs']['data-bs-auto-close']);
    }

    public function testActionLabels(): void
    {
        $component = new DropdownMulti($this->config);
        $component->selectAllLabel = 'Choose All';
        $component->clearLabel = 'Reset';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Choose All', $options['selectAllLabel']);
        $this->assertSame('Reset', $options['clearLabel']);
    }
}

