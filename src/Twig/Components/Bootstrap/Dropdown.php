<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:dropdown', template: '@NeuralGlitchUxBootstrap/components/bootstrap/dropdown.html.twig')]
final class Dropdown extends AbstractBootstrap
{
    use Traits\VariantTrait;
    use Traits\SizeTrait;

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

        $this->applyVariantDefaults($d);
        $this->applySizeDefaults($d);
        $this->applyClassDefaults($d);

        $this->label ??= $d['label'] ?? 'Dropdown';
        $this->direction ??= $d['direction'] ?? null;
        $this->menuAlign ??= $d['menu_align'] ?? null;
        $this->dark = $this->dark || ($d['dark'] ?? false);
        $this->split = $this->split || ($d['split'] ?? false);
        $this->splitLabel ??= $d['split_label'] ?? null;
        $this->autoClose ??= $d['auto_close'] ?? null;
        $this->toggleClass ??= $d['toggle_class'] ?? null;
        $this->menuClass ??= $d['menu_class'] ?? null;
        $this->menuAttr = array_merge($d['menu_attr'] ?? [], $this->menuAttr);
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
        $wrapperClasses = $this->buildClasses(
            [$this->split ? 'btn-group' : 'dropdown'],
            $this->direction ? [$this->direction] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        // Toggle button classes
        $toggleClasses = $this->buildClasses(
            ['btn', 'dropdown-toggle'],
            $this->variant ? ($this->outline ? ["btn-outline-{$this->variant}"] : ["btn-{$this->variant}"]) : ['btn-secondary'],
            $this->sizeClassesFor('button'),
            $this->toggleClass ? explode(' ', trim($this->toggleClass)) : [],
            $this->split ? ['dropdown-toggle-split'] : []
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

        // Wrapper attributes
        $wrapperAttrs = $this->mergeAttributes([], $this->attr);

        // Menu attributes
        $menuAttrs = $this->mergeAttributes([], $this->menuAttr);

        return [
            'label' => $this->label,
            'split' => $this->split,
            'splitLabel' => $this->splitLabel ?? $this->label,
            'wrapperClasses' => $wrapperClasses,
            'toggleClasses' => $toggleClasses,
            'menuClasses' => $menuClasses,
            'wrapperAttrs' => $wrapperAttrs,
            'toggleAttrs' => $toggleAttrs,
            'menuAttrs' => $menuAttrs,
        ];
    }
}

