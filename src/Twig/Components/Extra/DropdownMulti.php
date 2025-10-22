<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\SizeTrait;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\VariantTrait;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('bs:dropdown-multi', template: '@NeuralGlitchUxBootstrap/components/extra/dropdown-multi.html.twig')]
final class DropdownMulti extends AbstractStimulus
{
    use VariantTrait;
    use SizeTrait;

    // Stimulus controller
    public string $stimulusController = 'bs-dropdown-multi';

    // Label
    public ?string $label = null;
    public ?string $placeholder = null;

    // Options (array of items with value, label, selected properties)
    /**
     * @var array<int, array{value: string, label: string, selected?: bool, disabled?: bool, description?: string}>
     */
    public array $options = [];

    // Behavior
    public ?string $direction = null; // 'dropup' | 'dropend' | 'dropstart' | 'dropup-center' | 'dropdown-center'
    public ?string $menuAlign = null; // 'start' | 'end' | responsive like 'lg-end'
    public bool $dark = false;
    public ?string $autoClose = 'outside'; // 'true' | 'false' | 'inside' | 'outside'

    // Search
    public bool $searchable = false;
    public ?string $searchPlaceholder = null;
    public int $searchMinChars = 0;

    // Features
    public bool $showSelectAll = true;
    public bool $showClear = true;
    public bool $showApply = false;
    public ?string $selectAllLabel = null;
    public ?string $clearLabel = null;
    public ?string $applyLabel = null;

    // Display
    public bool $showCount = true;
    public ?string $countFormat = null; // e.g., '{count} selected'
    public bool $showChecks = true;
    public int $maxDisplay = 3; // Max items to show in button label

    // Form integration
    public ?string $name = null;
    public bool $required = false;

    // Styling
    public ?string $toggleClass = null;
    public ?string $menuClass = null;
    public ?string $maxHeight = null; // e.g., '300px'

    /**
     * @var array<string, mixed>
     */
    public array $menuAttr = [];

    public function mount(): void
    {
        $d = $this->config->for('dropdown-multi');

        $this->applyStimulusDefaults($d);

        $this->applyVariantDefaults($d);
        $this->applySizeDefaults($d);
        $this->applyClassDefaults($d);

        $this->label ??= $d['label'] ?? 'Select options';
        $this->placeholder ??= $d['placeholder'] ?? null;
        $this->direction ??= $d['direction'] ?? null;
        $this->menuAlign ??= $d['menu_align'] ?? null;
        $this->dark = $this->dark || ($d['dark'] ?? false);
        $this->autoClose ??= $d['auto_close'] ?? 'outside';

        $this->searchable = $this->searchable || ($d['searchable'] ?? false);
        $this->searchPlaceholder ??= $d['search_placeholder'] ?? 'Search...';
        $this->searchMinChars = $this->searchMinChars ?: ($d['search_min_chars'] ?? 0);

        $this->showSelectAll = $this->showSelectAll && ($d['show_select_all'] ?? true);
        $this->showClear = $this->showClear && ($d['show_clear'] ?? true);
        $this->showApply = $this->showApply || ($d['show_apply'] ?? false);
        $this->selectAllLabel ??= $d['select_all_label'] ?? 'Select All';
        $this->clearLabel ??= $d['clear_label'] ?? 'Clear';
        $this->applyLabel ??= $d['apply_label'] ?? 'Apply';

        $this->showCount = $this->showCount && ($d['show_count'] ?? true);
        $this->countFormat ??= $d['count_format'] ?? '{count} selected';
        $this->showChecks = $this->showChecks && ($d['show_checks'] ?? true);

        // Only apply default if not explicitly set
        if ($this->maxDisplay === 3) {
            $this->maxDisplay = $d['max_display'] ?? 3;
        }

        $this->name ??= $d['name'] ?? null;
        $this->required = $this->required || ($d['required'] ?? false);

        $this->toggleClass ??= $d['toggle_class'] ?? null;
        $this->menuClass ??= $d['menu_class'] ?? null;
        $this->maxHeight ??= $d['max_height'] ?? '300px';
        $this->menuAttr = array_merge($d['menu_attr'] ?? [], $this->menuAttr);

        // Initialize controller with default
        $this->initializeController();
    }

    protected function getComponentName(): string
    {
        return 'dropdown-multi';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        // Count selected items
        $selectedCount = count(array_filter($this->options, fn($opt) => $opt['selected'] ?? false));

        // Build button label
        $buttonLabel = $this->buildButtonLabel($selectedCount);

        // Wrapper classes
        $wrapperClasses = $this->buildClasses(
            ['dropdown'],
            $this->direction ? [$this->direction] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        // Toggle button classes
        $toggleClasses = $this->buildClasses(
            ['btn', 'dropdown-toggle'],
            $this->variant ? ($this->outline ? ["btn-outline-{$this->variant}"] : ["btn-{$this->variant}"]) : ['btn-secondary'],
            $this->sizeClassesFor('button'),
            $this->toggleClass ? explode(' ', trim($this->toggleClass)) : []
        );

        // Menu classes
        $menuClasses = $this->buildClasses(
            ['dropdown-menu'],
            $this->dark ? ['dropdown-menu-dark'] : [],
            $this->menuAlign ? ["dropdown-menu-{$this->menuAlign}"] : [],
            $this->menuClass ? explode(' ', trim($this->menuClass)) : []
        );

        // Toggle attributes
        $toggleAttrs = [
            'type' => 'button',
            'data-bs-toggle' => 'dropdown',
            'aria-expanded' => 'false',
        ];

        if ($this->autoClose !== null) {
            $toggleAttrs['data-bs-auto-close'] = $this->autoClose;
        }

        // Wrapper attributes (with controller)
        $wrapperAttrs = $this->mergeAttributes([
            'data-controller' => $this->stimulusController,
            'data-bs-dropdown-multi-name-value' => $this->name,
            'data-bs-dropdown-multi-show-apply-value' => $this->showApply ? 'true' : 'false',
            'data-bs-dropdown-multi-searchable-value' => $this->searchable ? 'true' : 'false',
            'data-bs-dropdown-multi-min-chars-value' => (string)$this->searchMinChars,
        ], $this->attr);

        // Menu attributes
        $menuAttrs = $this->mergeAttributes([], $this->menuAttr);

        // Menu style for max height
        if ($this->maxHeight) {
            $menuAttrs['style'] = ($menuAttrs['style'] ?? '') . ' max-height: ' . $this->maxHeight . '; overflow-y: auto;';
        }

        return [
            'label' => $this->label,
            'placeholder' => $this->placeholder,
            'buttonLabel' => $buttonLabel,
            'selectedCount' => $selectedCount,
            'options' => $this->options,
            'name' => $this->name,
            'required' => $this->required,

            'searchable' => $this->searchable,
            'searchPlaceholder' => $this->searchPlaceholder,
            'searchMinChars' => $this->searchMinChars,

            'showSelectAll' => $this->showSelectAll,
            'showClear' => $this->showClear,
            'showApply' => $this->showApply,
            'selectAllLabel' => $this->selectAllLabel,
            'clearLabel' => $this->clearLabel,
            'applyLabel' => $this->applyLabel,

            'showCount' => $this->showCount,
            'showChecks' => $this->showChecks,
            'maxDisplay' => $this->maxDisplay,
            'maxHeight' => $this->maxHeight,

            'wrapperClasses' => $wrapperClasses,
            'toggleClasses' => $toggleClasses,
            'menuClasses' => $menuClasses,
            'wrapperAttrs' => $wrapperAttrs,
            'toggleAttrs' => $toggleAttrs,
            'menuAttrs' => $menuAttrs,
        ];
    }

    private function buildButtonLabel(int $selectedCount): string
    {
        if ($selectedCount === 0) {
            return $this->placeholder ?? $this->label ?? 'Select options';
        }

        $selected = array_filter($this->options, fn($opt) => $opt['selected'] ?? false);
        $selectedValues = array_values($selected);

        if ($selectedCount <= $this->maxDisplay) {
            // Show individual labels
            $labels = array_map(fn($opt) => $opt['label'], $selectedValues);
            return implode(', ', $labels);
        }

        // Show count
        if ($this->showCount && $this->countFormat) {
            return str_replace('{count}', (string)$selectedCount, $this->countFormat);
        }

        return $selectedCount . ' selected';
    }
}

