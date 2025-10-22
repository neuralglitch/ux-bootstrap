<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\Testimonial;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class TestimonialTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'testimonial' => [
                'variant' => 'single',
                'quote' => null,
                'author' => null,
                'role' => null,
                'company' => null,
                'avatar_src' => null,
                'avatar_alt' => null,
                'rating' => null,
                'container' => 'container',
                'alignment' => 'left',
                'columns' => 3,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new Testimonial($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('single', $options['variant']);
        $this->assertSame('container', $options['container']);
        $this->assertSame('left', $options['alignment']);
        $this->assertSame(3, $options['columns']);
        $this->assertStringContainsString('py-5', $options['classes']);
    }

    public function testSingleVariant(): void
    {
        $component = new Testimonial($this->config);
        $component->variant = 'single';
        $component->mount();
        $options = $component->options();

        $this->assertSame('single', $options['variant']);
    }

    public function testFeaturedVariant(): void
    {
        $component = new Testimonial($this->config);
        $component->variant = 'featured';
        $component->mount();
        $options = $component->options();

        $this->assertSame('featured', $options['variant']);
    }

    public function testGridVariant(): void
    {
        $component = new Testimonial($this->config);
        $component->variant = 'grid';
        $component->mount();
        $options = $component->options();

        $this->assertSame('grid', $options['variant']);
    }

    public function testWallVariant(): void
    {
        $component = new Testimonial($this->config);
        $component->variant = 'wall';
        $component->mount();
        $options = $component->options();

        $this->assertSame('wall', $options['variant']);
    }

    public function testMinimalVariant(): void
    {
        $component = new Testimonial($this->config);
        $component->variant = 'minimal';
        $component->mount();
        $options = $component->options();

        $this->assertSame('minimal', $options['variant']);
    }

    public function testQuoteOption(): void
    {
        $component = new Testimonial($this->config);
        $component->quote = 'This product changed my life!';
        $component->mount();
        $options = $component->options();

        $this->assertSame('This product changed my life!', $options['quote']);
    }

    public function testAuthorOption(): void
    {
        $component = new Testimonial($this->config);
        $component->author = 'Jane Doe';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Jane Doe', $options['author']);
    }

    public function testRoleAndCompany(): void
    {
        $component = new Testimonial($this->config);
        $component->role = 'CEO';
        $component->company = 'Acme Corp';
        $component->mount();
        $options = $component->options();

        $this->assertSame('CEO', $options['role']);
        $this->assertSame('Acme Corp', $options['company']);
    }

    public function testAvatarOptions(): void
    {
        $component = new Testimonial($this->config);
        $component->avatarSrc = '/images/avatar.jpg';
        $component->avatarAlt = 'John Doe';
        $component->mount();
        $options = $component->options();

        $this->assertSame('/images/avatar.jpg', $options['avatarSrc']);
        $this->assertSame('John Doe', $options['avatarAlt']);
    }

    public function testRatingOption(): void
    {
        $component = new Testimonial($this->config);
        $component->rating = 5;
        $component->mount();
        $options = $component->options();

        $this->assertSame(5, $options['rating']);
    }

    public function testAlignmentLeft(): void
    {
        $component = new Testimonial($this->config);
        $component->alignment = 'left';
        $component->mount();

        $this->assertSame('text-start', $component->getAlignmentClass());
    }

    public function testAlignmentCenter(): void
    {
        $component = new Testimonial($this->config);
        $component->alignment = 'center';
        $component->mount();

        $this->assertSame('text-center', $component->getAlignmentClass());
    }

    public function testAlignmentRight(): void
    {
        $component = new Testimonial($this->config);
        $component->alignment = 'right';
        $component->mount();

        $this->assertSame('text-end', $component->getAlignmentClass());
    }

    public function testColumnClass2Columns(): void
    {
        $component = new Testimonial($this->config);
        $component->columns = 2;
        $component->mount();

        $this->assertSame('col-md-6', $component->getColumnClass());
    }

    public function testColumnClass3Columns(): void
    {
        $component = new Testimonial($this->config);
        $component->columns = 3;
        $component->mount();

        $this->assertSame('col-md-6 col-lg-4', $component->getColumnClass());
    }

    public function testColumnClass4Columns(): void
    {
        $component = new Testimonial($this->config);
        $component->columns = 4;
        $component->mount();

        $this->assertSame('col-md-6 col-lg-3', $component->getColumnClass());
    }

    public function testCustomClasses(): void
    {
        $component = new Testimonial($this->config);
        $component->class = 'custom-testimonial bg-light';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-testimonial', $options['classes']);
        $this->assertStringContainsString('bg-light', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new Testimonial($this->config);
        $component->attr = [
            'data-test' => 'testimonial',
            'id' => 'testimonial-1',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('testimonial', $options['attrs']['data-test']);
        $this->assertArrayHasKey('id', $options['attrs']);
        $this->assertSame('testimonial-1', $options['attrs']['id']);
    }

    public function testConfigDefaults(): void
    {
        $config = new Config([
            'testimonial' => [
                'variant' => 'featured',
                'quote' => null,
                'author' => null,
                'role' => null,
                'company' => null,
                'avatar_src' => null,
                'avatar_alt' => null,
                'rating' => null,
                'container' => 'container',
                'alignment' => 'center',
                'columns' => 3,
                'class' => 'default-class',
                'attr' => [],
            ],
        ]);

        $component = new Testimonial($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('featured', $options['variant']);
        $this->assertSame('center', $options['alignment']);
        $this->assertStringContainsString('default-class', $options['classes']);
    }

    public function testRenderStars(): void
    {
        $component = new Testimonial($this->config);
        $component->mount();

        $starsHtml = $component->renderStars(5);

        $this->assertStringContainsString('text-warning', $starsHtml);
        $this->assertStringContainsString('bi-star-fill', $starsHtml);
    }

    public function testRenderStarsPartial(): void
    {
        $component = new Testimonial($this->config);
        $component->mount();

        $starsHtml = $component->renderStars(3);

        $this->assertStringContainsString('bi-star-fill', $starsHtml);
        $this->assertStringContainsString('bi-star', $starsHtml);
    }

    public function testContainerOption(): void
    {
        $component = new Testimonial($this->config);
        $component->container = 'container-fluid';
        $component->mount();
        $options = $component->options();

        $this->assertSame('container-fluid', $options['container']);
    }

    public function testGetComponentName(): void
    {
        $component = new Testimonial($this->config);
        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('testimonial', $method->invoke($component));
    }
}

