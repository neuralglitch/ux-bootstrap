<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\TreeView;
use PHPUnit\Framework\TestCase;

final class TreeViewTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'tree_view' => [
                'selectable' => false,
                'multi_select' => false,
                'show_icons' => true,
                'default_icon' => 'bi-file-earmark',
                'folder_icon' => 'bi-folder',
                'folder_open_icon' => 'bi-folder-open',
                'show_expand_icons' => true,
                'expand_icon' => 'bi-chevron-right',
                'collapse_icon' => 'bi-chevron-down',
                'expand_all' => false,
                'collapse_all' => false,
                'keyboard' => true,
                'show_lines' => false,
                'compact' => false,
                'hoverable' => true,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new TreeView($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('tree-view', $options['classes']);
        $this->assertStringContainsString('tree-view-hoverable', $options['classes']);
        $this->assertArrayHasKey('attrs', $options);
        $this->assertSame('tree', $options['attrs']['role']);
    }

    public function testSelectableOption(): void
    {
        $component = new TreeView($this->config);
        $component->selectable = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['selectable']);
        $this->assertSame('true', $options['attrs']['data-bs-tree-view-selectable-value']);
    }

    public function testMultiSelectOption(): void
    {
        $component = new TreeView($this->config);
        $component->multiSelect = true;
        $component->mount();
        $options = $component->options();

        $this->assertSame('true', $options['attrs']['data-bs-tree-view-multi-select-value']);
        $this->assertSame('true', $options['attrs']['aria-multiselectable']);
    }

    public function testShowIconsOption(): void
    {
        $component = new TreeView($this->config);
        $component->showIcons = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['showIcons']);
        $this->assertSame('bi-file-earmark', $options['defaultIcon']);
        $this->assertSame('bi-folder', $options['folderIcon']);
        $this->assertSame('bi-folder-open', $options['folderOpenIcon']);
    }

    public function testCustomIconsOption(): void
    {
        $component = new TreeView($this->config);
        $component->defaultIcon = 'custom-file';
        $component->folderIcon = 'custom-folder';
        $component->folderOpenIcon = 'custom-folder-open';
        $component->mount();
        $options = $component->options();

        $this->assertSame('custom-file', $options['defaultIcon']);
        $this->assertSame('custom-folder', $options['folderIcon']);
        $this->assertSame('custom-folder-open', $options['folderOpenIcon']);
    }

    public function testExpandIconsOption(): void
    {
        $component = new TreeView($this->config);
        $component->showExpandIcons = true;
        $component->expandIcon = 'bi-plus';
        $component->collapseIcon = 'bi-minus';
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['showExpandIcons']);
        $this->assertSame('bi-plus', $options['expandIcon']);
        $this->assertSame('bi-minus', $options['collapseIcon']);
    }

    public function testKeyboardOption(): void
    {
        $component = new TreeView($this->config);
        $component->keyboard = true;
        $component->mount();
        $options = $component->options();

        $this->assertSame('true', $options['attrs']['data-bs-tree-view-keyboard-value']);
    }

    public function testCompactOption(): void
    {
        $component = new TreeView($this->config);
        $component->compact = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('tree-view-compact', $options['classes']);
    }

    public function testShowLinesOption(): void
    {
        $component = new TreeView($this->config);
        $component->showLines = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('tree-view-lines', $options['classes']);
    }

    public function testHoverableOption(): void
    {
        $component = new TreeView($this->config);
        $component->hoverable = false;
        $component->mount();
        $options = $component->options();

        $this->assertStringNotContainsString('tree-view-hoverable', $options['classes']);
    }

    public function testItemsProcessing(): void
    {
        $component = new TreeView($this->config);
        $component->items = [
            [
                'id' => '1',
                'label' => 'Parent',
                'children' => [
                    ['id' => '1-1', 'label' => 'Child 1'],
                    ['id' => '1-2', 'label' => 'Child 2'],
                ],
            ],
        ];
        $component->mount();
        $options = $component->options();

        $this->assertCount(1, $options['items']);
        $this->assertSame('Parent', $options['items'][0]['label']);
        $this->assertCount(2, $options['items'][0]['children']);
        $this->assertArrayHasKey('expanded', $options['items'][0]);
    }

    public function testExpandAllOption(): void
    {
        $component = new TreeView($this->config);
        $component->items = [
            [
                'id' => '1',
                'label' => 'Parent',
                'children' => [
                    ['id' => '1-1', 'label' => 'Child'],
                ],
            ],
        ];
        $component->expandAll = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['items'][0]['expanded']);
    }

    public function testCollapseAllOption(): void
    {
        $component = new TreeView($this->config);
        $component->items = [
            [
                'id' => '1',
                'label' => 'Parent',
                'children' => [
                    ['id' => '1-1', 'label' => 'Child'],
                ],
            ],
        ];
        $component->collapseAll = true;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['items'][0]['expanded']);
    }

    public function testSelectedIdsOption(): void
    {
        $component = new TreeView($this->config);
        $component->selectable = true;
        $component->selectedIds = ['1', '2', '3'];
        $component->mount();
        $options = $component->options();

        $this->assertSame(['1', '2', '3'], $options['selectedIds']);
        $this->assertArrayHasKey('data-bs-tree-view-selected-ids-value', $options['attrs']);
    }

    public function testCallbacksOption(): void
    {
        $component = new TreeView($this->config);
        $component->onItemClick = 'handleItemClick';
        $component->onExpand = 'handleExpand';
        $component->onCollapse = 'handleCollapse';
        $component->onSelectionChange = 'handleSelectionChange';
        $component->mount();
        $options = $component->options();

        $this->assertSame('handleItemClick', $options['attrs']['data-bs-tree-view-on-item-click-value']);
        $this->assertSame('handleExpand', $options['attrs']['data-bs-tree-view-on-expand-value']);
        $this->assertSame('handleCollapse', $options['attrs']['data-bs-tree-view-on-collapse-value']);
        $this->assertSame('handleSelectionChange', $options['attrs']['data-bs-tree-view-on-selection-change-value']);
    }

    public function testCustomClasses(): void
    {
        $component = new TreeView($this->config);
        $component->class = 'custom-class another-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-class', $options['classes']);
        $this->assertStringContainsString('another-class', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new TreeView($this->config);
        $component->attr = [
            'data-test' => 'value',
            'aria-label' => 'Tree navigation',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('value', $options['attrs']['data-test']);
        $this->assertSame('Tree navigation', $options['attrs']['aria-label']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'tree_view' => [
                'selectable' => true,
                'multi_select' => true,
                'show_icons' => false,
                'compact' => true,
                'hoverable' => false,
                'class' => 'default-class',
            ],
        ]);

        $component = new TreeView($config);
        $component->mount();
        $options = $component->options();

        $this->assertTrue($component->selectable);
        $this->assertTrue($component->multiSelect);
        $this->assertFalse($component->showIcons);
        $this->assertTrue($component->compact);
        $this->assertFalse($component->hoverable);
        $this->assertStringContainsString('default-class', $options['classes']);
    }

    public function testStimulusControllerAttribute(): void
    {
        $component = new TreeView($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('bs-tree-view', $options['attrs']['data-controller']);
    }

    public function testNestedItemsStructure(): void
    {
        $component = new TreeView($this->config);
        $component->items = [
            [
                'id' => '1',
                'label' => 'Level 1',
                'children' => [
                    [
                        'id' => '1-1',
                        'label' => 'Level 2',
                        'children' => [
                            ['id' => '1-1-1', 'label' => 'Level 3'],
                        ],
                    ],
                ],
            ],
        ];
        $component->mount();
        $options = $component->options();

        $this->assertCount(1, $options['items']);
        $this->assertCount(1, $options['items'][0]['children']);
        $this->assertCount(1, $options['items'][0]['children'][0]['children']);
        $this->assertSame('Level 3', $options['items'][0]['children'][0]['children'][0]['label']);
    }

    public function testEmptyItemsArray(): void
    {
        $component = new TreeView($this->config);
        $component->items = [];
        $component->mount();
        $options = $component->options();

        $this->assertSame([], $options['items']);
    }

    public function testItemsWithCustomIcons(): void
    {
        $component = new TreeView($this->config);
        $component->items = [
            [
                'id' => '1',
                'label' => 'File',
                'icon' => 'custom-icon',
            ],
        ];
        $component->mount();
        $options = $component->options();

        $this->assertSame('custom-icon', $options['items'][0]['icon']);
    }

    public function testCombinedOptions(): void
    {
        $component = new TreeView($this->config);
        $component->selectable = true;
        $component->multiSelect = true;
        $component->showLines = true;
        $component->compact = true;
        $component->keyboard = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('tree-view-lines', $options['classes']);
        $this->assertStringContainsString('tree-view-compact', $options['classes']);
        $this->assertSame('true', $options['attrs']['data-bs-tree-view-selectable-value']);
        $this->assertSame('true', $options['attrs']['data-bs-tree-view-multi-select-value']);
        $this->assertSame('true', $options['attrs']['data-bs-tree-view-keyboard-value']);
    }
}

