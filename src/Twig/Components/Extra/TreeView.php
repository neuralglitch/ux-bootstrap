<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\FilesystemAdapter;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * TreeView Component
 *
 * Hierarchical tree structure for file browsers, category trees,
 * organization charts, and menu editors.
 */
#[AsTwigComponent(name: 'bs:tree-view', template: '@NeuralGlitchUxBootstrap/components/extra/tree-view.html.twig')]
final class TreeView extends AbstractStimulus
{
    public string $stimulusController = 'bs-tree-view';

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

    /**
     * Filesystem integration
     * @var string|null
     */
    public ?string $filesystemPath = null;
    
    /**
     * Filesystem path (alternative property name for Twig binding)
     * @var string|null
     */
    public ?string $path = null;
    
    /**
     * Simple path property for testing
     * @var string|null
     */
    public ?string $src = null;

    /**
     * Directories to exclude from filesystem tree
     *
     * @var array<string>
     */
    public array $excludeDirs = ['.git', 'node_modules', 'vendor', '.idea', '.vscode'];

    /**
     * Files to exclude from filesystem tree
     *
     * @var array<string>
     */
    public array $excludeFiles = ['.DS_Store', 'Thumbs.db', '.gitignore'];

    /**
     * Maximum directory depth for filesystem tree (0 = unlimited)
     */
    public int $maxDepth = 0;

    /**
     * Show file sizes in filesystem tree
     */
    public bool $showFileSizes = false;

    /**
     * Show file permissions in filesystem tree
     */
    public bool $showPermissions = false;

    /**
     * Show file modification dates in filesystem tree
     */
    public bool $showModified = false;

    /**
     * @param array<string>|null $excludeDirs
     * @param array<string>|null $excludeFiles
     */
    public function mount(
        ?string $filesystemPath = null,
        ?string $path = null,
        ?string $src = null,
        ?array $excludeDirs = null,
        ?array $excludeFiles = null,
        ?int $maxDepth = null,
    ): void {
        // Override properties with mount parameters if provided
        if ($filesystemPath !== null) {
            $this->filesystemPath = $filesystemPath;
        }
        if ($path !== null) {
            $this->path = $path;
        }
        if ($src !== null) {
            $this->src = $src;
        }
        if ($excludeDirs !== null) {
            $this->excludeDirs = $excludeDirs;
        }
        if ($excludeFiles !== null) {
            $this->excludeFiles = $excludeFiles;
        }
        if ($maxDepth !== null) {
            $this->maxDepth = $maxDepth;
        }

        // Debug: Check if filesystemPath is set from template
        
        $d = $this->config->for('tree-view');

        $this->applyStimulusDefaults($d);

        $this->applyClassDefaults($d);

        // Apply boolean config - only if not already set manually
        if (isset($d['selectable']) && $this->selectable === false) {
            $this->selectable = $this->configBoolWithFallback($d, 'selectable', false);
        }
        if (isset($d['multi_select']) && $this->multiSelect === false) {
            $this->multiSelect = $this->configBoolWithFallback($d, 'multi_select', false);
        }
        if (isset($d['show_icons']) && $this->showIcons === true) {
            $this->showIcons = $this->configBoolWithFallback($d, 'show_icons', true);
        }

        // Use null coalescing for icon properties to respect component-level changes
        if ($this->defaultIcon === 'bi-file-earmark') {
            $this->defaultIcon = $this->configStringWithFallback($d, 'default_icon', 'bi-file-earmark');
        }
        if ($this->folderIcon === 'bi-folder') {
            $this->folderIcon = $this->configStringWithFallback($d, 'folder_icon', 'bi-folder');
        }
        if ($this->folderOpenIcon === 'bi-folder-open') {
            $this->folderOpenIcon = $this->configStringWithFallback($d, 'folder_open_icon', 'bi-folder-open');
        }

        $this->showExpandIcons = $this->showExpandIcons && ($d['show_expand_icons'] ?? true);

        // Use null coalescing for expand/collapse icon properties
        if ($this->expandIcon === 'bi-chevron-right') {
            $this->expandIcon = $this->configStringWithFallback($d, 'expand_icon', 'bi-chevron-right');
        }
        if ($this->collapseIcon === 'bi-chevron-down') {
            $this->collapseIcon = $this->configStringWithFallback($d, 'collapse_icon', 'bi-chevron-down');
        }

        // Apply other boolean configs - only if not already set manually
        if (isset($d['expand_all']) && $this->expandAll === false) {
            $this->expandAll = $this->configBoolWithFallback($d, 'expand_all', false);
        }
        if (isset($d['collapse_all']) && $this->collapseAll === false) {
            $this->collapseAll = $this->configBoolWithFallback($d, 'collapse_all', false);
        }
        if (isset($d['keyboard']) && $this->keyboard === true) {
            $this->keyboard = $this->configBoolWithFallback($d, 'keyboard', true);
        }
        if (isset($d['show_lines']) && $this->showLines === false) {
            $this->showLines = $this->configBoolWithFallback($d, 'show_lines', false);
        }
        if (isset($d['compact']) && $this->compact === false) {
            $this->compact = $this->configBoolWithFallback($d, 'compact', false);
        }
        if (isset($d['hoverable']) && $this->hoverable === true) {
            $this->hoverable = $this->configBoolWithFallback($d, 'hoverable', true);
        }

        // Handle filesystem integration
        // Use either filesystemPath, path, or src property
        $path = $this->filesystemPath ?? $this->path ?? $this->src;
        
        if ($path) {
            $this->loadFilesystemTreeFromPath($path);
        } else {
            // Process items to add default expanded state
            $this->items = $this->processItems($this->items);
        }
    }

    protected function getComponentName(): string
    {
        return 'tree-view';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = array_merge(
            ['tree-view'],
            $this->showLines ? ['tree-view-lines'] : [],
            $this->compact ? ['tree-view-compact'] : [],
            $this->hoverable ? ['tree-view-hoverable'] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );
        $classes = implode(' ', array_filter($classes));

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
            'showFileSizes' => $this->showFileSizes,
            'showPermissions' => $this->showPermissions,
            'showModified' => $this->showModified,
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
                /** @var array<int, array<string, mixed>> $children */
                $children = $item['children'];
                $item['children'] = $this->processItems($children);
            }

            return $item;
        }, $items);
    }

    /**
     * Load filesystem tree from a specific path
     */
    private function loadFilesystemTreeFromPath(string $path): void
    {
        $adapter = new FilesystemAdapter();
        $treeData = $adapter->buildTree(
            $path,
            $this->excludeDirs,
            $this->excludeFiles,
            $this->maxDepth
        );

        // Process filesystem data to match tree view format
        // buildTree returns array with root item, we need to get its children
        $rootItem = $treeData[0] ?? null;
        if ($rootItem && isset($rootItem['children'])) {
            /** @var array<int, array<string, mixed>> $children */
            $children = $rootItem['children'];
            $this->items = $this->processFilesystemItems($children);
        } else {
            $this->items = [];
        }
    }

    /**
     * Process filesystem items to match tree view format
     *
     * @param array<int, array<string, mixed>> $items
     * @return array<int, array<string, mixed>>
     */
    private function processFilesystemItems(array $items): array
    {
        $adapter = new FilesystemAdapter();
        
        return array_map(function (array $item) use ($adapter): array {
            // Set expanded state
            if (!isset($item['expanded'])) {
                $item['expanded'] = $this->expandAll;
            }

            // Add file metadata as separate fields
            if ($item['type'] === 'file' && ($this->showFileSizes || $this->showPermissions || $this->showModified)) {
                if ($this->showFileSizes && is_int($item['size'])) {
                    $item['size'] = $adapter->formatFileSize($item['size']);
                }
                
                if ($this->showPermissions) {
                    $item['permissions'] = $item['permissions'];
                }
                
                if ($this->showModified && $item['modified'] instanceof \DateTime) {
                    $item['modified'] = $item['modified']->format('Y-m-d H:i');
                }
            }

            // Process children recursively
            if (isset($item['children']) && is_array($item['children'])) {
                /** @var array<int, array<string, mixed>> $children */
                $children = $item['children'];
                $item['children'] = $this->processFilesystemItems($children);
            }

            return $item;
        }, $items);
    }
}

