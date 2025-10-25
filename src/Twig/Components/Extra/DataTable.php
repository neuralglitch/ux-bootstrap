<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:data-table', template: '@NeuralGlitchUxBootstrap/components/extra/data-table.html.twig')]
final class DataTable extends AbstractStimulus
{
    // Stimulus controller
    public string $stimulusController = 'bs-data-table';

    // Data
    /** @var array<int, array<string, mixed>> */
    public array $rows = [];

    /** @var array<int, array<string, mixed>> */
    public array $columns = [];

    // Table appearance
    public bool $striped = true;
    public bool $bordered = false;
    public bool $borderless = false;
    public bool $hover = true;
    public bool $small = false;
    public ?string $variant = null;        // 'primary' | 'secondary' | 'success' | 'danger' | 'warning' | 'info' | 'light' | 'dark'

    // Responsive behavior
    public bool $responsive = true;
    public ?string $responsiveBreakpoint = null;  // null | 'sm' | 'md' | 'lg' | 'xl' | 'xxl'

    // Table layout
    public ?string $captionText = null;
    public string $captionPosition = 'top';  // 'top' | 'bottom'
    public ?string $thead = null;           // 'light' | 'dark' | null
    public bool $divider = false;           // Add divider between thead and tbody

    // Sorting
    public bool $sortable = false;
    public ?string $sortedColumn = null;    // Column key currently sorted
    public string $sortDirection = 'asc';   // 'asc' | 'desc'
    public ?string $sortBaseUrl = null;     // Base URL for sort links

    // Selection
    public bool $selectable = false;
    public string $selectName = 'selected[]';
    public bool $selectAll = false;         // Show "select all" checkbox

    // Actions column
    public bool $showActions = false;
    public string $actionsLabel = 'Actions';
    public string $actionsPosition = 'end';  // 'start' | 'end'

    // Empty state
    public string $emptyMessage = 'No data available';
    public bool $showEmptyState = true;

    // Container
    public string $container = 'container-fluid';  // 'container' | 'container-fluid' | 'container-{breakpoint}' | null

    // Card wrapper
    public bool $cardWrapper = false;
    public ?string $cardTitle = null;
    public ?string $cardSubtitle = null;

    public function mount(): void
    {
        $d = $this->config->for('data-table');

        $this->applyStimulusDefaults($d);

        // Apply defaults
        $this->striped = $this->striped && ($d['striped'] ?? true);
        $this->bordered = $this->bordered || ($d['bordered'] ?? false);
        $this->borderless = $this->borderless || ($d['borderless'] ?? false);
        $this->hover = $this->hover && ($d['hover'] ?? true);
        $this->small = $this->small || ($d['small'] ?? false);
        $this->variant ??= $this->configString($d, 'variant');

        $this->responsive = $this->responsive && ($d['responsive'] ?? true);
        $this->responsiveBreakpoint ??= $this->configString($d, 'responsive_breakpoint');

        $this->captionPosition ??= $this->configStringWithFallback($d, 'caption_position', 'top');
        $this->thead ??= $this->configString($d, 'thead');
        $this->divider = $this->divider || ($d['divider'] ?? false);

        $this->sortable = $this->sortable || ($d['sortable'] ?? false);
        $this->sortDirection ??= $this->configStringWithFallback($d, 'sort_direction', 'asc');

        $this->selectable = $this->selectable || ($d['selectable'] ?? false);
        $this->selectName ??= $this->configStringWithFallback($d, 'select_name', 'selected[]');
        $this->selectAll = $this->selectAll || ($d['select_all'] ?? false);

        $this->showActions = $this->showActions || ($d['show_actions'] ?? false);

        // Only override actionsLabel if it's still the default value
        if ($this->actionsLabel === 'Actions' && isset($d['actions_label'])) {
            $this->actionsLabel = $this->configStringWithFallback($d, 'actions_label', 'Actions');
        }

        $this->actionsPosition ??= $this->configStringWithFallback($d, 'actions_position', 'end');

        // Only override emptyMessage if it's still the default value
        if ($this->emptyMessage === 'No data available' && isset($d['empty_message'])) {
            $this->emptyMessage = $this->configStringWithFallback($d, 'empty_message', 'No data available');
        }

        $this->showEmptyState = $this->showEmptyState && ($d['show_empty_state'] ?? true);

        $this->container ??= $this->configStringWithFallback($d, 'container', 'container-fluid');
        $this->cardWrapper = $this->cardWrapper || ($d['card_wrapper'] ?? false);

        // Initialize controller
        $this->initializeController();

        $this->applyClassDefaults($d);

        // Merge attr defaults
        if (isset($d['attr']) && is_array($d['attr'])) {
            $this->attr = array_merge($d['attr'], $this->attr);
        }
    }

    protected function getComponentName(): string
    {
        return 'data-table';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $tableClasses = $this->buildClassesFromArrays(
            ['table'],
            $this->striped ? ['table-striped'] : [],
            $this->bordered ? ['table-bordered'] : [],
            $this->borderless ? ['table-borderless'] : [],
            $this->hover ? ['table-hover'] : [],
            $this->small ? ['table-sm'] : [],
            $this->variant ? ["table-{$this->variant}"] : []
        );

        $responsiveClass = $this->responsive
            ? ($this->responsiveBreakpoint ? "table-responsive-{$this->responsiveBreakpoint}" : 'table-responsive')
            : null;

        $theadClass = $this->thead ? "table-{$this->thead}" : null;

        $containerClasses = $this->container
            ? $this->buildClasses([$this->container])
            : null;

        $wrapperClasses = $this->buildClasses(
            $this->class ? explode(' ', trim($this->class)) : []
        );

        // Build controller wrapper attributes (for Stimulus)
        $controllerAttrs = [
            'data-controller' => $this->stimulusController,
        ];

        $attrs = $this->mergeAttributes([], $this->attr);

        // Process columns for rendering
        $processedColumns = $this->processColumns();

        // Check if table has data
        $isEmpty = empty($this->rows);

        return [
            'rows' => $this->rows,
            'columns' => $processedColumns,
            'tableClasses' => $tableClasses,
            'responsiveClass' => $responsiveClass,
            'theadClass' => $theadClass,
            'containerClasses' => $containerClasses,
            'wrapperClasses' => $wrapperClasses,
            'controllerAttrs' => $controllerAttrs,
            'attrs' => $attrs,
            'captionText' => $this->captionText,
            'captionPosition' => $this->captionPosition,
            'divider' => $this->divider,
            'sortable' => $this->sortable,
            'sortedColumn' => $this->sortedColumn,
            'sortDirection' => $this->sortDirection,
            'sortBaseUrl' => $this->sortBaseUrl,
            'selectable' => $this->selectable,
            'selectName' => $this->selectName,
            'selectAll' => $this->selectAll,
            'showActions' => $this->showActions,
            'actionsLabel' => $this->actionsLabel,
            'actionsPosition' => $this->actionsPosition,
            'isEmpty' => $isEmpty,
            'emptyMessage' => $this->emptyMessage,
            'showEmptyState' => $this->showEmptyState,
            'cardWrapper' => $this->cardWrapper,
            'cardTitle' => $this->cardTitle,
            'cardSubtitle' => $this->cardSubtitle,
        ];
    }

    /**
     * Process columns for rendering - ensure they have required fields
     *
     * @return array<int, array<string, mixed>>
     */
    private function processColumns(): array
    {
        $processed = [];

        foreach ($this->columns as $column) {
            $processed[] = [
                'key' => $column['key'] ?? '',
                'label' => $column['label'] ?? ucfirst($this->configStringWithFallback($column, 'key')),
                'sortable' => $column['sortable'] ?? true,
                'class' => $column['class'] ?? null,
                'headerClass' => $column['headerClass'] ?? null,
                'align' => $column['align'] ?? null,  // 'start' | 'center' | 'end'
                'formatter' => $column['formatter'] ?? null,  // Callback for custom formatting
            ];
        }

        return $processed;
    }

    /**
     * Get sort URL for a column
     */
    public function getSortUrl(string $column): ?string
    {
        if (!$this->sortBaseUrl) {
            return null;
        }

        $direction = ($this->sortedColumn === $column && $this->sortDirection === 'asc') ? 'desc' : 'asc';
        $separator = str_contains($this->sortBaseUrl, '?') ? '&' : '?';

        return "{$this->sortBaseUrl}{$separator}sort={$column}&direction={$direction}";
    }

    /**
     * Get sort icon for a column
     */
    public function getSortIcon(string $column): string
    {
        if ($this->sortedColumn !== $column) {
            return '⇅';  // Both directions
        }

        return $this->sortDirection === 'asc' ? '↑' : '↓';
    }
}

