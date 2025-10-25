<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:nav', template: '@NeuralGlitchUxBootstrap/components/bootstrap/nav.html.twig')]
final class Nav extends AbstractStimulus
{
    public ?string $variant = null; // 'tabs' | 'pills' | 'underline'
    public bool $fill = false;
    public bool $justified = false;
    public bool|string|null $vertical = false;
    public string|bool|null $verticalResponsive = null; // null | true (always) | 'sm' | 'md' | 'lg' | 'xl' | 'xxl'
    public ?string $align = null; // 'start' | 'center' | 'end'
    public ?string $tag = null; // 'ul' | 'nav' | 'div' | 'ol'
    public ?string $id = null;
    public ?string $role = null;

    public function mount(): void
    {
        $d = $this->config->for('nav');

        $this->applyStimulusDefaults($d);
        $this->applyClassDefaults($d);

        // Apply defaults from config
        $this->variant ??= $this->configString($d, 'variant');
        $this->fill = $this->fill || $this->configBoolWithFallback($d, 'fill', false);
        $this->justified = $this->justified || $this->configBoolWithFallback($d, 'justified', false);
        $this->vertical = $this->vertical ?: $this->configString($d, 'vertical') ?: false;
        $this->verticalResponsive ??= $this->configString($d, 'vertical_responsive');
        $this->align ??= $this->configString($d, 'align');
        $this->tag ??= $this->configStringWithFallback($d, 'tag', 'ul');
        $this->id ??= $this->configString($d, 'id');
        $this->role ??= $this->configStringWithFallback($d, 'role', $this->tag === 'ol' ? 'list' : 'navigation');

        // Initialize controller with default
        $this->initializeController();
    }

    protected function getComponentName(): string
    {
        return 'nav';
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = $this->buildClassesFromArrays(
            ['nav'],
            $this->variant ? ['nav-' . $this->variant] : [],
            $this->fill ? ['nav-fill'] : [],
            $this->justified ? ['nav-justified'] : [],
            ($this->vertical === true || $this->vertical === 'true') ? ['flex-column'] : [],
            $this->verticalResponsive ? ['flex-' . ($this->verticalResponsive !== true ? $this->verticalResponsive . '-column' : 'column')] : [],
            ($this->vertical && $this->vertical !== true && $this->vertical !== 'true') ? ['flex-' . $this->vertical . '-column'] : [],
            $this->align ? ['justify-content-' . $this->align] : [],
            $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = [];

        if ($this->id) {
            $attrs['id'] = $this->id;
        }

        if ($this->role) {
            $attrs['role'] = $this->role;
        }

        $attrs = $this->mergeAttributes($attrs, $this->attr);

        return [
            'tag' => $this->tag,
            'classes' => $classes,
            'attrs' => $attrs,
            'isListTag' => $this->tag === 'ul' || $this->tag === 'ol',
        ];
    }
}