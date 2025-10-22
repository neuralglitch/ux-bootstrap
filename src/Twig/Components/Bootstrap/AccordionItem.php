<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:accordion-item', template: '@NeuralGlitchUxBootstrap/components/bootstrap/accordion-item.html.twig')]
final class AccordionItem extends AbstractStimulus
{
    public ?string $header = null;
    public ?string $targetId = null;
    public ?string $parentId = null;
    public bool $show = false;

    public function mount(): void
    {
        $d = $this->config->for('accordion-item');

        $this->applyStimulusDefaults($d);
        $this->applyClassDefaults($d);

        // Apply config defaults
        $this->show = $this->show || ($d['show'] ?? false);
        $this->header ??= $d['header'] ?? null;
        $this->targetId ??= $d['target_id'] ?? 'collapse-' . uniqid();

        $this->initializeController();
    }

    protected function getComponentName(): string
    {
        return 'accordion-item';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        // Collapsed is ALWAYS the inverse of show (calculated dynamically)
        $collapsed = !$this->show;

        $itemClasses = $this->buildClasses(
            ['accordion-item'],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $buttonClasses = $this->buildClasses(
            ['accordion-button'],
            $collapsed ? ['collapsed'] : []
        );

        $collapseClasses = $this->buildClasses(
            ['accordion-collapse', 'collapse'],
            $this->show ? ['show'] : []
        );

        $attrs = $this->mergeAttributes([], $this->attr);

        return [
            'header' => $this->header,
            'targetId' => $this->targetId,
            'parentId' => $this->parentId,
            'show' => $this->show,
            'collapsed' => $collapsed,
            'itemClasses' => $itemClasses,
            'buttonClasses' => $buttonClasses,
            'collapseClasses' => $collapseClasses,
            'attrs' => $attrs,
        ];
    }
}

