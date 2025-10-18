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
            $out .= ' ' . $key . '="' . htmlspecialchars((string)$val, ENT_QUOTES | ENT_SUBSTITUTE) . '"';
        }
        return $out;
    }
}
