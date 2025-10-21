<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:rating', template: '@NeuralGlitchUxBootstrap/components/extra/rating.html.twig')]
final class Rating extends AbstractStimulus
{
    // Rating value
    public float $value = 0;
    public int $max = 5;

    // Display mode
    public string $mode = 'stars';          // 'stars' | 'hearts' | 'circles' | 'custom'
    public bool $readonly = false;          // Interactive or read-only
    public bool $halfStars = false;         // Allow half-star ratings

    // Appearance
    public string $size = 'default';        // 'sm' | 'default' | 'lg'
    public ?string $variant = null;         // Bootstrap color variants
    public string $emptyVariant = 'secondary'; // Color for empty stars
    public ?string $customIcon = null;      // Custom icon HTML/emoji

    // Labels and display
    public bool $showValue = false;         // Show numeric value (e.g., "4.5")
    public bool $showCount = false;         // Show count/max (e.g., "4/5")
    public bool $showText = false;          // Show text label
    public ?string $text = null;            // Custom text label
    public string $textPosition = 'end';    // 'start' | 'end'

    // Accessibility
    public ?string $ariaLabel = null;
    public bool $ariaLive = false;          // Announce changes to screen readers

    public function mount(): void
    {
        $d = $this->config->for('rating');

        $this->applyStimulusDefaults($d);

        // Apply defaults from config
        // For properties with defaults, only apply config if value hasn't been explicitly changed from default
        if (isset($d['value']) && is_numeric($d['value']) && $this->value === 0.0) {
            $this->value = (float) $d['value'];

        
        // Initialize controller with default
        $this->initializeController();
    }
        if (isset($d['max']) && is_int($d['max']) && $this->max === 5) {
            $this->max = $d['max'];
        }
        if (isset($d['mode']) && is_string($d['mode']) && $this->mode === 'stars') {
            $this->mode = $d['mode'];
        }
        if (isset($d['size']) && is_string($d['size']) && $this->size === 'default') {
            $this->size = $d['size'];
        }
        if (isset($d['empty_variant']) && is_string($d['empty_variant']) && $this->emptyVariant === 'secondary') {
            $this->emptyVariant = $d['empty_variant'];
        }
        if (isset($d['text_position']) && is_string($d['text_position']) && $this->textPosition === 'end') {
            $this->textPosition = $d['text_position'];
        }
        
        // Boolean properties
        $this->readonly = $this->readonly || (is_bool($d['readonly'] ?? false) && ($d['readonly'] ?? false));
        $this->halfStars = $this->halfStars || (is_bool($d['half_stars'] ?? false) && ($d['half_stars'] ?? false));
        $this->showValue = $this->showValue || (is_bool($d['show_value'] ?? false) && ($d['show_value'] ?? false));
        $this->showCount = $this->showCount || (is_bool($d['show_count'] ?? false) && ($d['show_count'] ?? false));
        $this->showText = $this->showText || (is_bool($d['show_text'] ?? false) && ($d['show_text'] ?? false));
        $this->ariaLive = $this->ariaLive || (is_bool($d['aria_live'] ?? false) && ($d['aria_live'] ?? false));
        
        // Nullable properties
        if (array_key_exists('variant', $d) && (is_string($d['variant']) || $d['variant'] === null)) {
            $this->variant ??= $d['variant'];
        }

        $this->applyClassDefaults($d);

        // Merge attr defaults
        if (isset($d['attr']) && is_array($d['attr'])) {
            $this->attr = array_merge($d['attr'], $this->attr);
        }
    }

    protected function getComponentName(): string
    {
        return 'rating';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $sizeClasses = match ($this->size) {
            'sm' => ['rating-sm'],
            'lg' => ['rating-lg'],
            default => [],
        };

        $classes = $this->buildClasses(
            ['rating', "rating-{$this->mode}"],
            $this->readonly ? ['rating-readonly'] : ['rating-interactive'],
            $sizeClasses,
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = $this->mergeAttributes(
            [
                'role' => 'img',
                'aria-label' => $this->ariaLabel ?? $this->generateAriaLabel(),
            ],
            $this->attr
        );

        if ($this->ariaLive && !$this->readonly) {
            $attrs['aria-live'] = 'polite';
        }

        // Generate rating items
        $items = $this->generateRatingItems();

        return [
            'value' => $this->value,
            'max' => $this->max,
            'mode' => $this->mode,
            'readonly' => $this->readonly,
            'halfStars' => $this->halfStars,
            'variant' => $this->variant,
            'emptyVariant' => $this->emptyVariant,
            'customIcon' => $this->customIcon,
            'showValue' => $this->showValue,
            'showCount' => $this->showCount,
            'showText' => $this->showText,
            'text' => $this->text,
            'textPosition' => $this->textPosition,
            'items' => $items,
            'classes' => $classes,
            'attrs' => $attrs,
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function generateRatingItems(): array
    {
        $items = [];
        $value = $this->value;
        $max = $this->max;

        for ($i = 1; $i <= $max; $i++) {
            $state = $this->getItemState($i, $value);
            $icon = $this->getIcon($state);

            $itemClasses = [
                'rating-item',
                "rating-item-{$state}",
            ];

            if ($state === 'filled') {
                $itemClasses[] = $this->variant ? "text-{$this->variant}" : 'text-warning';
            } elseif ($state === 'half') {
                $itemClasses[] = $this->variant ? "text-{$this->variant}" : 'text-warning';
            } else {
                $itemClasses[] = "text-{$this->emptyVariant}";
            }

            $items[] = [
                'index' => $i,
                'state' => $state,
                'icon' => $icon,
                'classes' => implode(' ', $itemClasses),
            ];
        }

        return $items;
    }

    private function getItemState(int $index, float $value): string
    {
        if ($value >= $index) {
            return 'filled';
        }

        if ($this->halfStars && $value >= ($index - 0.5)) {
            return 'half';
        }

        return 'empty';
    }

    private function getIcon(string $state): string
    {
        if ($this->customIcon) {
            return $this->customIcon;
        }

        return match ($this->mode) {
            'hearts' => $this->getHeartIcon($state),
            'circles' => $this->getCircleIcon($state),
            'custom' => $this->customIcon ?? '',
            default => $this->getStarIcon($state),
        };
    }

    private function getStarIcon(string $state): string
    {
        return match ($state) {
            'filled' => '★',
            'half' => '⯨',
            default => '☆',
        };
    }

    private function getHeartIcon(string $state): string
    {
        return match ($state) {
            'filled' => '♥',
            'half' => '♡',
            default => '♡',
        };
    }

    private function getCircleIcon(string $state): string
    {
        return match ($state) {
            'filled' => '●',
            'half' => '◐',
            default => '○',
        };
    }

    private function generateAriaLabel(): string
    {
        $ratingText = $this->halfStars
            ? number_format($this->value, 1)
            : (string) (int) $this->value;

        return "Rating: {$ratingText} out of {$this->max}";
    }
}

