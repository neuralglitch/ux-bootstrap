<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\MetricsGrid;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class MetricsGridTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'metrics-grid' => [
                'columns' => 4,
                'gap' => '4',
                'equal_height' => true,
                'card_variant' => null,
                'card_border' => false,
                'card_shadow' => false,
                'size' => 'default',
                'text_align' => 'start',
                'show_sparklines' => false,
                'sparkline_color' => 'primary',
                'sparkline_height' => 40,
                'columns_sm' => null,
                'columns_md' => null,
                'columns_lg' => null,
                'columns_xl' => null,
                'columns_xxl' => null,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new MetricsGrid($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('metrics-grid', $options['containerClasses']);
        $this->assertStringContainsString('row', $options['rowClasses']);
        $this->assertStringContainsString('g-4', $options['rowClasses']);
        $this->assertStringContainsString('col-lg-3', $options['colClasses']); // 12/4 = 3
    }

    public function testColumnsOption(): void
    {
        $component = new MetricsGrid($this->config);
        $component->columns = 3;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('col-lg-4', $options['colClasses']); // 12/3 = 4
    }

    public function testColumnsOptionWithTwoColumns(): void
    {
        $component = new MetricsGrid($this->config);
        $component->columns = 2;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('col-lg-6', $options['colClasses']); // 12/2 = 6
    }

    public function testGapOption(): void
    {
        $component = new MetricsGrid($this->config);
        $component->gap = '5';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('g-5', $options['rowClasses']);
    }

    public function testEqualHeightOption(): void
    {
        $component = new MetricsGrid($this->config);
        $component->equalHeight = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('h-100', $options['cardClasses']);
    }

    public function testCardVariantOption(): void
    {
        $component = new MetricsGrid($this->config);
        $component->cardVariant = 'primary';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('border-primary', $options['cardClasses']);
    }

    public function testCardBorderOption(): void
    {
        $component = new MetricsGrid($this->config);
        $component->cardBorder = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('border', $options['cardClasses']);
        $this->assertStringNotContainsString('border-0', $options['cardClasses']);
    }

    public function testCardShadowOption(): void
    {
        $component = new MetricsGrid($this->config);
        $component->cardShadow = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('shadow-sm', $options['cardClasses']);
    }

    public function testSizeSmallOption(): void
    {
        $component = new MetricsGrid($this->config);
        $component->size = 'sm';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('p-3', $options['bodyClasses']);
    }

    public function testSizeLargeOption(): void
    {
        $component = new MetricsGrid($this->config);
        $component->size = 'lg';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('p-4', $options['bodyClasses']);
    }

    public function testTextAlignCenterOption(): void
    {
        $component = new MetricsGrid($this->config);
        $component->textAlign = 'center';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('text-center', $options['bodyClasses']);
    }

    public function testMetricsDataProcessing(): void
    {
        $component = new MetricsGrid($this->config);
        $component->metrics = [
            [
                'value' => '1,234',
                'label' => 'Total Users',
                'variant' => 'primary',
                'change' => '+12%',
                'trend' => 'up',
            ],
            [
                'value' => '567',
                'label' => 'Active Sessions',
                'variant' => 'success',
            ],
        ];
        $component->mount();
        $options = $component->options();

        $this->assertCount(2, $options['metrics']);
        $this->assertSame('1,234', $options['metrics'][0]['value']);
        $this->assertSame('Total Users', $options['metrics'][0]['label']);
        $this->assertSame('primary', $options['metrics'][0]['variant']);
        $this->assertSame('567', $options['metrics'][1]['value']);
    }

    public function testMetricTrendProcessing(): void
    {
        $component = new MetricsGrid($this->config);
        $component->metrics = [
            [
                'value' => '100',
                'label' => 'Sales',
                'trend' => 'up',
                'change' => '+15%',
            ],
        ];
        $component->mount();
        $options = $component->options();

        $this->assertNotNull($options['metrics'][0]['trendData']);
        $this->assertSame('success', $options['metrics'][0]['trendData']['variant']);
        $this->assertSame('↑', $options['metrics'][0]['trendData']['icon']);
    }

    public function testMetricTrendDown(): void
    {
        $component = new MetricsGrid($this->config);
        $component->metrics = [
            [
                'value' => '50',
                'label' => 'Errors',
                'trend' => 'down',
                'change' => '-5%',
            ],
        ];
        $component->mount();
        $options = $component->options();

        $this->assertSame('danger', $options['metrics'][0]['trendData']['variant']);
        $this->assertSame('↓', $options['metrics'][0]['trendData']['icon']);
    }

    public function testShowSparklinesOption(): void
    {
        $component = new MetricsGrid($this->config);
        $component->showSparklines = true;
        $component->sparklineColor = 'success';
        $component->sparklineHeight = 50;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['showSparklines']);
        $this->assertSame('success', $options['sparklineColor']);
        $this->assertSame(50, $options['sparklineHeight']);
    }

    public function testSparklineDataProcessing(): void
    {
        $component = new MetricsGrid($this->config);
        $component->showSparklines = true;
        $component->metrics = [
            [
                'value' => '1,234',
                'label' => 'Revenue',
                'sparkline' => [100, 150, 120, 180, 200],
            ],
        ];
        $component->mount();
        $options = $component->options();

        $this->assertNotNull($options['metrics'][0]['sparkline']);
        $this->assertIsArray($options['metrics'][0]['sparkline']['values']);
        $this->assertCount(5, $options['metrics'][0]['sparkline']['values']);
    }

    public function testResponsiveColumnsSmall(): void
    {
        $component = new MetricsGrid($this->config);
        $component->columnsSm = 2;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('col-sm-6', $options['colClasses']); // 12/2 = 6
    }

    public function testResponsiveColumnsMedium(): void
    {
        $component = new MetricsGrid($this->config);
        $component->columnsMd = 3;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('col-md-4', $options['colClasses']); // 12/3 = 4
    }

    public function testResponsiveColumnsLarge(): void
    {
        $component = new MetricsGrid($this->config);
        $component->columnsLg = 4;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('col-lg-3', $options['colClasses']); // 12/4 = 3
    }

    public function testResponsiveColumnsExtraLarge(): void
    {
        $component = new MetricsGrid($this->config);
        $component->columnsXl = 6;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('col-xl-2', $options['colClasses']); // 12/6 = 2
    }

    public function testCustomClassOption(): void
    {
        $component = new MetricsGrid($this->config);
        $component->class = 'my-custom-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('my-custom-class', $options['containerClasses']);
    }

    public function testCustomAttributesOption(): void
    {
        $component = new MetricsGrid($this->config);
        $component->attr = ['data-test' => 'value'];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('value', $options['attrs']['data-test']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'metrics-grid' => [
                'columns' => 3,
                'gap' => '5',
                'card_variant' => 'success',
                'card_shadow' => true,
                'size' => 'lg',
            ],
        ]);

        $component = new MetricsGrid($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame(3, $component->columns);
        $this->assertSame('5', $component->gap);
        $this->assertSame('success', $component->cardVariant);
        $this->assertTrue($component->cardShadow);
        $this->assertSame('lg', $component->size);
    }

    public function testGetComponentName(): void
    {
        $component = new MetricsGrid($this->config);
        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('metrics-grid', $method->invoke($component));
    }

    public function testEmptyMetricsArray(): void
    {
        $component = new MetricsGrid($this->config);
        $component->metrics = [];
        $component->mount();
        $options = $component->options();

        $this->assertIsArray($options['metrics']);
        $this->assertCount(0, $options['metrics']);
    }

    public function testMetricWithIcon(): void
    {
        $component = new MetricsGrid($this->config);
        $component->metrics = [
            [
                'value' => '42',
                'label' => 'Messages',
                'icon' => '📧',
                'iconPosition' => 'start',
            ],
        ];
        $component->mount();
        $options = $component->options();

        $this->assertSame('📧', $options['metrics'][0]['icon']);
        $this->assertSame('start', $options['metrics'][0]['iconPosition']);
        $this->assertNotEmpty($options['metrics'][0]['iconClasses']);
    }

    public function testMetricWithDescription(): void
    {
        $component = new MetricsGrid($this->config);
        $component->metrics = [
            [
                'value' => '98%',
                'label' => 'Uptime',
                'description' => 'Last 30 days',
            ],
        ];
        $component->mount();
        $options = $component->options();

        $this->assertSame('Last 30 days', $options['metrics'][0]['description']);
    }

    public function testColumnsRangeConstraints(): void
    {
        $component = new MetricsGrid($this->config);

        // Test minimum constraint (should be 1)
        $component->columns = 0;
        $component->mount();
        $options = $component->options();
        $this->assertStringContainsString('col-lg-12', $options['colClasses']); // 12/1 = 12

        // Test maximum constraint (should be 6)
        $component->columns = 7;
        $component->mount();
        $options = $component->options();
        $this->assertStringContainsString('col-lg-2', $options['colClasses']); // 12/6 = 2
    }
}

