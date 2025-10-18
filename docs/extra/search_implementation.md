# Search Implementation Guide

The bundle provides a `SearchService` for implementing search functionality in documentation sites. This guide shows how to integrate it into your application.

## Overview

The search system consists of:
- **SearchService** - Indexes and searches content (provided by bundle)
- **Controller** - API endpoint for search (you implement)
- **SearchBar Component** - UI component (provided by bundle)
- **Stimulus Controller** - Interactive search (provided by bundle)

---

## Step 1: Enable SearchService (Optional)

The SearchService is **optional**. Only use it if you need documentation search functionality.

### Register the Service

If not auto-registered, add to `config/services.yaml`:

```yaml
services:
    # SearchService is auto-registered if you use the bundle's services.yaml
    # If you need custom configuration:
    NeuralGlitch\UxBootstrap\Service\Search\SearchService:
        arguments:
            $projectDir: '%kernel.project_dir%'
            $router: '@router'
```

---

## Step 2: Create Search Controller

Create your own search controller in your application:

### Example: `src/Controller/SearchController.php`

```php
<?php

declare(strict_types=1);

namespace App\Controller;

use NeuralGlitch\UxBootstrap\Service\Search\SearchService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/search', name: 'app_search', methods: ['GET'])]
class SearchController extends AbstractController
{
    public function __construct(
        private readonly SearchService $searchService,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $query = $request->query->get('q', '');
        
        // Minimum query length
        if (strlen($query) < 2) {
            return $this->json([
                'results' => [],
                'total' => 0,
                'query' => $query,
            ]);
        }
        
        // Perform search
        $results = $this->searchService->search($query, limit: 20);
        
        // Return JSON for AJAX requests
        if ($request->isXmlHttpRequest() || $request->getPreferredFormat() === 'json') {
            return $this->json([
                'results' => $results,
                'total' => count($results),
                'query' => $query,
            ]);
        }
        
        // Return HTML for direct page access
        return $this->render('search/results.html.twig', [
            'query' => $query,
            'results' => $results,
        ]);
    }
}
```

---

## Step 3: Create Search Results Template

### `templates/search/results.html.twig`

```twig
{% extends 'base.html.twig' %}

{% block title %}Search Results{% if query %}: {{ query }}{% endif %}{% endblock %}

{% block body %}
<div class="container py-5">
    <h1 class="mb-4">Search Results</h1>
    
    {# Search form #}
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto">
            <twig:bs:searchbar 
                :autofocus="true"
                searchUrl="{{ path('app_search') }}"
                placeholder="Search documentation..."
            />
        </div>
    </div>
    
    {% if query %}
        <p class="lead">
            Found <strong>{{ results|length }}</strong> result(s) for 
            <strong>"{{ query }}"</strong>
        </p>
        
        {% if results is not empty %}
            <div class="list-group">
                {% for result in results %}
                    <a href="{{ result.url }}" class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">{{ result.title }}</h5>
                            {% if result.type %}
                                <small>
                                    <twig:bs:badge variant="secondary" :pill="true">
                                        {{ result.type }}
                                    </twig:bs:badge>
                                </small>
                            {% endif %}
                        </div>
                        {% if result.description %}
                            <p class="mb-1 text-muted">{{ result.description }}</p>
                        {% endif %}
                        <small class="text-muted">{{ result.url }}</small>
                    </a>
                {% endfor %}
            </div>
        {% else %}
            <twig:bs:alert variant="info">
                No results found for "{{ query }}". Try different keywords.
            </twig:bs:alert>
        {% endif %}
    {% endif %}
</div>
{% endblock %}
```

---

## Step 4: Use SearchBar Component

Add the search bar anywhere in your application:

### In Navbar

```twig
<twig:bs:navbar brand="My Site">
    <twig:block name="nav">
        {# Your nav items #}
    </twig:block>
    
    <twig:block name="right">
        <twig:bs:searchbar 
            searchUrl="{{ path('app_search') }}"
            size="sm"
            containerClass="d-none d-lg-block"
        />
    </twig:block>
</twig:bs:navbar>
```

### Standalone on Page

```twig
<div class="container my-5">
    <twig:bs:searchbar 
        searchUrl="{{ path('app_search') }}"
        :autofocus="true"
        placeholder="Search our documentation..."
        :minChars="3"
        :debounce="500"
    />
</div>
```

---

## Step 5: Test Search Index

The bundle provides a command to test your search configuration:

### Basic Test

```bash
php bin/console ux-bootstrap:search:test
```

This runs several test queries and shows results.

### Test Specific Query

```bash
# Search for a specific term
php bin/console ux-bootstrap:search:test "component"

# Limit results
php bin/console ux-bootstrap:search:test "bootstrap" --limit=5

# Verbose output (shows result details)
php bin/console ux-bootstrap:search:test "twig" -v
```

### Expected Output

```
UX Bootstrap Search Service Test
=================================

Running Default Test Queries
----------------------------

Query: "component"         → Found 12 result(s)
Query: "bootstrap"         → Found 8 result(s)
Query: "twig"              → Found 15 result(s)

[OK] Search service is working correctly!
```

---

## Configuration

### SearchBar Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `searchUrl` | string | `/search` | Your search endpoint URL |
| `placeholder` | string | `Search...` | Input placeholder |
| `minChars` | int | `2` | Min characters before search |
| `debounce` | int | `300` | Delay before request (ms) |
| `size` | string | `default` | `sm`, `default`, or `lg` |
| `showClear` | bool | `true` | Show clear button |
| `autofocus` | bool | `false` | Auto-focus input |

### SearchService Methods

```php
// Basic search
$results = $searchService->search('query');

// With limit
$results = $searchService->search('query', limit: 10);

// Result structure:
// [
//     [
//         'title' => 'Page Title',
//         'description' => 'Description...',
//         'url' => '/path/to/page',
//         'type' => 'Documentation'
//     ],
//     // ...
// ]
```

---

## Customization

### Add Static Pages

Override `getStaticPages()` to add important pages to the search index:

```php
namespace App\Service;

use NeuralGlitch\UxBootstrap\Service\Search\SearchService as BaseSearchService;

class CustomSearchService extends BaseSearchService
{
    protected function getStaticPages(): array
    {
        return [
            [
                'title' => 'Getting Started',
                'description' => 'Learn how to get started',
                'url' => $this->router->generate('getting_started'),
                'type' => 'Documentation',
                'keywords' => ['start', 'begin', 'intro', 'setup'],
            ],
            [
                'title' => 'API Documentation',
                'description' => 'REST API endpoints and usage',
                'url' => '/api/docs',
                'type' => 'Documentation',
                'keywords' => ['api', 'rest', 'endpoints'],
            ],
            // Add more pages...
        ];
    }
}
```

### Auto-Discovery of Template Directories

The SearchService **automatically discovers** template directories! It scans `templates/` and indexes all subdirectories, with smart exclusions:

**Default Behavior:**
- ✅ Indexes: `templates/docs/`, `templates/blog/`, `templates/pages/`, etc.
- ❌ Excludes: `templates/components/`, `templates/partials/`, `templates/bundles/`, `templates/emails/`
- ❌ Excludes: Any directory starting with `_` (e.g., `templates/_private/`)
- ❌ Excludes: Directories containing `.ux-bootstrap-search-ignore` file

**Type Generation:**
Directory names are automatically converted to human-readable types:
- `templates/docs/` → Type: "Docs"
- `templates/blog/` → Type: "Blog"
- `templates/help-center/` → Type: "Help Center" (dashes → spaces)
- `templates/api_docs/` → Type: "Api Docs" (underscores → spaces)

### Customize Excluded Directories

Override `getExcludedDirectories()` to change which directories are excluded:

```php
namespace App\Service;

use NeuralGlitch\UxBootstrap\Service\Search\SearchService as BaseSearchService;

class CustomSearchService extends BaseSearchService
{
    protected function getExcludedDirectories(): array
    {
        return [
            'components',
            'partials',
            'bundles',
            'emails',
            'admin',  // Add custom exclusions
            'internal',
        ];
    }
}
```

### Exclude Specific Directories with Ignore File

Create a `.ux-bootstrap-search-ignore` file in any directory to exclude it:

```bash
# Exclude templates/private/ from search
touch templates/private/.ux-bootstrap-search-ignore

# Exclude templates/drafts/ from search
touch templates/drafts/.ux-bootstrap-search-ignore
```

### Customize Type Generation

Override `generateTypeFromDirectory()` to customize type names:

```php
namespace App\Service;

use NeuralGlitch\UxBootstrap\Service\Search\SearchService as BaseSearchService;

class CustomSearchService extends BaseSearchService
{
    protected function generateTypeFromDirectory(string $dirName): string
    {
        // Custom type mapping
        return match ($dirName) {
            'docs' => 'Documentation',
            'blog' => 'Blog Article',
            'api' => 'API Reference',
            default => ucwords(str_replace(['-', '_'], ' ', $dirName)),
        };
    }
}
```

### Search Database Content

Add database search alongside file-based search:

```php
namespace App\Service;

use App\Repository\ArticleRepository;
use NeuralGlitch\UxBootstrap\Service\Search\SearchService as BaseSearchService;

class CustomSearchService extends BaseSearchService
{
    public function __construct(
        string $projectDir,
        RouterInterface $router,
        private readonly ArticleRepository $articleRepo,
    ) {
        parent::__construct($projectDir, $router);
    }

    public function search(string $query, int $limit = 20): array
    {
        // Get file-based results
        $results = parent::search($query, $limit);
        
        // Add database results
        $articles = $this->articleRepo->search($query);
        foreach ($articles as $article) {
            $results[] = [
                'title' => $article->getTitle(),
                'description' => $article->getExcerpt(),
                'url' => '/blog/' . $article->getSlug(),
                'type' => 'Article',
            ];
        }
        
        return array_slice($results, 0, $limit);
    }
}
```

### Register Custom Service

Replace the default SearchService in `config/services.yaml`:

```yaml
services:
    # Use your custom search service
    NeuralGlitch\UxBootstrap\Service\Search\SearchService:
        class: App\Service\CustomSearchService
        arguments:
            $projectDir: '%kernel.project_dir%'
            $router: '@router'
            # Add your own arguments here
```

---

## Alternative: Without SearchService

If you don't need file-based search, create your own implementation:

```php
#[Route('/search', name: 'app_search')]
class SearchController extends AbstractController
{
    public function __invoke(
        Request $request,
        ArticleRepository $articleRepo
    ): Response {
        $query = $request->query->get('q', '');
        
        // Search your database
        $results = $articleRepo->search($query);
        
        // Format for SearchBar component
        $formatted = array_map(fn($article) => [
            'title' => $article->getTitle(),
            'description' => $article->getExcerpt(),
            'url' => $this->generateUrl('article_show', ['slug' => $article->getSlug()]),
            'type' => 'Article',
        ], $results);
        
        return $this->json([
            'results' => $formatted,
            'total' => count($formatted),
            'query' => $query,
        ]);
    }
}
```

---

## Best Practices

1. **Use the right tool**:
   - SearchService = Documentation/template-based sites
   - Database search = Dynamic content (blog, products, etc.)
   - External service (Algolia, Elasticsearch) = Large scale

2. **Optimize performance**:
   - Cache search index
   - Limit results (default 20)
   - Use debouncing in frontend (300-500ms)

3. **User experience**:
   - Minimum 2-3 characters before search
   - Show loading state
   - Handle no results gracefully
   - Provide search suggestions

---

## Summary

The bundle provides:
- ✅ `SearchService` for file-based search (optional)
- ✅ `SearchBar` component for UI
- ✅ Stimulus controller for interactivity

You implement:
- ✅ Search controller (endpoint)
- ✅ Search results template
- ✅ Route configuration

This pattern gives you full control while leveraging bundle components! 🎉

