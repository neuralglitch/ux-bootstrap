<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:list-group', template: '@NeuralGlitchUxBootstrap/components/bootstrap/list-group.html.twig')]
final class ListGroup extends AbstractStimulus
{
    public ?string $id = null;
    public bool $flush = false;
    public bool $numbered = false;
    public string|bool|null $horizontal = null; // null | true (always) | 'sm' | 'md' | 'lg' | 'xl' | 'xxl'
    public ?string $tag = null; // Auto-detect: 'ul' for basic, 'ol' for numbered, 'div' for action items

    public function mount(): void
    {
        $d = $this->config->for('list_group');

        $this->applyStimulusDefaults($d);

        $this->applyClassDefaults($d);

        // Apply defaults from config
        $this->flush = $this->flush || $this->configBoolWithFallback($d, 'flush', false);
        $this->numbered = $this->numbered || $this->configBoolWithFallback($d, 'numbered', false);
        $this->horizontal ??= $this->configString($d, 'horizontal');

        // Auto-determine tag if not specified
        if (null === $this->tag) {
            $this->tag = $this->numbered ? 'ol' : $this->configStringWithFallback($d, 'tag', 'ul');
        }

        // Generate unique ID if not provided
        if (null === $this->id) {
            $this->id = $this->configString($d, 'id');
        }

        // Initialize controller with default
        $this->initializeController();
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
        $classes = $this->buildClassesFromArrays(
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

