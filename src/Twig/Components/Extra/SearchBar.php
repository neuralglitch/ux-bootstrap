<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('bs:searchbar', template: '@NeuralGlitchUxBootstrap/components/extra/searchbar.html.twig')]
final class SearchBar extends AbstractStimulus
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

        $this->applyStimulusDefaults($d);

        $this->placeholder ??= $d['placeholder'] ?? 'Search...';
        $this->searchUrl ??= $d['search_url'] ?? '/search';
        $this->minChars ??= $d['min_chars'] ?? 2;
        $this->debounce ??= $d['debounce'] ?? 300;
        $this->size ??= $d['size'] ?? 'default';
        $this->showClear = $this->showClear && ($d['show_clear'] ?? true);
        $this->autofocus = $this->autofocus || ($d['autofocus'] ?? false);
        $this->name ??= $d['name'] ?? 'q';

        $this->applyClassDefaults($d);


        // Initialize controller with default
        $this->initializeController();
    }

    protected function getComponentName(): string
    {
        return 'searchbar';
    }

    /**
     * Override default controller name to match registered controller
     * Component name is 'searchbar' but controller is 'bs-search' (shorter)
     */
    protected function getDefaultController(): string
    {
        return 'bs-search';
    }

    /**
     * Override to build SearchBar-specific Stimulus attributes
     */
    protected function buildStimulusAttributes(): array
    {
        $attrs = $this->stimulusControllerAttributes();

        // Add SearchBar-specific values
        if ($this->resolveControllers() !== '') {
            $attrs = array_merge($attrs, $this->stimulusValues('bs-search', [
                'url' => $this->searchUrl,
                'minChars' => $this->minChars,
                'debounce' => $this->debounce,
            ]));
        }

        return $attrs;
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

        // Build Stimulus attributes and merge with custom attrs
        $attrs = $this->buildStimulusAttributes();
        $attrs = $this->mergeAttributes($attrs, $this->attr);

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

