<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:list-group-item', template: '@NeuralGlitchUxBootstrap/components/bootstrap/list-group-item.html.twig')]
final class ListGroupItem extends AbstractInteractive
{
    use Traits\VariantTrait;

    public ?string $tag = null; // 'li' | 'a' | 'button'
    public ?string $href = null;
    public ?string $target = null;
    public ?string $rel = null;
    public bool $action = false;
    public bool $active = false;
    public bool $disabled = false;
    public ?string $label = null; // Optional: text content if not using blocks
    public ?string $ariaLabel = null;
    public ?string $ariaCurrent = null;

    public function mount(): void
    {
        $d = $this->config->for('list_group_item');

        $this->applyInteractiveDefaults($d);
        $this->applyClassDefaults($d);

        // Apply defaults from config
        $this->action = $this->action || $this->configBoolWithFallback($d, 'action', false);
        $this->active = $this->active || $this->configBoolWithFallback($d, 'active', false);
        $this->disabled = $this->disabled || $this->configBoolWithFallback($d, 'disabled', false);
        $this->target ??= $this->configString($d, 'target');
        $this->rel ??= $this->configString($d, 'rel');

        // Auto-determine tag if not specified
        if (null === $this->tag) {
            if ($this->href !== null) {
                $this->tag = 'a';


                // Initialize controller with default
                $this->initializeController();
            } elseif ($this->action) {
                $this->tag = 'button';
            } else {
                $this->tag = $this->configStringWithFallback($d, 'tag', 'li');
            }
        }

        // Auto-enable action class for links and buttons
        if (($this->tag === 'a' || $this->tag === 'button') && !$this->action) {
            $this->action = true;
        }

        // Set aria-current for active items
        if ($this->active && null === $this->ariaCurrent) {
            $this->ariaCurrent = 'true';
        }
    }

    protected function getComponentType(): string
    {
        return 'list-group-item';
    }

    protected function getComponentName(): string
    {
        return 'list_group_item';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = $this->buildClassesFromArrays(
            ['list-group-item'],
            $this->action ? ['list-group-item-action'] : [],
            $this->active ? ['active'] : [],
            $this->disabled ? ['disabled'] : [],
            $this->variantClassesFor('list-group-item'),
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = [];

        // Add href for links
        if ($this->tag === 'a' && $this->href !== null) {
            $attrs['href'] = $this->href;

            if ($this->target) {
                $attrs['target'] = $this->target;
            }

            if ($this->rel) {
                $attrs['rel'] = $this->rel;
            }
        }

        // Add button attributes
        if ($this->tag === 'button') {
            $attrs['type'] = 'button';
        }

        // Add disabled attributes
        if ($this->disabled) {
            if ($this->tag === 'button') {
                $attrs['disabled'] = true;
            } else {
                $attrs['aria-disabled'] = 'true';
            }
        }

        // Add aria-current for active items
        if ($this->ariaCurrent) {
            $attrs['aria-current'] = $this->ariaCurrent;
        }

        // Add aria-label if provided
        if ($this->ariaLabel) {
            $attrs['aria-label'] = $this->ariaLabel;
        }

        $attrs = $this->mergeAttributes($attrs, $this->buildInteractiveAttributes($this->tag === 'a' || $this->tag === 'button'));

        return [
            'tag' => $this->tag,
            'label' => $this->label,
            'classes' => $classes,
            'attrs' => $attrs,
        ];
    }
}

