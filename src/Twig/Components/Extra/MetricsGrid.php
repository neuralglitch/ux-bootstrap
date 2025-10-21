<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:metrics-grid', template: '@NeuralGlitchUxBootstrap/components/extra/metrics-grid.html.twig')]
final class MetricsGrid extends AbstractStimulus
{
    // Grid layout
    public int $columns = 4;              // Number of columns in desktop view (1-6)
    public string $gap = '4';             // Bootstrap gap class (0-5)
    public bool $equalHeight = true;      // Make all cards equal height
    
    // Metrics data - array of metric objects/arrays
    /**
     * @var array<int, array{
     *     value: string|int|float,
     *     label: string,
     *     variant?: string|null,
     *     icon?: string|null,
     *     iconPosition?: string,
     *     trend?: string|null,
     *     change?: string|null,
     *     description?: string|null,
     *     sparkline?: array<int, int|float>|null
     * }>
     */
    public array $metrics = [];
    
    // Global styling options (applied to all metrics)
    public ?string $cardVariant = null;
    public bool $cardBorder = false;
    public bool $cardShadow = false;
    public ?string $size = null;          // 'sm' | 'default' | 'lg'
    public ?string $textAlign = null;     // 'start' | 'center' | 'end'
    
    // Sparkline options (when enabled)
    public bool $showSparklines = false;
    public string $sparklineColor = 'primary';
    public int $sparklineHeight = 40;
    
    // Responsive breakpoints for columns
    public ?int $columnsSm = null;        // Small devices (≥576px)
    public ?int $columnsMd = null;        // Medium devices (≥768px)
    public ?int $columnsLg = null;        // Large devices (≥992px)
    public ?int $columnsXl = null;        // Extra large devices (≥1200px)
    public ?int $columnsXxl = null;       // Extra extra large devices (≥1400px)
    
    public function mount(): void
    {
        $d = $this->config->for('metrics_grid');

        $this->applyStimulusDefaults($d);
        
        // Apply base class defaults
        $this->applyClassDefaults($d);
        
        // Apply component-specific defaults
        // For non-nullable properties, check against default value
        if ($this->columns === 4 && isset($d['columns'])) {
            $this->columns = $d['columns'];

        
        // Initialize controller with default
        $this->initializeController();
    }
        if ($this->gap === '4' && isset($d['gap'])) {
            $this->gap = $d['gap'];
        }
        $this->equalHeight = $this->equalHeight && ($d['equal_height'] ?? true);
        $this->cardVariant ??= $d['card_variant'] ?? null;
        $this->cardBorder = $this->cardBorder || ($d['card_border'] ?? false);
        $this->cardShadow = $this->cardShadow || ($d['card_shadow'] ?? false);
        $this->size ??= $d['size'] ?? 'default';
        $this->textAlign ??= $d['text_align'] ?? 'start';
        $this->showSparklines = $this->showSparklines || ($d['show_sparklines'] ?? false);
        $this->sparklineColor ??= $d['sparkline_color'] ?? 'primary';
        if ($this->sparklineHeight === 40 && isset($d['sparkline_height'])) {
            $this->sparklineHeight = $d['sparkline_height'];
        }
        
        // Responsive columns
        $this->columnsSm ??= $d['columns_sm'] ?? null;
        $this->columnsMd ??= $d['columns_md'] ?? null;
        $this->columnsLg ??= $d['columns_lg'] ?? null;
        $this->columnsXl ??= $d['columns_xl'] ?? null;
        $this->columnsXxl ??= $d['columns_xxl'] ?? null;
    }
    
    protected function getComponentName(): string
    {
        return 'metrics_grid';
    }
    
    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        // Ensure columns is within valid range
        $columns = max(1, min(6, $this->columns));
        
        // Build responsive column classes
        $colClasses = [];
        
        // Base columns (mobile first)
        $colClasses[] = 'col-12'; // Mobile: full width
        
        // Small devices
        if ($this->columnsSm !== null) {
            $colsSm = max(1, min(6, $this->columnsSm));
            $colClasses[] = "col-sm-" . (12 / $colsSm);
        }
        
        // Medium devices (default breakpoint for 2 columns)
        if ($this->columnsMd !== null) {
            $colsMd = max(1, min(6, $this->columnsMd));
            $colClasses[] = "col-md-" . (12 / $colsMd);
        } else {
            // Default: 2 columns on medium
            $colClasses[] = 'col-md-6';
        }
        
        // Large devices (default breakpoint for specified columns)
        if ($this->columnsLg !== null) {
            $colsLg = max(1, min(6, $this->columnsLg));
            $colClasses[] = "col-lg-" . (12 / $colsLg);
        } else {
            // Use main columns property for large and up
            $colClasses[] = "col-lg-" . (12 / $columns);
        }
        
        // Extra large devices
        if ($this->columnsXl !== null) {
            $colsXl = max(1, min(6, $this->columnsXl));
            $colClasses[] = "col-xl-" . (12 / $colsXl);
        }
        
        // Extra extra large devices
        if ($this->columnsXxl !== null) {
            $colsXxl = max(1, min(6, $this->columnsXxl));
            $colClasses[] = "col-xxl-" . (12 / $colsXxl);
        }
        
        // Build container classes
        $containerClasses = $this->buildClasses(
            ['metrics-grid'],
            $this->class ? explode(' ', trim($this->class)) : []
        );
        
        // Build row classes
        $rowClasses = $this->buildClasses(
            ['row'],
            ["g-{$this->gap}"],
            $this->equalHeight ? ['row-cols-auto'] : []
        );
        
        // Build card classes (applied to all metric cards)
        $cardClasses = $this->buildClasses(
            ['card', 'metric-card'],
            $this->equalHeight ? ['h-100'] : [],
            $this->cardBorder ? ['border'] : ['border-0'],
            $this->cardShadow ? ['shadow-sm'] : [],
            $this->cardVariant ? ["border-{$this->cardVariant}"] : []
        );
        
        // Build card body classes
        $bodyClasses = $this->buildClasses(
            ['card-body'],
            $this->size === 'sm' ? ['p-3'] : ($this->size === 'lg' ? ['p-4'] : []),
            $this->textAlign !== 'start' ? ["text-{$this->textAlign}"] : []
        );
        
        // Process metrics data
        $processedMetrics = [];
        foreach ($this->metrics as $metric) {
            $processedMetrics[] = $this->processMetric($metric);
        }
        
        $attrs = $this->mergeAttributes([], $this->attr);
        
        return [
            'containerClasses' => $containerClasses,
            'rowClasses' => $rowClasses,
            'colClasses' => implode(' ', $colClasses),
            'cardClasses' => $cardClasses,
            'bodyClasses' => $bodyClasses,
            'metrics' => $processedMetrics,
            'showSparklines' => $this->showSparklines,
            'sparklineColor' => $this->sparklineColor,
            'sparklineHeight' => $this->sparklineHeight,
            'size' => $this->size,
            'textAlign' => $this->textAlign,
            'attrs' => $attrs,
        ];
    }
    
    /**
     * Process individual metric data and apply defaults
     *
     * @param array<string, mixed> $metric
     * @return array<string, mixed>
     */
    private function processMetric(array $metric): array
    {
        // Extract metric properties with defaults
        $value = $metric['value'] ?? '0';
        $label = $metric['label'] ?? 'Metric';
        $variant = $metric['variant'] ?? $this->cardVariant;
        $icon = $metric['icon'] ?? null;
        $iconPosition = $metric['iconPosition'] ?? 'start';
        $trend = $metric['trend'] ?? null;
        $change = $metric['change'] ?? null;
        $description = $metric['description'] ?? null;
        $sparkline = $metric['sparkline'] ?? null;
        
        // Build value classes
        $valueClasses = $this->buildClasses(
            ['metric-value', 'fs-2', 'fw-bold', 'mb-1'],
            $variant ? ["text-{$variant}"] : [],
            $this->size === 'sm' ? ['fs-4'] : ($this->size === 'lg' ? ['fs-1'] : [])
        );
        
        // Build label classes
        $labelClasses = $this->buildClasses(
            ['metric-label', 'text-muted', 'mb-0'],
            $this->size === 'sm' ? ['small'] : []
        );
        
        // Build icon classes
        $iconClasses = [];
        if ($icon) {
            $iconClasses = $this->buildClasses(
                ['metric-icon'],
                $variant ? ["text-{$variant}"] : ['text-muted'],
                $iconPosition === 'top' ? ['mb-2', 'fs-1'] : ($iconPosition === 'end' ? ['ms-2'] : ['me-2']),
                $this->size === 'sm' ? ['fs-5'] : ($this->size === 'lg' ? ['fs-1'] : ['fs-3'])
            );
        }
        
        // Build trend data
        $trendData = null;
        if ($trend) {
            $trendVariant = match ($trend) {
                'up' => 'success',
                'down' => 'danger',
                'neutral' => 'secondary',
                default => 'secondary',
            };
            
            $trendIcon = match ($trend) {
                'up' => '↑',
                'down' => '↓',
                'neutral' => '→',
                default => '→',
            };
            
            $trendClasses = $this->buildClasses(
                ['metric-trend', 'badge', "text-bg-{$trendVariant}", 'ms-2'],
                $this->size === 'sm' ? ['badge-sm'] : []
            );
            
            $trendData = [
                'variant' => $trendVariant,
                'icon' => $trendIcon,
                'classes' => $trendClasses,
            ];
        }
        
        // Build description classes
        $descriptionClasses = $this->buildClasses(
            ['metric-description', 'text-muted', 'small', 'mt-1']
        );
        
        // Process sparkline data
        $sparklineData = null;
        if ($this->showSparklines && $sparkline && is_array($sparkline)) {
            $sparklineData = [
                'values' => $sparkline,
                'color' => $this->sparklineColor,
                'height' => $this->sparklineHeight,
            ];
        }
        
        return [
            'value' => $value,
            'label' => $label,
            'variant' => $variant,
            'icon' => $icon,
            'iconPosition' => $iconPosition,
            'trend' => $trend,
            'change' => $change,
            'description' => $description,
            'valueClasses' => $valueClasses,
            'labelClasses' => $labelClasses,
            'iconClasses' => $iconClasses,
            'trendData' => $trendData,
            'descriptionClasses' => $descriptionClasses,
            'sparkline' => $sparklineData,
        ];
    }
}

