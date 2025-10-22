<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:feature-grid', template: '@NeuralGlitchUxBootstrap/components/extra/feature-grid.html.twig')]
final class FeatureGrid extends AbstractStimulus
{
    // Layout
    public ?int $columns = null;        // Number of columns: 2, 3, 4, or 6
    public ?string $gap = null;         // Gap between items (1-5)
    public ?string $container = null;   // 'container' | 'container-fluid' | 'container-{breakpoint}'

    // Appearance
    public ?string $variant = null;     // 'default' | 'icon-lg' | 'icon-box' | 'icon-colored' | 'bordered' | 'shadow'
    public ?string $align = null;       // 'start' | 'center' | 'end'
    public bool $centered = false;      // Center all content (title, icons, text)

    /**
     * Features array
     * Each feature: ['icon' => '...', 'title' => '...', 'description' => '...', 'variant' => 'primary']
     * @var array<int, array<string, mixed>>
     */
    public array $features = [];

    // Heading
    public ?string $heading = null;
    public ?string $subheading = null;
    public ?string $headingTag = null;
    public ?string $headingAlign = null;

    public function mount(): void
    {
        $d = $this->config->for('feature-grid');

        $this->applyStimulusDefaults($d);

        // Apply defaults from config
        $this->columns ??= $d['columns'] ?? 3;
        $this->gap ??= $d['gap'] ?? '4';
        $this->container ??= $d['container'] ?? 'container';
        $this->variant ??= $d['variant'] ?? 'default';
        $this->align ??= $d['align'] ?? 'start';
        $this->centered = $this->centered || ($d['centered'] ?? false);
        $this->headingTag ??= $d['heading_tag'] ?? 'h2';
        $this->headingAlign ??= $d['heading_align'] ?? 'center';

        $this->applyClassDefaults($d);

        // Merge attr defaults
        if (isset($d['attr']) && is_array($d['attr'])) {
            $this->attr = array_merge($d['attr'], $this->attr);


            // Initialize controller with default
            $this->initializeController();
        }
    }

    protected function getComponentName(): string
    {
        return 'feature-grid';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = $this->buildClasses(
            ['py-5'],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = $this->mergeAttributes([], $this->attr);

        // Determine grid column classes based on columns setting
        $colClass = match ($this->columns) {
            2 => 'col-md-6',
            3 => 'col-md-4',
            4 => 'col-md-6 col-lg-3',
            6 => 'col-sm-6 col-md-4 col-lg-2',
            default => 'col-md-4',
        };

        return [
            'container' => $this->container,
            'columns' => $this->columns,
            'colClass' => $colClass,
            'gap' => $this->gap,
            'variant' => $this->variant,
            'align' => $this->align,
            'centered' => $this->centered,
            'features' => $this->features,
            'heading' => $this->heading,
            'subheading' => $this->subheading,
            'headingTag' => $this->headingTag,
            'headingAlign' => $this->headingAlign,
            'classes' => $classes,
            'attrs' => $attrs,
        ];
    }
}

