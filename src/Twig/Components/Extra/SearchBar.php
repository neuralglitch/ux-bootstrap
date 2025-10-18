<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractBootstrap;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('bs:searchbar', template: '@NeuralGlitchUxBootstrap/components/extra/searchbar.html.twig')]
final class SearchBar extends AbstractBootstrap
{
    public string $placeholder = 'Search...';
    public string $searchUrl = '/search';
    public int $minChars = 2;
    public int $debounce = 300;
    public string $size = 'default';
    public bool $showClear = true;
    public bool $autofocus = false;
    public string $name = 'q';

    public function mount(): void
    {
        $d = $this->config->for('searchbar');

        $this->placeholder ??= $d['placeholder'] ?? 'Search...';
        $this->searchUrl ??= $d['search_url'] ?? '/search';
        $this->minChars ??= $d['min_chars'] ?? 2;
        $this->debounce ??= $d['debounce'] ?? 300;
        $this->size ??= $d['size'] ?? 'default';
        $this->showClear = $this->showClear && ($d['show_clear'] ?? true);
        $this->autofocus = $this->autofocus || ($d['autofocus'] ?? false);
        $this->name ??= $d['name'] ?? 'q';

        $this->applyClassDefaults($d);
    }

    protected function getComponentName(): string
    {
        return 'searchbar';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $inputClasses = ['form-control'];

        if ($this->size === 'sm') {
            $inputClasses[] = 'form-control-sm';
        } elseif ($this->size === 'lg') {
            $inputClasses[] = 'form-control-lg';
        }

        $containerClasses = $this->buildClasses(
            ['search-container'],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = $this->mergeAttributes([], $this->attr);

        return [
            'placeholder' => $this->placeholder,
            'searchUrl' => $this->searchUrl,
            'minChars' => $this->minChars,
            'debounce' => $this->debounce,
            'name' => $this->name,
            'showClear' => $this->showClear,
            'autofocus' => $this->autofocus,
            'inputClasses' => implode(' ', array_unique($inputClasses)),
            'containerClasses' => $containerClasses,
            'attrs' => $attrs,
        ];
    }
}

