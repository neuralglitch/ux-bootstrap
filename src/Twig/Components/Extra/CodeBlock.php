<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:code-block', template: '@NeuralGlitchUxBootstrap/components/extra/code-block.html.twig')]
final class CodeBlock extends AbstractStimulus
{
    public string $stimulusController = 'bs-code-block';

    public ?string $language = null;
    public ?string $title = null;
    public ?string $filename = null;
    public bool $lineNumbers = false;
    public bool $copyButton = true;
    public ?string $highlightLines = null;
    public ?string $theme = null; // 'light' | 'dark' | null (auto)
    public int $maxHeight = 0; // 0 = no limit, >0 = max height in pixels
    public bool $wrapLines = false;
    public ?string $code = null; // Alternative to content block

    public function mount(): void
    {
        $d = $this->config->for('code-block');

        $this->applyStimulusDefaults($d);

        $this->applyClassDefaults($d);

        $this->language ??= $this->configString($d, 'language');
        $this->title ??= $this->configString($d, 'title');
        $this->filename ??= $this->configString($d, 'filename');
        $this->lineNumbers = $this->lineNumbers || $this->configBoolWithFallback($d, 'line_numbers', false);
        $this->copyButton = $this->copyButton && $this->configBoolWithFallback($d, 'copy_button', true);
        $this->highlightLines ??= $this->configString($d, 'highlight_lines');
        $this->theme ??= $this->configString($d, 'theme');
        $this->maxHeight = $this->maxHeight ?: $this->configIntWithFallback($d, 'max_height', 0);
        $this->wrapLines = $this->wrapLines || $this->configBoolWithFallback($d, 'wrap_lines', false);
        $this->code ??= $this->configString($d, 'code');


        // Initialize controller with default
        $this->initializeController();
    }

    protected function getComponentName(): string
    {
        return 'code-block';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classArray = $this->class ? array_filter(explode(' ', trim($this->class)), fn($v) => $v !== '') : [];
        /** @var array<string> $classArray */
        
        $classes = $this->buildClassesFromArrays(
            ['code-block'],
            $this->theme ? ["code-block-{$this->theme}"] : [],
            $this->lineNumbers ? ['code-block-line-numbers'] : [],
            $this->wrapLines ? ['code-block-wrap'] : [],
            $classArray
        );

        $preClasses = $this->buildClasses(
            ['code-block-pre'],
            $this->maxHeight > 0 ? ['code-block-scrollable'] : []
        );

        $codeClasses = $this->buildClasses(
            ['code-block-code'],
            $this->language ? ["language-{$this->language}"] : []
        );

        // Add Stimulus controller attributes if copy button is enabled
        $attrs = [];
        if ($this->copyButton) {
            $attrs = $this->stimulusControllerAttributes();
        }
        $attrs = $this->mergeAttributes($attrs, $this->attr);

        $preStyles = [];
        if ($this->maxHeight > 0) {
            $preStyles[] = "max-height: {$this->maxHeight}px";
        }

        return [
            'language' => $this->language,
            'title' => $this->title,
            'filename' => $this->filename,
            'lineNumbers' => $this->lineNumbers,
            'copyButton' => $this->copyButton,
            'highlightLines' => $this->highlightLines,
            'theme' => $this->theme,
            'maxHeight' => $this->maxHeight,
            'wrapLines' => $this->wrapLines,
            'code' => $this->code,
            'classes' => $classes,
            'preClasses' => $preClasses,
            'codeClasses' => $codeClasses,
            'preStyles' => !empty($preStyles) ? implode('; ', $preStyles) : null,
            'attrs' => $attrs,
        ];
    }
}

