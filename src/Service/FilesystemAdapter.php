<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * Filesystem Adapter for TreeView Component
 * 
 * Provides filesystem integration for the TreeView component,
 * allowing it to display real directory structures with proper
 * file type detection and icons.
 */
final class FilesystemAdapter
{
    private Filesystem $filesystem;

    public function __construct()
    {
        $this->filesystem = new Filesystem();
    }

    /**
     * Build tree structure from filesystem path
     *
     * @param string $rootPath Root directory path
     * @param array<string> $excludeDirs Directories to exclude (e.g., ['node_modules', '.git'])
     * @param array<string> $excludeFiles Files to exclude (e.g., ['.DS_Store', 'Thumbs.db'])
     * @param int $maxDepth Maximum directory depth (0 = unlimited)
     * @return array<string, mixed>
     */
    /**
     * @param array<string> $excludeDirs
     * @param array<string> $excludeFiles
     * @return array<int, array<string, mixed>>
     */
    public function buildTree(
        string $rootPath,
        array $excludeDirs = [],
        array $excludeFiles = [],
        int $maxDepth = 0
    ): array {
        dump('FilesystemAdapter: buildTree called with path: ' . $rootPath);
        dump('FilesystemAdapter: excludeDirs: ' . var_export($excludeDirs, true));
        dump('FilesystemAdapter: excludeFiles: ' . var_export($excludeFiles, true));
        dump('FilesystemAdapter: maxDepth: ' . $maxDepth);
        
        // Make path absolute if it's relative
        if (!str_starts_with($rootPath, '/')) {
            // In Docker, we need to go up from /var/www/public to the project root
            $cwd = getcwd();
            if ($cwd === false) {
                dump('FilesystemAdapter: Cannot get current working directory');
                return [];
            }
            $projectRoot = dirname($cwd);
            $rootPath = $projectRoot . '/' . $rootPath;
            dump('FilesystemAdapter: Made path absolute: ' . $rootPath);
        }
        
        // Resolve symlinks
        $realPath = realpath($rootPath);
        if ($realPath === false) {
            dump('FilesystemAdapter: Path does not exist or cannot be resolved: ' . $rootPath);
            return [];
        }
        
        dump('FilesystemAdapter: Resolved path: ' . $realPath);
        
        dump('FilesystemAdapter: Path exists, building tree...');
        $children = $this->buildTreeRecursive($realPath, $excludeDirs, $excludeFiles, $maxDepth, 0);
        
        // Create root item
        $rootItem = [
            'id' => md5($realPath),
            'label' => basename($realPath),
            'path' => $realPath,
            'relativePath' => basename($realPath),
            'expanded' => true,
            'icon' => 'bi:folder-fill',
            'type' => 'directory',
            'size' => $this->getDirectorySize($realPath),
            'permissions' => $this->getFilePermissions($realPath),
            'modified' => $this->getFileModificationTime($realPath),
            'children' => $children
        ];
        
        $result = [$rootItem];
        dump('FilesystemAdapter: Built tree with ' . count($result) . ' items');
        
        return $result;
    }

    /**
     * Get file type icon based on file extension
     */
    public function getFileIcon(string $filename): string
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        return match ($extension) {
            'php' => 'bi:filetype-php',
            'js' => 'bi:filetype-js',
            'ts' => 'bi:filetype-js', // TypeScript uses JS icon
            'scss', 'sass' => 'bi:filetype-scss',
            'css' => 'bi:filetype-css',
            'html', 'twig' => 'bi:filetype-html',
            'yaml', 'yml' => 'bi:filetype-yml',
            'json' => 'bi:filetype-json',
            'xml' => 'bi:filetype-xml',
            'md', 'markdown' => 'bi:filetype-md',
            'txt' => 'bi:filetype-txt',
            'pdf' => 'bi:filetype-pdf',
            'doc', 'docx' => 'bi:filetype-doc',
            'xls', 'xlsx' => 'bi:filetype-xls',
            'ppt', 'pptx' => 'bi:filetype-ppt',
            'zip', 'rar', '7z' => 'bi:filetype-zip',
            'jpg', 'jpeg', 'png', 'gif', 'svg', 'webp' => 'bi:filetype-image',
            'mp4', 'avi', 'mov', 'wmv' => 'bi:filetype-video',
            'mp3', 'wav', 'flac' => 'bi:filetype-audio',
            default => 'bi:file-earmark'
        };
    }

    /**
     * Check if path is a directory
     */
    public function isDirectory(string $path): bool
    {
        return is_dir($path);
    }

    /**
     * Get directory size (recursive)
     */
    public function getDirectorySize(string $path): int
    {
        if (!$this->isDirectory($path)) {
            return 0;
        }

        $size = 0;
        $finder = new Finder();
        $finder->in($path)->files();

        foreach ($finder as $file) {
            $size += $file->getSize();
        }

        return $size;
    }

    /**
     * Format file size in human readable format
     */
    public function formatFileSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= (1 << (10 * $pow));

        return round($bytes, 2) . ' ' . $units[(int)$pow];
    }

    /**
     * Get file permissions in human readable format
     */
    public function getFilePermissions(string $path): string
    {
        if (!$this->filesystem->exists($path)) {
            return '';
        }

        $perms = fileperms($path);
        return substr(sprintf('%o', $perms), -4);
    }

    /**
     * Check if file is executable
     */
    public function isExecutable(string $path): bool
    {
        return is_executable($path);
    }

    /**
     * Get file modification time
     */
    public function getFileModificationTime(string $path): ?\DateTime
    {
        if (!$this->filesystem->exists($path)) {
            return null;
        }

        $timestamp = filemtime($path);
        if ($timestamp === false) {
            return null;
        }
        return (new \DateTime())->setTimestamp($timestamp);
    }

    /**
     * Build tree structure recursively
     *
     * @param array<string> $excludeDirs
     * @param array<string> $excludeFiles
     * @return array<int, array<string, mixed>>
     */
    private function buildTreeRecursive(
        string $path,
        array $excludeDirs,
        array $excludeFiles,
        int $maxDepth,
        int $currentDepth
    ): array {
        $items = [];

        if ($maxDepth > 0 && $currentDepth >= $maxDepth) {
            return $items;
        }

        $iterator = new \DirectoryIterator($path);

        foreach ($iterator as $file) {
            if ($file->isDot()) {
                continue;
            }

            $filename = $file->getFilename();

            // Skip excluded files
            if (in_array($filename, $excludeFiles, true)) {
                continue;
            }

            // Skip excluded directories
            if ($file->isDir() && in_array($filename, $excludeDirs, true)) {
                continue;
            }

            $item = [
                'id' => md5($file->getPathname()),
                'label' => $filename,
                'path' => $file->getPathname(),
                'relativePath' => str_replace($path . DIRECTORY_SEPARATOR, '', $file->getPathname()),
                'expanded' => false,
            ];

            if ($file->isDir()) {
                $item['icon'] = 'bi:folder-fill';
                $item['type'] = 'directory';
                $item['size'] = $this->getDirectorySize($file->getPathname());
                $item['permissions'] = $this->getFilePermissions($file->getPathname());
                $item['modified'] = $this->getFileModificationTime($file->getPathname());
                
                // Recursively build children
                $item['children'] = $this->buildTreeRecursive(
                    $file->getPathname(),
                    $excludeDirs,
                    $excludeFiles,
                    $maxDepth,
                    $currentDepth + 1
                );
                $item['hasChildren'] = !empty($item['children']);
            } else {
                $item['icon'] = $this->getFileIcon($filename);
                $item['type'] = 'file';
                $item['size'] = $file->getSize();
                $item['permissions'] = $this->getFilePermissions($file->getPathname());
                $item['modified'] = $this->getFileModificationTime($file->getPathname());
                $item['executable'] = $this->isExecutable($file->getPathname());
                $item['extension'] = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            }

            $items[] = $item;
        }

        // Sort: directories first, then files, both alphabetically
        usort($items, function ($a, $b) {
            if ($a['type'] === $b['type']) {
                return strcasecmp($a['label'], $b['label']);
            }
            return $a['type'] === 'directory' ? -1 : 1;
        });

        return $items;
    }

}
