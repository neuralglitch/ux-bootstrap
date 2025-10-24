<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Command;

use NeuralGlitch\UxBootstrap\Command\InstallCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

final class InstallCommandTest extends TestCase
{
    private const TEST_TEMPLATE_PATH = 'templates/base.html.twig';

    protected function setUp(): void
    {
        // Ensure templates directory exists
        if (!is_dir('templates')) {
            mkdir('templates', 0777, true);
        }

        // Clean up any existing test files
        $this->cleanupTestFiles();
    }

    protected function tearDown(): void
    {
        $this->cleanupTestFiles();
    }

    private function cleanupTestFiles(): void
    {
        if (file_exists(self::TEST_TEMPLATE_PATH)) {
            unlink(self::TEST_TEMPLATE_PATH);
        }
        
        if (file_exists(self::TEST_TEMPLATE_PATH . '.backup')) {
            unlink(self::TEST_TEMPLATE_PATH . '.backup');
        }
    }

    private function createCommandTester(): CommandTester
    {
        $command = new InstallCommand();
        
        return new CommandTester($command);
    }

    public function testCommandNameIsCorrect(): void
    {
        $command = new InstallCommand();
        
        self::assertSame('ux-bootstrap:install', $command->getName());
    }

    public function testCommandHasDescription(): void
    {
        $command = new InstallCommand();
        
        self::assertNotEmpty($command->getDescription());
        self::assertStringContainsString('UX Bootstrap', $command->getDescription());
    }

    public function testCommandFailsWhenTemplateDoesNotExist(): void
    {
        $commandTester = $this->createCommandTester();
        $exitCode = $commandTester->execute([]);

        self::assertSame(Command::FAILURE, $exitCode);
        self::assertStringContainsString('not found', $commandTester->getDisplay());
    }

    public function testCommandSucceedsWhenAlreadyInstalled(): void
    {
        // Create template with theme support already installed
        $content = <<<'TWIG'
<!DOCTYPE html>
<html lang="en" {{ ux_bootstrap_html_attrs() }}>
<head>
    <meta charset="UTF-8">
    <title>Test</title>
</head>
<body>
</body>
</html>
TWIG;
        file_put_contents(self::TEST_TEMPLATE_PATH, $content);

        $commandTester = $this->createCommandTester();
        $exitCode = $commandTester->execute([]);

        self::assertSame(Command::SUCCESS, $exitCode);
        self::assertStringContainsString('already installed', $commandTester->getDisplay());
    }

    public function testCommandInstallsThemeSupportWithSimpleHtmlTag(): void
    {
        // Create template with simple <html> tag
        $content = <<<'TWIG'
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Test</title>
</head>
<body>
</body>
</html>
TWIG;
        file_put_contents(self::TEST_TEMPLATE_PATH, $content);

        $commandTester = $this->createCommandTester();
        $exitCode = $commandTester->execute([], ['interactive' => false]);

        self::assertSame(Command::SUCCESS, $exitCode);
        
        $updatedContent = file_get_contents(self::TEST_TEMPLATE_PATH);
        self::assertStringContainsString('{{ ux_bootstrap_html_attrs() }}', $updatedContent);
        self::assertStringContainsString('<html {{ ux_bootstrap_html_attrs() }}>', $updatedContent);
    }

    public function testCommandInstallsThemeSupportWithLangAttribute(): void
    {
        // Create template with lang attribute
        $content = <<<'TWIG'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test</title>
</head>
<body>
</body>
</html>
TWIG;
        file_put_contents(self::TEST_TEMPLATE_PATH, $content);

        $commandTester = $this->createCommandTester();
        $exitCode = $commandTester->execute([], ['interactive' => false]);

        self::assertSame(Command::SUCCESS, $exitCode);
        
        $updatedContent = file_get_contents(self::TEST_TEMPLATE_PATH);
        self::assertStringContainsString('{{ ux_bootstrap_html_attrs() }}', $updatedContent);
        self::assertStringContainsString('<html lang="en" {{ ux_bootstrap_html_attrs() }}>', $updatedContent);
    }

    public function testCommandInstallsThemeSupportWithMultipleAttributes(): void
    {
        // Create template with multiple attributes
        $content = <<<'TWIG'
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Test</title>
</head>
<body>
</body>
</html>
TWIG;
        file_put_contents(self::TEST_TEMPLATE_PATH, $content);

        $commandTester = $this->createCommandTester();
        $exitCode = $commandTester->execute([], ['interactive' => false]);

        self::assertSame(Command::SUCCESS, $exitCode);
        
        $updatedContent = file_get_contents(self::TEST_TEMPLATE_PATH);
        self::assertStringContainsString('{{ ux_bootstrap_html_attrs() }}', $updatedContent);
        self::assertStringContainsString('<html lang="en" dir="ltr" {{ ux_bootstrap_html_attrs() }}>', $updatedContent);
    }

    public function testCommandCreatesBackupFile(): void
    {
        $content = <<<'TWIG'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test</title>
</head>
<body>
</body>
</html>
TWIG;
        file_put_contents(self::TEST_TEMPLATE_PATH, $content);

        $commandTester = $this->createCommandTester();
        $commandTester->execute([], ['interactive' => false]);

        self::assertFileExists(self::TEST_TEMPLATE_PATH . '.backup');
        self::assertSame($content, file_get_contents(self::TEST_TEMPLATE_PATH . '.backup'));
    }

    public function testCommandCancelsWhenUserDeclines(): void
    {
        $content = <<<'TWIG'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test</title>
</head>
<body>
</body>
</html>
TWIG;
        file_put_contents(self::TEST_TEMPLATE_PATH, $content);

        $commandTester = $this->createCommandTester();
        $commandTester->setInputs(['no']); // Decline the confirmation
        $exitCode = $commandTester->execute([]);

        self::assertSame(Command::SUCCESS, $exitCode);
        
        // Content should be unchanged
        self::assertSame($content, file_get_contents(self::TEST_TEMPLATE_PATH));
        
        // No backup should be created
        self::assertFileDoesNotExist(self::TEST_TEMPLATE_PATH . '.backup');
    }

    public function testCommandFailsWhenNoHtmlTag(): void
    {
        // Create template without <html> tag
        $content = <<<'TWIG'
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Test</title>
</head>
<body>
</body>
TWIG;
        file_put_contents(self::TEST_TEMPLATE_PATH, $content);

        $commandTester = $this->createCommandTester();
        $exitCode = $commandTester->execute([]);

        self::assertSame(Command::FAILURE, $exitCode);
        self::assertStringContainsString('Could not find <html> tag', $commandTester->getDisplay());
    }

    public function testCommandPreservesTemplateStructure(): void
    {
        $content = <<<'TWIG'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{% block title %}Test{% endblock %}</title>
</head>
<body>
    {% block body %}{% endblock %}
</body>
</html>
TWIG;
        file_put_contents(self::TEST_TEMPLATE_PATH, $content);

        $commandTester = $this->createCommandTester();
        $commandTester->execute([], ['interactive' => false]);

        $updatedContent = file_get_contents(self::TEST_TEMPLATE_PATH);
        
        // Check that template structure is preserved
        self::assertStringContainsString('<!DOCTYPE html>', $updatedContent);
        self::assertStringContainsString('{% block title %}', $updatedContent);
        self::assertStringContainsString('{% block body %}', $updatedContent);
        self::assertStringContainsString('</body>', $updatedContent);
        self::assertStringContainsString('</html>', $updatedContent);
    }

    public function testCommandDisplaysSuccessMessage(): void
    {
        $content = <<<'TWIG'
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Test</title>
</head>
<body>
</body>
</html>
TWIG;
        file_put_contents(self::TEST_TEMPLATE_PATH, $content);

        $commandTester = $this->createCommandTester();
        $commandTester->execute([], ['interactive' => false]);

        $display = $commandTester->getDisplay();
        
        self::assertStringContainsString('successfully', $display);
        self::assertStringContainsString('data-bs-theme', $display);
        self::assertStringContainsString('color-scheme', $display);
    }

    public function testCommandIsFinal(): void
    {
        $reflection = new \ReflectionClass(InstallCommand::class);
        
        self::assertTrue($reflection->isFinal());
    }
}




