<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:link', template: '@NeuralGlitchUxBootstrap/components/bootstrap/link.html.twig')]
final class Link extends AbstractInteraction
{
    public string $href = '#';
    public ?string $target = '_self';
    public ?string $rel = null;

    public ?string $underline = null;
    public ?int $underlineOpacity = null;
    public ?int $underlineOpacityHover = null;
    public ?int $offset = null;
    public bool $stretched = false;

    public function mount(): void
    {
        $d = $this->config->for('link');

        $this->applyCommonDefaults($d);
        $this->applyClassDefaults($d);

        $this->underline ??= $d['underline'] ?? null;
        $this->underlineOpacity ??= $d['underline_opacity'] ?? null;
        $this->underlineOpacityHover ??= $d['underline_opacity_hover'] ?? null;
        $this->offset ??= $d['offset'] ?? null;
        $this->stretched = $this->stretched || (bool)($d['stretched'] ?? false);
        
        // Initialize controller with default
        $this->initializeController();
    }

    protected function getComponentType(): string
    {
        return 'link';
    }
    
    protected function getComponentName(): string
    {
        return 'link';
    }
    
    /**
     * Override to conditionally attach tooltip/popover controllers
     * Link component doesn't need its own controller - just delegates to bs-tooltip/bs-popover
     */
    protected function shouldAttachController(): bool
    {
        // Link attaches controllers when tooltip or popover is configured
        return $this->controllerEnabled && $this->hasTooltipOrPopover();
    }
    
    /**
     * Override to attach appropriate universal controllers
     */
    protected function buildStimulusAttributes(): array
    {
        $attrs = [];
        
        // Build list of controllers to attach
        $controllers = [];
        
        // Add tooltip controller if tooltip is configured
        if ($this->tooltip !== null) {
            $controllers[] = 'bs-tooltip';
        }
        
        // Add popover controller if popover is configured
        if ($this->popover !== null) {
            $controllers[] = 'bs-popover';
        }
        
        // Add any additional controllers from the controller property
        if ($this->controller !== '') {
            // User explicitly set controllers - append or replace
            $controllers[] = $this->controller;
        }
        
        // Build data-controller attribute if we have controllers
        if (!empty($controllers)) {
            $attrs['data-controller'] = implode(' ', array_unique($controllers));
        }
        
        // No component-specific values needed - tooltip/popover controllers handle everything
        
        return $attrs;
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = array_merge(
            $this->variantClassesFor('link'),      // -> link-primary|danger|…
            $this->stateClassesFor('link'),        // -> d-block (bei block), .active, .disabled
            $this->linkUnderlineClasses(),         // -> link-underline/opacity/offset/… (s.u.)
            $this->stretched ? ['stretched-link'] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = $this->buildCommonAttributes(true);

        // Add link-specific attributes
        if ($this->target) {
            $attrs['target'] = $this->target;
        }
        if ($this->rel) {
            $attrs['rel'] = $this->rel;
        }

        $iconSpace = $this->iconSpacingClasses('link');

        return [
            'href' => $this->disabled ? 'javascript:void(0)' : $this->href,
            'label' => $this->label,
            'iconStart' => $this->iconStart,
            'iconEnd' => $this->iconEnd,
            'iconOnly' => $this->iconOnly,
            'iconSize' => $this->effectiveIconSize(),
            'classes' => implode(' ', array_unique(array_filter($classes))),
            'attrs' => $attrs,
            'disabled' => $this->disabled,
            'iconStartClasses' => implode(' ', $iconSpace['start']),
            'iconEndClasses' => implode(' ', $iconSpace['end']),
        ];
    }

    /**
     * @return array<int, string>
     */
    private function linkUnderlineClasses(): array
    {
        $c = [];

        // Grundlogik:
        // - 'never'  => link-underline + link-underline-opacity-0 (kein underline, aber konsistentes Verhalten)
        // - 'always' => link-underline (dauerhafte Unterstreichung)
        // - 'hover'  => Standard via opacity-hover steuern
        if ($this->underline === 'never') {
            $c[] = 'link-underline';
            $c[] = 'link-underline-opacity-0';
        } elseif ($this->underline === 'always') {
            $c[] = 'link-underline';
        } elseif ($this->underline === 'hover') {
            // nichts Basis-spezifisches, wir steuern über opacity-hover unten
            $c[] = 'link-underline';
        }

        if ($this->offset) {
            $c[] = "link-offset-{$this->offset}";
        }
        if ($this->underlineOpacity !== null) {
            $c[] = "link-underline-opacity-{$this->underlineOpacity}";
        }
        if ($this->underlineOpacityHover !== null) {
            $c[] = "link-underline-opacity-{$this->underlineOpacityHover}-hover";
        }

        return $c;
    }
}
