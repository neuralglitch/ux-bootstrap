<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits;

trait HtmlAttributesTrait
{
    /**
     * @param array<string, mixed> $base
     * @param array<string, mixed> $extra
     * @return array<string, mixed>
     */
    protected function mergeAttributes(array $base, array $extra): array
    {
        foreach ($extra as $k => $v) {
            $base[$k] = $v;
        }
        return $base;
    }

    /**
     * @param array<string, mixed> $attributes
     */
    public function renderHtmlAttributes(array $attributes): string
    {
        $out = '';
        foreach ($attributes as $key => $val) {
            if ($val === false || $val === null) {
                continue;
            }
            if ($val === true) {
                $out .= ' ' . $key;
                continue;
            }
            
            // Special handling for Bootstrap data attributes that should preserve HTML
            $shouldEscape = true;
            if (str_starts_with($key, 'data-bs-') && in_array($key, ['data-bs-content', 'data-bs-title'])) {
                // Check if the value contains HTML tags - if so, don't escape
                /** @var string $valString */
                $valString = is_string($val) ? $val : (is_scalar($val) ? (string)$val : '');
                if (preg_match('/<[^>]+>/', $valString)) {
                    $shouldEscape = false;
                }
            }
            
            if ($shouldEscape) {
                /** @var string $valString */
                $valString = is_string($val) ? $val : (is_scalar($val) ? (string)$val : '');
                $out .= ' ' . $key . '="' . htmlspecialchars($valString, ENT_QUOTES | ENT_SUBSTITUTE) . '"';
            } else {
                /** @var string $valString */
                $valString = is_string($val) ? $val : (is_scalar($val) ? (string)$val : '');
                $out .= ' ' . $key . '="' . $valString . '"';
            }
        }
        return $out;
    }
}
