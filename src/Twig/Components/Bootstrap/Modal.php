<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:modal', template: '@NeuralGlitchUxBootstrap/components/bootstrap/modal.html.twig')]
final class Modal extends AbstractStimulus
{
    use Traits\SizeTrait;

    public string $stimulusController = 'bs-modal';

    // Required
    public string $id;

    // Modal content
    public ?string $title = null;

    // Fullscreen options
    public string|bool $fullscreen = false; // true | 'sm' | 'md' | 'lg' | 'xl' | 'xxl'

    // Layout options
    public bool $centered = false;
    public bool $scrollable = false;

    // Behavior options
    public string|bool $backdrop = true; // true | false | 'static'
    public bool $keyboard = true;
    public bool $focus = true;

    // Animation
    public bool $animation = true;

    // Header/Footer visibility
    public bool $showHeader = true;
    public bool $showFooter = true;
    public bool $showCloseButton = true;

    // Button labels
    public ?string $closeLabel = null;
    public ?string $saveLabel = null;

    public function mount(): void
    {
        $d = $this->config->for('modal');

        $this->applyStimulusDefaults($d);

        // Apply defaults
        $this->applySizeDefaults($d);
        $this->applyClassDefaults($d);
        $this->fullscreen = $this->fullscreen !== false ? $this->fullscreen : ($d['fullscreen'] ?? false);
        $this->centered = $this->centered || ($d['centered'] ?? false);
        $this->scrollable = $this->scrollable || ($d['scrollable'] ?? false);

        // Behavior
        if ($this->backdrop === true) {
            $this->backdrop = $d['backdrop'] ?? true;


            // Initialize controller with default
            $this->initializeController();
        }
        $this->keyboard = $this->keyboard && ($d['keyboard'] ?? true);
        $this->focus = $this->focus && ($d['focus'] ?? true);

        // Animation
        $this->animation = $this->animation && ($d['animation'] ?? true);

        // Visibility
        $this->showHeader = $this->showHeader && ($d['show_header'] ?? true);
        $this->showFooter = $this->showFooter && ($d['show_footer'] ?? true);
        $this->showCloseButton = $this->showCloseButton && ($d['show_close_button'] ?? true);

        // Labels
        $this->closeLabel ??= $d['close_label'] ?? 'Close';
        $this->saveLabel ??= $d['save_label'] ?? 'Save changes';
    }

    protected function getComponentName(): string
    {
        return 'modal';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        // Modal wrapper classes
        $modalClasses = ['modal'];
        if ($this->animation) {
            $modalClasses[] = 'fade';
        }
        if ($this->class) {
            $modalClasses = array_merge($modalClasses, explode(' ', trim($this->class)));
        }

        // Modal dialog classes
        $dialogClasses = array_merge(
            ['modal-dialog'],
            $this->sizeClassesFor('modal')
        );
        if ($this->fullscreen === true) {
            $dialogClasses[] = 'modal-fullscreen';
        } elseif (is_string($this->fullscreen)) {
            $dialogClasses[] = "modal-fullscreen-{$this->fullscreen}-down";
        }
        if ($this->centered) {
            $dialogClasses[] = 'modal-dialog-centered';
        }
        if ($this->scrollable) {
            $dialogClasses[] = 'modal-dialog-scrollable';
        }

        // Modal attributes
        $attrs = [
            'id' => $this->id,
            'tabindex' => '-1',
            'aria-labelledby' => $this->title ? "{$this->id}Label" : null,
            'aria-hidden' => 'true',
        ];

        // Backdrop attribute
        if ($this->backdrop === 'static') {
            $attrs['data-bs-backdrop'] = 'static';
        } elseif ($this->backdrop === false) {
            $attrs['data-bs-backdrop'] = 'false';
        }

        // Keyboard attribute
        if (!$this->keyboard) {
            $attrs['data-bs-keyboard'] = 'false';
        }

        // Merge with custom attributes
        $attrs = $this->mergeAttributes($attrs, $this->attr);

        return [
            'modalClasses' => implode(' ', array_filter($modalClasses)),
            'dialogClasses' => implode(' ', array_filter($dialogClasses)),
            'attrs' => $attrs,
            'title' => $this->title,
            'titleId' => $this->title ? "{$this->id}Label" : null,
            'showHeader' => $this->showHeader,
            'showFooter' => $this->showFooter,
            'showCloseButton' => $this->showCloseButton,
            'closeLabel' => $this->closeLabel,
            'saveLabel' => $this->saveLabel,
        ];
    }
}

