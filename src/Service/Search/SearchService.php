<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Service\Search;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Routing\RouterInterface;

class SearchService
{
    /**
     * Directories to exclude from search indexing.
     * Override getExcludedDirectories() to customize.
     */
    protected const EXCLUDED_DIRECTORIES = [
        'components',
        'partials',
        'bundles',
        'emails',
    ];

    /**
     * File name that, when present in a directory, excludes it from indexing.
     */
    protected const IGNORE_FILE_NAME = '.ux-bootstrap-search-ignore';

    /**
     * @var array<int, array{title: string, description: string|null, url: string, type: string|null, content: string, keywords: array<string>}>
     */
    private array $searchIndex = [];

    public function __construct(
        private readonly string $projectDir,
        private readonly RouterInterface $router,
    ) {
    }

    /**
     * @return array<int, array{title: string, description: string|null, url: string, type: string}>
     */
    public function search(string $query, int $limit = 20): array
    {
        if ($this->searchIndex === []) {
            $this->buildSearchIndex();
        }

        $query = strtolower(trim($query));
        $results = [];

        foreach ($this->searchIndex as $item) {
            $score = $this->calculateRelevanceScore($query, $item);

            if ($score > 0) {
                $results[] = [
                    'title' => $item['title'],
                    'description' => $item['description'],
                    'url' => $item['url'],
                    'type' => $item['type'] ?? 'Page',
                    'score' => $score,
                ];
            }
        }

        // Sort by relevance score (highest first)
        usort($results, fn($a, $b) => $b['score'] <=> $a['score']);

        // Remove score from final results and limit
        return array_map(
            fn($item) => [
                'title' => $item['title'],
                'description' => $item['description'],
                'url' => $item['url'],
                'type' => $item['type'],
            ],
            array_slice($results, 0, $limit)
        );
    }

    private function buildSearchIndex(): void
    {
        $this->searchIndex = [];

        // Index documentation pages
        $this->indexDocumentationFiles();

        // Index routes
        $this->indexRoutes();

        // Add static pages (users can override getStaticPages() to customize)
        $this->addStaticPages();
    }

    private function indexDocumentationFiles(): void
    {
        foreach ($this->discoverSearchDirectories() as $dirName => $dirPath) {
            $fullPath = $this->projectDir . '/' . $dirPath;

            if (!is_dir($fullPath)) {
                continue;
            }

            $finder = new Finder();
            $finder->files()
                ->in($fullPath)
                ->name('*.twig')
                ->notPath('ignore');

            foreach ($finder as $file) {
                $content = $file->getContents();
                $relativePath = $file->getRelativePathname();

                // Extract title from file
                $title = $this->extractTitle($content, $relativePath);
                $description = $this->extractDescription($content);
                $url = $this->generateUrlFromPath($relativePath, $dirName);
                $keywords = $this->extractKeywords($content);
                $type = $this->generateTypeFromDirectory($dirName);

                $this->searchIndex[] = [
                    'title' => $title,
                    'description' => $description,
                    'url' => $url,
                    'type' => $type,
                    'content' => $this->stripTags($content),
                    'keywords' => $keywords,
                ];
            }
        }
    }

    private function indexRoutes(): void
    {
        $routeCollection = $this->router->getRouteCollection();

        foreach ($routeCollection->all() as $name => $route) {
            // Skip internal routes
            if (str_starts_with($name, '_')) {
                continue;
            }

            // Skip API and ignore routes
            if (str_contains($name, 'api') || str_contains($name, 'ignore')) {
                continue;
            }

            $path = $route->getPath();
            $title = $this->generateTitleFromRouteName($name);

            // Skip if already indexed
            $alreadyIndexed = false;
            foreach ($this->searchIndex as $item) {
                if ($item['url'] === $path) {
                    $alreadyIndexed = true;
                    break;
                }
            }

            if (!$alreadyIndexed) {
                $this->searchIndex[] = [
                    'title' => $title,
                    'description' => 'Route: ' . $name,
                    'url' => $path,
                    'type' => 'Route',
                    'content' => $title . ' ' . $path,
                    'keywords' => explode('.', $name),
                ];
            }
        }
    }

    private function addStaticPages(): void
    {
        $staticPages = $this->getStaticPages();

        foreach ($staticPages as $page) {
            $this->searchIndex[] = [
                'title' => $page['title'],
                'description' => $page['description'] ?? null,
                'url' => $page['url'],
                'type' => $page['type'] ?? 'Page',
                'content' => $page['title'] . ' ' . ($page['description'] ?? ''),
                'keywords' => $page['keywords'] ?? [],
            ];
        }
    }

    /**
     * Auto-discover template directories to index.
     * Scans templates/ and excludes specified directories.
     *
     * @return array<string, string> Array of directory name => path mappings
     */
    protected function discoverSearchDirectories(): array
    {
        $templatesDir = $this->projectDir . '/templates';

        if (!is_dir($templatesDir)) {
            return [];
        }

        $directories = [];
        $excluded = $this->getExcludedDirectories();
        $ignoreFileName = $this->getIgnoreFileName();

        $finder = new Finder();
        $finder->directories()
            ->in($templatesDir)
            ->depth(0); // Only top-level directories

        foreach ($finder as $dir) {
            $dirName = $dir->getFilename();

            // Skip if directory name starts with underscore
            if (str_starts_with($dirName, '_')) {
                continue;
            }

            // Skip if in excluded list
            if (in_array($dirName, $excluded, true)) {
                continue;
            }

            // Skip if contains ignore file
            if (file_exists($dir->getPathname() . '/' . $ignoreFileName)) {
                continue;
            }

            $directories[$dirName] = 'templates/' . $dirName;
        }

        return $directories;
    }

    /**
     * Get list of directories to exclude from indexing.
     * Override to customize exclusions.
     *
     * @return array<string>
     */
    protected function getExcludedDirectories(): array
    {
        return static::EXCLUDED_DIRECTORIES;
    }

    /**
     * Get ignore file name.
     * Override to use a different ignore file name.
     */
    protected function getIgnoreFileName(): string
    {
        return static::IGNORE_FILE_NAME;
    }

    /**
     * Generate human-readable type from directory name.
     * Override to customize type generation.
     */
    protected function generateTypeFromDirectory(string $dirName): string
    {
        // Convert directory name to human-readable format
        // Examples: 'docs' -> 'Docs', 'blog-posts' -> 'Blog Posts'
        $type = str_replace(['-', '_'], ' ', $dirName);
        return ucwords($type);
    }

    /**
     * Get static pages to index.
     * Override this method in your own service to add custom static pages.
     *
     * @return array<int, array{title: string, description?: string, url: string, type?: string, keywords?: array<string>}>
     */
    protected function getStaticPages(): array
    {
        // Return empty array by default
        // Users can override this method to add their own static pages
        return [];
    }

    /**
     * @param array{title: string, description: string|null, content: string, keywords: array<string>} $item
     */
    private function calculateRelevanceScore(string $query, array $item): int
    {
        $score = 0;
        $queryLower = strtolower($query);
        $titleLower = strtolower($item['title']);
        $descriptionLower = $item['description'] ? strtolower($item['description']) : '';
        $contentLower = strtolower($item['content']);

        // Exact title match - highest score
        if ($titleLower === $queryLower) {
            $score += 100;
        }

        // Title starts with query
        if (str_starts_with($titleLower, $queryLower)) {
            $score += 50;
        }

        // Title contains query
        if (str_contains($titleLower, $queryLower)) {
            $score += 30;
        }

        // Description contains query
        if (str_contains($descriptionLower, $queryLower)) {
            $score += 20;
        }

        // Keywords match
        foreach ($item['keywords'] as $keyword) {
            $keywordLower = strtolower($keyword);
            if ($keywordLower === $queryLower) {
                $score += 40;
            } elseif (str_contains($keywordLower, $queryLower) || str_contains($queryLower, $keywordLower)) {
                $score += 15;
            }
        }

        // Content contains query (with word boundary check)
        if (preg_match('/\b' . preg_quote($queryLower, '/') . '\b/i', $contentLower)) {
            $score += 10;
        }

        // Partial word matches in content
        $queryWords = explode(' ', $queryLower);
        foreach ($queryWords as $word) {
            if (strlen($word) >= 3 && str_contains($contentLower, $word)) {
                $score += 5;
            }
        }

        return $score;
    }

    private function extractTitle(string $content, string $fallbackPath): string
    {
        // Try to extract from {% block title %}
        if (preg_match('/\{%\s*block\s+title\s*%\}(.*?)\{%\s*endblock\s*%\}/s', $content, $matches)) {
            $title = trim(strip_tags($matches[1]));
            // Skip if it's just a parent() call or template syntax
            if ($title !== '' && !str_contains($title, 'parent()') && !str_contains($title, '{{')) {
                return $title;
            }
        }

        // Try to extract from <h1>
        if (preg_match('/<h1[^>]*>(.*?)<\/h1>/si', $content, $matches)) {
            $title = trim(strip_tags($matches[1]));
            if ($title !== '' && !str_contains($title, '{{')) {
                return $title;
            }
        }

        // Try to extract from display-4 or display-5 class
        if (preg_match('/<[^>]*class="[^"]*display-[45][^"]*"[^>]*>(.*?)<\//si', $content, $matches)) {
            $title = trim(strip_tags($matches[1]));
            if ($title !== '' && !str_contains($title, '{{')) {
                return $title;
            }
        }

        // Try to extract from <title> tag
        if (preg_match('/<title[^>]*>(.*?)<\/title>/si', $content, $matches)) {
            $title = trim(strip_tags($matches[1]));
            if ($title !== '' && !str_contains($title, '{{')) {
                return $title;
            }
        }

        // Fallback to filename
        return $this->formatFilenameAsTitle($fallbackPath);
    }

    private function extractDescription(string $content): ?string
    {
        // Try to extract from lead paragraph
        if (preg_match('/<p[^>]*class="[^"]*lead[^"]*"[^>]*>(.*?)<\/p>/si', $content, $matches)) {
            $description = trim(strip_tags($matches[1]));
            return $this->truncate($description, 150);
        }

        // Try to extract first paragraph after h1
        if (preg_match('/<h1[^>]*>.*?<\/h1>\s*<p[^>]*>(.*?)<\/p>/si', $content, $matches)) {
            $description = trim(strip_tags($matches[1]));
            return $this->truncate($description, 150);
        }

        return null;
    }

    /**
     * @return array<string>
     */
    private function extractKeywords(string $content): array
    {
        $keywords = [];

        // Extract from common HTML heading tags
        if (preg_match_all('/<h[2-6][^>]*>(.*?)<\/h[2-6]>/si', $content, $matches)) {
            foreach ($matches[1] as $heading) {
                $keywords[] = trim(strip_tags($heading));
            }
        }

        // Extract from code blocks (common in docs)
        if (preg_match_all('/<code[^>]*>(.*?)<\/code>/si', $content, $matches)) {
            foreach ($matches[1] as $code) {
                $keywords[] = trim(strip_tags($code));
            }
        }

        return array_filter(array_unique($keywords));
    }

    private function generateUrlFromPath(string $relativePath, string $type): string
    {
        $path = str_replace('.html.twig', '', $relativePath);
        $path = str_replace('\\', '/', $path);

        if ($type === 'docs') {
            return '/docs/' . $path;
        }

        return '/' . $path;
    }

    private function generateTitleFromRouteName(string $routeName): string
    {
        $parts = explode('.', $routeName);
        $parts = array_map(fn($part) => ucfirst(str_replace(['_', '-'], ' ', $part)), $parts);
        return implode(' - ', $parts);
    }

    private function formatFilenameAsTitle(string $filename): string
    {
        $name = basename($filename, '.html.twig');
        $name = str_replace(['-', '_'], ' ', $name);
        return ucwords($name);
    }

    private function stripTags(string $content): string
    {
        // Remove Twig tags
        $content = preg_replace('/\{[%#].*?[%#]\}/s', ' ', $content) ?? $content;
        $content = preg_replace('/\{\{.*?\}\}/s', ' ', $content) ?? $content;

        // Remove HTML tags
        $content = strip_tags($content);

        // Normalize whitespace
        $content = preg_replace('/\s+/', ' ', $content) ?? $content;

        return trim($content);
    }

    private function truncate(string $text, int $length): string
    {
        if (strlen($text) <= $length) {
            return $text;
        }

        $truncated = substr($text, 0, $length);
        $lastSpace = strrpos($truncated, ' ');

        if ($lastSpace !== false) {
            $truncated = substr($truncated, 0, $lastSpace);
        }

        return $truncated . '...';
    }
}

