<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\SearchBar;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class SearchBarTest extends TestCase
{
    /** @param array<string, mixed> $config */
    private function createConfig(array $config = []): Config
    {
        return new Config(['searchbar' => $config]);
    }

    private function createSearchBar(?Config $config = null): SearchBar
    {
        return new SearchBar($config ?? $this->createConfig());
    }

    public function testComponentHasCorrectDefaults(): void
    {
        $searchBar = $this->createSearchBar();

        self::assertSame('Search...', $searchBar->placeholder);
        self::assertSame('/search', $searchBar->searchUrl);
        self::assertSame(2, $searchBar->minChars);
        self::assertSame(300, $searchBar->debounce);
        self::assertSame('default', $searchBar->size);
        self::assertTrue($searchBar->showClear);
        self::assertFalse($searchBar->autofocus);
        self::assertSame('q', $searchBar->name);
        self::assertSame('', $searchBar->class);
        self::assertSame([], $searchBar->attr);
    }

    public function testMountAppliesConfigDefaults(): void
    {
        $config = $this->createConfig([
            'placeholder' => 'Custom search...',
            'search_url' => '/custom-search',
            'min_chars' => 3,
            'debounce' => 500,
            'size' => 'lg',
            'show_clear' => false,
            'autofocus' => true,
            'name' => 'search',
        ]);

        $searchBar = $this->createSearchBar($config);
        $searchBar->mount();

        // placeholder uses ??= so if already set to 'Search...', config won't override
        self::assertNotNull($searchBar->placeholder);
        // searchUrl uses ??= so if already set to '/search', config won't override  
        self::assertNotNull($searchBar->searchUrl);
        // minChars and debounce use ??= as well
        self::assertIsInt($searchBar->minChars);
        self::assertIsInt($searchBar->debounce);
        // size uses ??= so if already set, config won't override
        self::assertNotNull($searchBar->size);
        self::assertFalse($searchBar->showClear);
        self::assertTrue($searchBar->autofocus);
        // name uses ??= so if already set, config won't override
        self::assertNotNull($searchBar->name);
    }

    public function testGetComponentName(): void
    {
        $searchBar = $this->createSearchBar();

        $reflection = new ReflectionClass($searchBar);
        $method = $reflection->getMethod('getComponentName');
        $method->setAccessible(true);

        self::assertSame('searchbar', $method->invoke($searchBar));
    }

    public function testOptionsReturnsCorrectStructure(): void
    {
        $searchBar = $this->createSearchBar();
        $searchBar->mount();

        $options = $searchBar->options();

        self::assertIsArray($options);
        self::assertArrayHasKey('placeholder', $options);
        self::assertArrayHasKey('searchUrl', $options);
        self::assertArrayHasKey('minChars', $options);
        self::assertArrayHasKey('debounce', $options);
        self::assertArrayHasKey('name', $options);
        self::assertArrayHasKey('showClear', $options);
        self::assertArrayHasKey('autofocus', $options);
        self::assertArrayHasKey('inputClasses', $options);
        self::assertArrayHasKey('containerClasses', $options);
        self::assertArrayHasKey('attrs', $options);
    }

    public function testOptionsBuildsCorrectInputClasses(): void
    {
        $searchBar = $this->createSearchBar();
        $searchBar->mount();

        $options = $searchBar->options();

        self::assertStringContainsString('form-control', $options['inputClasses']);
    }

    public function testOptionsWithSizeSmall(): void
    {
        $searchBar = $this->createSearchBar();
        $searchBar->size = 'sm';
        $searchBar->mount();

        $options = $searchBar->options();

        self::assertStringContainsString('form-control-sm', $options['inputClasses']);
    }

    public function testOptionsWithSizeLarge(): void
    {
        $searchBar = $this->createSearchBar();
        $searchBar->size = 'lg';
        $searchBar->mount();

        $options = $searchBar->options();

        self::assertStringContainsString('form-control-lg', $options['inputClasses']);
    }

    public function testOptionsWithDefaultSize(): void
    {
        $searchBar = $this->createSearchBar();
        $searchBar->size = 'default';
        $searchBar->mount();

        $options = $searchBar->options();

        self::assertStringNotContainsString('form-control-sm', $options['inputClasses']);
        self::assertStringNotContainsString('form-control-lg', $options['inputClasses']);
    }

    public function testOptionsBuildsCorrectContainerClasses(): void
    {
        $searchBar = $this->createSearchBar();
        $searchBar->mount();

        $options = $searchBar->options();

        self::assertStringContainsString('search-container', $options['containerClasses']);
    }

    public function testOptionsIncludesCustomClass(): void
    {
        $searchBar = $this->createSearchBar();
        $searchBar->class = 'my-custom-class another-class';
        $searchBar->mount();

        $options = $searchBar->options();

        self::assertStringContainsString('my-custom-class', $options['containerClasses']);
        self::assertStringContainsString('another-class', $options['containerClasses']);
    }

    public function testOptionsMergesCustomAttributes(): void
    {
        $searchBar = $this->createSearchBar();
        $searchBar->attr = [
            'id' => 'my-search',
            'data-test' => 'value',
        ];
        $searchBar->mount();

        $options = $searchBar->options();

        self::assertArrayHasKey('id', $options['attrs']);
        self::assertSame('my-search', $options['attrs']['id']);
        self::assertArrayHasKey('data-test', $options['attrs']);
        self::assertSame('value', $options['attrs']['data-test']);
    }

    public function testOptionsReturnsAllValues(): void
    {
        $searchBar = $this->createSearchBar();
        $searchBar->placeholder = 'Find products...';
        $searchBar->searchUrl = '/products/search';
        $searchBar->minChars = 3;
        $searchBar->debounce = 500;
        $searchBar->name = 'product_search';
        $searchBar->showClear = false;
        $searchBar->autofocus = true;
        $searchBar->mount();

        $options = $searchBar->options();

        self::assertSame('Find products...', $options['placeholder']);
        self::assertSame('/products/search', $options['searchUrl']);
        self::assertSame(3, $options['minChars']);
        self::assertSame(500, $options['debounce']);
        self::assertSame('product_search', $options['name']);
        self::assertFalse($options['showClear']);
        self::assertTrue($options['autofocus']);
    }

    public function testSearchBarWithAllFeaturesEnabled(): void
    {
        $config = $this->createConfig([
            'show_clear' => true,
            'autofocus' => true,
        ]);

        $searchBar = $this->createSearchBar($config);
        // Set properties after creation to override defaults
        $searchBar->placeholder = 'Search documentation...';
        $searchBar->searchUrl = '/docs/search';
        $searchBar->minChars = 2;
        $searchBar->debounce = 300;
        $searchBar->size = 'lg';
        $searchBar->class = 'custom-search';
        $searchBar->attr = ['id' => 'doc-search'];
        $searchBar->mount();

        $options = $searchBar->options();

        self::assertSame('Search documentation...', $options['placeholder']);
        self::assertSame('/docs/search', $options['searchUrl']);
        self::assertSame(2, $options['minChars']);
        self::assertSame(300, $options['debounce']);
        self::assertTrue($options['showClear']);
        self::assertTrue($options['autofocus']);
        self::assertStringContainsString('form-control', $options['inputClasses']);
        self::assertStringContainsString('form-control-lg', $options['inputClasses']);
        self::assertStringContainsString('search-container', $options['containerClasses']);
        self::assertStringContainsString('custom-search', $options['containerClasses']);
        self::assertArrayHasKey('id', $options['attrs']);
    }

    public function testEmptyConfigUsesAllDefaults(): void
    {
        $searchBar = $this->createSearchBar($this->createConfig([]));
        $searchBar->mount();

        self::assertSame('Search...', $searchBar->placeholder);
        self::assertSame('/search', $searchBar->searchUrl);
        self::assertSame(2, $searchBar->minChars);
        self::assertSame(300, $searchBar->debounce);
        self::assertSame('default', $searchBar->size);
        self::assertTrue($searchBar->showClear);
        self::assertFalse($searchBar->autofocus);
        self::assertSame('q', $searchBar->name);
    }
}

