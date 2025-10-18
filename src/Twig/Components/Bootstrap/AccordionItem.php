<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:accordion-item', template: '@NeuralGlitchUxBootstrap/components/bootstrap/accordion-item.html.twig')]
final class AccordionItem extends AbstractBootstrap
{
    public ?string $title = null;
    public ?string $targetId = null;
    public ?string $parentId = null;
    public bool $show = false;
    public bool $collapsed = true;

    public function mount(): void
    {
        $d = $this->config->for('accordion_item');

        $this->applyClassDefaults($d);

        // Apply defaults from config
        $this->show = $this->show || ($d['show'] ?? false);
        $this->collapsed = !$this->show && ($d['collapsed'] ?? true);
        
        // Generate unique IDs if not provided
        if (null === $this->targetId) {
            $this->targetId = $d['target_id'] ?? 'collapse-' . uniqid();
        }
    }

    protected function getComponentName(): string
    {
        return 'accordion_item';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $itemClasses = $this->buildClasses(
            ['accordion-item'],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $buttonClasses = $this->buildClasses(
            ['accordion-button'],
            $this->collapsed ? ['collapsed'] : []
        );

        $collapseClasses = $this->buildClasses(
            ['accordion-collapse', 'collapse'],
            $this->show ? ['show'] : []
        );

        $attrs = $this->mergeAttributes([], $this->attr);

        return [
            'title' => $this->title,
            'targetId' => $this->targetId,
            'parentId' => $this->parentId,
            'show' => $this->show,
            'collapsed' => $this->collapsed,
            'itemClasses' => $itemClasses,
            'buttonClasses' => $buttonClasses,
            'collapseClasses' => $collapseClasses,
            'attrs' => $attrs,
        ];
    }
}

