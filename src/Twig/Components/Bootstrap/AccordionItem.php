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
        $this->show = $this->show || $this->configBoolWithFallback($d, 'show', false);
        $this->header ??= $this->configString($d, 'header');
        $this->targetId ??= $this->configStringWithFallback($d, 'target_id', 'collapse-' . uniqid());

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

        $itemClasses = $this->buildClassesFromArrays(
            ['accordion-item'],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $buttonClasses = $this->buildClassesFromArrays(
            ['accordion-button'],
            $collapsed ? ['collapsed'] : []
        );

        $collapseClasses = $this->buildClassesFromArrays(
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

