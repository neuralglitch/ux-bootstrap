<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractBootstrap;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * TreeView Component
 * 
 * Hierarchical tree structure for file browsers, category trees,
 * organization charts, and menu editors.
 */
#[AsTwigComponent(name: 'bs:tree-view', template: '@NeuralGlitchUxBootstrap/components/extra/tree-view.html.twig')]
final class TreeView extends AbstractBootstrap
{
    /**
     * Tree data structure
     * Each item should have: id, label, children (optional), icon (optional), expanded (optional)
     * 
     * @var array<int, array<string, mixed>>
     */
    public array $items = [];

    /**
     * Enable selection of nodes
     */
    public bool $selectable = false;

    /**
     * Allow multiple selection
     */
    public bool $multiSelect = false;

    /**
     * Show icons for nodes
     */
    public bool $showIcons = true;

    /**
     * Default icon for nodes without children
     */
    public string $defaultIcon = 'bi-file-earmark';

    /**
     * Default icon for nodes with children (collapsed)
     */
    public string $folderIcon = 'bi-folder';

    /**
     * Default icon for nodes with children (expanded)
     */
    public string $folderOpenIcon = 'bi-folder-open';

    /**
     * Show expand/collapse icons
     */
    public bool $showExpandIcons = true;

    /**
     * Icon for collapsed nodes
     */
    public string $expandIcon = 'bi-chevron-right';

    /**
     * Icon for expanded nodes
     */
    public string $collapseIcon = 'bi-chevron-down';

    /**
     * Expand all nodes by default
     */
    public bool $expandAll = false;

    /**
     * Collapse all nodes by default
     */
    public bool $collapseAll = false;

    /**
     * Enable keyboard navigation
     */
    public bool $keyboard = true;

    /**
     * Show lines connecting nodes
     */
    public bool $showLines = false;

    /**
     * Compact mode (less padding)
     */
    public bool $compact = false;

    /**
     * Hover effect on nodes
     */
    public bool $hoverable = true;

    /**
     * Custom item click handler (JavaScript function name)
     */
    public ?string $onItemClick = null;

    /**
     * Custom expand handler (JavaScript function name)
     */
    public ?string $onExpand = null;

    /**
     * Custom collapse handler (JavaScript function name)
     */
    public ?string $onCollapse = null;

    /**
     * Custom selection change handler (JavaScript function name)
     */
    public ?string $onSelectionChange = null;

    /**
     * Initially selected item IDs
     * 
     * @var array<string>
     */
    public array $selectedIds = [];

    public function mount(): void
    {
        $d = $this->config->for('tree_view');

        $this->applyClassDefaults($d);

        $this->selectable = $this->selectable || ($d['selectable'] ?? false);
        $this->multiSelect = $this->multiSelect || ($d['multi_select'] ?? false);
        $this->showIcons = $this->showIcons && ($d['show_icons'] ?? true);
        
        // Use null coalescing for icon properties to respect component-level changes
        if ($this->defaultIcon === 'bi-file-earmark') {
            $this->defaultIcon = $d['default_icon'] ?? $this->defaultIcon;
        }
        if ($this->folderIcon === 'bi-folder') {
            $this->folderIcon = $d['folder_icon'] ?? $this->folderIcon;
        }
        if ($this->folderOpenIcon === 'bi-folder-open') {
            $this->folderOpenIcon = $d['folder_open_icon'] ?? $this->folderOpenIcon;
        }
        
        $this->showExpandIcons = $this->showExpandIcons && ($d['show_expand_icons'] ?? true);
        
        // Use null coalescing for expand/collapse icon properties
        if ($this->expandIcon === 'bi-chevron-right') {
            $this->expandIcon = $d['expand_icon'] ?? $this->expandIcon;
        }
        if ($this->collapseIcon === 'bi-chevron-down') {
            $this->collapseIcon = $d['collapse_icon'] ?? $this->collapseIcon;
        }
        
        $this->expandAll = $this->expandAll || ($d['expand_all'] ?? false);
        $this->collapseAll = $this->collapseAll || ($d['collapse_all'] ?? false);
        $this->keyboard = $this->keyboard && ($d['keyboard'] ?? true);
        $this->showLines = $this->showLines || ($d['show_lines'] ?? false);
        $this->compact = $this->compact || ($d['compact'] ?? false);
        $this->hoverable = $this->hoverable && ($d['hoverable'] ?? true);

        // Process items to add default expanded state
        $this->items = $this->processItems($this->items);
    }

    protected function getComponentName(): string
    {
        return 'tree_view';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = $this->buildClasses(
            ['tree-view'],
            $this->showLines ? ['tree-view-lines'] : [],
            $this->compact ? ['tree-view-compact'] : [],
            $this->hoverable ? ['tree-view-hoverable'] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = $this->mergeAttributes(
            [
                'role' => 'tree',
                'aria-multiselectable' => $this->multiSelect ? 'true' : 'false',
            ],
            $this->attr
        );

        // Stimulus controller configuration
        $controllerAttrs = [
            'data-controller' => 'bs-tree-view',
            'data-bs-tree-view-selectable-value' => $this->selectable ? 'true' : 'false',
            'data-bs-tree-view-multi-select-value' => $this->multiSelect ? 'true' : 'false',
            'data-bs-tree-view-keyboard-value' => $this->keyboard ? 'true' : 'false',
        ];

        if ($this->onItemClick) {
            $controllerAttrs['data-bs-tree-view-on-item-click-value'] = $this->onItemClick;
        }
        if ($this->onExpand) {
            $controllerAttrs['data-bs-tree-view-on-expand-value'] = $this->onExpand;
        }
        if ($this->onCollapse) {
            $controllerAttrs['data-bs-tree-view-on-collapse-value'] = $this->onCollapse;
        }
        if ($this->onSelectionChange) {
            $controllerAttrs['data-bs-tree-view-on-selection-change-value'] = $this->onSelectionChange;
        }
        if (!empty($this->selectedIds)) {
            $controllerAttrs['data-bs-tree-view-selected-ids-value'] = json_encode($this->selectedIds);
        }

        $attrs = $this->mergeAttributes($attrs, $controllerAttrs);

        return [
            'classes' => $classes,
            'attrs' => $attrs,
            'items' => $this->items,
            'showIcons' => $this->showIcons,
            'defaultIcon' => $this->defaultIcon,
            'folderIcon' => $this->folderIcon,
            'folderOpenIcon' => $this->folderOpenIcon,
            'showExpandIcons' => $this->showExpandIcons,
            'expandIcon' => $this->expandIcon,
            'collapseIcon' => $this->collapseIcon,
            'selectable' => $this->selectable,
            'selectedIds' => $this->selectedIds,
        ];
    }

    /**
     * Process items to add default expanded state
     * 
     * @param array<int, array<string, mixed>> $items
     * @return array<int, array<string, mixed>>
     */
    private function processItems(array $items): array
    {
        return array_map(function (array $item): array {
            // Set expanded state if not explicitly set
            if (!isset($item['expanded'])) {
                if ($this->expandAll) {
                    $item['expanded'] = true;
                } elseif ($this->collapseAll) {
                    $item['expanded'] = false;
                } else {
                    // Default: expand first level only
                    $item['expanded'] = false;
                }
            }

            // Process children recursively
            if (isset($item['children']) && is_array($item['children'])) {
                $item['children'] = $this->processItems($item['children']);
            }

            return $item;
        }, $items);
    }
}

