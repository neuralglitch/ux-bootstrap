<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:comparison-table', template: '@NeuralGlitchUxBootstrap/components/extra/comparison-table.html.twig')]
final class ComparisonTable extends AbstractStimulus
{
    // Layout
    public string $variant = 'default';    // 'default' | 'bordered' | 'striped' | 'cards' | 'horizontal'
    public bool $responsive = true;
    public string $container = 'container';

    // Columns/Products
    /** @var array<int, array<string, mixed>> */
    public array $columns = [];            // [{title: 'Free', badge: 'Popular', variant: 'primary', price: '$0', ...}]
    public int $highlightColumn = -1;      // Index of highlighted column (-1 = none)

    // Features/Rows
    /** @var array<int, array<string, mixed>> */
    public array $features = [];           // [{feature: 'Storage', values: ['10GB', '50GB', '100GB'], ...}]
    public bool $showCheckmarks = true;    // Use checkmarks for boolean values
    public ?string $checkIcon = null;      // Icon for checked/true values
    public ?string $uncheckIcon = null;    // Icon for unchecked/false values

    // Table options
    public bool $sticky = false;           // Sticky header on scroll
    public bool $centered = true;          // Center-align values
    public bool $hover = true;             // Hover effect on rows
    public ?string $emptyText = null;      // Text for empty/null values

    // Headings
    public ?string $title = null;
    public ?string $description = null;

    public function mount(): void
    {
        $d = $this->config->for('comparison-table');

        $this->applyStimulusDefaults($d);

        // Apply defaults
        $this->variant ??= $this->configStringWithFallback($d, 'variant', 'default');
        $this->responsive = $this->responsive && $this->configBoolWithFallback($d, 'responsive', true);
        $this->container ??= $this->configStringWithFallback($d, 'container', 'container');
        $this->highlightColumn = $this->highlightColumn !== -1 ? $this->highlightColumn : $this->configIntWithFallback($d, 'highlight_column', -1);
        $this->showCheckmarks = $this->showCheckmarks && $this->configBoolWithFallback($d, 'show_checkmarks', true);
        $this->checkIcon ??= $this->configStringWithFallback($d, 'check_icon', '✓');
        $this->uncheckIcon ??= $this->configStringWithFallback($d, 'uncheck_icon', '✗');
        $this->sticky = $this->sticky || $this->configBoolWithFallback($d, 'sticky', false);
        $this->centered = $this->centered && $this->configBoolWithFallback($d, 'centered', true);
        $this->hover = $this->hover && $this->configBoolWithFallback($d, 'hover', true);
        $this->emptyText ??= $this->configStringWithFallback($d, 'empty_text', '—');

        $this->applyClassDefaults($d);

        // Merge attr defaults
        if (isset($d['attr']) && is_array($d['attr'])) {
            $this->attr = array_merge($d['attr'], $this->attr);
        }

        // Initialize controller with default
        $this->initializeController();
    }

    protected function getComponentName(): string
    {
        return 'comparison-table';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = $this->buildClasses(
            ['py-5'],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $tableClasses = $this->buildClasses(
            ['table'],
            $this->variant === 'striped' ? ['table-striped'] : [],
            $this->variant === 'bordered' ? ['table-bordered'] : [],
            $this->hover && $this->variant !== 'cards' ? ['table-hover'] : []
        );

        $attrs = $this->mergeAttributes([], $this->attr);

        return [
            'variant' => $this->variant,
            'responsive' => $this->responsive,
            'container' => $this->container,
            'columns' => $this->columns,
            'highlightColumn' => $this->highlightColumn,
            'features' => $this->features,
            'showCheckmarks' => $this->showCheckmarks,
            'checkIcon' => $this->checkIcon,
            'uncheckIcon' => $this->uncheckIcon,
            'sticky' => $this->sticky,
            'centered' => $this->centered,
            'hover' => $this->hover,
            'emptyText' => $this->emptyText,
            'title' => $this->title,
            'description' => $this->description,
            'classes' => $classes,
            'tableClasses' => $tableClasses,
            'attrs' => $attrs,
        ];
    }
}

