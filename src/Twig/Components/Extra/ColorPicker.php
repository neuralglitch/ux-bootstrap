<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractBootstrap;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:color-picker', template: '@NeuralGlitchUxBootstrap/components/extra/color-picker.html.twig')]
final class ColorPicker extends AbstractBootstrap
{
    public ?string $name = null;
    public ?string $value = null;
    public ?string $label = null;
    public bool $required = false;
    public bool $disabled = false;
    
    /**
     * Array of preset colors to display
     * Example: ['#FF0000', '#00FF00', '#0000FF']
     *
     * @var array<string>
     */
    public array $presets = [];
    
    public bool $showPresets = true;
    public bool $showInput = true;
    public bool $showHex = true;
    public bool $allowCustom = true;
    
    public ?string $size = null; // 'sm', 'default', 'lg'
    public ?string $swatchSize = null; // 'sm', 'default', 'lg'
    public int $columns = 0; // Number of columns for preset grid
    
    public ?string $placeholder = null;
    public ?string $helpText = null;
    public bool $inline = false;
    
    /**
     * @var array<string, mixed>
     */
    public array $inputAttr = [];

    public function mount(): void
    {
        $d = $this->config->for('color_picker');

        $this->applyClassDefaults($d);

        // Apply defaults
        $this->name ??= $d['name'] ?? 'color';
        $this->value ??= $d['value'] ?? null;
        $this->label ??= $d['label'] ?? null;
        $this->required = $this->required || ($d['required'] ?? false);
        $this->disabled = $this->disabled || ($d['disabled'] ?? false);
        
        if (empty($this->presets) && isset($d['presets']) && is_array($d['presets'])) {
            $this->presets = $d['presets'];
        }
        
        $this->showPresets = $this->showPresets && ($d['show_presets'] ?? true);
        $this->showInput = $this->showInput && ($d['show_input'] ?? true);
        $this->showHex = $this->showHex && ($d['show_hex'] ?? true);
        $this->allowCustom = $this->allowCustom && ($d['allow_custom'] ?? true);
        
        $this->size ??= $d['size'] ?? 'default';
        $this->swatchSize ??= $d['swatch_size'] ?? 'default';
        $this->columns = $this->columns ?: ($d['columns'] ?? 6);
        
        $this->placeholder ??= $d['placeholder'] ?? null;
        $this->helpText ??= $d['help_text'] ?? null;
        $this->inline = $this->inline || ($d['inline'] ?? false);
        
        if (empty($this->inputAttr) && isset($d['input_attr']) && is_array($d['input_attr'])) {
            $this->inputAttr = $d['input_attr'];
        }
    }

    protected function getComponentName(): string
    {
        return 'color_picker';
    }

    public function options(): array
    {
        $classes = $this->buildClasses(
            ['color-picker'],
            $this->inline ? ['d-inline-flex', 'align-items-center', 'gap-2'] : ['mb-3'],
            $this->size !== 'default' ? ["color-picker-{$this->size}"] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = $this->mergeAttributes([], $this->attr);
        
        // Input classes
        $inputClasses = ['form-control', 'color-picker-input'];
        if ($this->size === 'sm') {
            $inputClasses[] = 'form-control-sm';
        } elseif ($this->size === 'lg') {
            $inputClasses[] = 'form-control-lg';
        }
        
        // Swatch size classes
        $swatchClasses = ['color-picker-swatch'];
        if ($this->swatchSize === 'sm') {
            $swatchClasses[] = 'color-picker-swatch-sm';
        } elseif ($this->swatchSize === 'lg') {
            $swatchClasses[] = 'color-picker-swatch-lg';
        }
        
        // Build input attributes
        $inputAttrs = $this->mergeAttributes(
            [
                'type' => 'text',
                'id' => $this->name,
                'name' => $this->name,
                'value' => $this->value,
                'placeholder' => $this->placeholder,
                'required' => $this->required ? true : null,
                'disabled' => $this->disabled ? true : null,
                'pattern' => $this->showHex ? '^#[0-9A-Fa-f]{6}$' : null,
            ],
            $this->inputAttr
        );

        return [
            'classes' => $classes,
            'attrs' => $attrs,
            'inputClasses' => implode(' ', $inputClasses),
            'inputAttrs' => $inputAttrs,
            'swatchClasses' => implode(' ', $swatchClasses),
            'label' => $this->label,
            'name' => $this->name,
            'value' => $this->value,
            'required' => $this->required,
            'disabled' => $this->disabled,
            'presets' => $this->presets,
            'showPresets' => $this->showPresets && !empty($this->presets),
            'showInput' => $this->showInput,
            'showHex' => $this->showHex,
            'allowCustom' => $this->allowCustom,
            'columns' => $this->columns,
            'helpText' => $this->helpText,
            'inline' => $this->inline,
        ];
    }
}

