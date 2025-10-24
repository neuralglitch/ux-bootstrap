<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\VariantTrait;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:badge', template: '@NeuralGlitchUxBootstrap/components/bootstrap/badge.html.twig')]
final class Badge extends AbstractInteractive
{
    use VariantTrait;

    public string $stimulusController = 'bs-badge';

    public ?string $label = null;
    public ?string $href = null;
    public ?string $target = null;
    public ?string $rel = null;
    public ?string $title = null;
    public ?string $id = null;

    /** Bootstrap text-color utilities: 'primary', 'body', 'white', etc. */
    public ?string $text = null;

    /** If true, applies 'rounded-pill' class */
    public bool $pill = false;

    /** If true, uses 'position-absolute' for notification badges */
    public bool $positioned = false;

    /** Position utilities: 'top-0 start-100', 'top-0 start-0', etc. */
    public ?string $position = null;

    /** If true, applies 'translate-middle' (default for positioned badges) */
    public bool $translate = true;

    // Stimulus Controller Properties
    public ?int $count = null;
    public int $maxCount = 99;
    public bool $autoHide = true;
    public ?string $status = null;  // online, brb, busy, offline
    public bool $blinking = false;
    public bool $hasCounter = false;
    public bool $hasIndicator = false;

    public function mount(): void
    {
        $d = $this->config->for('badge');

        $this->applyInteractiveDefaults($d);
        $this->applyClassDefaults($d);

        // Apply defaults from config
        $this->pill = $this->pill || ($d['pill'] ?? false);
        $this->href ??= $d['href'] ?? null;
        $this->target ??= $d['target'] ?? null;
        $this->rel ??= $d['rel'] ?? null;
        $this->title ??= $d['title'] ?? null;
        $this->id ??= $d['id'] ?? null;
        $this->text ??= $d['text'] ?? null;
        $this->positioned = $this->positioned || ($d['positioned'] ?? false);
        $this->position ??= $d['position'] ?? null;
        $this->translate = $this->translate && ($d['translate'] ?? true);

        // Stimulus controller properties
        $this->count ??= $d['count'] ?? null;
        $this->maxCount = $this->maxCount ?: ($d['max_count'] ?? 99);
        $this->autoHide = $this->autoHide && ($d['auto_hide'] ?? true);
        $this->status ??= $d['status'] ?? null;
        $this->blinking = $this->blinking || ($d['blinking'] ?? false);
        $this->hasCounter = $this->hasCounter || ($d['has_counter'] ?? false);
        $this->hasIndicator = $this->hasIndicator || ($d['has_indicator'] ?? false);

        // Initialize controller with default
        $this->initializeController();
    }

    protected function getComponentType(): string
    {
        return 'badge';
    }

    protected function getComponentName(): string
    {
        return 'badge';
    }

    /**
     * Override to conditionally attach controller only when interactive features are used
     */
    protected function shouldAttachController(): bool
    {
        return $this->controllerEnabled && (
                $this->hasCounter ||
                $this->hasIndicator ||
                $this->count !== null ||
                $this->status !== null ||
                $this->blinking
            );
    }

    /**
     * Override to build Badge-specific Stimulus attributes
     */
    protected function buildStimulusAttributes(): array
    {
        $attrs = $this->stimulusControllerAttributes();

        // Only add values if controller is active
        if ($this->resolveControllers() !== '') {
            $values = [];

            if ($this->count !== null) {
                $values['count'] = $this->count;
            }
            if ($this->maxCount !== 99) {
                $values['maxCount'] = $this->maxCount;
            }
            if (!$this->autoHide) {
                $values['autoHide'] = $this->autoHide;
            }
            if ($this->status !== null) {
                $values['status'] = $this->status;
            }
            if ($this->blinking) {
                $values['blinking'] = $this->blinking;
            }

            $attrs = array_merge($attrs, $this->stimulusValues('bs-badge', $values));
        }

        return $attrs;
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $isLink = $this->href !== null;

        $classes = $this->buildClasses(
            ['badge'],
            $this->variantClassesFor('badge'),  // text-bg-{variant}
            $this->pill ? ['rounded-pill'] : [],
            $this->text ? ["text-{$this->text}"] : [],
            $this->positionClasses(),
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = [];

        if ($this->id) {
            $attrs['id'] = $this->id;
        }
        if ($this->title) {
            $attrs['title'] = $this->title;
        }

        // Link-specific attributes
        if ($isLink) {
            if ($this->target) {
                $attrs['target'] = $this->target;
            }
            if ($this->rel) {
                $attrs['rel'] = $this->rel;
            }
        }

        // Add Stimulus controller attributes using new pattern
        $attrs = $this->mergeAttributes($attrs, $this->buildStimulusAttributes());

        // Merge custom attributes
        $attrs = $this->mergeAttributes($attrs, $this->attr);

        return [
            'tag' => $isLink ? 'a' : 'span',
            'href' => $this->href,
            'label' => $this->label,
            'classes' => $classes,
            'attrs' => $attrs,
            'hasCounter' => $this->hasCounter,
            'hasIndicator' => $this->hasIndicator,
            'count' => $this->count,
        ];
    }

    /**
     * @return array<string>
     */
    private function positionClasses(): array
    {
        if (!$this->positioned) {
            return [];
        }

        $c = ['position-absolute'];

        if ($this->position) {
            // Split position string into individual classes (e.g. "top-0 start-100")
            $c = array_merge($c, explode(' ', trim($this->position)));
        }

        if ($this->translate) {
            $c[] = 'translate-middle';
        }

        return $c;
    }
}

