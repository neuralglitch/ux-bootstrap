<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:list-group', template: '@NeuralGlitchUxBootstrap/components/bootstrap/list-group.html.twig')]
final class ListGroup extends AbstractBootstrap
{
    public ?string $id = null;
    public bool $flush = false;
    public bool $numbered = false;
    public string|bool|null $horizontal = null; // null | true (always) | 'sm' | 'md' | 'lg' | 'xl' | 'xxl'
    public ?string $tag = null; // Auto-detect: 'ul' for basic, 'ol' for numbered, 'div' for action items

    public function mount(): void
    {
        $d = $this->config->for('list_group');

        $this->applyClassDefaults($d);

        // Apply defaults from config
        $this->flush = $this->flush || ($d['flush'] ?? false);
        $this->numbered = $this->numbered || ($d['numbered'] ?? false);
        $this->horizontal ??= $d['horizontal'] ?? null;
        
        // Auto-determine tag if not specified
        if (null === $this->tag) {
            $this->tag = $this->numbered ? 'ol' : ($d['tag'] ?? 'ul');
        }
        
        // Generate unique ID if not provided
        if (null === $this->id) {
            $this->id = $d['id'] ?? null;
        }
    }

    protected function getComponentName(): string
    {
        return 'list_group';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = $this->buildClasses(
            ['list-group'],
            $this->flush ? ['list-group-flush'] : [],
            $this->numbered ? ['list-group-numbered'] : [],
            $this->horizontal ? ['list-group-horizontal' . ($this->horizontal !== true ? '-' . $this->horizontal : '')] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = [];
        
        if ($this->id) {
            $attrs['id'] = $this->id;
        }

        $attrs = $this->mergeAttributes($attrs, $this->attr);

        return [
            'tag' => $this->tag,
            'classes' => $classes,
            'attrs' => $attrs,
        ];
    }
}

