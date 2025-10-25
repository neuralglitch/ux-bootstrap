<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:alert-stack', template: '@NeuralGlitchUxBootstrap/components/extra/alert-stack.html.twig')]
final class AlertStack extends AbstractStimulus
{
    public string $stimulusController = 'bs-alert-stack';

    /**
     * Alerts to display. Each alert should be an array with keys:
     * - message (string): Alert message content
     * - variant (string): Bootstrap variant (primary, success, danger, etc.)
     * - dismissible (bool): Whether alert can be dismissed
     * - id (string|null): Optional unique ID for the alert
     *
     * @var array<int, string|array<string, mixed>>
     */
    public array $alerts = [];

    /**
     * Position of the alert stack
     * Options: 'top-end' | 'top-start' | 'top-center' | 'bottom-end' | 'bottom-start' | 'bottom-center'
     */
    public string $position = 'top-end';

    /**
     * Maximum number of alerts to show at once (0 = unlimited)
     */
    public int $maxAlerts = 0;

    /**
     * Default variant for alerts if not specified
     */
    public string $defaultVariant = 'info';

    /**
     * Whether alerts should auto-hide
     */
    public bool $autoHide = false;

    /**
     * Auto-hide delay in milliseconds
     */
    public int $autoHideDelay = 5000;

    /**
     * Whether to show fade animation
     */
    public bool $fade = true;

    /**
     * Whether alerts are dismissible by default
     */
    public bool $dismissible = true;

    /**
     * Container z-index
     */
    public int $zIndex = 1080;

    /**
     * Gap between stacked alerts (in rem)
     */
    public float $gap = 0.75;

    /**
     * Whether to load flash messages automatically from session
     */
    public bool $autoLoadFlashMessages = false;

    protected function getComponentName(): string
    {
        return 'alert-stack';
    }

    protected function buildStimulusAttributes(): array
    {
        $attrs = $this->stimulusControllerAttributes();

        if ($this->resolveControllers() !== '') {
            $attrs = array_merge($attrs, [
                'data-bs-alert-stack-auto-hide-value' => $this->autoHide ? 'true' : 'false',
                'data-bs-alert-stack-auto-hide-delay-value' => (string)$this->autoHideDelay,
                'data-bs-alert-stack-max-alerts-value' => (string)$this->maxAlerts,
            ]);
        }

        return $attrs;
    }

    public function mount(): void
    {
        $d = $this->config->for('alert-stack');

        $this->applyStimulusDefaults($d);
        $this->applyClassDefaults($d);

        // Apply defaults from config - only if not explicitly set (check against initial defaults)
        if ($this->position === 'top-end' && isset($d['position'])) {
            $this->position = $this->configStringWithFallback($d, 'position', 'top-end');
        }

        $this->maxAlerts = $this->maxAlerts ?: $this->configIntWithFallback($d, 'max_alerts', 0);
        if ($this->defaultVariant === 'info' && isset($d['default_variant'])) {
            $this->defaultVariant = $this->configStringWithFallback($d, 'default_variant', 'info');
        }
        $this->autoHide = $this->autoHide || $this->configBoolWithFallback($d, 'auto_hide', false);
        $this->autoHideDelay = $this->autoHideDelay === 5000 ? $this->configIntWithFallback($d, 'auto_hide_delay', 5000) : $this->autoHideDelay;
        $this->fade = $this->fade && $this->configBoolWithFallback($d, 'fade', true);
        $this->dismissible = $this->dismissible && $this->configBoolWithFallback($d, 'dismissible', true);
        $this->zIndex = $this->zIndex === 1080 ? $this->configIntWithFallback($d, 'z_index', 1080) : $this->zIndex;
        $this->gap = $this->gap === 0.75 ? $this->configFloatWithFallback($d, 'gap', 0.75) : $this->gap;
        $this->autoLoadFlashMessages = $this->autoLoadFlashMessages || $this->configBoolWithFallback($d, 'auto_load_flash_messages', false);

        // Initialize controller with default
        $this->initializeController();
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        // Map position to CSS classes
        $positionClasses = $this->getPositionClasses();

        $classes = $this->buildClasses(
            ['alert-stack'],
            $positionClasses,
            $this->class ? explode(' ', trim($this->class)) : []
        );

        // Normalize alerts array
        $normalizedAlerts = $this->normalizeAlerts();

        // Apply max alerts limit
        if ($this->maxAlerts > 0 && count($normalizedAlerts) > $this->maxAlerts) {
            $normalizedAlerts = array_slice($normalizedAlerts, 0, $this->maxAlerts);
        }

        // Build Stimulus attributes using new pattern
        $attrs = $this->buildStimulusAttributes();
        $attrs = $this->mergeAttributes($attrs, $this->attr);

        return [
            'alerts' => $normalizedAlerts,
            'position' => $this->position,
            'fade' => $this->fade,
            'zIndex' => $this->zIndex,
            'gap' => $this->gap,
            'classes' => $classes,
            'attrs' => $attrs,
        ];
    }

    /**
     * Get CSS classes for positioning
     * @return array<int, string>
     */
    private function getPositionClasses(): array
    {
        return match ($this->position) {
            'top-end' => ['position-fixed', 'top-0', 'end-0', 'm-3'],
            'top-start' => ['position-fixed', 'top-0', 'start-0', 'm-3'],
            'top-center' => ['position-fixed', 'top-0', 'start-50', 'translate-middle-x', 'm-3'],
            'bottom-end' => ['position-fixed', 'bottom-0', 'end-0', 'm-3'],
            'bottom-start' => ['position-fixed', 'bottom-0', 'start-0', 'm-3'],
            'bottom-center' => ['position-fixed', 'bottom-0', 'start-50', 'translate-middle-x', 'm-3'],
            default => ['position-fixed', 'top-0', 'end-0', 'm-3'],
        };
    }

    /**
     * Normalize alerts array to ensure consistent structure
     * @return array<int, array<string, mixed>>
     */
    private function normalizeAlerts(): array
    {
        $normalized = [];
        $index = 0;

        foreach ($this->alerts as $alert) {
            // Support both array and simple string format
            if (is_string($alert)) {
                $alert = ['message' => $alert];
            }

            // Ensure required keys exist
            $normalized[] = [
                'id' => $alert['id'] ?? 'alert-' . $index++,
                'message' => $alert['message'] ?? '',
                'variant' => $alert['variant'] ?? $this->defaultVariant,
                'dismissible' => $alert['dismissible'] ?? $this->dismissible,
                'autoHide' => $alert['autoHide'] ?? $this->autoHide,
                'autoHideDelay' => $alert['autoHideDelay'] ?? $this->autoHideDelay,
            ];
        }

        return $normalized;
    }
}

