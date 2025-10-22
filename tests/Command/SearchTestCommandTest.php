<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Command;

use NeuralGlitch\UxBootstrap\Command\SearchTestCommand;
use NeuralGlitch\UxBootstrap\Service\Search\SearchService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Tester\CommandTester;

final class SearchTestCommandTest extends TestCase
{
    private function createCommand(): SearchTestCommand
    {
        $searchService = $this->createMock(SearchService::class);
        $searchService->method('search')->willReturn([
            [
                'title' => 'Test Result',
                'description' => 'Test description',
                'url' => '/test',
                'type' => 'Page',
            ],
        ]);

        return new SearchTestCommand($searchService);
    }

    public function testCommandIsNamed(): void
    {
        $command = $this->createCommand();

        self::assertSame('ux-bootstrap:search:test', $command->getName());
    }

    public function testCommandHasDescription(): void
    {
        $command = $this->createCommand();

        self::assertStringContainsString('search', strtolower($command->getDescription()));
    }

    public function testCommandHasQueryArgument(): void
    {
        $command = $this->createCommand();
        $definition = $command->getDefinition();

        self::assertTrue($definition->hasArgument('query'));
        $queryArg = $definition->getArgument('query');
        self::assertFalse($queryArg->isRequired());
    }

    public function testCommandHasLimitOption(): void
    {
        $command = $this->createCommand();
        $definition = $command->getDefinition();

        self::assertTrue($definition->hasOption('limit'));
        $limitOption = $definition->getOption('limit');
        self::assertTrue($limitOption->isValueRequired());
        self::assertEquals(10, $limitOption->getDefault());
    }

    public function testExecuteWithoutArgumentsRunsDefaultTests(): void
    {
        $command = $this->createCommand();
        $tester = new CommandTester($command);

        $exitCode = $tester->execute([]);

        self::assertSame(Command::SUCCESS, $exitCode);
        self::assertStringContainsString('UX Bootstrap Search Service Test', $tester->getDisplay());
    }

    public function testExecuteWithQueryArgument(): void
    {
        $searchService = $this->createMock(SearchService::class);
        $searchService->expects(self::once())
            ->method('search')
            ->with('test query', 10)
            ->willReturn([
                [
                    'title' => 'Test Result',
                    'description' => 'Test description',
                    'url' => '/test',
                    'type' => 'Page',
                ],
            ]);

        $command = new SearchTestCommand($searchService);
        $tester = new CommandTester($command);

        $exitCode = $tester->execute([
            'query' => 'test query',
        ]);

        self::assertSame(Command::SUCCESS, $exitCode);
        self::assertStringContainsString('test query', $tester->getDisplay());
        self::assertStringContainsString('Test Result', $tester->getDisplay());
    }

    public function testExecuteWithCustomLimit(): void
    {
        $searchService = $this->createMock(SearchService::class);
        $searchService->expects(self::once())
            ->method('search')
            ->with('test', 25)
            ->willReturn([]);

        $command = new SearchTestCommand($searchService);
        $tester = new CommandTester($command);

        $exitCode = $tester->execute([
            'query' => 'test',
            '--limit' => '25',
        ]);

        self::assertSame(Command::SUCCESS, $exitCode);
    }

    public function testExecuteWithNoResults(): void
    {
        $searchService = $this->createMock(SearchService::class);
        $searchService->method('search')->willReturn([]);

        $command = new SearchTestCommand($searchService);
        $tester = new CommandTester($command);

        $exitCode = $tester->execute([
            'query' => 'nonexistent',
        ]);

        self::assertSame(Command::SUCCESS, $exitCode);
        self::assertStringContainsString('No results found', $tester->getDisplay());
    }

    public function testExecuteDisplaysResultsInTable(): void
    {
        $searchService = $this->createMock(SearchService::class);
        $searchService->method('search')->willReturn([
            [
                'title' => 'Result 1',
                'description' => 'Description 1',
                'url' => '/url1',
                'type' => 'Page',
            ],
            [
                'title' => 'Result 2',
                'description' => 'Description 2',
                'url' => '/url2',
                'type' => 'Route',
            ],
        ]);

        $command = new SearchTestCommand($searchService);
        $tester = new CommandTester($command);

        $exitCode = $tester->execute([
            'query' => 'test',
        ]);

        self::assertSame(Command::SUCCESS, $exitCode);
        $display = $tester->getDisplay();
        self::assertStringContainsString('Result 1', $display);
        self::assertStringContainsString('Result 2', $display);
        self::assertStringContainsString('/url1', $display);
        self::assertStringContainsString('/url2', $display);
    }

    public function testExecuteReturnsSuccessCode(): void
    {
        $command = $this->createCommand();
        $tester = new CommandTester($command);

        $exitCode = $tester->execute([]);

        self::assertSame(Command::SUCCESS, $exitCode);
    }

    public function testExecuteDisplaysSuccessMessage(): void
    {
        $command = $this->createCommand();
        $tester = new CommandTester($command);

        $tester->execute([]);

        self::assertStringContainsString('Search service is working correctly', $tester->getDisplay());
    }

    public function testExecuteWithVerboseOutput(): void
    {
        $command = $this->createCommand();
        $tester = new CommandTester($command);

        $tester->execute([], ['verbosity' => OutputInterface::VERBOSITY_VERBOSE]);

        $display = $tester->getDisplay();
        self::assertNotEmpty($display);
    }

    public function testExecuteTruncatesLongDescriptions(): void
    {
        $longDescription = str_repeat('A very long description that should be truncated. ', 10);

        $searchService = $this->createMock(SearchService::class);
        $searchService->method('search')->willReturn([
            [
                'title' => 'Test',
                'description' => $longDescription,
                'url' => '/test',
                'type' => 'Page',
            ],
        ]);

        $command = new SearchTestCommand($searchService);
        $tester = new CommandTester($command);

        $tester->execute(['query' => 'test']);

        $display = $tester->getDisplay();
        // Verify output contains truncated content (ellipsis)
        self::assertStringContainsString('...', $display);
    }
}

