<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractBootstrap;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:notification-center', template: '@NeuralGlitchUxBootstrap/components/extra/notification-center.html.twig')]
final class NotificationCenter extends AbstractBootstrap
{
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
    
    // Stimulus controller
    public string $stimulusController = 'bs-notification-center';
    
    public function mount(): void
    {
        $d = $this->config->for('notification_center');
        
        // Apply defaults
        $this->variant ??= $d['variant'] ?? 'dropdown';
        $this->title ??= $d['title'] ?? 'Notifications';
        $this->emptyMessage ??= $d['empty_message'] ?? 'No notifications';
        
        // Badge
        $this->showBadge = $this->showBadge && ($d['show_badge'] ?? true);
        $this->unreadCount ??= $d['unread_count'] ?? 0;
        $this->badgeVariant ??= $d['badge_variant'] ?? 'danger';
        $this->badgePositioned = $this->badgePositioned || ($d['badge_positioned'] ?? true);
        
        // Trigger
        $this->triggerVariant ??= $d['trigger_variant'] ?? 'link';
        $this->triggerIcon ??= $d['trigger_icon'] ?? '🔔';
        $this->triggerIconOnly = $this->triggerIconOnly && ($d['trigger_icon_only'] ?? true);
        
        // Offcanvas
        $this->offcanvasPlacement ??= $d['offcanvas_placement'] ?? 'end';
        $this->offcanvasBackdrop = $this->offcanvasBackdrop || ($d['offcanvas_backdrop'] ?? true);
        $this->offcanvasScroll = $this->offcanvasScroll || ($d['offcanvas_scroll'] ?? false);
        
        // Modal
        $this->modalSize ??= $d['modal_size'] ?? null;
        $this->modalCentered = $this->modalCentered || ($d['modal_centered'] ?? false);
        $this->modalScrollable = $this->modalScrollable || ($d['modal_scrollable'] ?? true);
        
        // Dropdown
        $this->dropdownDirection ??= $d['dropdown_direction'] ?? 'dropdown';
        $this->dropdownMenuAlign ??= $d['dropdown_menu_align'] ?? 'end';
        $this->dropdownWidth ??= $d['dropdown_width'] ?? '350px';
        $this->dropdownMaxHeight ??= $d['dropdown_max_height'] ?? '400px';
        
        // Features
        $this->grouped = $this->grouped || ($d['grouped'] ?? false);
        $this->showTimestamps = $this->showTimestamps && ($d['show_timestamps'] ?? true);
        $this->showAvatars = $this->showAvatars && ($d['show_avatars'] ?? true);
        $this->showActions = $this->showActions && ($d['show_actions'] ?? true);
        $this->showMarkAllRead = $this->showMarkAllRead && ($d['show_mark_all_read'] ?? true);
        $this->showClearAll = $this->showClearAll && ($d['show_clear_all'] ?? true);
        $this->showViewAll = $this->showViewAll && ($d['show_view_all'] ?? true);
        $this->viewAllLabel ??= $d['view_all_label'] ?? 'View all notifications';
        
        // Behavior
        $this->markReadOnClick = $this->markReadOnClick || ($d['mark_read_on_click'] ?? true);
        $this->autoRefresh = $this->autoRefresh || ($d['auto_refresh'] ?? false);
        $this->autoRefreshInterval ??= $d['auto_refresh_interval'] ?? 30000;
        
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
    }
    
    protected function getComponentName(): string
    {
        return 'notification_center';
    }
    
    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        // Container classes
        $containerClasses = $this->buildClasses(
            ['notification-center'],
            $this->variant === 'inline' ? [] : [$this->variant],
            $this->class ? explode(' ', trim($this->class)) : []
        );
        
        // Trigger button classes
        $triggerClasses = $this->buildClasses(
            ['position-relative'],
            $this->triggerVariant === 'link' ? ['btn', 'btn-link', 'text-decoration-none'] : ['btn', "btn-{$this->triggerVariant}"],
            $this->triggerIconOnly ? ['btn-icon'] : []
        );
        
        // Badge classes (build as array, then join)
        $badgeClassesArray = array_merge(
            ['badge', "bg-{$this->badgeVariant}"],
            $this->badgePositioned ? ['position-absolute', 'top-0', 'start-100', 'translate-middle', 'rounded-pill'] : []
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
        $stimulusAttrs = [
            'data-controller' => $this->stimulusController,
            'data-' . $this->stimulusController . '-unread-count-value' => $this->unreadCount,
            'data-' . $this->stimulusController . '-mark-read-on-click-value' => $this->markReadOnClick ? 'true' : 'false',
            'data-' . $this->stimulusController . '-auto-refresh-value' => $this->autoRefresh ? 'true' : 'false',
            'data-' . $this->stimulusController . '-auto-refresh-interval-value' => $this->autoRefreshInterval,
        ];
        
        if ($this->fetchUrl) {
            $stimulusAttrs['data-' . $this->stimulusController . '-fetch-url-value'] = $this->fetchUrl;
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

