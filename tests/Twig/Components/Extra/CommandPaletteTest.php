<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\CommandPalette;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class CommandPaletteTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'command-palette' => [
                'trigger' => 'Cmd+K',
                'trigger_key' => 'k',
                'trigger_ctrl' => false,
                'trigger_meta' => true,
                'trigger_shift' => false,
                'trigger_alt' => false,
                'placeholder' => 'Type a command or search...',
                'empty_message' => 'No commands found',
                'show_shortcuts' => true,
                'show_icons' => true,
                'show_recent' => true,
                'max_recent' => 5,
                'search_url' => '/command-palette',
                'min_chars' => 0,
                'debounce' => 150,
                'close_on_select' => true,
                'close_on_escape' => true,
                'close_on_backdrop' => true,
                'size' => 'lg',
                'placement' => 'top',
                'centered' => false,
                'scrollable' => false,
                'animation' => 'fade',
                'animation_duration' => 200,
                'grouped' => true,
                'default_groups' => ['Quick Actions', 'Navigation', 'Admin'],
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new CommandPalette($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('modal', $options['modalClasses']);
        $this->assertStringContainsString('fade', $options['modalClasses']);
        $this->assertStringContainsString('modal-dialog', $options['dialogClasses']);
        $this->assertStringContainsString('modal-lg', $options['dialogClasses']);
        $this->assertSame('Type a command or search...', $options['placeholder']);
        $this->assertTrue($options['showShortcuts']);
        $this->assertTrue($options['showIcons']);
    }

    public function testTriggerConfiguration(): void
    {
        $component = new CommandPalette($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('k', $options['triggerKey']);
        $this->assertFalse($options['triggerCtrl']);
        $this->assertTrue($options['triggerMeta']);
        $this->assertFalse($options['triggerShift']);
        $this->assertFalse($options['triggerAlt']);
        $this->assertSame('⌘+K', $options['triggerDisplay']);
    }

    public function testCustomTriggerKey(): void
    {
        $component = new CommandPalette($this->config);
        $component->triggerKey = 'p';
        $component->mount();
        $options = $component->options();

        $this->assertSame('p', $options['triggerKey']);
        $this->assertSame('⌘+P', $options['triggerDisplay']);
    }

    public function testCtrlTrigger(): void
    {
        $component = new CommandPalette($this->config);
        $component->triggerCtrl = true;
        $component->triggerMeta = false;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['triggerCtrl']);
        $this->assertFalse($options['triggerMeta']);
        $this->assertStringContainsString('Ctrl', $options['triggerDisplay']);
    }

    public function testPlaceholderOption(): void
    {
        $component = new CommandPalette($this->config);
        $component->placeholder = 'Search commands...';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Search commands...', $options['placeholder']);
    }

    public function testEmptyMessageOption(): void
    {
        $component = new CommandPalette($this->config);
        $component->emptyMessage = 'No results';
        $component->mount();
        $options = $component->options();

        $this->assertSame('No results', $options['emptyMessage']);
    }

    public function testSearchUrlOption(): void
    {
        $component = new CommandPalette($this->config);
        $component->searchUrl = '/api/commands';
        $component->mount();
        $options = $component->options();

        $this->assertSame('/api/commands', $options['searchUrl']);
    }

    public function testMinCharsOption(): void
    {
        $component = new CommandPalette($this->config);
        $component->minChars = 2;
        $component->mount();
        $options = $component->options();

        $this->assertSame(2, $options['minChars']);
    }

    public function testDebounceOption(): void
    {
        $component = new CommandPalette($this->config);
        $component->debounce = 300;
        $component->mount();
        $options = $component->options();

        $this->assertSame(300, $options['debounce']);
    }

    public function testShowShortcutsOption(): void
    {
        $component = new CommandPalette($this->config);
        $component->showShortcuts = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['showShortcuts']);
    }

    public function testShowIconsOption(): void
    {
        $component = new CommandPalette($this->config);
        $component->showIcons = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['showIcons']);
    }

    public function testShowRecentOption(): void
    {
        $component = new CommandPalette($this->config);
        $component->showRecent = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['showRecent']);
    }

    public function testMaxRecentOption(): void
    {
        $component = new CommandPalette($this->config);
        $component->maxRecent = 10;
        $component->mount();
        $options = $component->options();

        $this->assertSame(10, $options['maxRecent']);
    }

    public function testCloseOnSelectOption(): void
    {
        $component = new CommandPalette($this->config);
        $component->closeOnSelect = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['closeOnSelect']);
    }

    public function testCloseOnEscapeOption(): void
    {
        $component = new CommandPalette($this->config);
        $component->closeOnEscape = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['closeOnEscape']);
    }

    public function testCloseOnBackdropOption(): void
    {
        $component = new CommandPalette($this->config);
        $component->closeOnBackdrop = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['closeOnBackdrop']);
    }

    public function testSizeOption(): void
    {
        $component = new CommandPalette($this->config);
        $component->size = 'xl';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('modal-xl', $options['dialogClasses']);
    }

    public function testPlacementTop(): void
    {
        $component = new CommandPalette($this->config);
        $component->placement = 'top';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('modal-dialog-top', $options['dialogClasses']);
    }

    public function testCenteredOption(): void
    {
        $component = new CommandPalette($this->config);
        $component->centered = true;
        $component->placement = 'center';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('modal-dialog-centered', $options['dialogClasses']);
    }

    public function testScrollableOption(): void
    {
        $component = new CommandPalette($this->config);
        $component->scrollable = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('modal-dialog-scrollable', $options['dialogClasses']);
    }

    public function testAnimationFade(): void
    {
        $component = new CommandPalette($this->config);
        $component->animation = 'fade';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('fade', $options['modalClasses']);
    }

    public function testAnimationNone(): void
    {
        $component = new CommandPalette($this->config);
        $component->animation = 'none';
        $component->mount();
        $options = $component->options();

        $this->assertStringNotContainsString('fade', $options['modalClasses']);
    }

    public function testAnimationDuration(): void
    {
        $component = new CommandPalette($this->config);
        $component->animationDuration = 300;
        $component->mount();
        $options = $component->options();

        $this->assertSame(300, $options['animationDuration']);
    }

    public function testGroupedOption(): void
    {
        $component = new CommandPalette($this->config);
        $component->grouped = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['grouped']);
    }

    public function testDefaultGroups(): void
    {
        $component = new CommandPalette($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertIsArray($options['defaultGroups']);
        $this->assertContains('Quick Actions', $options['defaultGroups']);
        $this->assertContains('Navigation', $options['defaultGroups']);
        $this->assertContains('Admin', $options['defaultGroups']);
    }

    public function testCustomDefaultGroups(): void
    {
        $component = new CommandPalette($this->config);
        $component->defaultGroups = ['Custom', 'Groups'];
        $component->mount();
        $options = $component->options();

        $this->assertIsArray($options['defaultGroups']);
        $this->assertContains('Custom', $options['defaultGroups']);
        $this->assertContains('Groups', $options['defaultGroups']);
    }

    public function testCustomClasses(): void
    {
        $component = new CommandPalette($this->config);
        $component->class = 'custom-palette';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-palette', $options['modalClasses']);
    }

    public function testCustomAttributes(): void
    {
        $component = new CommandPalette($this->config);
        $component->attr = [
            'data-test' => 'palette',
            'data-id' => '123',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('palette', $options['attrs']['data-test']);
        $this->assertArrayHasKey('data-id', $options['attrs']);
        $this->assertSame('123', $options['attrs']['data-id']);
    }

    public function testAriaAttributes(): void
    {
        $component = new CommandPalette($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('role', $options['attrs']);
        $this->assertSame('dialog', $options['attrs']['role']);
        $this->assertArrayHasKey('aria-label', $options['attrs']);
        $this->assertSame('Command Palette', $options['attrs']['aria-label']);
    }

    public function testConfigDefaults(): void
    {
        $config = new Config([
            'command-palette' => [
                'trigger' => 'Ctrl+K',
                'trigger_key' => 'k',
                'trigger_ctrl' => true,
                'trigger_meta' => false,
                'placeholder' => 'Custom placeholder',
                'search_url' => '/custom-search',
                'min_chars' => 3,
                'debounce' => 500,
                'size' => 'sm',
                'class' => 'default-class',
            ],
        ]);

        $component = new CommandPalette($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('Custom placeholder', $options['placeholder']);
        $this->assertSame('/custom-search', $options['searchUrl']);
        $this->assertSame(3, $options['minChars']);
        $this->assertSame(500, $options['debounce']);
        $this->assertStringContainsString('modal-sm', $options['dialogClasses']);
        $this->assertStringContainsString('default-class', $options['modalClasses']);
    }

    public function testGetComponentName(): void
    {
        $component = new CommandPalette($this->config);
        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('command-palette', $method->invoke($component));
    }

    public function testTriggerDisplayWithAllModifiers(): void
    {
        $component = new CommandPalette($this->config);
        $component->triggerCtrl = true;
        $component->triggerMeta = true;
        $component->triggerShift = true;
        $component->triggerAlt = true;
        $component->triggerKey = 'k';
        $component->mount();
        $options = $component->options();

        $display = $options['triggerDisplay'];
        $this->assertStringContainsString('⌘', $display);
        $this->assertStringContainsString('Ctrl', $display);
        $this->assertStringContainsString('Shift', $display);
        $this->assertStringContainsString('Alt', $display);
        $this->assertStringContainsString('K', $display);
    }
}

