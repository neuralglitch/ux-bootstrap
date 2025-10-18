<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\DataTable;
use PHPUnit\Framework\TestCase;

final class DataTableTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'data_table' => [
                'striped' => true,
                'bordered' => false,
                'borderless' => false,
                'hover' => true,
                'small' => false,
                'variant' => null,
                'responsive' => true,
                'responsive_breakpoint' => null,
                'caption_position' => 'top',
                'thead' => null,
                'divider' => false,
                'sortable' => false,
                'sort_direction' => 'asc',
                'selectable' => false,
                'select_name' => 'selected[]',
                'select_all' => false,
                'show_actions' => false,
                'actions_label' => 'Actions',
                'actions_position' => 'end',
                'empty_message' => 'No data available',
                'show_empty_state' => true,
                'container' => 'container-fluid',
                'card_wrapper' => false,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new DataTable($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('table', $options['tableClasses']);
        $this->assertStringContainsString('table-striped', $options['tableClasses']);
        $this->assertStringContainsString('table-hover', $options['tableClasses']);
        $this->assertSame('table-responsive', $options['responsiveClass']);
        $this->assertTrue($options['isEmpty']);
    }

    public function testStripedOption(): void
    {
        $component = new DataTable($this->config);
        $component->striped = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('table-striped', $options['tableClasses']);
    }

    public function testBorderedOption(): void
    {
        $component = new DataTable($this->config);
        $component->bordered = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('table-bordered', $options['tableClasses']);
    }

    public function testBorderlessOption(): void
    {
        $component = new DataTable($this->config);
        $component->borderless = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('table-borderless', $options['tableClasses']);
    }

    public function testHoverOption(): void
    {
        $component = new DataTable($this->config);
        $component->hover = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('table-hover', $options['tableClasses']);
    }

    public function testSmallOption(): void
    {
        $component = new DataTable($this->config);
        $component->small = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('table-sm', $options['tableClasses']);
    }

    public function testVariantOption(): void
    {
        $component = new DataTable($this->config);
        $component->variant = 'primary';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('table-primary', $options['tableClasses']);
    }

    public function testResponsiveOption(): void
    {
        $component = new DataTable($this->config);
        $component->responsive = true;
        $component->mount();
        $options = $component->options();

        $this->assertSame('table-responsive', $options['responsiveClass']);
    }

    public function testResponsiveBreakpointOption(): void
    {
        $component = new DataTable($this->config);
        $component->responsive = true;
        $component->responsiveBreakpoint = 'md';
        $component->mount();
        $options = $component->options();

        $this->assertSame('table-responsive-md', $options['responsiveClass']);
    }

    public function testTheadOption(): void
    {
        $component = new DataTable($this->config);
        $component->thead = 'dark';
        $component->mount();
        $options = $component->options();

        $this->assertSame('table-dark', $options['theadClass']);
    }

    public function testCaptionOption(): void
    {
        $component = new DataTable($this->config);
        $component->captionText = 'Test Caption';
        $component->captionPosition = 'bottom';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Test Caption', $options['captionText']);
        $this->assertSame('bottom', $options['captionPosition']);
    }

    public function testSortableOption(): void
    {
        $component = new DataTable($this->config);
        $component->sortable = true;
        $component->sortedColumn = 'name';
        $component->sortDirection = 'desc';
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['sortable']);
        $this->assertSame('name', $options['sortedColumn']);
        $this->assertSame('desc', $options['sortDirection']);
    }

    public function testSelectableOption(): void
    {
        $component = new DataTable($this->config);
        $component->selectable = true;
        $component->selectAll = true;
        $component->selectName = 'items[]';
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['selectable']);
        $this->assertTrue($options['selectAll']);
        $this->assertSame('items[]', $options['selectName']);
    }

    public function testShowActionsOption(): void
    {
        $component = new DataTable($this->config);
        $component->showActions = true;
        $component->actionsLabel = 'Operations';
        $component->actionsPosition = 'start';
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['showActions']);
        $this->assertSame('Operations', $options['actionsLabel']);
        $this->assertSame('start', $options['actionsPosition']);
    }

    public function testWithDataRows(): void
    {
        $component = new DataTable($this->config);
        $component->rows = [
            ['id' => 1, 'name' => 'John', 'email' => 'john@example.com'],
            ['id' => 2, 'name' => 'Jane', 'email' => 'jane@example.com'],
        ];
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['isEmpty']);
        $this->assertCount(2, $options['rows']);
    }

    public function testWithColumns(): void
    {
        $component = new DataTable($this->config);
        $component->columns = [
            ['key' => 'id', 'label' => 'ID', 'sortable' => true],
            ['key' => 'name', 'label' => 'Name', 'sortable' => true],
            ['key' => 'email', 'label' => 'Email', 'sortable' => false],
        ];
        $component->mount();
        $options = $component->options();

        $this->assertCount(3, $options['columns']);
        $this->assertSame('ID', $options['columns'][0]['label']);
        $this->assertTrue($options['columns'][0]['sortable']);
        $this->assertFalse($options['columns'][2]['sortable']);
    }

    public function testColumnsAutoGenerateLabels(): void
    {
        $component = new DataTable($this->config);
        $component->columns = [
            ['key' => 'user_name'],
            ['key' => 'email'],
        ];
        $component->mount();
        $options = $component->options();

        $this->assertSame('User_name', $options['columns'][0]['label']);
        $this->assertSame('Email', $options['columns'][1]['label']);
    }

    public function testEmptyStateOption(): void
    {
        $component = new DataTable($this->config);
        $component->emptyMessage = 'No users found';
        $component->showEmptyState = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['isEmpty']);
        $this->assertTrue($options['showEmptyState']);
        $this->assertSame('No users found', $options['emptyMessage']);
    }

    public function testCardWrapperOption(): void
    {
        $component = new DataTable($this->config);
        $component->cardWrapper = true;
        $component->cardTitle = 'User List';
        $component->cardSubtitle = 'All registered users';
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['cardWrapper']);
        $this->assertSame('User List', $options['cardTitle']);
        $this->assertSame('All registered users', $options['cardSubtitle']);
    }

    public function testContainerOption(): void
    {
        $component = new DataTable($this->config);
        $component->container = 'container';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('container', $options['containerClasses']);
    }

    public function testCustomClassOption(): void
    {
        $component = new DataTable($this->config);
        $component->class = 'custom-table-wrapper';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-table-wrapper', $options['wrapperClasses']);
    }

    public function testCustomAttributesOption(): void
    {
        $component = new DataTable($this->config);
        $component->attr = [
            'data-test' => 'data-table',
            'id' => 'users-table',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('data-table', $options['attrs']['data-test']);
        $this->assertArrayHasKey('id', $options['attrs']);
        $this->assertSame('users-table', $options['attrs']['id']);
    }

    public function testGetSortUrlMethod(): void
    {
        $component = new DataTable($this->config);
        $component->sortBaseUrl = '/users';
        $component->sortedColumn = 'name';
        $component->sortDirection = 'asc';
        $component->mount();

        // Sorting by the same column should reverse direction
        $url = $component->getSortUrl('name');
        $this->assertStringContainsString('sort=name', $url);
        $this->assertStringContainsString('direction=desc', $url);

        // Sorting by a different column should default to asc
        $url = $component->getSortUrl('email');
        $this->assertStringContainsString('sort=email', $url);
        $this->assertStringContainsString('direction=asc', $url);
    }

    public function testGetSortUrlWithoutBaseUrl(): void
    {
        $component = new DataTable($this->config);
        $component->mount();

        $url = $component->getSortUrl('name');
        $this->assertNull($url);
    }

    public function testGetSortIconMethod(): void
    {
        $component = new DataTable($this->config);
        $component->sortedColumn = 'name';
        $component->sortDirection = 'asc';
        $component->mount();

        // Sorted column ascending
        $icon = $component->getSortIcon('name');
        $this->assertSame('↑', $icon);

        // Sorted column descending
        $component->sortDirection = 'desc';
        $icon = $component->getSortIcon('name');
        $this->assertSame('↓', $icon);

        // Unsorted column
        $icon = $component->getSortIcon('email');
        $this->assertSame('⇅', $icon);
    }

    public function testGetComponentName(): void
    {
        $component = new DataTable($this->config);
        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('data_table', $method->invoke($component));
    }

    public function testCombinedOptions(): void
    {
        $component = new DataTable($this->config);
        $component->striped = true;
        $component->bordered = true;
        $component->hover = true;
        $component->small = true;
        $component->variant = 'success';
        $component->sortable = true;
        $component->selectable = true;
        $component->showActions = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('table-striped', $options['tableClasses']);
        $this->assertStringContainsString('table-bordered', $options['tableClasses']);
        $this->assertStringContainsString('table-hover', $options['tableClasses']);
        $this->assertStringContainsString('table-sm', $options['tableClasses']);
        $this->assertStringContainsString('table-success', $options['tableClasses']);
        $this->assertTrue($options['sortable']);
        $this->assertTrue($options['selectable']);
        $this->assertTrue($options['showActions']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'data_table' => [
                'striped' => false,
                'bordered' => true,
                'hover' => false,
                'small' => true,
                'variant' => 'primary',
                'responsive' => true,
                'responsive_breakpoint' => 'lg',
                'thead' => 'dark',
                'sortable' => true,
                'selectable' => true,
                'show_actions' => true,
                'actions_label' => 'Edit',
                'empty_message' => 'Nothing here',
                'container' => 'container',
                'card_wrapper' => true,
                'class' => 'default-table',
            ],
        ]);

        $component = new DataTable($config);
        $component->mount();
        $options = $component->options();

        $this->assertStringNotContainsString('table-striped', $options['tableClasses']);
        $this->assertStringContainsString('table-bordered', $options['tableClasses']);
        $this->assertStringNotContainsString('table-hover', $options['tableClasses']);
        $this->assertStringContainsString('table-sm', $options['tableClasses']);
        $this->assertStringContainsString('table-primary', $options['tableClasses']);
        $this->assertSame('table-responsive-lg', $options['responsiveClass']);
        $this->assertSame('table-dark', $options['theadClass']);
        $this->assertTrue($options['sortable']);
        $this->assertTrue($options['selectable']);
        $this->assertTrue($options['showActions']);
        $this->assertSame('Edit', $options['actionsLabel']);
        $this->assertSame('Nothing here', $options['emptyMessage']);
        $this->assertStringContainsString('container', $options['containerClasses']);
        $this->assertTrue($options['cardWrapper']);
        $this->assertStringContainsString('default-table', $options['wrapperClasses']);
    }
}

