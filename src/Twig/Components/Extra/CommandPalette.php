<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('bs:command-palette', template: '@NeuralGlitchUxBootstrap/components/extra/command-palette.html.twig')]
final class CommandPalette extends AbstractStimulus
{
    // Stimulus controller
    public string $stimulusController = 'bs-command-palette';

    // Trigger
    public ?string $trigger = null;
    public ?string $triggerKey = null;
    public bool $triggerCtrl = false;
    public bool $triggerMeta = true;
    public bool $triggerShift = false;
    public bool $triggerAlt = false;

    // Appearance
    public ?string $placeholder = null;
    public ?string $emptyMessage = null;
    public bool $showShortcuts = true;
    public bool $showIcons = true;
    public bool $showRecent = true;
    public int $maxRecent = 0;

    // Behavior
    public ?string $searchUrl = null;
    public int $minChars = 0;
    public int $debounce = 0;
    public bool $closeOnSelect = true;
    public bool $closeOnEscape = true;
    public bool $closeOnBackdrop = true;

    // Modal styling
    public ?string $size = null;
    public ?string $placement = null;
    public bool $centered = false;
    public bool $scrollable = false;

    // Animation
    public ?string $animation = null;
    public int $animationDuration = 0;

    // Categories/Groups
    public bool $grouped = true;

    /**
     * @var array<int, string>
     */
    public array $defaultGroups = [];

    public function mount(): void
    {
        $d = $this->config->for('command-palette');

        $this->applyStimulusDefaults($d);

        // Trigger configuration
        $this->trigger ??= $d['trigger'] ?? 'Cmd+K';
        $this->triggerKey ??= $d['trigger_key'] ?? 'k';
        $this->triggerCtrl = $this->triggerCtrl || ($d['trigger_ctrl'] ?? false);
        $this->triggerMeta = $this->triggerMeta && ($d['trigger_meta'] ?? true);
        $this->triggerShift = $this->triggerShift || ($d['trigger_shift'] ?? false);
        $this->triggerAlt = $this->triggerAlt || ($d['trigger_alt'] ?? false);

        // Appearance
        $this->placeholder ??= $d['placeholder'] ?? 'Type a command or search...';
        $this->emptyMessage ??= $d['empty_message'] ?? 'No commands found';
        $this->showShortcuts = $this->showShortcuts && ($d['show_shortcuts'] ?? true);
        $this->showIcons = $this->showIcons && ($d['show_icons'] ?? true);
        $this->showRecent = $this->showRecent && ($d['show_recent'] ?? true);
        $this->maxRecent = $this->maxRecent ?: ($d['max_recent'] ?? 5);

        // Behavior
        $this->searchUrl ??= $d['search_url'] ?? '/command-palette';
        $this->minChars = $this->minChars ?: ($d['min_chars'] ?? 0);
        $this->debounce = $this->debounce ?: ($d['debounce'] ?? 150);
        $this->closeOnSelect = $this->closeOnSelect && ($d['close_on_select'] ?? true);
        $this->closeOnEscape = $this->closeOnEscape && ($d['close_on_escape'] ?? true);
        $this->closeOnBackdrop = $this->closeOnBackdrop && ($d['close_on_backdrop'] ?? true);

        // Modal styling
        $this->size ??= $d['size'] ?? 'lg';
        $this->placement ??= $d['placement'] ?? 'top';
        $this->centered = $this->centered || ($d['centered'] ?? false);
        $this->scrollable = $this->scrollable || ($d['scrollable'] ?? false);

        // Animation
        $this->animation ??= $d['animation'] ?? 'fade';
        $this->animationDuration = $this->animationDuration ?: ($d['animation_duration'] ?? 200);

        // Groups
        $this->grouped = $this->grouped && ($d['grouped'] ?? true);
        $this->defaultGroups = !empty($this->defaultGroups) ? $this->defaultGroups : ($d['default_groups'] ?? [
            'Quick Actions',
            'Navigation',
            'Admin'
        ]);

        $this->applyClassDefaults($d);


        // Initialize controller with default
        $this->initializeController();
    }

    protected function getComponentName(): string
    {
        return 'command-palette';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        // Modal classes
        $modalClasses = $this->buildClasses(
            ['modal', $this->animation === 'fade' ? 'fade' : ''],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        // Dialog classes
        $dialogClasses = ['modal-dialog'];

        // Size
        if ($this->size !== 'default') {
            $dialogClasses[] = 'modal-' . $this->size;
        }

        // Placement
        if ($this->placement === 'top') {
            $dialogClasses[] = 'modal-dialog-top';
        } elseif ($this->centered) {
            $dialogClasses[] = 'modal-dialog-centered';
        }

        // Scrollable
        if ($this->scrollable) {
            $dialogClasses[] = 'modal-dialog-scrollable';
        }

        // Trigger shortcut display
        $triggerDisplay = $this->formatTriggerDisplay();

        $attrs = $this->mergeAttributes([
            'data-controller' => $this->stimulusController,
            'data-bs-command-palette-trigger-key-value' => $this->triggerKey,
            'data-bs-command-palette-trigger-ctrl-value' => $this->triggerCtrl ? 'true' : 'false',
            'data-bs-command-palette-trigger-meta-value' => $this->triggerMeta ? 'true' : 'false',
            'data-bs-command-palette-trigger-shift-value' => $this->triggerShift ? 'true' : 'false',
            'data-bs-command-palette-trigger-alt-value' => $this->triggerAlt ? 'true' : 'false',
            'data-bs-command-palette-search-url-value' => $this->searchUrl,
            'data-bs-command-palette-min-chars-value' => (string)$this->minChars,
            'data-bs-command-palette-debounce-value' => (string)$this->debounce,
            'data-bs-command-palette-close-on-select-value' => $this->closeOnSelect ? 'true' : 'false',
            'data-bs-command-palette-close-on-escape-value' => $this->closeOnEscape ? 'true' : 'false',
            'data-bs-command-palette-close-on-backdrop-value' => $this->closeOnBackdrop ? 'true' : 'false',
            'tabindex' => '-1',
            'role' => 'dialog',
            'aria-label' => 'Command Palette',
            'aria-hidden' => 'true',
        ], $this->attr);

        return [
            'modalClasses' => $modalClasses,
            'dialogClasses' => implode(' ', $dialogClasses),
            'attrs' => $attrs,
            'placeholder' => $this->placeholder,
            'emptyMessage' => $this->emptyMessage,
            'showShortcuts' => $this->showShortcuts,
            'showIcons' => $this->showIcons,
            'showRecent' => $this->showRecent,
            'maxRecent' => $this->maxRecent,
            'searchUrl' => $this->searchUrl,
            'minChars' => $this->minChars,
            'debounce' => $this->debounce,
            'closeOnSelect' => $this->closeOnSelect,
            'closeOnEscape' => $this->closeOnEscape,
            'closeOnBackdrop' => $this->closeOnBackdrop,
            'triggerDisplay' => $triggerDisplay,
            'triggerKey' => $this->triggerKey,
            'triggerCtrl' => $this->triggerCtrl,
            'triggerMeta' => $this->triggerMeta,
            'triggerShift' => $this->triggerShift,
            'triggerAlt' => $this->triggerAlt,
            'grouped' => $this->grouped,
            'defaultGroups' => $this->defaultGroups,
            'animationDuration' => $this->animationDuration,
        ];
    }

    private function formatTriggerDisplay(): string
    {
        $parts = [];

        if ($this->triggerMeta) {
            $parts[] = '⌘'; // Mac Command key
        }

        if ($this->triggerCtrl) {
            $parts[] = 'Ctrl';
        }

        if ($this->triggerShift) {
            $parts[] = 'Shift';
        }

        if ($this->triggerAlt) {
            $parts[] = 'Alt';
        }

        $parts[] = strtoupper($this->triggerKey ?? 'k');

        return implode('+', $parts);
    }
}

