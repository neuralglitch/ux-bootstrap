<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:nav-item', template: '@NeuralGlitchUxBootstrap/components/bootstrap/nav-item.html.twig')]
final class NavItem extends AbstractInteractive
{
    /**
     * Link label/text (alternative to content block)
     */
    public ?string $label = null;

    /**
     * Link href
     */
    public ?string $href = null;

    /**
     * Is this nav item active?
     */
    public bool $active = false;

    /**
     * Is this nav item disabled?
     */
    public bool $disabled = false;

    /**
     * HTML tag to use for the link: 'a', 'button', or 'span'
     */
    public string $tag = 'a';

    /**
     * Optional ID attribute
     */
    public ?string $id = null;

    /**
     * Target attribute for links (e.g., '_blank')
     */
    public ?string $target = null;

    /**
     * ARIA current value when active
     */
    public string|bool|null $ariaCurrent = 'page';

    /**
     * If true, renders the nav-item wrapper (for <ul> nav)
     * Set to false for plain nav without list structure
     */
    public bool $wrapper = true;

    public function mount(): void
    {
        $d = $this->config->for('nav_item');

        $this->applyInteractiveDefaults($d);

        // Apply base class defaults
        $this->applyClassDefaults($d);

        // Apply component-specific defaults
        $this->label ??= $d['label'] ?? null;
        $this->href ??= $d['href'] ?? null;
        $this->active = $this->active || ($d['active'] ?? false);
        $this->disabled = $this->disabled || ($d['disabled'] ?? false);
        $this->tag = $this->tag !== 'a' ? $this->tag : ($d['tag'] ?? 'a');
        $this->id ??= $d['id'] ?? null;
        $this->target ??= $d['target'] ?? null;
        $this->ariaCurrent = $this->ariaCurrent !== 'page' ? $this->ariaCurrent : ($d['aria_current'] ?? 'page');
        $this->wrapper = $this->wrapper !== true ? $this->wrapper : ($d['wrapper'] ?? true);

        // Auto-detect tag if not explicitly set
        if ($this->tag === 'a' && $this->href === null && !$this->disabled) {
            $this->tag = 'button';


            // Initialize controller with default
            $this->initializeController();
        }
    }

    protected function getComponentType(): string
    {
        return 'nav-item';
    }

    protected function getComponentName(): string
    {
        return 'nav_item';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = $this->buildClasses(
            ['nav-link'],
            $this->active ? ['active'] : [],
            $this->disabled ? ['disabled'] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = $this->mergeAttributes(
            array_filter([
                'id' => $this->id,
                'href' => $this->tag === 'a' ? ($this->href ?? '#') : null,
                'target' => $this->target,
                'role' => $this->tag === 'a' && !$this->href ? 'button' : null,
                'aria-current' => $this->active ? ($this->ariaCurrent === true ? 'true' : $this->ariaCurrent) : null,
                'aria-disabled' => $this->disabled ? 'true' : null,
                'tabindex' => $this->disabled ? '-1' : null,
                'type' => $this->tag === 'button' ? 'button' : null,
            ], fn($value) => $value !== null),
            $this->buildInteractiveAttributes($this->tag === 'a')
        );

        return [
            'label' => $this->label,
            'tag' => $this->tag,
            'classes' => $classes,
            'attrs' => $attrs,
            'wrapper' => $this->wrapper,
        ];
    }
}

