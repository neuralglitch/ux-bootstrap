<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\VariantTrait;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:toast', template: '@NeuralGlitchUxBootstrap/components/bootstrap/toast.html.twig')]
final class Toast extends AbstractStimulus
{
    use VariantTrait;

    public string $stimulusController = 'bs-toast';

    public ?string $message = null;
    public ?string $title = null;
    public bool $header = true;
    public bool $body = true;
    public bool $autohide = true;
    public int $delay = 5000;
    public bool $animation = true;
    public string $position = 'top-0 end-0';

    public function mount(): void
    {
        $d = $this->config->for('toast');

        $this->applyVariantDefaults($d);
        $this->applyStimulusDefaults($d);
        $this->applyClassDefaults($d);

        // Apply defaults from config
        $this->title = $this->title ?: ($d['title'] ?? null);
        $this->header = $this->header && ($d['header'] ?? true);
        $this->body = $this->body && ($d['body'] ?? true);
        $this->autohide = $this->autohide && ($d['autohide'] ?? true);
        $this->delay = $this->delay ?: ($d['delay'] ?? 5000);
        $this->animation = $this->animation && ($d['animation'] ?? true);
        $this->position = $this->position ?: ($d['position'] ?? 'top-0 end-0');

        // Initialize controller with default (Toast always has a controller)
        $this->initializeController();
    }

    protected function getComponentName(): string
    {
        return 'toast';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = $this->buildClasses(
            ['toast'],
            $this->animation ? ['fade'] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = [
            'role' => 'alert',
            'aria-live' => 'assertive',
            'aria-atomic' => 'true',
            'data-bs-autohide' => $this->autohide ? 'true' : 'false',
            'data-bs-delay' => (string)$this->delay,
        ];

        // Add Stimulus controller attributes using new pattern
        $attrs = $this->mergeAttributes($attrs, $this->buildStimulusAttributes());

        // Merge custom attributes
        $attrs = $this->mergeAttributes($attrs, $this->attr);

        return [
            'message' => $this->message,
            'title' => $this->title,
            'header' => $this->header,
            'body' => $this->body,
            'autohide' => $this->autohide,
            'delay' => $this->delay,
            'animation' => $this->animation,
            'position' => $this->position,
            'classes' => $classes,
            'attrs' => $attrs,
        ];
    }
}
