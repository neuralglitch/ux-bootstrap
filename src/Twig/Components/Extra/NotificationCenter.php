<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:notification-center', template: '@NeuralGlitchUxBootstrap/components/extra/notification-center.html.twig')]
final class NotificationCenter extends AbstractStimulus
{
    public string $stimulusController = 'bs-notification-center';

    // Layout & Appearance
    public ?string $variant = null; // 'dropdown' | 'popover' | 'offcanvas' | 'modal' | 'inline'
    public ?string $title = null;
    public ?string $emptyMessage = null;

    // Badge/Count
    public bool $showBadge = true;
    public ?int $unreadCount = null;
    public ?string $badgeVariant = null;
    public bool $badgePositioned = true;

    // Trigger button (for dropdown/popover/offcanvas/modal variants)
    public ?string $triggerVariant = null;
    public ?string $triggerIcon = null; // Bell icon by default
    public ?string $triggerLabel = null;
    public bool $triggerIconOnly = true;

    // Offcanvas options (when variant='offcanvas')
    public ?string $offcanvasPlacement = null; // 'start' | 'end' | 'top' | 'bottom'
    public bool $offcanvasBackdrop = true;
    public bool $offcanvasScroll = false;

    // Modal options (when variant='modal')
    public ?string $modalSize = null; // null | 'sm' | 'lg' | 'xl'
    public bool $modalCentered = false;
    public bool $modalScrollable = true;

    // Dropdown options (when variant='dropdown')
    public ?string $dropdownDirection = null; // 'dropdown' | 'dropup' | 'dropstart' | 'dropend'
    public ?string $dropdownMenuAlign = null; // 'start' | 'end'
    public ?string $dropdownWidth = null; // CSS width value
    public ?string $dropdownMaxHeight = null; // CSS max-height value

    // Features
    public bool $grouped = false; // Group notifications by date/category
    public bool $showTimestamps = true;
    public bool $showAvatars = true;
    public bool $showActions = true; // Mark as read, delete, etc.
    public bool $showMarkAllRead = true;
    public bool $showClearAll = true;
    public bool $showViewAll = true;
    public ?string $viewAllHref = null;
    public ?string $viewAllLabel = null;

    // Behavior
    public bool $markReadOnClick = true;
    public bool $autoRefresh = false;
    public ?int $autoRefreshInterval = null; // milliseconds
    public ?string $fetchUrl = null; // URL to fetch notifications from

    // IDs
    public ?string $id = null;
    public ?string $triggerId = null;
    public ?string $menuId = null;

    public function mount(): void
    {
        $d = $this->config->for('notification-center');

        $this->applyStimulusDefaults($d);

        // Apply defaults
        $this->variant ??= $this->configStringWithFallback($d, 'variant', 'dropdown');
        $this->title ??= $this->configStringWithFallback($d, 'title', 'Notifications');
        $this->emptyMessage ??= $this->configStringWithFallback($d, 'empty_message', 'No notifications');

        // Badge
        $this->showBadge = $this->showBadge && $this->configBoolWithFallback($d, 'show_badge', true);
        $this->unreadCount ??= $this->configInt($d, 'unread_count');
        $this->badgeVariant ??= $this->configStringWithFallback($d, 'badge_variant', 'danger');
        $this->badgePositioned = $this->badgePositioned || $this->configBoolWithFallback($d, 'badge_positioned', true);

        // Trigger
        $this->triggerVariant ??= $this->configStringWithFallback($d, 'trigger_variant', 'link');
        $this->triggerIcon ??= $this->configStringWithFallback($d, 'trigger_icon', 'bi:bell-fill');
        $this->triggerIconOnly = $this->triggerIconOnly && $this->configBoolWithFallback($d, 'trigger_icon_only', true);

        // Offcanvas
        $this->offcanvasPlacement ??= $this->configStringWithFallback($d, 'offcanvas_placement', 'end');
        $this->offcanvasBackdrop = $this->offcanvasBackdrop || $this->configBoolWithFallback($d, 'offcanvas_backdrop', true);
        $this->offcanvasScroll = $this->offcanvasScroll || $this->configBoolWithFallback($d, 'offcanvas_scroll', false);

        // Modal
        $this->modalSize ??= $this->configString($d, 'modal_size');
        $this->modalCentered = $this->modalCentered || $this->configBoolWithFallback($d, 'modal_centered', false);
        $this->modalScrollable = $this->modalScrollable || $this->configBoolWithFallback($d, 'modal_scrollable', true);

        // Dropdown
        $this->dropdownDirection ??= $this->configStringWithFallback($d, 'dropdown_direction', 'dropdown');
        $this->dropdownMenuAlign ??= $this->configStringWithFallback($d, 'dropdown_menu_align', 'end');
        $this->dropdownWidth ??= $this->configStringWithFallback($d, 'dropdown_width', '350px');
        $this->dropdownMaxHeight ??= $this->configStringWithFallback($d, 'dropdown_max_height', '400px');

        // Features
        $this->grouped = $this->grouped || $this->configBoolWithFallback($d, 'grouped', false);
        $this->showTimestamps = $this->showTimestamps && $this->configBoolWithFallback($d, 'show_timestamps', true);
        $this->showAvatars = $this->showAvatars && $this->configBoolWithFallback($d, 'show_avatars', true);
        $this->showActions = $this->showActions && $this->configBoolWithFallback($d, 'show_actions', true);
        $this->showMarkAllRead = $this->showMarkAllRead && $this->configBoolWithFallback($d, 'show_mark_all_read', true);
        $this->showClearAll = $this->showClearAll && $this->configBoolWithFallback($d, 'show_clear_all', true);
        $this->showViewAll = $this->showViewAll && $this->configBoolWithFallback($d, 'show_view_all', true);
        $this->viewAllLabel ??= $this->configStringWithFallback($d, 'view_all_label', 'View all notifications');

        // Behavior
        $this->markReadOnClick = $this->markReadOnClick || $this->configBoolWithFallback($d, 'mark_read_on_click', true);
        $this->autoRefresh = $this->autoRefresh || $this->configBoolWithFallback($d, 'auto_refresh', false);
        $this->autoRefreshInterval ??= $this->configInt($d, 'auto_refresh_interval');

        // Generate IDs if not provided
        if (!$this->id) {
            $this->id = 'notification-center-' . uniqid();
        }
        if (!$this->triggerId) {
            $this->triggerId = $this->id . '-trigger';
        }
        if (!$this->menuId) {
            $this->menuId = $this->id . '-menu';
        }

        $this->applyClassDefaults($d);

        // Merge attr defaults
        if (isset($d['attr']) && is_array($d['attr'])) {
            $this->attr = array_merge($d['attr'], $this->attr);
        }

        // Initialize controller with default
        $this->initializeController();
    }

    protected function getComponentName(): string
    {
        return 'notification-center';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        // Container classes
        $classArray = $this->class ? array_filter(explode(' ', trim($this->class)), fn($v) => $v !== '') : [];
        /** @var array<string> $classArray */

        $containerClasses = $this->buildClassesFromArrays(
            ['notification-center'],
            $this->variant === 'inline' ? [] : ($this->variant ? [$this->variant] : []),
            $classArray
        );

        // Trigger button classes
        $triggerClasses = $this->buildClassesFromArrays(
            ['position-relative'],
            $this->triggerVariant === 'link' ? ['btn', 'btn-link', 'text-decoration-none'] : [
                'btn',
                "btn-{$this->triggerVariant}"
            ],
            $this->triggerIconOnly ? ['btn-icon'] : []
        );

        // Badge classes (build as array, then join)
        $badgeClassesArray = array_merge(
            ['badge', "bg-{$this->badgeVariant}"],
            $this->badgePositioned ? [
                'position-absolute',
                'top-0',
                'start-100',
                'translate-middle',
                'rounded-pill'
            ] : []
        );
        $badgeClasses = implode(' ', array_unique($badgeClassesArray));

        // Menu/dropdown classes
        $menuClassesArray = ['notification-menu'];
        if ($this->variant === 'dropdown') {
            $menuClassesArray[] = 'dropdown-menu';
            $menuClassesArray[] = "dropdown-menu-{$this->dropdownMenuAlign}";
        }
        $menuClasses = implode(' ', $menuClassesArray);

        $attrs = $this->mergeAttributes([], $this->attr);

        // Add Stimulus controller data attributes
        $controllerName = $this->controller;
        $stimulusAttrs = [
            'data-controller' => $controllerName,
            'data-' . $controllerName . '-unread-count-value' => $this->unreadCount,
            'data-' . $controllerName . '-mark-read-on-click-value' => $this->markReadOnClick ? 'true' : 'false',
            'data-' . $controllerName . '-auto-refresh-value' => $this->autoRefresh ? 'true' : 'false',
            'data-' . $controllerName . '-auto-refresh-interval-value' => $this->autoRefreshInterval,
        ];

        if ($this->fetchUrl) {
            $stimulusAttrs['data-' . $controllerName . '-fetch-url-value'] = $this->fetchUrl;
        }

        $attrs = array_merge($stimulusAttrs, $attrs);

        return [
            'id' => $this->id,
            'triggerId' => $this->triggerId,
            'menuId' => $this->menuId,
            'variant' => $this->variant,
            'title' => $this->title,
            'emptyMessage' => $this->emptyMessage,

            // Badge
            'showBadge' => $this->showBadge,
            'unreadCount' => $this->unreadCount,
            'badgeClasses' => $badgeClasses,

            // Trigger
            'triggerClasses' => $triggerClasses,
            'triggerIcon' => $this->triggerIcon,
            'triggerLabel' => $this->triggerLabel,
            'triggerIconOnly' => $this->triggerIconOnly,

            // Offcanvas
            'offcanvasPlacement' => $this->offcanvasPlacement,
            'offcanvasBackdrop' => $this->offcanvasBackdrop,
            'offcanvasScroll' => $this->offcanvasScroll,

            // Modal
            'modalSize' => $this->modalSize,
            'modalCentered' => $this->modalCentered,
            'modalScrollable' => $this->modalScrollable,

            // Dropdown
            'dropdownDirection' => $this->dropdownDirection,
            'dropdownWidth' => $this->dropdownWidth,
            'dropdownMaxHeight' => $this->dropdownMaxHeight,
            'menuClasses' => $menuClasses,

            // Features
            'grouped' => $this->grouped,
            'showTimestamps' => $this->showTimestamps,
            'showAvatars' => $this->showAvatars,
            'showActions' => $this->showActions,
            'showMarkAllRead' => $this->showMarkAllRead,
            'showClearAll' => $this->showClearAll,
            'showViewAll' => $this->showViewAll,
            'viewAllHref' => $this->viewAllHref,
            'viewAllLabel' => $this->viewAllLabel,

            'containerClasses' => $containerClasses,
            'attrs' => $attrs,
        ];
    }
}

