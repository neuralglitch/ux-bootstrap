<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Command;

use NeuralGlitch\UxBootstrap\Service\Search\SearchService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'ux-bootstrap:search:test',
    description: 'Test the search service and view indexed content',
)]
final class SearchTestCommand extends Command
{
    public function __construct(
        private readonly SearchService $searchService,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('query', InputArgument::OPTIONAL, 'Search query to test')
            ->addOption('limit', 'l', InputOption::VALUE_REQUIRED, 'Maximum number of results', 10)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('UX Bootstrap Search Service Test');

        $query = $input->getArgument('query');
        $limit = (int) $input->getOption('limit');

        if ($query) {
            // Test specific query
            $this->testQuery($io, $query, $limit);
        } else {
            // Run default test queries
            $this->runDefaultTests($io, $limit);
        }

        $io->success('Search service is working correctly!');
        return Command::SUCCESS;
    }

    private function testQuery(SymfonyStyle $io, string $query, int $limit): void
    {
        $io->section(sprintf('Search Results for: "%s"', $query));

        $results = $this->searchService->search($query, $limit);

        if ($results === []) {
            $io->warning('No results found.');
            return;
        }

        $io->writeln(sprintf('Found <comment>%d</comment> result(s):', count($results)));
        $io->newLine();

        $tableRows = [];
        foreach ($results as $result) {
            $tableRows[] = [
                $result['title'],
                $result['type'],
                $result['url'],
                $this->truncate($result['description'] ?? '', 50),
            ];
        }

        $io->table(
            ['Title', 'Type', 'URL', 'Description'],
            $tableRows
        );
    }

    private function runDefaultTests(SymfonyStyle $io, int $limit): void
    {
        $io->section('Running Default Test Queries');

        $testQueries = [
            'component',
            'bootstrap',
            'twig',
            'card',
            'getting started',
            'search',
            'navbar',
        ];

        foreach ($testQueries as $query) {
            $results = $this->searchService->search($query, $limit);

            $io->writeln(sprintf(
                'Query: <info>%-20s</info> → Found <comment>%d</comment> result(s)',
                '"' . $query . '"',
                count($results)
            ));

            if ($results !== [] && $io->isVerbose()) {
                foreach (array_slice($results, 0, 3) as $result) {
                    $io->writeln(sprintf('  • %s (%s)', $result['title'], $result['url']));
                }
                if (count($results) > 3) {
                    $io->writeln(sprintf('  ... and %d more', count($results) - 3));
                }
            }

            $io->newLine();
        }

        $io->note([
            'Run with a specific query: ux-bootstrap:search:test "your query"',
            'Use -v flag to see detailed results',
            'Use --limit option to change result count',
        ]);
    }

    private function truncate(string $text, int $length): string
    {
        if (strlen($text) <= $length) {
            return $text;
        }

        return substr($text, 0, $length - 3) . '...';
    }
}

