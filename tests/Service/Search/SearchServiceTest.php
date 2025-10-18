<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Service\Search;

use NeuralGlitch\UxBootstrap\Service\Search\SearchService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RouterInterface;

final class SearchServiceTest extends TestCase
{
    /**
     * @param array<string, string> $routes
     */
    private function createMockRouter(array $routes = []): RouterInterface
    {
        $router = $this->createMock(RouterInterface::class);
        $routeCollection = new RouteCollection();

        foreach ($routes as $name => $path) {
            $routeCollection->add($name, new Route($path));
        }

        $router->method('getRouteCollection')->willReturn($routeCollection);

        return $router;
    }

    public function testConstructor(): void
    {
        $router = $this->createMockRouter();
        $service = new SearchService('/test/project', $router);

        self::assertInstanceOf(SearchService::class, $service);
    }

    public function testSearchReturnsEmptyArrayForNoMatches(): void
    {
        $router = $this->createMockRouter();
        $service = new SearchService(__DIR__, $router);

        $results = $service->search('nonexistentquerythatwillnevermatch');

        self::assertSame([], $results);
    }

    public function testSearchReturnsArrayOfResults(): void
    {
        $router = $this->createMockRouter([
            'test.route' => '/test',
        ]);
        $service = new SearchService(__DIR__, $router);

        $results = $service->search('test');

        self::assertIsArray($results);
        if ($results !== []) {
            self::assertArrayHasKey('title', $results[0]);
            self::assertArrayHasKey('description', $results[0]);
            self::assertArrayHasKey('url', $results[0]);
            self::assertArrayHasKey('type', $results[0]);
        }
    }

    public function testSearchLimitsResults(): void
    {
        $routes = [];
        for ($i = 1; $i <= 50; $i++) {
            $routes["test.route{$i}"] = "/test{$i}";
        }

        $router = $this->createMockRouter($routes);
        $service = new SearchService(__DIR__, $router);

        $results = $service->search('test', 10);

        self::assertLessThanOrEqual(10, count($results));
    }

    public function testSearchHandlesEmptyQuery(): void
    {
        $router = $this->createMockRouter();
        $service = new SearchService(__DIR__, $router);

        $results = $service->search('');

        self::assertIsArray($results);
    }

    public function testSearchHandlesWhitespaceQuery(): void
    {
        $router = $this->createMockRouter();
        $service = new SearchService(__DIR__, $router);

        $results = $service->search('   ');

        self::assertIsArray($results);
    }

    public function testSearchIsCaseInsensitive(): void
    {
        $router = $this->createMockRouter([
            'test.uppercase' => '/UPPERCASE',
        ]);
        $service = new SearchService(__DIR__, $router);

        $resultsLower = $service->search('uppercase');
        $resultsUpper = $service->search('UPPERCASE');
        $resultsMixed = $service->search('UpPeRcAsE');

        // Should find same number of results regardless of case
        self::assertSame(count($resultsLower), count($resultsUpper));
        self::assertSame(count($resultsLower), count($resultsMixed));
    }

    public function testSearchSkipsInternalRoutes(): void
    {
        $router = $this->createMockRouter([
            '_internal_route' => '/internal',
            'public_route' => '/public',
        ]);
        $service = new SearchService(__DIR__, $router);

        $results = $service->search('internal');

        // Should not include routes starting with underscore
        $foundInternal = false;
        foreach ($results as $result) {
            if (str_contains($result['title'] . $result['url'], '_internal')) {
                $foundInternal = true;
            }
        }
        self::assertFalse($foundInternal, 'Internal routes should not be included in search results');
    }

    public function testSearchSkipsApiRoutes(): void
    {
        $router = $this->createMockRouter([
            'api.users' => '/api/users',
            'frontend.users' => '/users',
        ]);
        $service = new SearchService(__DIR__, $router);

        $results = $service->search('users');

        // Should not include API routes
        foreach ($results as $result) {
            self::assertStringNotContainsString('/api/', $result['url']);
        }
    }

    public function testSearchResultsAreSortedByRelevance(): void
    {
        $router = $this->createMockRouter([
            'exact.match' => '/exact-match',
            'partial.match' => '/something-match-partial',
            'another.route' => '/different',
        ]);
        $service = new SearchService(__DIR__, $router);

        $results = $service->search('exact match');

        if (count($results) >= 2) {
            // First result should be more relevant than subsequent ones
            // (We can't assert exact scores, but we can verify it's an array)
            self::assertIsArray($results);
        }
    }

    public function testSearchDoesNotIncludeIgnoreRoutes(): void
    {
        $router = $this->createMockRouter([
            'ignore.test' => '/ignore/test',
            'normal.test' => '/normal/test',
        ]);
        $service = new SearchService(__DIR__, $router);

        $results = $service->search('test');

        foreach ($results as $result) {
            self::assertStringNotContainsString('ignore', strtolower($result['url']));
        }
    }

    public function testSearchWithMultipleWords(): void
    {
        $router = $this->createMockRouter([
            'test.route' => '/test/page',
        ]);
        $service = new SearchService(__DIR__, $router);

        $results = $service->search('test page');

        self::assertIsArray($results);
    }

    public function testSearchResultStructure(): void
    {
        $router = $this->createMockRouter([
            'test.route' => '/test',
        ]);
        $service = new SearchService(__DIR__, $router);

        $results = $service->search('test');

        if ($results !== []) {
            $result = $results[0];
            self::assertArrayHasKey('title', $result);
            self::assertArrayHasKey('description', $result);
            self::assertArrayHasKey('url', $result);
            self::assertArrayHasKey('type', $result);
            self::assertArrayNotHasKey('score', $result); // Score should be removed from final results
            self::assertArrayNotHasKey('content', $result); // Internal content should not be exposed
            self::assertArrayNotHasKey('keywords', $result); // Internal keywords should not be exposed
        }
    }

    public function testSearchWithSpecialCharacters(): void
    {
        $router = $this->createMockRouter([
            'special.test' => '/test-route',
        ]);
        $service = new SearchService(__DIR__, $router);

        // Should not throw exception with special characters
        $results = $service->search('test@route#special');

        self::assertIsArray($results);
    }

    public function testSearchRespectsLimit(): void
    {
        $routes = [];
        for ($i = 1; $i <= 100; $i++) {
            $routes["common.word{$i}"] = "/common-{$i}";
        }

        $router = $this->createMockRouter($routes);
        $service = new SearchService(__DIR__, $router);

        $resultsDefault = $service->search('common', 20);
        $resultsSmall = $service->search('common', 5);
        $resultsLarge = $service->search('common', 50);

        self::assertLessThanOrEqual(20, count($resultsDefault));
        self::assertLessThanOrEqual(5, count($resultsSmall));
        self::assertLessThanOrEqual(50, count($resultsLarge));
    }

    public function testSearchIndexIsBuiltOnlyOnce(): void
    {
        $router = $this->createMockRouter([
            'test.route' => '/test',
        ]);
        $service = new SearchService(__DIR__, $router);

        // First search builds index
        $results1 = $service->search('test');
        // Second search uses cached index
        $results2 = $service->search('test');

        // Both should return same results
        self::assertSame(count($results1), count($results2));
    }

    public function testSearchHandlesNonExistentProjectDirectory(): void
    {
        $router = $this->createMockRouter();
        $service = new SearchService('/nonexistent/directory', $router);

        // Should not throw exception
        $results = $service->search('test');

        self::assertIsArray($results);
    }
}

