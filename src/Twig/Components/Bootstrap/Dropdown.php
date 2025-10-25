<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:dropdown', template: '@NeuralGlitchUxBootstrap/components/bootstrap/dropdown.html.twig')]
final class Dropdown extends AbstractStimulus
{
    use Traits\VariantTrait;
    use Traits\SizeTrait;

    public string $stimulusController = 'bs-dropdown';

    public ?string $label = null;
    public ?string $direction = null; // 'dropup' | 'dropend' | 'dropstart' | 'dropup-center' | 'dropdown-center'
    public ?string $menuAlign = null; // 'start' | 'end' | responsive like 'lg-end'
    public bool $dark = false;
    public bool $split = false;
    public ?string $splitLabel = null; // Label for main button in split mode
    public ?string $autoClose = null; // 'true' | 'false' | 'inside' | 'outside'
    public ?string $toggleClass = null;
    public ?string $menuClass = null;

    /**
     * @var array<string, mixed>
     */
    public array $menuAttr = [];

    public function mount(): void
    {
        $d = $this->config->for('dropdown');

        $this->applyStimulusDefaults($d);

        $this->applyVariantDefaults($d);
        $this->applySizeDefaults($d);
        $this->applyClassDefaults($d);

        $this->label ??= $this->configStringWithFallback($d, 'label', 'Dropdown');
        $this->direction ??= $this->configString($d, 'direction');
        $this->menuAlign ??= $this->configString($d, 'menu_align');
        $this->dark = $this->dark || $this->configBoolWithFallback($d, 'dark', false);
        $this->split = $this->split || $this->configBoolWithFallback($d, 'split', false);
        $this->splitLabel ??= $this->configString($d, 'split_label');
        $this->autoClose ??= $this->configString($d, 'auto_close');
        $this->toggleClass ??= $this->configString($d, 'toggle_class');
        $this->menuClass ??= $this->configString($d, 'menu_class');
        $this->menuAttr = array_merge($this->configArray($d, 'menu_attr', []) ?? [], $this->menuAttr);


        // Initialize controller with default
        $this->initializeController();
    }

    protected function getComponentName(): string
    {
        return 'dropdown';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        // Wrapper classes
        $wrapperClasses = array_merge(
            [$this->split ? 'btn-group' : 'dropdown'],
            $this->direction ? [$this->direction] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        // Toggle button classes
        $toggleClasses = array_merge(
            ['btn', 'dropdown-toggle'],
            $this->variant ? ($this->outline ? ["btn-outline-{$this->variant}"] : ["btn-{$this->variant}"]) : ['btn-secondary'],
            $this->sizeClassesFor('button'),
            $this->toggleClass ? explode(' ', trim($this->toggleClass)) : [],
            $this->split ? ['dropdown-toggle-split'] : []
        );

        // Menu classes
        $menuClasses = array_merge(
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

        // Wrapper attributes
        $wrapperAttrs = $this->mergeAttributes([], $this->attr);

        // Menu attributes
        $menuAttrs = $this->mergeAttributes([], $this->menuAttr);

        return [
            'label' => $this->label,
            'split' => $this->split,
            'splitLabel' => $this->splitLabel ?? $this->label,
            'wrapperClasses' => implode(' ', array_filter($wrapperClasses)),
            'toggleClasses' => implode(' ', array_filter($toggleClasses)),
            'menuClasses' => implode(' ', array_filter($menuClasses)),
            'wrapperAttrs' => $wrapperAttrs,
            'toggleAttrs' => $toggleAttrs,
            'menuAttrs' => $menuAttrs,
        ];
    }
}

