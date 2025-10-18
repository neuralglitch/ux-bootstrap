<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractBootstrap;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:sidebar', template: '@NeuralGlitchUxBootstrap/components/extra/sidebar.html.twig')]
final class Sidebar extends AbstractBootstrap
{
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

    // Stimulus controller
    public ?string $stimulusController = 'bs-sidebar';

    public function mount(): void
    {
        $d = $this->config->for('sidebar');

        // Apply defaults from config (use explicit check for non-nullable properties with defaults)
        if ($this->variant === 'fixed' && isset($d['variant'])) {
            $this->variant = $d['variant'];
        }
        if ($this->position === 'left' && isset($d['position'])) {
            $this->position = $d['position'];
        }
        $this->width ??= $d['width'] ?? '280px';
        $this->miniWidth ??= $d['mini_width'] ?? '80px';

        // Behavior defaults
        $this->collapsed = $this->collapsed || ($d['collapsed'] ?? false);
        $this->collapsible = $this->collapsible && ($d['collapsible'] ?? true);
        $this->overlay = $this->overlay || ($d['overlay'] ?? false);
        $this->backdropClose = $this->backdropClose && ($d['backdrop_close'] ?? true);

        // Mobile defaults
        $this->mobileBreakpoint ??= $d['mobile_breakpoint'] ?? 'lg';
        $this->mobileBehavior ??= $d['mobile_behavior'] ?? 'overlay';

        // Header/footer defaults
        $this->showHeader = $this->showHeader || ($d['show_header'] ?? false);
        $this->headerTitle ??= $d['header_title'] ?? null;
        $this->showToggle = $this->showToggle && ($d['show_toggle'] ?? true);
        $this->showFooter = $this->showFooter || ($d['show_footer'] ?? false);

        // Styling defaults
        $this->bg ??= $d['bg'] ?? null;
        $this->textColor ??= $d['text_color'] ?? null;
        $this->border = $this->border || ($d['border'] ?? false);
        $this->shadow = $this->shadow || ($d['shadow'] ?? false);

        // Scrolling
        $this->scrollable = $this->scrollable && ($d['scrollable'] ?? true);

        // Z-index (use explicit check)
        if ($this->zIndex === 1040 && isset($d['z_index'])) {
            $this->zIndex = $d['z_index'];
        }

        // Animation
        if ($this->transition === 'slide' && isset($d['transition'])) {
            $this->transition = $d['transition'];
        }
        if ($this->transitionDuration === 300 && isset($d['transition_duration'])) {
            $this->transitionDuration = $d['transition_duration'];
        }

        // Stimulus controller
        $this->stimulusController ??= $d['stimulus_controller'] ?? 'bs-sidebar';

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
        $classes = $this->buildClasses(
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

        $attrs = $this->mergeAttributes([
            'data-controller' => $this->stimulusController,
            'data-bs-sidebar-variant-value' => $this->variant,
            'data-bs-sidebar-position-value' => $this->position,
            'data-bs-sidebar-collapsed-value' => $this->collapsed ? 'true' : 'false',
            'data-bs-sidebar-collapsible-value' => $this->collapsible ? 'true' : 'false',
            'data-bs-sidebar-overlay-value' => $this->overlay ? 'true' : 'false',
            'data-bs-sidebar-backdrop-close-value' => $this->backdropClose ? 'true' : 'false',
            'data-bs-sidebar-mobile-breakpoint-value' => $this->mobileBreakpoint,
            'data-bs-sidebar-mobile-behavior-value' => $this->mobileBehavior,
            'data-bs-sidebar-width-value' => $this->width,
            'data-bs-sidebar-mini-width-value' => $this->miniWidth,
            'data-bs-sidebar-transition-value' => $this->transition,
            'data-bs-sidebar-transition-duration-value' => (string) $this->transitionDuration,
        ], $this->attr);

        $style = [
            '--ux-sidebar-width' => $this->width,
            '--ux-sidebar-mini-width' => $this->miniWidth,
            '--ux-sidebar-z-index' => (string) $this->zIndex,
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

