<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\EmptyState;
use PHPUnit\Framework\TestCase;

final class EmptyStateTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'empty_state' => [
                'title' => 'No items found',
                'description' => null,
                'icon' => null,
                'icon_class' => null,
                'image_src' => null,
                'image_alt' => null,
                'cta_label' => null,
                'cta_href' => null,
                'cta_variant' => 'primary',
                'cta_size' => null,
                'secondary_cta_label' => null,
                'secondary_cta_href' => null,
                'secondary_cta_variant' => 'outline-secondary',
                'secondary_cta_size' => null,
                'variant' => null,
                'size' => null,
                'container' => 'container',
                'centered' => true,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new EmptyState($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('No items found', $options['title']);
        $this->assertNull($options['description']);
        $this->assertNull($options['icon']);
        $this->assertNull($options['imageSrc']);
        $this->assertStringContainsString('container', $options['containerClasses']);
        $this->assertStringContainsString('text-center', $options['containerClasses']);
        $this->assertStringContainsString('empty-state', $options['wrapperClasses']);
    }

    public function testCustomTitle(): void
    {
        $component = new EmptyState($this->config);
        $component->title = 'No results found';
        $component->mount();
        $options = $component->options();

        $this->assertSame('No results found', $options['title']);
    }

    public function testWithDescription(): void
    {
        $component = new EmptyState($this->config);
        $component->description = 'Try adjusting your filters or search terms.';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Try adjusting your filters or search terms.', $options['description']);
    }

    public function testWithIcon(): void
    {
        $component = new EmptyState($this->config);
        $component->icon = 'bi bi-inbox';
        $component->mount();
        $options = $component->options();

        $this->assertSame('bi bi-inbox', $options['icon']);
        $this->assertStringContainsString('empty-state-icon', $options['iconClasses']);
        $this->assertStringContainsString('text-muted', $options['iconClasses']);
    }

    public function testWithIconClass(): void
    {
        $component = new EmptyState($this->config);
        $component->icon = 'bi bi-inbox';
        $component->iconClass = 'custom-icon-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-icon-class', $options['iconClasses']);
    }

    public function testWithImage(): void
    {
        $component = new EmptyState($this->config);
        $component->imageSrc = '/images/empty-state.svg';
        $component->imageAlt = 'No items';
        $component->mount();
        $options = $component->options();

        $this->assertSame('/images/empty-state.svg', $options['imageSrc']);
        $this->assertSame('No items', $options['imageAlt']);
        $this->assertStringContainsString('empty-state-image', $options['imageClasses']);
    }

    public function testWithPrimaryCta(): void
    {
        $component = new EmptyState($this->config);
        $component->ctaLabel = 'Add Item';
        $component->ctaHref = '/items/new';
        $component->ctaVariant = 'success';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Add Item', $options['ctaLabel']);
        $this->assertSame('/items/new', $options['ctaHref']);
        $this->assertSame('success', $options['ctaVariant']);
    }

    public function testWithSecondaryCta(): void
    {
        $component = new EmptyState($this->config);
        $component->secondaryCtaLabel = 'Learn More';
        $component->secondaryCtaHref = '/docs';
        $component->secondaryCtaVariant = 'outline-info';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Learn More', $options['secondaryCtaLabel']);
        $this->assertSame('/docs', $options['secondaryCtaHref']);
        $this->assertSame('outline-info', $options['secondaryCtaVariant']);
    }

    public function testWithBothCtas(): void
    {
        $component = new EmptyState($this->config);
        $component->ctaLabel = 'Primary Action';
        $component->ctaHref = '/primary';
        $component->secondaryCtaLabel = 'Secondary Action';
        $component->secondaryCtaHref = '/secondary';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Primary Action', $options['ctaLabel']);
        $this->assertSame('Secondary Action', $options['secondaryCtaLabel']);
    }

    public function testVariantInfo(): void
    {
        $component = new EmptyState($this->config);
        $component->variant = 'info';
        $component->icon = 'bi bi-info-circle';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('empty-state-info', $options['wrapperClasses']);
        $this->assertStringContainsString('text-info', $options['iconClasses']);
    }

    public function testVariantWarning(): void
    {
        $component = new EmptyState($this->config);
        $component->variant = 'warning';
        $component->icon = 'bi bi-exclamation-triangle';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('empty-state-warning', $options['wrapperClasses']);
        $this->assertStringContainsString('text-warning', $options['iconClasses']);
    }

    public function testVariantSuccess(): void
    {
        $component = new EmptyState($this->config);
        $component->variant = 'success';
        $component->icon = 'bi bi-check-circle';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('empty-state-success', $options['wrapperClasses']);
        $this->assertStringContainsString('text-success', $options['iconClasses']);
    }

    public function testVariantDanger(): void
    {
        $component = new EmptyState($this->config);
        $component->variant = 'danger';
        $component->icon = 'bi bi-x-circle';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('empty-state-danger', $options['wrapperClasses']);
        $this->assertStringContainsString('text-danger', $options['iconClasses']);
    }

    public function testSizeSmall(): void
    {
        $component = new EmptyState($this->config);
        $component->size = 'sm';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('empty-state-sm', $options['wrapperClasses']);
        $this->assertStringContainsString('fs-1', $options['iconClasses']);
        $this->assertStringContainsString('h5', $options['titleClasses']);
        $this->assertStringContainsString('small', $options['descriptionClasses']);
    }

    public function testSizeLarge(): void
    {
        $component = new EmptyState($this->config);
        $component->size = 'lg';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('empty-state-lg', $options['wrapperClasses']);
        $this->assertStringContainsString('fs-display-1', $options['iconClasses']);
        $this->assertStringContainsString('display-5', $options['titleClasses']);
        $this->assertStringContainsString('fs-5', $options['descriptionClasses']);
    }

    public function testDefaultSize(): void
    {
        $component = new EmptyState($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('fs-2', $options['iconClasses']);
        $this->assertStringContainsString('h4', $options['titleClasses']);
    }

    public function testCustomContainer(): void
    {
        $component = new EmptyState($this->config);
        $component->container = 'container-fluid';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('container-fluid', $options['containerClasses']);
    }

    public function testNotCentered(): void
    {
        $component = new EmptyState($this->config);
        $component->centered = false;
        $component->mount();
        $options = $component->options();

        $this->assertStringNotContainsString('text-center', $options['containerClasses']);
    }

    public function testCustomClass(): void
    {
        $component = new EmptyState($this->config);
        $component->class = 'custom-empty-state my-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-empty-state', $options['wrapperClasses']);
        $this->assertStringContainsString('my-class', $options['wrapperClasses']);
    }

    public function testCustomAttributes(): void
    {
        $component = new EmptyState($this->config);
        $component->attr = [
            'data-test' => 'empty-state',
            'data-variant' => 'custom',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('empty-state', $options['attrs']['data-test']);
        $this->assertArrayHasKey('data-variant', $options['attrs']);
        $this->assertSame('custom', $options['attrs']['data-variant']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'empty_state' => [
                'title' => 'No data available',
                'description' => 'Default description',
                'variant' => 'info',
                'size' => 'lg',
                'class' => 'default-class',
                'centered' => false,
                'icon' => 'bi bi-inbox',
                'cta_label' => null,
                'cta_href' => null,
                'cta_variant' => 'primary',
                'cta_size' => null,
                'secondary_cta_label' => null,
                'secondary_cta_href' => null,
                'secondary_cta_variant' => 'outline-secondary',
                'secondary_cta_size' => null,
                'icon_class' => null,
                'image_src' => null,
                'image_alt' => null,
                'container' => 'container',
                'attr' => [],
            ],
        ]);

        $component = new EmptyState($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('No data available', $options['title']);
        $this->assertSame('Default description', $options['description']);
        $this->assertStringContainsString('empty-state-info', $options['wrapperClasses']);
        $this->assertStringContainsString('empty-state-lg', $options['wrapperClasses']);
        $this->assertStringContainsString('default-class', $options['wrapperClasses']);
        $this->assertStringNotContainsString('text-center', $options['containerClasses']);
    }

    public function testGetComponentName(): void
    {
        $component = new EmptyState($this->config);
        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('empty_state', $method->invoke($component));
    }

    public function testCompleteExample(): void
    {
        $component = new EmptyState($this->config);
        $component->title = 'No search results';
        $component->description = 'We couldn\'t find any results matching your search criteria. Try adjusting your filters.';
        $component->icon = 'bi bi-search';
        $component->variant = 'info';
        $component->size = 'lg';
        $component->ctaLabel = 'Clear Filters';
        $component->ctaHref = '/search?reset=1';
        $component->ctaVariant = 'primary';
        $component->secondaryCtaLabel = 'Browse All';
        $component->secondaryCtaHref = '/browse';
        $component->mount();
        $options = $component->options();

        $this->assertSame('No search results', $options['title']);
        $this->assertStringContainsString('We couldn\'t find any results', $options['description']);
        $this->assertSame('bi bi-search', $options['icon']);
        $this->assertStringContainsString('empty-state-info', $options['wrapperClasses']);
        $this->assertStringContainsString('empty-state-lg', $options['wrapperClasses']);
        $this->assertSame('Clear Filters', $options['ctaLabel']);
        $this->assertSame('Browse All', $options['secondaryCtaLabel']);
    }
}

