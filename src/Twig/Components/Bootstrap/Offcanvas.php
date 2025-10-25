<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:offcanvas', template: '@NeuralGlitchUxBootstrap/components/bootstrap/offcanvas.html.twig')]
final class Offcanvas extends AbstractStimulus
{
    public string $stimulusController = 'bs-offcanvas';

    public string $id;
    public ?string $title = null;
    public ?string $placement = null;
    public bool|string|null $backdrop = null;
    public ?bool $scroll = null;
    public ?bool $keyboard = null;
    public ?bool $show = null;
    public ?string $bodyClass = null;
    public ?string $headerClass = null;
    public ?bool $showCloseButton = null;

    public function mount(): void
    {
        $d = $this->config->for('offcanvas');

        $this->applyStimulusDefaults($d);

        // Apply base class defaults
        $this->applyClassDefaults($d);

        // Apply component-specific defaults
        $this->placement ??= $this->configStringWithFallback($d, 'placement', 'start');
        $this->backdrop ??= $this->configBoolWithFallback($d, 'backdrop', true);
        $this->scroll ??= $this->configBoolWithFallback($d, 'scroll', false);
        $this->keyboard ??= $this->configBoolWithFallback($d, 'keyboard', true);
        $this->show ??= $this->configBoolWithFallback($d, 'show', false);
        $this->bodyClass ??= $this->configString($d, 'body_class');
        $this->headerClass ??= $this->configString($d, 'header_class');
        $this->showCloseButton ??= $this->configBoolWithFallback($d, 'show_close_button', true);

        // Generate unique ID if not provided
        if (!isset($this->id)) {
            $this->id = 'offcanvas-' . uniqid();
        }

        // Initialize controller with default
        $this->initializeController();
    }

    protected function getComponentName(): string
    {
        return 'offcanvas';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = array_merge(
            ['offcanvas', "offcanvas-{$this->placement}"],
            $this->show ? ['show'] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = [
            'tabindex' => '-1',
            'aria-labelledby' => $this->title ? "{$this->id}Label" : null,
        ];

        // Add backdrop and scroll data attributes
        if ($this->backdrop === 'static') {
            $attrs['data-bs-backdrop'] = 'static';
        } elseif ($this->backdrop === false) {
            $attrs['data-bs-backdrop'] = 'false';
        }

        if ($this->scroll) {
            $attrs['data-bs-scroll'] = 'true';
        }

        if (!$this->keyboard) {
            $attrs['data-bs-keyboard'] = 'false';
        }

        $attrs = $this->mergeAttributes($attrs, $this->attr);

        // Body classes
        $bodyClasses = array_merge(
            ['offcanvas-body'],
            $this->bodyClass ? explode(' ', trim($this->bodyClass)) : []
        );

        // Header classes
        $headerClasses = array_merge(
            ['offcanvas-header'],
            $this->headerClass ? explode(' ', trim($this->headerClass)) : []
        );

        return [
            'id' => $this->id,
            'title' => $this->title,
            'classes' => implode(' ', array_filter($classes)),
            'attrs' => $attrs,
            'bodyClasses' => implode(' ', array_filter($bodyClasses)),
            'headerClasses' => implode(' ', array_filter($headerClasses)),
            'showCloseButton' => $this->showCloseButton,
        ];
    }
}

