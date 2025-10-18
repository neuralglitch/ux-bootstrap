<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\VariantTrait;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:alert', template: '@NeuralGlitchUxBootstrap/components/bootstrap/alert.html.twig')]
final class Alert extends AbstractStimulus
{
    use VariantTrait;

    public ?string $message = null;
    public bool $dismissible = false;
    public bool $fade = true;
    public bool $show = true;
    public bool $autoHide = false;
    public int $autoHideDelay = 5000;
    public string $role = 'alert';
    public string $stimulusController = 'bs-alert';

    public function mount(): void
    {
        $d = $this->config->for('alert');

        $this->applyVariantDefaults($d);
        $this->applyStimulusDefaults($d);
        $this->applyClassDefaults($d);

        // Apply defaults from config
        $this->dismissible = $this->dismissible || ($d['dismissible'] ?? false);
        $this->fade = $this->fade && ($d['fade'] ?? true);
        $this->show = $this->show && ($d['show'] ?? true);
        $this->autoHide = $this->autoHide || ($d['auto_hide'] ?? false);
        $this->autoHideDelay = $this->autoHideDelay ?: ($d['auto_hide_delay'] ?? 5000);
        $this->role = $this->role ?: ($d['role'] ?? 'alert');
    }

    protected function getComponentName(): string
    {
        return 'alert';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = $this->buildClasses(
            ['alert'],
            $this->variantClassesFor('alert'),  // alert-{variant}
            $this->dismissible ? ['alert-dismissible'] : [],
            $this->fade ? ['fade'] : [],
            $this->show ? ['show'] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = [
            'role' => $this->role,
        ];

        // Add stimulus attributes for auto-hide functionality
        if ($this->autoHide) {
            $attrs = $this->mergeAttributes($attrs, $this->stimulusAttributes($this->stimulusController));
            $attrs['data-bs-alert-auto-hide-value'] = 'true';
            $attrs['data-bs-alert-auto-hide-delay-value'] = (string)$this->autoHideDelay;
        }

        $attrs = $this->mergeAttributes($attrs, $this->attr);

        return [
            'message' => $this->message,
            'dismissible' => $this->dismissible,
            'fade' => $this->fade,
            'show' => $this->show,
            'autoHide' => $this->autoHide,
            'autoHideDelay' => $this->autoHideDelay,
            'classes' => $classes,
            'attrs' => $attrs,
        ];
    }
}
