<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:button-group', template: '@NeuralGlitchUxBootstrap/components/bootstrap/button-group.html.twig')]
final class ButtonGroup extends AbstractStimulus
{
    use Traits\SizeTrait;

    public string $stimulusController = 'bs-button-group';

    /**
     * Vertical orientation - stacks buttons vertically instead of horizontally
     */
    public bool $vertical = false;

    /**
     * Role attribute for accessibility (usually 'group' or 'toolbar')
     */
    public string $role = 'group';

    /**
     * ARIA label for accessibility
     */
    public ?string $ariaLabel = null;

    /**
     * ARIA labelledby for accessibility (alternative to ariaLabel)
     */
    public ?string $ariaLabelledby = null;

    public function mount(): void
    {
        $d = $this->config->for('button_group');

        $this->applyStimulusDefaults($d);

        // Apply defaults
        $this->applySizeDefaults($d);
        $this->applyClassDefaults($d);

        // Apply component-specific defaults
        $this->vertical = $this->vertical || ($d['vertical'] ?? false);
        $this->role = $this->role ?: ($d['role'] ?? 'group');
        $this->ariaLabel ??= $d['aria_label'] ?? null;
        $this->ariaLabelledby ??= $d['aria_labelledby'] ?? null;


        // Initialize controller with default
        $this->initializeController();
    }

    protected function getComponentName(): string
    {
        return 'button_group';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $baseClass = $this->vertical ? 'btn-group-vertical' : 'btn-group';

        $classes = $this->buildClasses(
            [$baseClass],
            $this->sizeClassesFor('btn-group'),
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = [
            'role' => $this->role,
        ];

        // Add ARIA label if provided
        if ($this->ariaLabel) {
            $attrs['aria-label'] = $this->ariaLabel;
        }

        // Add ARIA labelledby if provided
        if ($this->ariaLabelledby) {
            $attrs['aria-labelledby'] = $this->ariaLabelledby;
        }

        // Merge with custom attributes
        $attrs = $this->mergeAttributes($attrs, $this->attr);

        return [
            'classes' => $classes,
            'attrs' => $attrs,
        ];
    }
}

