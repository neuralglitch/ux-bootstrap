<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\SizeTrait;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:button', template: '@NeuralGlitchUxBootstrap/components/bootstrap/button.html.twig')]
final class Button extends AbstractInteraction
{
    use SizeTrait;

    public string $stimulusController = 'bs-button';

    public ?string $href = null;
    public string $type = 'button';

    public function mount(): void
    {
        $d = $this->config->for('button');

        $this->applyCommonDefaults($d);
        $this->applySizeDefaults($d);
        $this->applyClassDefaults($d);

        // Initialize controller with default
        $this->initializeController();
    }

    protected function getComponentType(): string
    {
        return 'button';
    }

    protected function getComponentName(): string
    {
        return 'button';
    }

    /**
     * Override to conditionally attach controllers
     * Button attaches:
     * - bs-button: When explicitly enabled OR for enhanced features
     * - bs-tooltip: When tooltip is configured
     * - bs-popover: When popover is configured
     */
    protected function shouldAttachController(): bool
    {
        // Button can attach its own controller OR tooltip/popover controllers
        return $this->controllerEnabled;
    }

    /**
     * Override to attach appropriate controllers
     */
    protected function buildStimulusAttributes(): array
    {
        $attrs = [];

        // Build list of controllers to attach
        $controllers = [];

        // Add button controller if explicitly requested
        if ($this->controller !== '' && str_contains($this->controller, 'bs-button')) {
            $controllers[] = 'bs-button';
        }

        // Add tooltip controller if tooltip is configured
        if ($this->tooltip !== null) {
            $controllers[] = 'bs-tooltip';
        }

        // Add popover controller if popover is configured
        if ($this->popover !== null) {
            $controllers[] = 'bs-popover';
        }

        // Add any additional custom controllers from the controller property
        if ($this->controller !== '') {
            // Split and filter out bs-button/bs-tooltip/bs-popover (already added)
            $customControllers = array_filter(
                explode(' ', $this->controller),
                fn($c) => !in_array($c, ['bs-button', 'bs-tooltip', 'bs-popover'], true)
            );
            $controllers = array_merge($controllers, $customControllers);
        }

        // Build data-controller attribute if we have controllers
        if (!empty($controllers)) {
            $attrs['data-controller'] = implode(' ', array_unique($controllers));
        }

        // No component-specific values needed for now
        // bs-button controller can be enhanced later with values

        return $attrs;
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $isAnchor = $this->href !== null;

        $classes = array_merge(
            ['btn'],
            $this->variantClassesFor('button'),  // btn-(outline-)?<variant>
            $this->sizeClassesFor('button'),     // btn-sm/btn-lg
            $this->stateClassesFor('button'),    // w-100, active, …
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = $this->buildCommonAttributes($isAnchor);

        $iconSpace = $this->iconSpacingClasses('button');

        return [
            'tag' => $isAnchor ? 'a' : 'button',
            'href' => $this->href,
            'type' => $this->type,
            'label' => $this->label,
            'iconStart' => $this->iconStart,
            'iconEnd' => $this->iconEnd,
            'iconOnly' => $this->iconOnly,
            'iconSize' => $this->effectiveIconSize(),
            'classes' => implode(' ', array_unique(array_filter($classes))),
            'attrs' => $attrs,
            'disabled' => $this->disabled,
            'iconStartClasses' => implode(' ', $iconSpace['start']),
            'iconEndClasses' => implode(' ', $iconSpace['end']),
        ];
    }
}
