<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\VariantTrait;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:badge', template: '@NeuralGlitchUxBootstrap/components/bootstrap/badge.html.twig')]
final class Badge extends AbstractBootstrap
{
    use VariantTrait;

    public ?string $label = null;
    public ?string $href = null;
    public ?string $target = null;
    public ?string $rel = null;
    public ?string $title = null;
    public ?string $id = null;

    /** Bootstrap text-color utilities: 'primary', 'body', 'white', etc. */
    public ?string $text = null;

    /** If true, applies 'rounded-pill' class */
    public bool $pill = false;

    /** If true, uses 'position-absolute' for notification badges */
    public bool $positioned = false;

    /** Position utilities: 'top-0 start-100', 'top-0 start-0', etc. */
    public ?string $position = null;

    /** If true, applies 'translate-middle' (default for positioned badges) */
    public bool $translate = true;

    public function mount(): void
    {
        $d = $this->config->for('badge');

        $this->applyVariantDefaults($d);
        $this->applyClassDefaults($d);

        // Apply defaults from config
        $this->pill = $this->pill || ($d['pill'] ?? false);
        $this->href ??= $d['href'] ?? null;
        $this->target ??= $d['target'] ?? null;
        $this->rel ??= $d['rel'] ?? null;
        $this->title ??= $d['title'] ?? null;
        $this->id ??= $d['id'] ?? null;
        $this->text ??= $d['text'] ?? null;
        $this->positioned = $this->positioned || ($d['positioned'] ?? false);
        $this->position ??= $d['position'] ?? null;
        $this->translate = $this->translate && ($d['translate'] ?? true);
    }

    protected function getComponentName(): string
    {
        return 'badge';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $isLink = $this->href !== null;

        $classes = $this->buildClasses(
            ['badge'],
            $this->variantClassesFor('badge'),  // text-bg-{variant}
            $this->pill ? ['rounded-pill'] : [],
            $this->text ? ["text-{$this->text}"] : [],
            $this->positionClasses(),
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = [];

        if ($this->id) {
            $attrs['id'] = $this->id;
        }
        if ($this->title) {
            $attrs['title'] = $this->title;
        }

        // Link-specific attributes
        if ($isLink) {
            if ($this->target) {
                $attrs['target'] = $this->target;
            }
            if ($this->rel) {
                $attrs['rel'] = $this->rel;
            }
        }

        $attrs = $this->mergeAttributes($attrs, $this->attr);

        return [
            'tag' => $isLink ? 'a' : 'span',
            'href' => $this->href,
            'label' => $this->label,
            'classes' => $classes,
            'attrs' => $attrs,
        ];
    }

    /**
     * @return array<string>
     */
    private function positionClasses(): array
    {
        if (!$this->positioned) {
            return [];
        }

        $c = ['position-absolute'];

        if ($this->position) {
            // Split position string into individual classes (e.g. "top-0 start-100")
            $c = array_merge($c, explode(' ', trim($this->position)));
        }

        if ($this->translate) {
            $c[] = 'translate-middle';
        }

        return $c;
    }
}

