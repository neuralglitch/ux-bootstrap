<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\ComparisonTable;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class ComparisonTableTest extends TestCase
{
    /** @param array<string, mixed> $config */
    private function createConfig(array $config = []): Config
    {
        return new Config(['comparison-table' => $config]);
    }

    private function createComparisonTable(?Config $config = null): ComparisonTable
    {
        return new ComparisonTable($config ?? $this->createConfig());
    }

    public function testComponentHasCorrectDefaults(): void
    {
        $table = $this->createComparisonTable();

        self::assertSame('default', $table->variant);
        self::assertTrue($table->responsive);
        self::assertSame('container', $table->container);
        self::assertSame([], $table->columns);
        self::assertSame(-1, $table->highlightColumn);
        self::assertSame([], $table->features);
        self::assertTrue($table->showCheckmarks);
        self::assertNull($table->checkIcon);
        self::assertNull($table->uncheckIcon);
        self::assertFalse($table->sticky);
        self::assertTrue($table->centered);
        self::assertTrue($table->hover);
        self::assertNull($table->emptyText);
        self::assertNull($table->title);
        self::assertNull($table->description);
        self::assertSame('', $table->class);
        self::assertSame([], $table->attr);
    }

    public function testMountAppliesConfigDefaults(): void
    {
        $config = $this->createConfig([
            'variant' => 'bordered',
            'responsive' => false,
            'container' => 'container-fluid',
            'highlight_column' => 1,
            'show_checkmarks' => false,
            'check_icon' => '✔',
            'uncheck_icon' => '✘',
            'sticky' => true,
            'centered' => false,
            'hover' => false,
            'empty_text' => 'N/A',
        ]);

        $table = $this->createComparisonTable($config);
        $table->mount();

        self::assertNotNull($table->variant);
        self::assertFalse($table->responsive);
        self::assertNotNull($table->container);
        self::assertSame(1, $table->highlightColumn);
        self::assertFalse($table->showCheckmarks);
        self::assertSame('✔', $table->checkIcon);
        self::assertSame('✘', $table->uncheckIcon);
        self::assertTrue($table->sticky);
        self::assertFalse($table->centered);
        self::assertFalse($table->hover);
        self::assertSame('N/A', $table->emptyText);
    }

    public function testGetComponentName(): void
    {
        $table = $this->createComparisonTable();

        $reflection = new ReflectionClass($table);
        $method = $reflection->getMethod('getComponentName');
        $method->setAccessible(true);

        self::assertSame('comparison-table', $method->invoke($table));
    }

    public function testOptionsReturnsCorrectStructure(): void
    {
        $table = $this->createComparisonTable();
        $table->mount();

        $options = $table->options();

        self::assertIsArray($options);
        self::assertArrayHasKey('variant', $options);
        self::assertArrayHasKey('responsive', $options);
        self::assertArrayHasKey('container', $options);
        self::assertArrayHasKey('columns', $options);
        self::assertArrayHasKey('highlightColumn', $options);
        self::assertArrayHasKey('features', $options);
        self::assertArrayHasKey('showCheckmarks', $options);
        self::assertArrayHasKey('checkIcon', $options);
        self::assertArrayHasKey('uncheckIcon', $options);
        self::assertArrayHasKey('sticky', $options);
        self::assertArrayHasKey('centered', $options);
        self::assertArrayHasKey('hover', $options);
        self::assertArrayHasKey('emptyText', $options);
        self::assertArrayHasKey('title', $options);
        self::assertArrayHasKey('description', $options);
        self::assertArrayHasKey('classes', $options);
        self::assertArrayHasKey('tableClasses', $options);
        self::assertArrayHasKey('attrs', $options);
    }

    public function testOptionsBuildsCorrectClassesForDefault(): void
    {
        $table = $this->createComparisonTable();
        $table->variant = 'default';
        $table->mount();

        $options = $table->options();

        self::assertStringContainsString('py-5', $options['classes']);
        self::assertStringContainsString('table', $options['tableClasses']);
        self::assertStringNotContainsString('table-striped', $options['tableClasses']);
        self::assertStringNotContainsString('table-bordered', $options['tableClasses']);
    }

    public function testOptionsBuildsCorrectClassesForStriped(): void
    {
        $table = $this->createComparisonTable();
        $table->variant = 'striped';
        $table->mount();

        $options = $table->options();

        self::assertStringContainsString('table-striped', $options['tableClasses']);
    }

    public function testOptionsBuildsCorrectClassesForBordered(): void
    {
        $table = $this->createComparisonTable();
        $table->variant = 'bordered';
        $table->mount();

        $options = $table->options();

        self::assertStringContainsString('table-bordered', $options['tableClasses']);
    }

    public function testOptionsBuildsCorrectClassesWithHover(): void
    {
        $table = $this->createComparisonTable();
        $table->variant = 'default';
        $table->hover = true;
        $table->mount();

        $options = $table->options();

        self::assertStringContainsString('table-hover', $options['tableClasses']);
    }

    public function testOptionsDoesNotAddHoverForCardsVariant(): void
    {
        $table = $this->createComparisonTable();
        $table->variant = 'cards';
        $table->hover = true;
        $table->mount();

        $options = $table->options();

        self::assertStringNotContainsString('table-hover', $options['tableClasses']);
    }

    public function testOptionsWithCenteredOption(): void
    {
        $table = $this->createComparisonTable();
        $table->centered = true;
        $table->mount();

        $options = $table->options();

        // Centered is now handled via CSS in _comparison_table.scss, not via Bootstrap classes
        self::assertTrue($table->centered);
        self::assertStringContainsString('table', $options['tableClasses']);
    }

    public function testOptionsIncludesCustomClass(): void
    {
        $table = $this->createComparisonTable();
        $table->class = 'my-custom-class another-class';
        $table->mount();

        $options = $table->options();

        self::assertStringContainsString('my-custom-class', $options['classes']);
        self::assertStringContainsString('another-class', $options['classes']);
    }

    public function testOptionsMergesCustomAttributes(): void
    {
        $table = $this->createComparisonTable();
        $table->attr = [
            'id' => 'my-table',
            'data-test' => 'value',
        ];
        $table->mount();

        $options = $table->options();

        self::assertArrayHasKey('id', $options['attrs']);
        self::assertSame('my-table', $options['attrs']['id']);
        self::assertArrayHasKey('data-test', $options['attrs']);
        self::assertSame('value', $options['attrs']['data-test']);
    }

    public function testOptionsReturnsContentValues(): void
    {
        $table = $this->createComparisonTable();
        $table->title = 'Compare Plans';
        $table->description = 'Choose the perfect plan for your needs';
        $table->columns = [
            ['title' => 'Free', 'price' => '$0'],
            ['title' => 'Pro', 'price' => '$10'],
        ];
        $table->features = [
            ['feature' => 'Storage', 'values' => ['10GB', '100GB']],
        ];
        $table->mount();

        $options = $table->options();

        self::assertSame('Compare Plans', $options['title']);
        self::assertSame('Choose the perfect plan for your needs', $options['description']);
        self::assertCount(2, $options['columns']);
        self::assertCount(1, $options['features']);
    }

    public function testOptionsReturnsVariantValues(): void
    {
        $variants = ['default', 'bordered', 'striped', 'cards', 'horizontal'];

        foreach ($variants as $variant) {
            $table = $this->createComparisonTable();
            $table->variant = $variant;
            $table->mount();

            $options = $table->options();

            self::assertSame($variant, $options['variant']);
        }
    }

    public function testOptionsReturnsContainerValue(): void
    {
        $containers = ['container', 'container-fluid', 'container-lg', 'container-md'];

        foreach ($containers as $container) {
            $table = $this->createComparisonTable();
            $table->container = $container;
            $table->mount();

            $options = $table->options();

            self::assertSame($container, $options['container']);
        }
    }

    public function testComparisonTableWithAllFeaturesEnabled(): void
    {
        $config = $this->createConfig([
            'variant' => 'bordered',
            'sticky' => true,
        ]);

        $table = $this->createComparisonTable($config);
        $table->variant = 'striped';
        $table->title = 'Feature Comparison';
        $table->description = 'See what makes us different';
        $table->columns = [
            ['title' => 'Basic', 'price' => '$9', 'period' => 'month'],
            ['title' => 'Pro', 'price' => '$29', 'period' => 'month', 'badge' => 'Popular'],
            ['title' => 'Enterprise', 'price' => '$99', 'period' => 'month'],
        ];
        $table->features = [
            ['feature' => 'Users', 'values' => ['5', '25', 'Unlimited']],
            ['feature' => 'Storage', 'values' => ['10GB', '100GB', '1TB']],
            ['feature' => 'Support', 'values' => [true, true, true]],
        ];
        $table->highlightColumn = 1;
        $table->class = 'custom-table';
        $table->attr = ['id' => 'pricing-table'];
        $table->mount();

        $options = $table->options();

        self::assertSame('Feature Comparison', $options['title']);
        self::assertSame('See what makes us different', $options['description']);
        self::assertSame('striped', $options['variant']);
        self::assertCount(3, $options['columns']);
        self::assertCount(3, $options['features']);
        self::assertSame(1, $options['highlightColumn']);
        self::assertTrue($options['sticky']);
        self::assertStringContainsString('custom-table', $options['classes']);
        self::assertArrayHasKey('id', $options['attrs']);
    }

    public function testEmptyConfigUsesAllDefaults(): void
    {
        $table = $this->createComparisonTable($this->createConfig([]));
        $table->mount();

        self::assertSame('default', $table->variant);
        self::assertTrue($table->responsive);
        self::assertSame('container', $table->container);
        self::assertTrue($table->showCheckmarks);
        self::assertSame('✓', $table->checkIcon);
        self::assertTrue($table->centered);
        self::assertTrue($table->hover);
    }

    public function testMountMergesConfigAttrs(): void
    {
        $config = $this->createConfig([
            'attr' => ['data-config' => 'value'],
        ]);

        $table = $this->createComparisonTable($config);
        $table->attr = ['data-user' => 'custom'];
        $table->mount();

        $options = $table->options();

        self::assertArrayHasKey('data-config', $options['attrs']);
        self::assertArrayHasKey('data-user', $options['attrs']);
    }

    public function testHighlightColumnCanBeDisabled(): void
    {
        $table = $this->createComparisonTable();
        $table->highlightColumn = -1;
        $table->mount();

        $options = $table->options();

        self::assertSame(-1, $options['highlightColumn']);
    }

    public function testCustomCheckmarksCanBeSet(): void
    {
        $table = $this->createComparisonTable();
        $table->checkIcon = '✔️';
        $table->uncheckIcon = '❌';
        $table->mount();

        $options = $table->options();

        self::assertSame('✔️', $options['checkIcon']);
        self::assertSame('❌', $options['uncheckIcon']);
    }
}

