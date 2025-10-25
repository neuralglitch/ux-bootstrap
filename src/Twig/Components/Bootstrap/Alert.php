<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\VariantTrait;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:alert', template: '@NeuralGlitchUxBootstrap/components/bootstrap/alert.html.twig')]
final class Alert extends AbstractStimulus
{
    use VariantTrait;

    public string $stimulusController = 'bs-alert';

    public ?string $message = null;
    public bool $dismissible = false;
    public bool $fade = true;
    public bool $show = true;
    public bool $autoHide = false;
    public int $autoHideDelay = 5000;
    public string $role = 'alert';

    public function mount(): void
    {
        $d = $this->config->for('alert');

        $this->applyVariantDefaults($d);
        $this->applyStimulusDefaults($d);
        $this->applyClassDefaults($d);

        // Apply defaults from config
        $this->dismissible = $this->dismissible || $this->configBoolWithFallback($d, 'dismissible', false);
        $this->fade = $this->fade && $this->configBoolWithFallback($d, 'fade', true);
        $this->show = $this->show && $this->configBoolWithFallback($d, 'show', true);
        $this->autoHide = $this->autoHide || $this->configBoolWithFallback($d, 'auto_hide', false);
        $this->autoHideDelay = $this->autoHideDelay ?: $this->configIntWithFallback($d, 'auto_hide_delay', 5000);
        $this->role = $this->role ?: $this->configStringWithFallback($d, 'role', 'alert');

        // Initialize controller with default
        $this->initializeController();
    }

    /**
     * Override to conditionally attach controller only when auto-hide is enabled
     */
    protected function shouldAttachController(): bool
    {
        return $this->controllerEnabled && $this->autoHide;
    }

    /**
     * Override to build Alert-specific Stimulus attributes
     */
    protected function buildStimulusAttributes(): array
    {
        $attrs = $this->stimulusControllerAttributes();

        // Only add values if controller is active
        if ($this->resolveControllers() !== '') {
            $attrs = array_merge($attrs, $this->stimulusValues('bs-alert', [
                'autoHide' => $this->autoHide,
                'autoHideDelay' => $this->autoHideDelay,
            ]));
        }

        return $attrs;
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
        $classes = $this->buildClassesFromArrays(
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

        // Add Stimulus controller attributes using new pattern
        $attrs = $this->mergeAttributes($attrs, $this->buildStimulusAttributes());

        // Merge custom attributes
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
