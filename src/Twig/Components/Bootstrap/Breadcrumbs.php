<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use Exception;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Service\Attribute\Required;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:breadcrumbs', template: '@NeuralGlitchUxBootstrap/components/bootstrap/breadcrumbs.html.twig')]
final class Breadcrumbs extends AbstractStimulus
{
    public string $stimulusController = 'bs-breadcrumbs';

    /**
     * @var array<int, array<string, string|bool|null>>|null
     */
    public ?array $items = null;
    public bool $autoGenerate = true;
    public bool $showHome = true;
    public ?string $homeLabel = null;
    public ?string $homeRoute = null;

    /**
     * @var array<string, mixed>|null
     */
    public ?array $homeRouteParams = null;
    public string $divider = '/';
    public bool $autoCollapse = false;
    public int $collapseThreshold = 4;

    private RouterInterface $router;
    private RequestStack $requestStack;

    #[Required]
    public function setRouter(RouterInterface $router): void
    {
        $this->router = $router;
    }

    #[Required]
    public function setRequestStack(RequestStack $requestStack): void
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @param array<int, array<string, string|bool|null>>|null $items
     * @param array<string, mixed>|null $homeRouteParams
     */
    public function mount(
        ?array $items = null,
        ?bool $autoGenerate = null,
        ?bool $showHome = null,
        ?string $homeLabel = null,
        ?string $homeRoute = null,
        ?array $homeRouteParams = null,
        ?string $divider = null,
        ?bool $autoCollapse = null,
        ?int $collapseThreshold = null,
    ): void {
        // Override properties with mount parameters if provided
        if ($items !== null) {
            $this->items = $items;
        }
        if ($autoGenerate !== null) {
            $this->autoGenerate = $autoGenerate;
        }
        if ($showHome !== null) {
            $this->showHome = $showHome;
        }
        if ($homeLabel !== null) {
            $this->homeLabel = $homeLabel;
        }
        if ($homeRoute !== null) {
            $this->homeRoute = $homeRoute;
        }
        if ($homeRouteParams !== null) {
            $this->homeRouteParams = $homeRouteParams;
        }
        if ($divider !== null) {
            $this->divider = $divider;
        }
        if ($autoCollapse !== null) {
            $this->autoCollapse = $autoCollapse;
        }
        if ($collapseThreshold !== null) {
            $this->collapseThreshold = $collapseThreshold;
        }

        $d = $this->config->for('breadcrumbs');

        $this->applyStimulusDefaults($d);
        $this->applyClassDefaults($d);

        // Apply defaults from config
        $this->autoGenerate = $this->autoGenerate && $this->configBoolWithFallback($d, 'auto_generate', true);
        $this->showHome = $this->showHome && $this->configBoolWithFallback($d, 'show_home', true);
        $this->homeLabel = $this->homeLabel ?? $this->configStringWithFallback($d, 'home_label', 'Home');
        $this->homeRoute = $this->homeRoute ?? $this->configStringWithFallback($d, 'home_route', 'default');
        $this->homeRouteParams = $this->homeRouteParams ?? $this->configArray($d, 'home_route_params', []);
        $this->divider = $this->divider ?: $this->configStringWithFallback($d, 'divider', '/');

        // Auto-generate breadcrumbs if enabled and no items provided
        if ($this->autoGenerate && $this->items === null) {
            $this->generateBreadcrumbs();
        }

        // Initialize controller with default
        $this->initializeController();
    }

    /**
     * Override to conditionally attach controller only when auto-collapse is enabled
     */
    protected function shouldAttachController(): bool
    {
        return $this->controllerEnabled && $this->autoCollapse;
    }

    /**
     * Override to build Breadcrumbs-specific Stimulus attributes
     */
    protected function buildStimulusAttributes(): array
    {
        $attrs = $this->stimulusControllerAttributes();

        // Only add values if controller is active
        if ($this->resolveControllers() !== '') {
            $attrs = array_merge($attrs, $this->stimulusValues('bs-breadcrumbs', [
                'autoCollapse' => $this->autoCollapse,
                'collapseThreshold' => $this->collapseThreshold,
            ]));
        }

        return $attrs;
    }

    protected function getComponentName(): string
    {
        return 'breadcrumbs';
    }

    private function generateBreadcrumbs(): void
    {
        $items = [];

        // Add home item if enabled
        if ($this->showHome) {
            try {
                $homeUrl = $this->router->generate($this->homeRoute ?? 'default', $this->homeRouteParams ?? []);

                // Check if we're currently on the home page
                $request = $this->requestStack->getCurrentRequest();
                $currentPath = $request ? $request->getPathInfo() : null;
                $isCurrentlyHome = $currentPath === $homeUrl || $currentPath === rtrim($homeUrl, '/');

                $items[] = [
                    'label' => $this->homeLabel,
                    'url' => $isCurrentlyHome ? null : $homeUrl,
                    'active' => $isCurrentlyHome,
                ];
            } catch (Exception $e) {
                // Route not found, skip home item
            }
        }

        // Auto-determine current route from request
        $request = $this->requestStack->getCurrentRequest();
        if ($request) {
            $currentRoute = $request->attributes->get('_route');
            if (is_string($currentRoute)) {
                $this->addRouteBreadcrumbs($items, $currentRoute);
            }
        }

        $this->items = $items;
    }

    /**
     * @param array<int, array<string, string|bool|null>> $items
     */
    private function addRouteBreadcrumbs(array &$items, string $routeName): void
    {
        try {
            $route = $this->router->getRouteCollection()->get($routeName);
            if (!$route) {
                // Route not found, add a fallback item
                $items[] = [
                    'label' => ucwords(str_replace(['-', '_'], ' ', $routeName)),
                    'url' => null,
                    'active' => true,
                ];
                return;
            }

            $path = $route->getPath();
            $segments = array_filter(explode('/', trim($path, '/')));

            // Build breadcrumb hierarchy from path segments
            $segmentCount = count($segments);
            $currentPath = '';

            foreach ($segments as $index => $segment) {
                // Skip parameter segments (e.g., {id})
                if (str_starts_with($segment, '{') && str_ends_with($segment, '}')) {
                    continue;
                }

                // Build cumulative path
                $currentPath .= '/' . $segment;

                // Generate label from segment
                $label = ucwords(str_replace(['-', '_'], ' ', $segment));

                // Check if this is the last segment (current page)
                $isLast = ($index === $segmentCount - 1);

                // Try to find a route that matches this path
                $url = null;
                if (!$isLast) {
                    $url = $this->findRouteForPath($currentPath);
                }

                // Add breadcrumb item
                $items[] = [
                    'label' => $label,
                    'url' => $url, // Will be null if no route found (rendered as plain text)
                    'active' => $isLast,
                ];
            }
        } catch (Exception $e) {
            // Route not found or generation failed, add fallback
            $items[] = [
                'label' => ucwords(str_replace(['-', '_'], ' ', $routeName)),
                'url' => null,
                'active' => true,
            ];
        }
    }

    private function findRouteForPath(string $path): ?string
    {
        // Normalize path
        $normalizedPath = rtrim($path, '/');
        if ($normalizedPath === '') {
            return null;
        }

        // Try to match the path against all routes
        foreach ($this->router->getRouteCollection()->all() as $routeName => $route) {
            $routePath = rtrim($route->getPath(), '/');

            // Check for exact match or match with trailing slash
            if ($routePath === $normalizedPath || $routePath === $normalizedPath . '/') {
                try {
                    // Try to generate URL for this route
                    return $this->router->generate($routeName);
                } catch (Exception $e) {
                    // Route generation failed, continue searching
                    continue;
                }
            }
        }

        return null;
    }

    /**
     * @return array<string, mixed>
     */
    public function options(): array
    {
        $classes = $this->buildClassesFromArrays(['breadcrumb'], $this->class ? explode(' ', trim($this->class)) : []
        );

        $attrs = [
            'aria-label' => 'breadcrumb', ];

        // Apply custom divider via CSS variable
        if ($this->divider && $this->divider !== '/') {
            $attrs['style'] = '--bs-breadcrumb-divider: \'' . addslashes($this->divider) . '\';';
        }

        // Add Stimulus controller attributes using new pattern
        $attrs = $this->mergeAttributes($attrs, $this->buildStimulusAttributes());

        // Merge custom attributes
        $attrs = $this->mergeAttributes($attrs, $this->attr);

        return [
            'items' => $this->items ?? [],
            'divider' => $this->divider,
            'classes' => $classes,
            'attrs' => $attrs,
        ];
    }
}

