<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:sidebar', template: '@NeuralGlitchUxBootstrap/components/extra/sidebar.html.twig')]
final class Sidebar extends AbstractStimulus
{
    public string $stimulusController = 'bs-sidebar';

    // Layout variants
    public string $variant = 'fixed';           // 'fixed' | 'collapsible' | 'overlay' | 'push' | 'mini'

    // Position and dimensions
    public string $position = 'left';           // 'left' | 'right'
    public ?string $width = null;               // CSS value (e.g., '250px', '280px', '20rem')
    public ?string $miniWidth = null;           // Width when collapsed to mini (e.g., '80px')

    // Behavior
    public bool $collapsed = false;             // Initial collapsed state
    public bool $collapsible = true;            // Allow collapse/expand
    public bool $overlay = false;               // Show overlay backdrop when open
    public bool $backdropClose = true;          // Close on backdrop click

    // Mobile behavior
    public string $mobileBreakpoint = 'lg';     // 'sm' | 'md' | 'lg' | 'xl' | 'xxl'
    public string $mobileBehavior = 'overlay';  // 'overlay' | 'push' | 'hidden'

    // Header and footer
    public bool $showHeader = false;
    public ?string $headerTitle = null;
    public bool $showToggle = true;             // Show toggle button in header
    public bool $showFooter = false;

    // Styling
    public ?string $bg = null;                  // Bootstrap background variant
    public ?string $textColor = null;           // Text color variant
    public bool $border = false;                // Show border
    public bool $shadow = false;                // Show shadow

    // Scrolling
    public bool $scrollable = true;             // Make sidebar scrollable

    // Z-index
    public int $zIndex = 1040;

    // Animation
    public string $transition = 'slide';        // 'slide' | 'fade' | 'none'
    public int $transitionDuration = 300;       // milliseconds

    public function mount(): void
    {
        $d = $this->config->for('sidebar');

        $this->applyStimulusDefaults($d);

        // Apply defaults from config
        $this->variant = ($this->variant !== 'fixed') ? $this->variant : $this->configStringWithFallback($d, 'variant', 'fixed');
        $this->position = ($this->position !== 'left') ? $this->position : $this->configStringWithFallback($d, 'position', 'left');
        $this->width = $this->width ?? $this->configStringWithFallback($d, 'width', '280px');
        $this->miniWidth = $this->miniWidth ?? $this->configStringWithFallback($d, 'mini_width', '80px');

        // Behavior defaults
        $this->collapsed = $this->collapsed || $this->configBoolWithFallback($d, 'collapsed', false);
        $this->collapsible = $this->collapsible && $this->configBoolWithFallback($d, 'collapsible', true);
        $this->overlay = $this->overlay || $this->configBoolWithFallback($d, 'overlay', false);
        $this->backdropClose = $this->backdropClose && $this->configBoolWithFallback($d, 'backdrop_close', true);

        // Mobile defaults
        $this->mobileBreakpoint = ($this->mobileBreakpoint !== 'lg') ? $this->mobileBreakpoint : $this->configStringWithFallback($d, 'mobile_breakpoint', 'lg');
        $this->mobileBehavior = ($this->mobileBehavior !== 'overlay') ? $this->mobileBehavior : $this->configStringWithFallback($d, 'mobile_behavior', 'overlay');

        // Header/footer defaults
        $this->showHeader = $this->showHeader || $this->configBoolWithFallback($d, 'show_header', false);
        $this->headerTitle = $this->headerTitle ?? $this->configString($d, 'header_title');
        $this->showToggle = $this->showToggle && $this->configBoolWithFallback($d, 'show_toggle', true);
        $this->showFooter = $this->showFooter || $this->configBoolWithFallback($d, 'show_footer', false);

        // Styling defaults
        $this->bg = isset($d['bg']) ? $this->configString($d, 'bg') : $this->bg;
        $this->textColor = isset($d['text_color']) ? $this->configString($d, 'text_color') : $this->textColor;
        $this->border = $this->border || $this->configBoolWithFallback($d, 'border', false);
        $this->shadow = $this->shadow || $this->configBoolWithFallback($d, 'shadow', false);

        // Scrolling
        $this->scrollable = $this->scrollable && $this->configBoolWithFallback($d, 'scrollable', true);

        // Z-index
        $this->zIndex = ($this->zIndex !== 1040) ? $this->zIndex : $this->configIntWithFallback($d, 'z_index', 1040);

        // Animation
        $this->transition = ($this->transition !== 'slide') ? $this->transition : $this->configStringWithFallback($d, 'transition', 'slide');
        $this->transitionDuration = ($this->transitionDuration !== 300) ? $this->transitionDuration : $this->configIntWithFallback($d, 'transition_duration', 300);

        // Apply Stimulus defaults
        $this->applyStimulusDefaults($d);

        // Initialize controller with default
        $this->initializeController();

        $this->applyClassDefaults($d);

        // Merge attr defaults
        if (isset($d['attr']) && is_array($d['attr'])) {
            $this->attr = array_merge($d['attr'], $this->attr);
        }
    }

    protected function getComponentName(): string
    {
        return 'sidebar';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = $this->buildClassesFromArrays(
            ['ux-sidebar'],
            ["ux-sidebar--{$this->variant}"],
            ["ux-sidebar--{$this->position}"],
            $this->collapsed ? ['ux-sidebar--collapsed'] : [],
            $this->scrollable ? ['ux-sidebar--scrollable'] : [],
            $this->overlay ? ['ux-sidebar--with-overlay'] : [],
            $this->bg ? ["bg-{$this->bg}"] : [],
            $this->textColor ? ["text-{$this->textColor}"] : [],
            $this->border ? ['border-end'] : [],
            $this->shadow ? ['shadow'] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = $this->buildStimulusAttributes();
        $attrs = $this->mergeAttributes($attrs, $this->attr);

        $style = [
            '--ux-sidebar-width' => $this->width,
            '--ux-sidebar-mini-width' => $this->miniWidth,
            '--ux-sidebar-z-index' => (string)$this->zIndex,
            '--ux-sidebar-transition-duration' => "{$this->transitionDuration}ms",
        ];

        // Add inline style if not already set
        if (!isset($attrs['style'])) {
            $styleStr = [];
            foreach ($style as $key => $value) {
                $styleStr[] = "{$key}: {$value}";
            }
            $attrs['style'] = implode('; ', $styleStr);
        }

        return [
            'variant' => $this->variant,
            'position' => $this->position,
            'width' => $this->width,
            'miniWidth' => $this->miniWidth,
            'collapsed' => $this->collapsed,
            'collapsible' => $this->collapsible,
            'overlay' => $this->overlay,
            'backdropClose' => $this->backdropClose,
            'mobileBreakpoint' => $this->mobileBreakpoint,
            'mobileBehavior' => $this->mobileBehavior,
            'showHeader' => $this->showHeader,
            'headerTitle' => $this->headerTitle,
            'showToggle' => $this->showToggle,
            'showFooter' => $this->showFooter,
            'scrollable' => $this->scrollable,
            'transition' => $this->transition,
            'classes' => $classes,
            'attrs' => $attrs,
        ];
    }
}

