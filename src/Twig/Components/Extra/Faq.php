<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:faq', template: '@NeuralGlitchUxBootstrap/components/extra/faq.html.twig')]
final class Faq extends AbstractStimulus
{
    public ?string $variant = null;

    /**
     * @var array<int, array{question: string, answer: string, id?: string}>
     */
    public array $items = [];

    public ?string $title = null;
    public ?string $lead = null;
    public ?string $accordionId = null;
    public bool $flush = false;
    public bool $alwaysOpen = false;

    public function mount(): void
    {
        $d = $this->config->for('faq');

        $this->applyStimulusDefaults($d);

        // Apply defaults from config
        $this->variant ??= $d['variant'] ?? 'accordion';
        $this->title ??= $d['title'] ?? null;
        $this->lead ??= $d['lead'] ?? null;
        $this->flush = $this->flush || ($d['flush'] ?? false);
        $this->alwaysOpen = $this->alwaysOpen || ($d['always_open'] ?? false);

        // Generate accordion ID if not provided
        if ($this->accordionId === null) {
            $this->accordionId = 'faq-' . uniqid();

        
        // Initialize controller with default
        $this->initializeController();
    }

        $this->applyClassDefaults($d);

        // Merge attr defaults
        if (isset($d['attr']) && is_array($d['attr'])) {
            $this->attr = array_merge($d['attr'], $this->attr);
        }
    }

    protected function getComponentName(): string
    {
        return 'faq';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = $this->buildClasses(
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = $this->mergeAttributes([], $this->attr);

        // Process items to ensure they have IDs
        $processedItems = [];
        foreach ($this->items as $index => $item) {
            $processedItems[] = [
                'question' => $item['question'],
                'answer' => $item['answer'],
                'id' => $item['id'] ?? $this->accordionId . '-item-' . $index,
            ];
        }

        return [
            'variant' => $this->variant,
            'items' => $processedItems,
            'title' => $this->title,
            'lead' => $this->lead,
            'accordionId' => $this->accordionId,
            'flush' => $this->flush,
            'alwaysOpen' => $this->alwaysOpen,
            'classes' => $classes,
            'attrs' => $attrs,
        ];
    }
}

