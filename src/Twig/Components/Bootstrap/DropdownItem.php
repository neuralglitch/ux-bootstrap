<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:dropdown-item', template: '@NeuralGlitchUxBootstrap/components/bootstrap/dropdown-item.html.twig')]
final class DropdownItem extends AbstractInteraction
{
    public ?string $href = null;
    public ?string $target = null;
    public ?string $rel = null;
    public bool $active = false;
    public bool $disabled = false;
    public ?string $tag = null;

    public function mount(): void
    {
        $d = $this->config->for('dropdown_item');

        $this->applyCommonDefaults($d);

        // Apply class defaults
        if (isset($d['class']) && is_string($d['class']) && trim($d['class'])) {
            $this->class = trim($this->class . ' ' . $d['class']);
        }

        $this->label ??= $d['label'] ?? null;
        $this->href ??= $d['href'] ?? null;
        $this->target ??= $d['target'] ?? null;
        $this->rel ??= $d['rel'] ?? null;
        $this->tag ??= $d['tag'] ?? null;

        // Note: tag detection moved to options() since href might be set after mount
    }

    protected function getComponentType(): string
    {
        return 'dropdown-item';
    }

    /**
     * For backward compatibility with tests
     */
    protected function getComponentName(): string
    {
        return 'dropdown_item';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        // Auto-detect tag in options() since href may be set after mount()
        if ($this->tag === null) {
            $this->tag = ($this->href !== null && $this->href !== '') ? 'a' : 'button';
        }

        $isAnchor = $this->tag === 'a';

        $classes = array_merge(
            ['dropdown-item'],
            $this->active ? ['active'] : [],
            $this->disabled ? ['disabled'] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = $this->buildCommonAttributes($isAnchor);

        if ($isAnchor) {
            $attrs['href'] = $this->href ?? '#';
        } else {
            $attrs['type'] = 'button';
        }

        if ($this->active) {
            $attrs['aria-current'] = 'true';
        }

        if ($this->disabled) {
            if ($isAnchor) {
                $attrs['tabindex'] = '-1';
                $attrs['aria-disabled'] = 'true';
            } else {
                $attrs['disabled'] = 'disabled';
            }
        }

        // Add target and rel for links
        if ($isAnchor) {
            if ($this->target) {
                $attrs['target'] = $this->target;
            }
            if ($this->rel) {
                $attrs['rel'] = $this->rel;
            }
        }

        return [
            'tag' => $this->tag,
            'label' => $this->label,
            'href' => $this->href,
            'classes' => implode(' ', array_unique(array_filter($classes))),
            'attrs' => $attrs,
        ];
    }
}


