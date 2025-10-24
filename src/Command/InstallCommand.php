<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'ux-bootstrap:install',
    description: 'Install and configure UX Bootstrap theme support in base templates'
)]
final class InstallCommand extends Command
{
    private const TEMPLATE_PATH = 'templates/base.html.twig';
    private const ALTERNATIVE_TEMPLATES = [
        'templates/layout.html.twig',
        'templates/app.html.twig',
        'templates/main.html.twig',
        'templates/default.html.twig',
    ];

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('UX Bootstrap Installation');

        $installedCount = 0;
        $processedTemplates = [];

        do {
            // Find the main template file
            $templatePath = $this->findMainTemplate($processedTemplates);
            
            if ($templatePath === null) {
                $io->error('No suitable template file found!');
                $io->newLine();
                $io->writeln('Looking for one of these files:');
                $io->writeln('  • <comment>templates/base.html.twig</comment>');
                foreach (self::ALTERNATIVE_TEMPLATES as $alt) {
                    $io->writeln('  • <comment>' . $alt . '</comment>');
                }
                $io->newLine();
                
                // Try to find any template files in templates directory
                $availableTemplates = $this->findAvailableTemplates($processedTemplates);
                
                if (empty($availableTemplates)) {
                    $io->writeln('No template files found in templates directory.');
                    $io->writeln('Please create a main template file, then run this command again.');
                    $io->note('You can also manually add {{ ux_bootstrap_html_attrs() }} to your <html> tag.');
                    
                    return Command::FAILURE;
                }
                
                // Let user choose from available templates
                $io->writeln('Found these template files:');
                $templatePath = $this->selectTemplate($io, $availableTemplates);
                
                if ($templatePath === null) {
                    $io->note('Installation cancelled.');
                    return Command::SUCCESS;
                }
            }

            $io->info(sprintf('Found template: %s', $templatePath));

            // Read template content
            $content = file_get_contents($templatePath);

            if ($content === false) {
                $io->error(sprintf('Could not read template file: %s', $templatePath));
                
                return Command::FAILURE;
            }

            // Check if already installed
            if (str_contains($content, 'ux_bootstrap_html_attrs()')) {
                $io->warning(sprintf('UX Bootstrap theme support is already installed in %s!', $templatePath));
                $io->note('This template already includes {{ ux_bootstrap_html_attrs() }}');
                
                // Add to processed list and continue
                $processedTemplates[] = $templatePath;
                continue;
            }

            // Find <html> tag
            if (!preg_match('/<html([^>]*)>/i', $content, $matches)) {
                $io->warning(sprintf('Could not find <html> tag in %s.', $templatePath));
                $io->newLine();
                $io->writeln('Please add manually to your <html> tag:');
                $io->writeln('  <fg=green>{{ ux_bootstrap_html_attrs() }}</fg=green>');
                $io->newLine();
                $io->writeln('Example:');
                $io->writeln('  <fg=yellow><html lang="en" {{ ux_bootstrap_html_attrs() }}></fg=yellow>');
                
                // Add to processed list and continue
                $processedTemplates[] = $templatePath;
                continue;
            }

            // Show what will be changed
            $io->section(sprintf('Installing in: %s', $templatePath));
            $io->writeln('Current <html> tag:');
            $io->writeln(sprintf('  <fg=red>%s</fg=red>', trim($matches[0])));
            $io->newLine();

            // Prepare the replacement
            $originalTag = $matches[0];
            $attributes = $matches[1]; // Captured attributes (may include leading space)
            
            // Build new tag
            if (trim($attributes) !== '') {
                // Has existing attributes
                // Ensure space before attributes if not present
                $attrs = ltrim($attributes);
                $newTag = sprintf('<html %s {{ ux_bootstrap_html_attrs() }}>', $attrs);
            } else {
                // No existing attributes
                $newTag = '<html {{ ux_bootstrap_html_attrs() }}>';
            }

            $io->writeln('Will be changed to:');
            $io->writeln(sprintf('  <fg=green>%s</fg=green>', $newTag));
            $io->newLine();

            // Ask for confirmation
            if (!$io->confirm('Do you want to apply this change?', true)) {
                $io->note('Skipping this template.');
                $processedTemplates[] = $templatePath;
                continue;
            }

            // Apply the change
            $newContent = str_replace($originalTag, $newTag, $content);

            // Backup original file
            $backupPath = $templatePath . '.backup';
            if (!copy($templatePath, $backupPath)) {
                $io->error('Could not create backup file. Skipping this template.');
                $processedTemplates[] = $templatePath;
                continue;
            }

            // Write new content
            if (file_put_contents($templatePath, $newContent) === false) {
                $io->error('Could not write to template file. Skipping this template.');
                $io->note(sprintf('Backup preserved at: %s', $backupPath));
                $processedTemplates[] = $templatePath;
                continue;
            }

            // Success!
            $io->success(sprintf('UX Bootstrap theme support installed in %s!', $templatePath));
            $installedCount++;
            $processedTemplates[] = $templatePath;
            
            $io->writeln(sprintf('Backup saved to: <comment>%s</comment>', $backupPath));
            $io->newLine();

        } while ($this->askToContinue($io, $installedCount));

        // Final summary
        if ($installedCount > 0) {
            $io->success(sprintf('Installation completed! %d template(s) updated.', $installedCount));
            
            $io->section('What was added:');
            $io->writeln('  • <info>data-bs-theme</info> attribute for automatic light/dark mode detection');
            $io->writeln('  • <info>color-scheme</info> CSS property for native browser theming');
            
            $io->newLine();
            $io->section('Next steps:');
            $io->writeln('  1. Install Bootstrap (if not already installed):');
            $io->writeln('     <comment>php bin/console importmap:require bootstrap</comment>');
            $io->writeln('     <comment>php bin/console importmap:require @popperjs/core</comment>');
            $io->newLine();
            $io->writeln('  2. Start using UX Bootstrap components in your templates!');
            $io->newLine();
            $io->writeln('  📖 Documentation: <href=https://github.com/neuralglitch/ux-bootstrap>https://github.com/neuralglitch/ux-bootstrap</>');
        } else {
            $io->note('No templates were modified.');
        }

        return Command::SUCCESS;
    }

    /**
     * Find the main template file to modify
     */
    private function findMainTemplate(array $processedTemplates = []): ?string
    {
        // Check primary template first
        if (file_exists(self::TEMPLATE_PATH) && !in_array(self::TEMPLATE_PATH, $processedTemplates)) {
            return self::TEMPLATE_PATH;
        }

        // Check alternative templates
        foreach (self::ALTERNATIVE_TEMPLATES as $template) {
            if (file_exists($template) && !in_array($template, $processedTemplates)) {
                return $template;
            }
        }

        return null;
    }

    /**
     * Find all available base template files in the templates directory
     */
    private function findAvailableTemplates(array $processedTemplates = []): array
    {
        $templates = [];
        
        if (!is_dir('templates')) {
            return $templates;
        }

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator('templates', \RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'twig') {
                $path = $file->getPathname();
                
                // Skip already processed templates
                if (in_array($path, $processedTemplates)) {
                    continue;
                }
                
                // Check if this is a base template
                if ($this->isBaseTemplate($path)) {
                    $templates[] = $path;
                }
            }
        }

        return $templates;
    }

    /**
     * Check if a template is a base template (not extended by others)
     */
    private function isBaseTemplate(string $templatePath): bool
    {
        $content = file_get_contents($templatePath);
        if (!$content) {
            return false;
        }

        // Must contain <html> tag
        if (!preg_match('/<html[^>]*>/i', $content)) {
            return false;
        }

        // Must NOT extend another template
        if (preg_match('/{%\s*extends\s+["\']([^"\']+)["\']\s*%}/i', $content)) {
            return false;
        }

        // Must NOT have extends in any form
        if (str_contains($content, '{% extends')) {
            return false;
        }

        // Check filename patterns for base templates
        $filename = basename($templatePath);
        $isBaseName = in_array($filename, [
            'base.html.twig',
            'layout.html.twig', 
            'app.html.twig',
            'main.html.twig',
            'default.html.twig',
            'index.html.twig'
        ]);

        // Check if it's in a base/layout directory
        $isBaseDir = str_contains($templatePath, '/base/') || 
                     str_contains($templatePath, '/layout/') ||
                     str_contains($templatePath, '/layouts/');

        // Check if it contains typical base template elements
        $hasBaseElements = str_contains($content, '<!DOCTYPE html>') ||
                          str_contains($content, '<head>') ||
                          str_contains($content, '<body>') ||
                          str_contains($content, '{% block title %}') ||
                          str_contains($content, '{% block body %}');

        // Must be a true base template
        return ($isBaseName || $isBaseDir || $hasBaseElements) && 
               !$this->isExtendedByOthers($templatePath);
    }

    /**
     * Check if this template is extended by other templates
     */
    private function isExtendedByOthers(string $templatePath): bool
    {
        if (!is_dir('templates')) {
            return false;
        }

        $templateName = basename($templatePath);
        $templateNameWithoutExt = pathinfo($templateName, PATHINFO_FILENAME);
        
        // Common patterns to look for
        $searchPatterns = [
            "'" . $templateName . "'",
            '"' . $templateName . '"',
            "'" . $templateNameWithoutExt . "'",
            '"' . $templateNameWithoutExt . '"',
            "'" . str_replace('templates/', '', $templatePath) . "'",
            '"' . str_replace('templates/', '', $templatePath) . '"'
        ];

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator('templates', \RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'twig') {
                $path = $file->getPathname();
                
                // Skip the template itself
                if ($path === $templatePath) {
                    continue;
                }
                
                $content = file_get_contents($path);
                if (!$content) {
                    continue;
                }
                
                // Check if this file extends our template
                foreach ($searchPatterns as $pattern) {
                    if (str_contains($content, '{% extends ' . $pattern . ' %}')) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Let user select a template from available options
     */
    private function selectTemplate(SymfonyStyle $io, array $templates): ?string
    {
        if (count($templates) === 1) {
            $io->writeln(sprintf('  • <info>%s</info>', $templates[0]));
            $io->newLine();
            
            if ($io->confirm('Use this template for installation?', true)) {
                return $templates[0];
            }
            
            return null;
        }

        $choices = [];
        foreach ($templates as $index => $template) {
            $choices[] = sprintf('%s (%s)', $template, $this->getTemplateDescription($template));
        }

        $choice = $io->choice('Select template to modify:', $choices);
        
        // Extract the template path from the choice
        $selectedIndex = array_search($choice, $choices);
        return $templates[$selectedIndex];
    }

    /**
     * Get a brief description of the template file
     */
    private function getTemplateDescription(string $templatePath): string
    {
        $content = file_get_contents($templatePath);
        
        // Try to extract title or description from template
        if (preg_match('/{%\s*block\s+title\s*%}(.*?){%\s*endblock\s*%}/s', $content, $matches)) {
            $title = trim(strip_tags($matches[1]));
            if (strlen($title) > 50) {
                $title = substr($title, 0, 47) . '...';
            }
            return $title ?: 'Template file';
        }
        
        // Check if it's a base/layout template
        if (str_contains($templatePath, 'base') || str_contains($templatePath, 'layout')) {
            return 'Base/Layout template';
        }
        
        return 'Template file';
    }

    /**
     * Ask user if they want to continue with another template
     */
    private function askToContinue(SymfonyStyle $io, int $installedCount): bool
    {
        $io->newLine();
        $io->section('Continue Installation');
        
        if ($installedCount > 0) {
            $io->writeln(sprintf('Successfully installed in %d template(s).', $installedCount));
        }
        
        $io->writeln('You can:');
        $io->writeln('  • Install in another template');
        $io->writeln('  • Exit the installation');
        $io->newLine();
        
        return $io->confirm('Do you want to install in another template?', false);
    }
}

