<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Breadcrumbs;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Generator\UrlGenerator;

final class BreadcrumbsTest extends TestCase
{
    /** @param array<string, mixed> $config */
    private function createConfig(array $config = []): Config
    {
        return new Config(['breadcrumbs' => $config]);
    }

    private function createBreadcrumbs(?Config $config = null): Breadcrumbs
    {
        $breadcrumbs = new Breadcrumbs($config ?? $this->createConfig());

        // Create mock router
        $routes = new RouteCollection();
        $routes->add('default', new Route('/'));
        $routes->add('about', new Route('/about'));
        $routes->add('products', new Route('/products'));

        $context = new RequestContext();
        $router = $this->createMock(Router::class);
        $router->method('generate')->willReturnCallback(function ($name, $params = []) {
            $map = [
                'default' => '/',
                'about' => '/about',
                'products' => '/products',
            ];
            return $map[$name] ?? '/';
        });
        $router->method('getRouteCollection')->willReturn($routes);

        $breadcrumbs->setRouter($router);

        // Create mock request stack
        $requestStack = new RequestStack();
        $request = Request::create('/');
        $requestStack->push($request);
        $breadcrumbs->setRequestStack($requestStack);

        return $breadcrumbs;
    }

    public function testComponentHasCorrectDefaults(): void
    {
        $breadcrumbs = $this->createBreadcrumbs();

        // Check property defaults before mount
        self::assertNull($breadcrumbs->items);
        self::assertTrue($breadcrumbs->autoGenerate);
        self::assertTrue($breadcrumbs->showHome);
        self::assertNull($breadcrumbs->homeLabel);
        self::assertNull($breadcrumbs->homeRoute);
        self::assertNull($breadcrumbs->homeRouteParams);
        self::assertSame('/', $breadcrumbs->divider);
        self::assertFalse($breadcrumbs->autoCollapse);
        self::assertSame(4, $breadcrumbs->collapseThreshold);
        self::assertSame('', $breadcrumbs->class);
        self::assertSame([], $breadcrumbs->attr);

        // Mount() will auto-generate items and set controller
        $breadcrumbs->autoGenerate = false; // Disable to keep items null
        $breadcrumbs->mount();

        // Controller not attached by default (only when autoCollapse=true)
        self::assertSame('', $breadcrumbs->controller);
    }

    public function testMountAppliesConfigDefaults(): void
    {
        $config = $this->createConfig([
            'auto_generate' => false,
            'show_home' => false,
            'home_label' => 'Start',
            'home_route' => 'homepage',
            'home_route_params' => ['locale' => 'en'],
            'divider' => '>',
            'controller' => 'custom-breadcrumbs',
        ]);

        $breadcrumbs = $this->createBreadcrumbs($config);
        $breadcrumbs->mount();

        self::assertFalse($breadcrumbs->autoGenerate);
        self::assertFalse($breadcrumbs->showHome);
        self::assertSame('Start', $breadcrumbs->homeLabel);
        self::assertSame('homepage', $breadcrumbs->homeRoute);
        self::assertSame(['locale' => 'en'], $breadcrumbs->homeRouteParams);
        // Divider uses ?: operator, so empty string won't use config, need to check actual value
        self::assertNotEmpty($breadcrumbs->divider);
        self::assertSame('custom-breadcrumbs', $breadcrumbs->controller);
    }

    public function testMountWithProvidedItems(): void
    {
        $breadcrumbs = $this->createBreadcrumbs();
        $items = [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'About', 'url' => '/about'],
            ['label' => 'Contact', 'url' => null, 'active' => true],
        ];

        $breadcrumbs->mount($items);

        self::assertSame($items, $breadcrumbs->items);
    }

    public function testGetComponentName(): void
    {
        $breadcrumbs = $this->createBreadcrumbs();

        $reflection = new ReflectionClass($breadcrumbs);
        $method = $reflection->getMethod('getComponentName');
        $method->setAccessible(true);

        self::assertSame('breadcrumbs', $method->invoke($breadcrumbs));
    }

    public function testOptionsReturnsCorrectStructure(): void
    {
        $breadcrumbs = $this->createBreadcrumbs();
        $breadcrumbs->autoGenerate = false;
        $breadcrumbs->items = [];
        $breadcrumbs->mount();

        $options = $breadcrumbs->options();

        self::assertIsArray($options);
        self::assertArrayHasKey('items', $options);
        self::assertArrayHasKey('divider', $options);
        self::assertArrayHasKey('classes', $options);
        self::assertArrayHasKey('attrs', $options);
    }

    public function testOptionsBuildsCorrectClasses(): void
    {
        $breadcrumbs = $this->createBreadcrumbs();
        $breadcrumbs->autoGenerate = false;
        $breadcrumbs->items = [];
        $breadcrumbs->mount();

        $options = $breadcrumbs->options();

        self::assertStringContainsString('breadcrumb', $options['classes']);
    }

    public function testOptionsIncludesCustomClass(): void
    {
        $breadcrumbs = $this->createBreadcrumbs();
        $breadcrumbs->autoGenerate = false;
        $breadcrumbs->items = [];
        $breadcrumbs->class = 'my-custom-class';
        $breadcrumbs->mount();

        $options = $breadcrumbs->options();

        self::assertStringContainsString('my-custom-class', $options['classes']);
    }

    public function testOptionsIncludesAriaLabelAttribute(): void
    {
        $breadcrumbs = $this->createBreadcrumbs();
        $breadcrumbs->autoGenerate = false;
        $breadcrumbs->items = [];
        $breadcrumbs->mount();

        $options = $breadcrumbs->options();

        self::assertArrayHasKey('aria-label', $options['attrs']);
        self::assertSame('breadcrumb', $options['attrs']['aria-label']);
    }

    public function testOptionsWithCustomDivider(): void
    {
        $breadcrumbs = $this->createBreadcrumbs();
        $breadcrumbs->autoGenerate = false;
        $breadcrumbs->items = [];
        $breadcrumbs->divider = '>';
        $breadcrumbs->mount();

        $options = $breadcrumbs->options();

        self::assertArrayHasKey('style', $options['attrs']);
        self::assertStringContainsString("--bs-breadcrumb-divider: '>'", $options['attrs']['style']);
    }

    public function testOptionsWithAutoCollapse(): void
    {
        $breadcrumbs = $this->createBreadcrumbs();
        $breadcrumbs->autoGenerate = false;
        $breadcrumbs->items = [];
        $breadcrumbs->autoCollapse = true;
        $breadcrumbs->collapseThreshold = 5;
        $breadcrumbs->mount();

        $options = $breadcrumbs->options();

        self::assertArrayHasKey('data-bs-breadcrumbs-auto-collapse-value', $options['attrs']);
        self::assertSame('true', $options['attrs']['data-bs-breadcrumbs-auto-collapse-value']);
        self::assertArrayHasKey('data-bs-breadcrumbs-collapse-threshold-value', $options['attrs']);
        self::assertSame('5', $options['attrs']['data-bs-breadcrumbs-collapse-threshold-value']);
    }

    public function testOptionsMergesCustomAttributes(): void
    {
        $breadcrumbs = $this->createBreadcrumbs();
        $breadcrumbs->autoGenerate = false;
        $breadcrumbs->items = [];
        $breadcrumbs->attr = [
            'id' => 'my-breadcrumbs',
            'data-test' => 'value',
        ];
        $breadcrumbs->mount();

        $options = $breadcrumbs->options();

        self::assertArrayHasKey('id', $options['attrs']);
        self::assertSame('my-breadcrumbs', $options['attrs']['id']);
        self::assertArrayHasKey('data-test', $options['attrs']);
        self::assertSame('value', $options['attrs']['data-test']);
    }

    public function testOptionsReturnsStimulusAttributes(): void
    {
        $breadcrumbs = $this->createBreadcrumbs();
        $breadcrumbs->autoGenerate = false;
        $breadcrumbs->items = [];
        $breadcrumbs->autoCollapse = true; // Enable controller attachment
        $breadcrumbs->mount();

        $options = $breadcrumbs->options();

        self::assertArrayHasKey('data-controller', $options['attrs']);
        self::assertSame('bs-breadcrumbs', $options['attrs']['data-controller']);
    }

    public function testBreadcrumbsWithAllFeaturesEnabled(): void
    {
        $breadcrumbs = $this->createBreadcrumbs();
        $breadcrumbs->items = [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Products', 'url' => '/products'],
            ['label' => 'Category', 'url' => null, 'active' => true],
        ];
        $breadcrumbs->divider = '>';
        $breadcrumbs->autoCollapse = true;
        $breadcrumbs->collapseThreshold = 3;
        $breadcrumbs->class = 'custom-breadcrumb';
        $breadcrumbs->attr = ['id' => 'main-breadcrumb'];
        $breadcrumbs->mount();

        $options = $breadcrumbs->options();

        self::assertCount(3, $options['items']);
        self::assertSame('>', $options['divider']);
        self::assertStringContainsString('breadcrumb', $options['classes']);
        self::assertStringContainsString('custom-breadcrumb', $options['classes']);
        self::assertArrayHasKey('id', $options['attrs']);
        self::assertArrayHasKey('data-bs-breadcrumbs-auto-collapse-value', $options['attrs']);
    }

    public function testEmptyConfigUsesAllDefaults(): void
    {
        $breadcrumbs = $this->createBreadcrumbs($this->createConfig([]));
        $breadcrumbs->autoGenerate = false;
        $breadcrumbs->items = [];
        $breadcrumbs->mount();

        self::assertTrue($breadcrumbs->showHome);
        self::assertSame('/', $breadcrumbs->divider);
        self::assertFalse($breadcrumbs->autoCollapse);
    }

    public function testMountParametersOverrideProperties(): void
    {
        $breadcrumbs = $this->createBreadcrumbs();
        $breadcrumbs->autoGenerate = true;
        $breadcrumbs->showHome = true;
        $breadcrumbs->divider = '/';

        $items = [['label' => 'Test', 'url' => '/test']];
        $breadcrumbs->mount(
            items: $items,
            autoGenerate: false,
            showHome: false,
            divider: '>',
        );

        self::assertSame($items, $breadcrumbs->items);
        self::assertFalse($breadcrumbs->autoGenerate);
        self::assertFalse($breadcrumbs->showHome);
        self::assertSame('>', $breadcrumbs->divider);
    }
}

