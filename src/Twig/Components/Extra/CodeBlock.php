<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:code-block', template: '@NeuralGlitchUxBootstrap/components/extra/code-block.html.twig')]
final class CodeBlock extends AbstractStimulus
{
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
        $d = $this->config->for('code_block');

        $this->applyStimulusDefaults($d);

        $this->applyClassDefaults($d);

        $this->language ??= $d['language'] ?? null;
        $this->title ??= $d['title'] ?? null;
        $this->filename ??= $d['filename'] ?? null;
        $this->lineNumbers = $this->lineNumbers || ($d['line_numbers'] ?? false);
        $this->copyButton = $this->copyButton && ($d['copy_button'] ?? true);
        $this->highlightLines ??= $d['highlight_lines'] ?? null;
        $this->theme ??= $d['theme'] ?? null;
        $this->maxHeight = $this->maxHeight ?: ($d['max_height'] ?? 0);
        $this->wrapLines = $this->wrapLines || ($d['wrap_lines'] ?? false);
        $this->code ??= $d['code'] ?? null;

        
        // Initialize controller with default
        $this->initializeController();
    }

    protected function getComponentName(): string
    {
        return 'code_block';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = $this->buildClasses(
            ['code-block'],
            $this->theme ? ["code-block-{$this->theme}"] : [],
            $this->lineNumbers ? ['code-block-line-numbers'] : [],
            $this->wrapLines ? ['code-block-wrap'] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $preClasses = $this->buildClasses(
            ['code-block-pre'],
            $this->maxHeight > 0 ? ['code-block-scrollable'] : []
        );

        $codeClasses = $this->buildClasses(
            ['code-block-code'],
            $this->language ? ["language-{$this->language}"] : []
        );

        $attrs = $this->mergeAttributes([], $this->attr);

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

