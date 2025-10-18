<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractBootstrap;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:testimonial', template: '@NeuralGlitchUxBootstrap/components/extra/testimonial.html.twig')]
final class Testimonial extends AbstractBootstrap
{
    public ?string $variant = null;

    // Content
    public ?string $quote = null;
    public ?string $author = null;
    public ?string $role = null;
    public ?string $company = null;

    // Media
    public ?string $avatarSrc = null;
    public ?string $avatarAlt = null;

    // Rating (optional)
    public ?int $rating = null; // 1-5 stars

    // Layout
    public ?string $container = null;
    public ?string $alignment = null; // 'left' | 'center' | 'right'

    // Grid/Wall variants
    public ?int $columns = null; // For grid/wall variants

    public function mount(): void
    {
        $d = $this->config->for('testimonial');

        // Apply defaults from config
        $this->variant ??= $d['variant'] ?? 'single';
        $this->quote ??= $d['quote'] ?? null;
        $this->author ??= $d['author'] ?? null;
        $this->role ??= $d['role'] ?? null;
        $this->company ??= $d['company'] ?? null;
        $this->avatarSrc ??= $d['avatar_src'] ?? null;
        $this->avatarAlt ??= $d['avatar_alt'] ?? null;
        $this->rating ??= $d['rating'] ?? null;
        $this->container ??= $d['container'] ?? 'container';
        $this->alignment ??= $d['alignment'] ?? 'left';
        $this->columns ??= $d['columns'] ?? 3;

        $this->applyClassDefaults($d);

        // Merge attr defaults
        if (isset($d['attr']) && is_array($d['attr'])) {
            $this->attr = array_merge($d['attr'], $this->attr);
        }
    }

    protected function getComponentName(): string
    {
        return 'testimonial';
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

        return [
            'variant' => $this->variant,
            'quote' => $this->quote,
            'author' => $this->author,
            'role' => $this->role,
            'company' => $this->company,
            'avatarSrc' => $this->avatarSrc,
            'avatarAlt' => $this->avatarAlt,
            'rating' => $this->rating,
            'container' => $this->container,
            'alignment' => $this->alignment,
            'columns' => $this->columns,
            'classes' => $classes,
            'attrs' => $attrs,
        ];
    }

    /**
     * Get column class for grid/wall variants
     */
    public function getColumnClass(): string
    {
        $cols = $this->columns ?? 3;
        return match ($cols) {
            2 => 'col-md-6',
            3 => 'col-md-6 col-lg-4',
            4 => 'col-md-6 col-lg-3',
            default => 'col-md-6 col-lg-4',
        };
    }

    /**
     * Get alignment class
     */
    public function getAlignmentClass(): string
    {
        $align = $this->alignment ?? 'left';
        return match ($align) {
            'center' => 'text-center',
            'right' => 'text-end',
            default => 'text-start',
        };
    }

    /**
     * Render star rating HTML
     */
    public function renderStars(int $rating): string
    {
        $html = '<div class="text-warning mb-2">';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) {
                $html .= '<i class="bi bi-star-fill"></i>';
            } else {
                $html .= '<i class="bi bi-star"></i>';
            }
        }
        $html .= '</div>';
        return $html;
    }
}

