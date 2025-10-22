<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:navbar', template: '@NeuralGlitchUxBootstrap/components/bootstrap/navbar.html.twig')]
final class Navbar extends AbstractStimulus
{
    public string $stimulusController = 'bs-navbar';

    /** Brand text or HTML */
    public ?string $brand = null;

    /** Brand link href */
    public ?string $brandHref = '#';

    /** Brand image source URL */
    public ?string $brandImg = null;

    /** Brand image alt text */
    public ?string $brandImgAlt = '';

    /** Brand image width */
    public ?string $brandImgWidth = '30';

    /** Brand image height */
    public ?string $brandImgHeight = '30';

    /** Brand icon (ux:icon name, e.g., 'bi:bootstrap') - alternative to brandImg */
    public ?string $brandIcon = null;

    /** Brand icon width (when using brandIcon) */
    public ?string $brandIconWidth = '32';

    /** Brand icon height (when using brandIcon) */
    public ?string $brandIconHeight = '32';

    /** Background color: 'primary' | 'secondary' | 'success' | 'danger' | 'warning' | 'info' | 'light' | 'dark' | 'body' | 'body-tertiary' | 'white' | 'transparent' */
    public ?string $bg = 'body-tertiary';

    /** Theme: 'light' | 'dark' | null (uses data-bs-theme attribute) */
    public ?string $theme = null;

    /** Expand breakpoint: 'sm' | 'md' | 'lg' | 'xl' | 'xxl' | null (always expanded) */
    public ?string $expand = 'lg';

    /** Container type: 'container' | 'container-fluid' | 'container-{breakpoint}' */
    public string $container = 'container-fluid';

    /** Placement: null | 'fixed-top' | 'fixed-bottom' | 'sticky-top' | 'sticky-bottom' */
    public ?string $placement = null;

    /** Show border at the bottom */
    public bool $borderBottom = false;

    /** Collapse ID for toggler */
    public string $collapseId = 'navbarSupportedContent';

    /** Toggler aria label */
    public string $togglerLabel = 'Toggle navigation';

    /** Show toggler button (auto-enabled if expand is set) */
    public bool $showToggler = true;

    /** Toggler icon (ux:icon name) */
    public ?string $togglerIcon = 'bi:three-dots';

    /** Toggler icon width */
    public string $togglerIconWidth = '1.5em';

    /** Toggler icon height */
    public string $togglerIconHeight = '1.5em';

    // ========================================
    // Collapse Type Configuration
    // ========================================

    /**
     * Collapse behavior type
     * Options: 'standard' | 'offcanvas' | 'fullscreen' | 'mega-menu' | 'centered-split' | 'double' | 'sidebar'
     */
    public string $collapseType = 'standard';

    // ========================================
    // Offcanvas Configuration (type: 'offcanvas')
    // ========================================

    /** Offcanvas placement: 'start' | 'end' | 'top' | 'bottom' */
    public string $offcanvasPlacement = 'start';

    /** Show backdrop when offcanvas is open */
    public bool $offcanvasBackdrop = true;

    /** Allow body scroll when offcanvas is open */
    public bool $offcanvasScroll = false;

    /** Offcanvas title (shown in header) */
    public ?string $offcanvasTitle = null;

    // ========================================
    // Fullscreen Overlay Configuration (type: 'fullscreen')
    // ========================================

    /** Fullscreen animation: 'fade' | 'slide-down' | 'scale' */
    public string $fullscreenAnimation = 'fade';

    /** Fullscreen background color (CSS value or Bootstrap bg class) */
    public string $fullscreenBg = 'var(--bs-body-bg)';

    /** Center content vertically in fullscreen mode */
    public bool $fullscreenCentered = true;

    // ========================================
    // Sticky/Scroll Behavior Configuration
    // ========================================

    /** Enable sticky scroll behavior (shrink on scroll, etc.) */
    public bool $stickyBehavior = false;

    /** Shrink navbar height on scroll */
    public bool $shrinkOnScroll = false;

    /** Auto-hide navbar on scroll down, show on scroll up */
    public bool $autoHide = false;

    /** Add shadow when scrolled */
    public bool $shadowOnScroll = false;

    /** Change background opacity on scroll */
    public bool $transparentUntilScroll = false;

    // ========================================
    // Centered Split Navigation Configuration (type: 'centered-split')
    // ========================================

    /** Enable centered brand with split navigation */
    public bool $centeredBrand = false;

    // ========================================
    // Double Navbar Configuration (type: 'double')
    // ========================================

    /** Enable double row navbar */
    public bool $doubleRow = false;

    /** Background for top row (in double navbar) */
    public ?string $topRowBg = null;

    // ========================================
    // Sidebar Configuration (type: 'sidebar')
    // ========================================

    /** Sidebar width (CSS value) */
    public string $sidebarWidth = '250px';

    /** Sidebar position: 'left' | 'right' */
    public string $sidebarPosition = 'left';

    /** Collapse sidebar on mobile */
    public bool $sidebarCollapsible = true;

    // ========================================
    // Mega Menu Configuration (type: 'mega-menu')
    // ========================================

    /** Enable mega menu functionality */
    public bool $megaMenu = false;

    /** Mega menu dropdown width: 'full' | 'auto' | specific px/% value */
    public string $megaMenuWidth = 'full';

    /** Mega menu columns (for auto layout) */
    public int $megaMenuColumns = 4;

    // ========================================
    // General
    // ========================================

    public ?string $id = null;

    public function mount(): void
    {
        $d = $this->config->for('navbar');

        $this->applyStimulusDefaults($d);

        // Apply defaults from config - Basic properties
        $this->brand ??= $d['brand'] ?? null;
        $this->brandHref ??= $d['brand_href'] ?? '#';
        $this->brandImg ??= $d['brand_img'] ?? null;
        $this->brandImgAlt ??= $d['brand_img_alt'] ?? '';
        $this->brandImgWidth ??= $d['brand_img_width'] ?? '30';
        $this->brandImgHeight ??= $d['brand_img_height'] ?? '30';
        $this->brandIcon ??= $d['brand_icon'] ?? null;
        $this->brandIconWidth ??= $d['brand_icon_width'] ?? '32';
        $this->brandIconHeight ??= $d['brand_icon_height'] ?? '32';
        $this->bg ??= $d['bg'] ?? 'body-tertiary';
        $this->theme ??= $d['theme'] ?? null;
        $this->expand ??= $d['expand'] ?? 'lg';
        $this->container = $this->container ?: ($d['container'] ?? 'container-fluid');
        $this->placement ??= $d['placement'] ?? null;
        $this->borderBottom = $this->borderBottom || ($d['border_bottom'] ?? false);
        $this->collapseId = $this->collapseId ?: ($d['collapse_id'] ?? 'navbarSupportedContent');
        $this->togglerLabel = $this->togglerLabel ?: ($d['toggler_label'] ?? 'Toggle navigation');
        $this->showToggler = $this->showToggler && ($d['show_toggler'] ?? true);
        $this->togglerIcon ??= $d['toggler_icon'] ?? 'bi:three-dots';
        $this->togglerIconWidth = $this->togglerIconWidth ?: ($d['toggler_icon_width'] ?? '1.5em');
        $this->togglerIconHeight = $this->togglerIconHeight ?: ($d['toggler_icon_height'] ?? '1.5em');
        $this->id ??= $d['id'] ?? null;

        // Collapse type
        $this->collapseType = $this->collapseType ?: ($d['collapse_type'] ?? 'standard');

        // Offcanvas configuration
        $this->offcanvasPlacement = $this->offcanvasPlacement ?: ($d['offcanvas_placement'] ?? 'start');
        $this->offcanvasBackdrop = $this->offcanvasBackdrop || ($d['offcanvas_backdrop'] ?? true);
        $this->offcanvasScroll = $this->offcanvasScroll || ($d['offcanvas_scroll'] ?? false);
        $this->offcanvasTitle ??= $d['offcanvas_title'] ?? null;

        // Fullscreen configuration
        $this->fullscreenAnimation = $this->fullscreenAnimation ?: ($d['fullscreen_animation'] ?? 'fade');
        $this->fullscreenBg = $this->fullscreenBg ?: ($d['fullscreen_bg'] ?? 'var(--bs-body-bg)');
        $this->fullscreenCentered = $this->fullscreenCentered || ($d['fullscreen_centered'] ?? true);

        // Sticky/Scroll behavior
        $this->stickyBehavior = $this->stickyBehavior || ($d['sticky_behavior'] ?? false);
        $this->shrinkOnScroll = $this->shrinkOnScroll || ($d['shrink_on_scroll'] ?? false);
        $this->autoHide = $this->autoHide || ($d['auto_hide'] ?? false);
        $this->shadowOnScroll = $this->shadowOnScroll || ($d['shadow_on_scroll'] ?? false);
        $this->transparentUntilScroll = $this->transparentUntilScroll || ($d['transparent_until_scroll'] ?? false);

        // Centered split configuration
        $this->centeredBrand = $this->centeredBrand || ($d['centered_brand'] ?? false);

        // Double navbar configuration
        $this->doubleRow = $this->doubleRow || ($d['double_row'] ?? false);
        $this->topRowBg ??= $d['top_row_bg'] ?? null;

        // Sidebar configuration
        $this->sidebarWidth = $this->sidebarWidth ?: ($d['sidebar_width'] ?? '250px');
        $this->sidebarPosition = $this->sidebarPosition ?: ($d['sidebar_position'] ?? 'left');
        $this->sidebarCollapsible = $this->sidebarCollapsible || ($d['sidebar_collapsible'] ?? true);

        // Mega menu configuration
        $this->megaMenu = $this->megaMenu || ($d['mega_menu'] ?? false);
        $this->megaMenuWidth = $this->megaMenuWidth ?: ($d['mega_menu_width'] ?? 'full');
        $this->megaMenuColumns = $this->megaMenuColumns ?: ($d['mega_menu_columns'] ?? 4);

        $this->applyClassDefaults($d);


        // Initialize controller with default
        $this->initializeController();
    }

    protected function getComponentName(): string
    {
        return 'navbar';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = ['navbar'];

        // Add expand class (not needed for sidebar or some variants)
        if ($this->expand && !in_array($this->collapseType, ['sidebar'])) {
            $classes[] = "navbar-expand-{$this->expand}";
        }

        // Add background color
        if ($this->bg) {
            $classes[] = "bg-{$this->bg}";
        }

        // Add placement
        if ($this->placement) {
            $classes[] = $this->placement;
        }

        // Add border bottom
        if ($this->borderBottom) {
            $classes[] = 'border-bottom';
            $classes[] = 'border-body';
        }

        // Add variant-specific classes
        if ($this->collapseType === 'sidebar') {
            $classes[] = 'navbar-sidebar';
        } elseif ($this->collapseType === 'fullscreen') {
            $classes[] = 'navbar-fullscreen';
        } elseif ($this->collapseType === 'centered-split') {
            $classes[] = 'navbar-centered-split';
        } elseif ($this->collapseType === 'double') {
            $classes[] = 'navbar-double';
        }

        // Add scroll behavior classes
        if ($this->stickyBehavior) {
            $classes[] = 'navbar-sticky-behavior';
        }
        if ($this->shrinkOnScroll) {
            $classes[] = 'navbar-shrink';
        }
        if ($this->autoHide) {
            $classes[] = 'navbar-autohide';
        }
        if ($this->transparentUntilScroll) {
            $classes[] = 'navbar-transparent';
        }

        // Add custom classes
        $classesString = $this->buildClasses(
            $classes,
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = [];

        if ($this->id) {
            $attrs['id'] = $this->id;
        }

        // Add theme attribute
        if ($this->theme) {
            $attrs['data-bs-theme'] = $this->theme;
        }

        // Add controller attributes based on features
        $controllers = [];
        if ($this->stickyBehavior || $this->shrinkOnScroll || $this->autoHide || $this->shadowOnScroll || $this->transparentUntilScroll) {
            $controllers[] = 'bs-navbar-sticky';
        }
        if ($this->collapseType === 'fullscreen') {
            $controllers[] = 'bs-navbar-fullscreen';
        }
        if ($this->megaMenu) {
            $controllers[] = 'bs-navbar-mega-menu';
        }

        if (!empty($controllers)) {
            $attrs['data-controller'] = implode(' ', $controllers);
        }

        // Add data attributes for Stimulus controllers
        if ($this->shrinkOnScroll) {
            $attrs['data-bs-navbar-sticky-shrink-value'] = 'true';
        }
        if ($this->autoHide) {
            $attrs['data-bs-navbar-sticky-auto-hide-value'] = 'true';
        }
        if ($this->shadowOnScroll) {
            $attrs['data-bs-navbar-sticky-shadow-value'] = 'true';
        }
        if ($this->transparentUntilScroll) {
            $attrs['data-bs-navbar-sticky-transparent-value'] = 'true';
        }
        if ($this->collapseType === 'fullscreen') {
            $attrs['data-bs-navbar-fullscreen-animation-value'] = $this->fullscreenAnimation;
        }

        $attrs = $this->mergeAttributes($attrs, $this->attr);

        return [
            'classes' => $classesString,
            'attrs' => $attrs,
            'brand' => $this->brand,
            'brandHref' => $this->brandHref,
            'brandImg' => $this->brandImg,
            'brandImgAlt' => $this->brandImgAlt,
            'brandImgWidth' => $this->brandImgWidth,
            'brandImgHeight' => $this->brandImgHeight,
            'brandIcon' => $this->brandIcon,
            'brandIconWidth' => $this->brandIconWidth,
            'brandIconHeight' => $this->brandIconHeight,
            'container' => $this->container,
            'expand' => $this->expand,
            'collapseId' => $this->collapseId,
            'togglerLabel' => $this->togglerLabel,
            'togglerIcon' => $this->togglerIcon,
            'togglerIconWidth' => $this->togglerIconWidth,
            'togglerIconHeight' => $this->togglerIconHeight,
            'showToggler' => $this->showToggler && $this->expand !== null,
            // Collapse type
            'collapseType' => $this->collapseType,
            // Offcanvas
            'offcanvasPlacement' => $this->offcanvasPlacement,
            'offcanvasBackdrop' => $this->offcanvasBackdrop,
            'offcanvasScroll' => $this->offcanvasScroll,
            'offcanvasTitle' => $this->offcanvasTitle ?? $this->brand ?? 'Menu',
            // Fullscreen
            'fullscreenAnimation' => $this->fullscreenAnimation,
            'fullscreenBg' => $this->fullscreenBg,
            'fullscreenCentered' => $this->fullscreenCentered,
            // Centered split
            'centeredBrand' => $this->centeredBrand,
            // Double navbar
            'doubleRow' => $this->doubleRow,
            'topRowBg' => $this->topRowBg,
            // Sidebar
            'sidebarWidth' => $this->sidebarWidth,
            'sidebarPosition' => $this->sidebarPosition,
            'sidebarCollapsible' => $this->sidebarCollapsible,
            // Mega menu
            'megaMenu' => $this->megaMenu,
            'megaMenuWidth' => $this->megaMenuWidth,
            'megaMenuColumns' => $this->megaMenuColumns,
        ];
    }
}

