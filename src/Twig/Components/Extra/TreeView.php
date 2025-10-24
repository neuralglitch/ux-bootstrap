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
        dump('TreeView mount() called');
        dump('TreeView: filesystemPath after mount = ' . var_export($this->filesystemPath, true));
        dump('TreeView: path after mount = ' . var_export($this->path, true));
        dump('TreeView: src after mount = ' . var_export($this->src, true));
        
        $d = $this->config->for('tree_view');

        $this->applyStimulusDefaults($d);

        $this->applyClassDefaults($d);

        $this->selectable = $this->selectable || ($d['selectable'] ?? false);
        $this->multiSelect = $this->multiSelect || ($d['multi_select'] ?? false);
        $this->showIcons = $this->showIcons && ($d['show_icons'] ?? true);

        // Use null coalescing for icon properties to respect component-level changes
        if ($this->defaultIcon === 'bi-file-earmark') {
            $this->defaultIcon = $d['default_icon'] ?? $this->defaultIcon;


            // Initialize controller with default
            $this->initializeController();
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

        // Handle filesystem integration
        dump('TreeView mount() called');
        dump('TreeView: filesystemPath = ' . var_export($this->filesystemPath, true));
        dump('TreeView: path = ' . var_export($this->path, true));
        dump('TreeView: excludeDirs = ' . var_export($this->excludeDirs, true));
        dump('TreeView: excludeFiles = ' . var_export($this->excludeFiles, true));
        dump('TreeView: maxDepth = ' . var_export($this->maxDepth, true));
        
        // Use either filesystemPath, path, or src property
        $path = $this->filesystemPath ?? $this->path ?? $this->src;
        
        // Hardcode path for testing
        if (!$path) {
            $path = 'vendor/neuralglitch/ux-bootstrap';
            dump('TreeView: Using hardcoded path for testing: ' . $path);
        }
        
        if ($path) {
            dump('TreeView: Loading filesystem tree from: ' . $path);
            $this->loadFilesystemTreeFromPath($path);
            dump('TreeView: Loaded ' . count($this->items) . ' items');
        } else {
            dump('TreeView: No path provided, items count = ' . count($this->items));
            // Process items to add default expanded state
            $this->items = $this->processItems($this->items);
        }
        dump($this->items);
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
                $item['children'] = $this->processItems($item['children']);
            }

            return $item;
        }, $items);
    }

    /**
     * Load tree structure from filesystem
     */
    private function loadFilesystemTree(): void
    {
        $adapter = new FilesystemAdapter();
        $treeData = $adapter->buildTree(
            $this->filesystemPath,
            $this->excludeDirs,
            $this->excludeFiles,
            $this->maxDepth
        );

        // Process filesystem data to match tree view format
        $this->items = $this->processFilesystemItems($treeData);
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
        $this->items = $this->processFilesystemItems($treeData);
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
                if ($this->showFileSizes) {
                    $item['size'] = $adapter->formatFileSize($item['size']);
                }
                
                if ($this->showPermissions) {
                    $item['permissions'] = $item['permissions'];
                }
                
                if ($this->showModified && $item['modified']) {
                    $item['modified'] = $item['modified']->format('Y-m-d H:i');
                }
            }

            // Process children recursively
            if (isset($item['children']) && is_array($item['children'])) {
                $item['children'] = $this->processFilesystemItems($item['children']);
            }

            return $item;
        }, $items);
    }
}

