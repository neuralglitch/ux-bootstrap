<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\FeatureGrid;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class FeatureGridTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'feature-grid' => [
                'columns' => 3,
                'gap' => '4',
                'container' => 'container',
                'variant' => 'default',
                'align' => 'start',
                'centered' => false,
                'heading_tag' => 'h2',
                'heading_align' => 'center',
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new FeatureGrid($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertSame(3, $options['columns']);
        $this->assertSame('4', $options['gap']);
        $this->assertSame('container', $options['container']);
        $this->assertSame('default', $options['variant']);
        $this->assertSame('start', $options['align']);
        $this->assertFalse($options['centered']);
        $this->assertStringContainsString('py-5', $options['classes']);
    }

    public function testColumnsOption(): void
    {
        $component = new FeatureGrid($this->config);
        $component->columns = 4;
        $component->mount();
        $options = $component->options();

        $this->assertSame(4, $options['columns']);
        $this->assertStringContainsString('col-md-6 col-lg-3', $options['colClass']);
    }

    public function testTwoColumnsLayout(): void
    {
        $component = new FeatureGrid($this->config);
        $component->columns = 2;
        $component->mount();
        $options = $component->options();

        $this->assertSame(2, $options['columns']);
        $this->assertStringContainsString('col-md-6', $options['colClass']);
    }

    public function testSixColumnsLayout(): void
    {
        $component = new FeatureGrid($this->config);
        $component->columns = 6;
        $component->mount();
        $options = $component->options();

        $this->assertSame(6, $options['columns']);
        $this->assertStringContainsString('col-sm-6', $options['colClass']);
        $this->assertStringContainsString('col-md-4', $options['colClass']);
        $this->assertStringContainsString('col-lg-2', $options['colClass']);
    }

    public function testGapOption(): void
    {
        $component = new FeatureGrid($this->config);
        $component->gap = '5';
        $component->mount();
        $options = $component->options();

        $this->assertSame('5', $options['gap']);
    }

    public function testContainerOption(): void
    {
        $component = new FeatureGrid($this->config);
        $component->container = 'container-fluid';
        $component->mount();
        $options = $component->options();

        $this->assertSame('container-fluid', $options['container']);
    }

    public function testVariantOption(): void
    {
        $component = new FeatureGrid($this->config);
        $component->variant = 'icon-lg';
        $component->mount();
        $options = $component->options();

        $this->assertSame('icon-lg', $options['variant']);
    }

    public function testIconBoxVariant(): void
    {
        $component = new FeatureGrid($this->config);
        $component->variant = 'icon-box';
        $component->mount();
        $options = $component->options();

        $this->assertSame('icon-box', $options['variant']);
    }

    public function testIconColoredVariant(): void
    {
        $component = new FeatureGrid($this->config);
        $component->variant = 'icon-colored';
        $component->mount();
        $options = $component->options();

        $this->assertSame('icon-colored', $options['variant']);
    }

    public function testBorderedVariant(): void
    {
        $component = new FeatureGrid($this->config);
        $component->variant = 'bordered';
        $component->mount();
        $options = $component->options();

        $this->assertSame('bordered', $options['variant']);
    }

    public function testShadowVariant(): void
    {
        $component = new FeatureGrid($this->config);
        $component->variant = 'shadow';
        $component->mount();
        $options = $component->options();

        $this->assertSame('shadow', $options['variant']);
    }

    public function testAlignOption(): void
    {
        $component = new FeatureGrid($this->config);
        $component->align = 'center';
        $component->mount();
        $options = $component->options();

        $this->assertSame('center', $options['align']);
    }

    public function testCenteredOption(): void
    {
        $component = new FeatureGrid($this->config);
        $component->centered = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['centered']);
    }

    public function testFeaturesArray(): void
    {
        $features = [
            [
                'icon' => '<i class="bi bi-star"></i>',
                'title' => 'Feature 1',
                'description' => 'Description 1',
                'variant' => 'primary',
            ],
            [
                'icon' => '<i class="bi bi-heart"></i>',
                'title' => 'Feature 2',
                'description' => 'Description 2',
                'variant' => 'success',
            ],
        ];

        $component = new FeatureGrid($this->config);
        $component->features = $features;
        $component->mount();
        $options = $component->options();

        $this->assertCount(2, $options['features']);
        $this->assertSame('Feature 1', $options['features'][0]['title']);
        $this->assertSame('primary', $options['features'][0]['variant']);
    }

    public function testHeadingOption(): void
    {
        $component = new FeatureGrid($this->config);
        $component->heading = 'Our Features';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Our Features', $options['heading']);
    }

    public function testSubheadingOption(): void
    {
        $component = new FeatureGrid($this->config);
        $component->subheading = 'Discover what makes us special';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Discover what makes us special', $options['subheading']);
    }

    public function testHeadingTagOption(): void
    {
        $component = new FeatureGrid($this->config);
        $component->headingTag = 'h3';
        $component->mount();
        $options = $component->options();

        $this->assertSame('h3', $options['headingTag']);
    }

    public function testHeadingAlignOption(): void
    {
        $component = new FeatureGrid($this->config);
        $component->headingAlign = 'start';
        $component->mount();
        $options = $component->options();

        $this->assertSame('start', $options['headingAlign']);
    }

    public function testCustomClasses(): void
    {
        $component = new FeatureGrid($this->config);
        $component->class = 'custom-class another-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-class', $options['classes']);
        $this->assertStringContainsString('another-class', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new FeatureGrid($this->config);
        $component->attr = [
            'data-test' => 'value',
            'id' => 'feature-grid-1',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('value', $options['attrs']['data-test']);
        $this->assertArrayHasKey('id', $options['attrs']);
        $this->assertSame('feature-grid-1', $options['attrs']['id']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'feature-grid' => [
                'columns' => 4,
                'gap' => '5',
                'variant' => 'icon-box',
                'centered' => true,
                'class' => 'default-class',
                'attr' => ['data-default' => 'yes'],
            ],
        ]);

        $component = new FeatureGrid($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame(4, $options['columns']);
        $this->assertSame('5', $options['gap']);
        $this->assertSame('icon-box', $options['variant']);
        $this->assertTrue($options['centered']);
        $this->assertStringContainsString('default-class', $options['classes']);
        $this->assertArrayHasKey('data-default', $options['attrs']);
    }

    public function testCombinedOptions(): void
    {
        $component = new FeatureGrid($this->config);
        $component->columns = 4;
        $component->gap = '5';
        $component->variant = 'icon-box';
        $component->centered = true;
        $component->heading = 'Features';
        $component->features = [
            [
                'icon' => '<i class="bi bi-check"></i>',
                'title' => 'Feature',
                'description' => 'Description',
            ],
        ];
        $component->mount();
        $options = $component->options();

        $this->assertSame(4, $options['columns']);
        $this->assertSame('5', $options['gap']);
        $this->assertSame('icon-box', $options['variant']);
        $this->assertTrue($options['centered']);
        $this->assertSame('Features', $options['heading']);
        $this->assertCount(1, $options['features']);
    }

    public function testGetComponentName(): void
    {
        $component = new FeatureGrid($this->config);
        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('feature-grid', $method->invoke($component));
    }

    public function testFeatureWithLink(): void
    {
        $features = [
            [
                'icon' => '<i class="bi bi-star"></i>',
                'title' => 'Feature 1',
                'description' => 'Description 1',
                'link' => '/learn-more',
                'linkText' => 'Learn more',
            ],
        ];

        $component = new FeatureGrid($this->config);
        $component->features = $features;
        $component->mount();
        $options = $component->options();

        $this->assertSame('/learn-more', $options['features'][0]['link']);
        $this->assertSame('Learn more', $options['features'][0]['linkText']);
    }
}

