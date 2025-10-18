<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\NotificationCenter;
use PHPUnit\Framework\TestCase;

final class NotificationCenterTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'notification_center' => [
                'variant' => 'dropdown',
                'title' => 'Notifications',
                'empty_message' => 'No notifications',
                'show_badge' => true,
                'unread_count' => 0,
                'badge_variant' => 'danger',
                'badge_positioned' => true,
                'trigger_variant' => 'link',
                'trigger_icon' => '🔔',
                'trigger_label' => null,
                'trigger_icon_only' => true,
                'offcanvas_placement' => 'end',
                'offcanvas_backdrop' => true,
                'offcanvas_scroll' => false,
                'modal_size' => null,
                'modal_centered' => false,
                'modal_scrollable' => true,
                'dropdown_direction' => 'dropdown',
                'dropdown_menu_align' => 'end',
                'dropdown_width' => '350px',
                'dropdown_max_height' => '400px',
                'grouped' => false,
                'show_timestamps' => true,
                'show_avatars' => true,
                'show_actions' => true,
                'show_mark_all_read' => true,
                'show_clear_all' => true,
                'show_view_all' => true,
                'view_all_label' => 'View all notifications',
                'mark_read_on_click' => true,
                'auto_refresh' => false,
                'auto_refresh_interval' => 30000,
                'stimulus_controller' => 'bs-notification-center',
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new NotificationCenter($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('dropdown', $options['variant']);
        $this->assertSame('Notifications', $options['title']);
        $this->assertSame('No notifications', $options['emptyMessage']);
        $this->assertTrue($options['showBadge']);
        $this->assertSame(0, $options['unreadCount']);
    }

    public function testDropdownVariant(): void
    {
        $component = new NotificationCenter($this->config);
        $component->variant = 'dropdown';
        $component->mount();
        $options = $component->options();

        $this->assertSame('dropdown', $options['variant']);
        $this->assertStringContainsString('dropdown-menu', $options['menuClasses']);
        $this->assertStringContainsString('dropdown-menu-end', $options['menuClasses']);
    }

    public function testOffcanvasVariant(): void
    {
        $component = new NotificationCenter($this->config);
        $component->variant = 'offcanvas';
        $component->offcanvasPlacement = 'start';
        $component->mount();
        $options = $component->options();

        $this->assertSame('offcanvas', $options['variant']);
        $this->assertSame('start', $options['offcanvasPlacement']);
        $this->assertTrue($options['offcanvasBackdrop']);
    }

    public function testModalVariant(): void
    {
        $component = new NotificationCenter($this->config);
        $component->variant = 'modal';
        $component->modalSize = 'lg';
        $component->modalCentered = true;
        $component->mount();
        $options = $component->options();

        $this->assertSame('modal', $options['variant']);
        $this->assertSame('lg', $options['modalSize']);
        $this->assertTrue($options['modalCentered']);
        $this->assertTrue($options['modalScrollable']);
    }

    public function testInlineVariant(): void
    {
        $component = new NotificationCenter($this->config);
        $component->variant = 'inline';
        $component->mount();
        $options = $component->options();

        $this->assertSame('inline', $options['variant']);
    }

    public function testPopoverVariant(): void
    {
        $component = new NotificationCenter($this->config);
        $component->variant = 'popover';
        $component->mount();
        $options = $component->options();

        $this->assertSame('popover', $options['variant']);
    }

    public function testUnreadCount(): void
    {
        $component = new NotificationCenter($this->config);
        $component->unreadCount = 5;
        $component->mount();
        $options = $component->options();

        $this->assertSame(5, $options['unreadCount']);
        $this->assertTrue($options['showBadge']);
    }

    public function testBadgeVariant(): void
    {
        $component = new NotificationCenter($this->config);
        $component->badgeVariant = 'primary';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('bg-primary', $options['badgeClasses']);
    }

    public function testBadgePositioned(): void
    {
        $component = new NotificationCenter($this->config);
        $component->badgePositioned = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('position-absolute', $options['badgeClasses']);
        $this->assertStringContainsString('translate-middle', $options['badgeClasses']);
    }

    public function testTriggerButton(): void
    {
        $component = new NotificationCenter($this->config);
        $component->triggerVariant = 'primary';
        $component->triggerIcon = '🔔';
        $component->triggerIconOnly = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('btn-primary', $options['triggerClasses']);
        $this->assertSame('🔔', $options['triggerIcon']);
        $this->assertTrue($options['triggerIconOnly']);
    }

    public function testTriggerWithLabel(): void
    {
        $component = new NotificationCenter($this->config);
        $component->triggerLabel = 'Notifications';
        $component->triggerIconOnly = false;
        $component->mount();
        $options = $component->options();

        $this->assertSame('Notifications', $options['triggerLabel']);
        $this->assertFalse($options['triggerIconOnly']);
    }

    public function testDropdownConfiguration(): void
    {
        $component = new NotificationCenter($this->config);
        $component->dropdownDirection = 'dropup';
        $component->dropdownMenuAlign = 'start';
        $component->dropdownWidth = '400px';
        $component->dropdownMaxHeight = '500px';
        $component->mount();
        $options = $component->options();

        $this->assertSame('dropup', $options['dropdownDirection']);
        $this->assertSame('400px', $options['dropdownWidth']);
        $this->assertSame('500px', $options['dropdownMaxHeight']);
    }

    public function testFeatureFlags(): void
    {
        $component = new NotificationCenter($this->config);
        $component->grouped = true;
        $component->showTimestamps = false;
        $component->showAvatars = false;
        $component->showActions = false;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['grouped']);
        $this->assertFalse($options['showTimestamps']);
        $this->assertFalse($options['showAvatars']);
        $this->assertFalse($options['showActions']);
    }

    public function testMarkAllReadOption(): void
    {
        $component = new NotificationCenter($this->config);
        $component->showMarkAllRead = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['showMarkAllRead']);
    }

    public function testClearAllOption(): void
    {
        $component = new NotificationCenter($this->config);
        $component->showClearAll = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['showClearAll']);
    }

    public function testViewAllOption(): void
    {
        $component = new NotificationCenter($this->config);
        $component->showViewAll = true;
        $component->viewAllHref = '/notifications';
        $component->viewAllLabel = 'See all';
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['showViewAll']);
        $this->assertSame('/notifications', $options['viewAllHref']);
        $this->assertSame('See all', $options['viewAllLabel']);
    }

    public function testAutoRefresh(): void
    {
        $component = new NotificationCenter($this->config);
        $component->autoRefresh = true;
        $component->autoRefreshInterval = 60000;
        $component->fetchUrl = '/api/notifications';
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-bs-notification-center-auto-refresh-value', $options['attrs']);
        $this->assertArrayHasKey('data-bs-notification-center-auto-refresh-interval-value', $options['attrs']);
        $this->assertArrayHasKey('data-bs-notification-center-fetch-url-value', $options['attrs']);
    }

    public function testMarkReadOnClick(): void
    {
        $component = new NotificationCenter($this->config);
        $component->markReadOnClick = true;
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-bs-notification-center-mark-read-on-click-value', $options['attrs']);
        $this->assertSame('true', $options['attrs']['data-bs-notification-center-mark-read-on-click-value']);
    }

    public function testIdGeneration(): void
    {
        $component = new NotificationCenter($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertNotNull($options['id']);
        $this->assertNotNull($options['triggerId']);
        $this->assertNotNull($options['menuId']);
        $this->assertStringStartsWith('notification-center-', $options['id']);
    }

    public function testCustomIds(): void
    {
        $component = new NotificationCenter($this->config);
        $component->id = 'custom-id';
        $component->triggerId = 'custom-trigger';
        $component->menuId = 'custom-menu';
        $component->mount();
        $options = $component->options();

        $this->assertSame('custom-id', $options['id']);
        $this->assertSame('custom-trigger', $options['triggerId']);
        $this->assertSame('custom-menu', $options['menuId']);
    }

    public function testCustomClasses(): void
    {
        $component = new NotificationCenter($this->config);
        $component->class = 'custom-notification-center';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-notification-center', $options['containerClasses']);
    }

    public function testCustomAttributes(): void
    {
        $component = new NotificationCenter($this->config);
        $component->attr = [
            'data-test' => 'value',
            'aria-label' => 'Notifications',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('value', $options['attrs']['data-test']);
        $this->assertArrayHasKey('aria-label', $options['attrs']);
        $this->assertSame('Notifications', $options['attrs']['aria-label']);
    }

    public function testStimulusController(): void
    {
        $component = new NotificationCenter($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-controller', $options['attrs']);
        $this->assertSame('bs-notification-center', $options['attrs']['data-controller']);
    }

    public function testEmptyMessage(): void
    {
        $component = new NotificationCenter($this->config);
        $component->emptyMessage = 'No new messages';
        $component->mount();
        $options = $component->options();

        $this->assertSame('No new messages', $options['emptyMessage']);
    }

    public function testConfigDefaults(): void
    {
        $customConfig = new Config([
            'notification_center' => [
                'variant' => 'offcanvas',
                'title' => 'Custom Title',
                'unread_count' => 3,
                'trigger_variant' => 'primary',
                'class' => 'custom-class',
            ],
        ]);

        $component = new NotificationCenter($customConfig);
        $component->mount();
        $options = $component->options();

        $this->assertSame('offcanvas', $options['variant']);
        $this->assertSame('Custom Title', $options['title']);
        $this->assertSame(3, $options['unreadCount']);
        $this->assertStringContainsString('btn-primary', $options['triggerClasses']);
        $this->assertStringContainsString('custom-class', $options['containerClasses']);
    }

    public function testGetComponentName(): void
    {
        $component = new NotificationCenter($this->config);
        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('notification_center', $method->invoke($component));
    }
}

