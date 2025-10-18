<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:nav', template: '@NeuralGlitchUxBootstrap/components/bootstrap/nav.html.twig')]
final class Nav extends AbstractBootstrap
{
    /**
     * Nav style variant: null, 'tabs', 'pills', or 'underline'
     */
    public ?string $variant = null;

    /**
     * Fill available space equally
     */
    public bool $fill = false;

    /**
     * Justify items to fill available space with equal widths
     */
    public bool $justified = false;

    /**
     * Stack navigation vertically
     * Can be: false, true, or responsive breakpoint ('sm', 'md', 'lg', 'xl', 'xxl')
     */
    public string|bool $vertical = false;

    /**
     * Horizontal alignment: null, 'start', 'center', or 'end'
     */
    public ?string $align = null;

    /**
     * HTML tag to use: 'ul', 'nav', 'ol', or 'div'
     */
    public string $tag = 'ul';

    /**
     * Optional ID attribute
     */
    public ?string $id = null;

    /**
     * ARIA role (automatically set based on tag)
     */
    public ?string $role = null;

    public function mount(): void
    {
        $d = $this->config->for('nav');

        // Apply base class defaults
        $this->applyClassDefaults($d);

        // Apply component-specific defaults
        $this->variant ??= $d['variant'] ?? null;
        $this->fill = $this->fill || ($d['fill'] ?? false);
        $this->justified = $this->justified || ($d['justified'] ?? false);
        $this->vertical = $this->vertical !== false ? $this->vertical : ($d['vertical'] ?? false);
        $this->align ??= $d['align'] ?? null;
        $this->tag = $this->tag !== 'ul' ? $this->tag : ($d['tag'] ?? 'ul');
        $this->id ??= $d['id'] ?? null;
        $this->role ??= $d['role'] ?? null;

        // Auto-detect role if not explicitly set
        if ($this->role === null) {
            $this->role = match ($this->tag) {
                'nav' => 'navigation',
                'ul', 'ol' => 'list',
                default => null,
            };
        }
    }

    protected function getComponentName(): string
    {
        return 'nav';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = $this->buildClasses(
            ['nav'],
            $this->variant ? ["nav-{$this->variant}"] : [],
            $this->fill ? ['nav-fill'] : [],
            $this->justified ? ['nav-justified'] : [],
            $this->buildVerticalClasses(),
            $this->buildAlignClasses(),
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = $this->mergeAttributes(
            array_filter([
                'id' => $this->id,
                'role' => $this->role,
            ]),
            $this->attr
        );

        return [
            'tag' => $this->tag,
            'classes' => $classes,
            'attrs' => $attrs,
            'isListTag' => in_array($this->tag, ['ul', 'ol'], true),
        ];
    }

    /**
     * Build vertical orientation classes
     *
     * @return array<string>
     */
    private function buildVerticalClasses(): array
    {
        if ($this->vertical === false) {
            return [];
        }

        if ($this->vertical === true) {
            return ['flex-column'];
        }

        // Responsive vertical: 'sm', 'md', 'lg', 'xl', 'xxl'
        return ["flex-{$this->vertical}-column"];
    }

    /**
     * Build horizontal alignment classes
     *
     * @return array<string>
     */
    private function buildAlignClasses(): array
    {
        if (!$this->align) {
            return [];
        }

        return match ($this->align) {
            'center' => ['justify-content-center'],
            'end' => ['justify-content-end'],
            'start' => ['justify-content-start'],
            default => [],
        };
    }
}

