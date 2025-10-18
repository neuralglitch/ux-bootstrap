<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractBootstrap;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:skeleton', template: '@NeuralGlitchUxBootstrap/components/extra/skeleton.html.twig')]
final class Skeleton extends AbstractBootstrap
{
    /**
     * Skeleton type/preset
     * Options: 'text', 'heading', 'avatar', 'card', 'list', 'paragraph', 'custom'
     */
    public ?string $type = null;

    /**
     * Number of lines/items (for text, paragraph, list types)
     */
    public ?int $lines = null;

    /**
     * Width of skeleton (CSS value or percentage)
     * Can be 'full', 'sm', 'md', 'lg', or custom CSS value like '200px', '75%'
     */
    public ?string $width = null;

    /**
     * Height of skeleton (CSS value)
     * Useful for custom skeletons
     */
    public ?string $height = null;

    /**
     * Animation type
     * Options: 'wave', 'pulse', 'none'
     */
    public ?string $animation = null;

    /**
     * Size variant for avatars
     * Options: 'sm', 'md', 'lg', 'xl'
     */
    public ?string $size = null;

    /**
     * Avatar shape
     * Options: 'circle', 'square', 'rounded'
     */
    public ?string $avatarShape = null;

    /**
     * Show avatar with text (for card/list types)
     */
    public bool $withAvatar = false;

    /**
     * Show button skeleton (for card type)
     */
    public bool $withButton = false;

    /**
     * Show image skeleton (for card type)
     */
    public bool $withImage = false;

    /**
     * Border radius
     * Options: 'none', 'sm', 'default', 'lg', 'pill', 'circle'
     */
    public ?string $rounded = null;

    /**
     * Custom container tag
     */
    public ?string $tag = null;

    public function mount(): void
    {
        $d = $this->config->for('skeleton');

        $this->applyClassDefaults($d);

        $this->type ??= is_string($d['type'] ?? null) ? $d['type'] : 'text';
        $this->lines ??= is_int($d['lines'] ?? null) ? $d['lines'] : 3;
        $this->width ??= is_string($d['width'] ?? null) ? $d['width'] : null;
        $this->height ??= is_string($d['height'] ?? null) ? $d['height'] : null;
        $this->animation ??= is_string($d['animation'] ?? null) ? $d['animation'] : 'wave';
        $this->size ??= is_string($d['size'] ?? null) ? $d['size'] : null;
        $this->avatarShape ??= is_string($d['avatar_shape'] ?? null) ? $d['avatar_shape'] : 'circle';
        $this->withAvatar = $this->withAvatar || (is_bool($d['with_avatar'] ?? null) ? $d['with_avatar'] : false);
        $this->withButton = $this->withButton || (is_bool($d['with_button'] ?? null) ? $d['with_button'] : false);
        $this->withImage = $this->withImage || (is_bool($d['with_image'] ?? null) ? $d['with_image'] : false);
        $this->rounded ??= is_string($d['rounded'] ?? null) ? $d['rounded'] : null;
        $this->tag ??= is_string($d['tag'] ?? null) ? $d['tag'] : 'div';
    }

    protected function getComponentName(): string
    {
        return 'skeleton';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $baseClasses = ['placeholder-glow'];
        
        if ($this->animation === 'wave') {
            $baseClasses = ['placeholder-wave'];
        } elseif ($this->animation === 'none') {
            $baseClasses = [];
        }

        $classes = $this->buildClasses(
            $baseClasses,
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = $this->mergeAttributes([], $this->attr);

        // Generate skeleton structure based on type
        $structure = $this->generateStructure();

        return [
            'type' => $this->type,
            'lines' => $this->lines,
            'width' => $this->width,
            'height' => $this->height,
            'animation' => $this->animation,
            'size' => $this->size,
            'avatarShape' => $this->avatarShape,
            'withAvatar' => $this->withAvatar,
            'withButton' => $this->withButton,
            'withImage' => $this->withImage,
            'rounded' => $this->rounded,
            'tag' => $this->tag,
            'classes' => $classes,
            'attrs' => $attrs,
            'structure' => $structure,
        ];
    }

    /**
     * Generate skeleton structure based on type
     * 
     * @return array<string, mixed>
     */
    private function generateStructure(): array
    {
        return match ($this->type) {
            'text' => $this->textStructure(),
            'heading' => $this->headingStructure(),
            'avatar' => $this->avatarStructure(),
            'card' => $this->cardStructure(),
            'list' => $this->listStructure(),
            'paragraph' => $this->paragraphStructure(),
            default => ['custom' => true],
        };
    }

    /**
     * @return array<string, mixed>
     */
    private function textStructure(): array
    {
        $lines = [];
        for ($i = 0; $i < $this->lines; $i++) {
            $lines[] = [
                'width' => $this->calculateLineWidth($i),
                'classes' => $this->placeholderClasses(),
            ];
        }

        return ['lines' => $lines];
    }

    /**
     * @return array<string, mixed>
     */
    private function headingStructure(): array
    {
        return [
            'classes' => $this->placeholderClasses('lg'),
            'width' => $this->width ?? '60%',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function avatarStructure(): array
    {
        $sizeClass = match ($this->size) {
            'sm' => '32px',
            'md' => '48px',
            'lg' => '64px',
            'xl' => '96px',
            default => '48px',
        };

        $shapeClass = match ($this->avatarShape) {
            'circle' => 'rounded-circle',
            'square' => 'rounded-0',
            'rounded' => 'rounded',
            default => 'rounded-circle',
        };

        return [
            'size' => $sizeClass,
            'shape' => $shapeClass,
            'classes' => $this->placeholderClasses(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function cardStructure(): array
    {
        return [
            'withImage' => $this->withImage,
            'withAvatar' => $this->withAvatar,
            'withButton' => $this->withButton,
            'title' => [
                'classes' => $this->placeholderClasses('lg'),
                'width' => '75%',
            ],
            'text' => [
                'lines' => $this->lines,
                'classes' => $this->placeholderClasses(),
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function listStructure(): array
    {
        $items = [];
        for ($i = 0; $i < $this->lines; $i++) {
            $items[] = [
                'withAvatar' => $this->withAvatar,
                'title' => [
                    'classes' => $this->placeholderClasses(),
                    'width' => $this->calculateLineWidth($i, 60, 80),
                ],
                'subtitle' => [
                    'classes' => $this->placeholderClasses('sm'),
                    'width' => $this->calculateLineWidth($i, 40, 60),
                ],
            ];
        }

        return ['items' => $items];
    }

    /**
     * @return array<string, mixed>
     */
    private function paragraphStructure(): array
    {
        $lines = [];
        for ($i = 0; $i < $this->lines; $i++) {
            $width = $this->calculateLineWidth($i, 85, 100);
            // Last line should be shorter
            if ($i === $this->lines - 1) {
                $width = $this->calculateLineWidth($i, 60, 75);
            }

            $lines[] = [
                'width' => $width,
                'classes' => $this->placeholderClasses(),
            ];
        }

        return ['lines' => $lines];
    }

    /**
     * Generate placeholder classes
     */
    private function placeholderClasses(?string $size = null): string
    {
        $classes = ['placeholder'];

        if ($size) {
            $classes[] = "placeholder-{$size}";
        }

        if ($this->rounded) {
            $roundedClass = match ($this->rounded) {
                'none' => 'rounded-0',
                'sm' => 'rounded-1',
                'default' => 'rounded',
                'lg' => 'rounded-3',
                'pill' => 'rounded-pill',
                'circle' => 'rounded-circle',
                default => 'rounded',
            };
            $classes[] = $roundedClass;
        }

        return implode(' ', $classes);
    }

    /**
     * Calculate line width with some variation
     */
    private function calculateLineWidth(int $index, int $min = 75, int $max = 95): string
    {
        if ($this->width) {
            return $this->width;
        }

        // Add some variation to line widths for more natural look
        $seed = $index * 13; // Simple pseudo-random
        $range = $max - $min;
        $width = $min + ($seed % $range);

        return $width . '%';
    }
}

