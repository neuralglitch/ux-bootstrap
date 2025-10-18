<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\Skeleton;
use PHPUnit\Framework\TestCase;

final class SkeletonTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'skeleton' => [
                'type' => 'text',
                'lines' => 3,
                'width' => null,
                'height' => null,
                'animation' => 'wave',
                'size' => null,
                'avatar_shape' => 'circle',
                'with_avatar' => false,
                'with_button' => false,
                'with_image' => false,
                'rounded' => null,
                'tag' => 'div',
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new Skeleton($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('text', $options['type']);
        $this->assertSame(3, $options['lines']);
        $this->assertSame('wave', $options['animation']);
        $this->assertStringContainsString('placeholder-wave', $options['classes']);
    }

    public function testTextType(): void
    {
        $component = new Skeleton($this->config);
        $component->type = 'text';
        $component->lines = 5;
        $component->mount();
        $options = $component->options();

        $this->assertSame('text', $options['type']);
        $this->assertSame(5, $options['lines']);
        $this->assertArrayHasKey('lines', $options['structure']);
        $this->assertCount(5, $options['structure']['lines']);
    }

    public function testHeadingType(): void
    {
        $component = new Skeleton($this->config);
        $component->type = 'heading';
        $component->mount();
        $options = $component->options();

        $this->assertSame('heading', $options['type']);
        $this->assertArrayHasKey('classes', $options['structure']);
        $this->assertStringContainsString('placeholder-lg', $options['structure']['classes']);
    }

    public function testAvatarType(): void
    {
        $component = new Skeleton($this->config);
        $component->type = 'avatar';
        $component->size = 'lg';
        $component->avatarShape = 'square';
        $component->mount();
        $options = $component->options();

        $this->assertSame('avatar', $options['type']);
        $this->assertSame('lg', $options['size']);
        $this->assertSame('square', $options['avatarShape']);
        $this->assertSame('64px', $options['structure']['size']);
        $this->assertSame('rounded-0', $options['structure']['shape']);
    }

    public function testAvatarCircleShape(): void
    {
        $component = new Skeleton($this->config);
        $component->type = 'avatar';
        $component->avatarShape = 'circle';
        $component->mount();
        $options = $component->options();

        $this->assertSame('rounded-circle', $options['structure']['shape']);
    }

    public function testAvatarRoundedShape(): void
    {
        $component = new Skeleton($this->config);
        $component->type = 'avatar';
        $component->avatarShape = 'rounded';
        $component->mount();
        $options = $component->options();

        $this->assertSame('rounded', $options['structure']['shape']);
    }

    public function testAvatarSizes(): void
    {
        $sizes = [
            'sm' => '32px',
            'md' => '48px',
            'lg' => '64px',
            'xl' => '96px',
        ];

        foreach ($sizes as $size => $expected) {
            $component = new Skeleton($this->config);
            $component->type = 'avatar';
            $component->size = $size;
            $component->mount();
            $options = $component->options();

            $this->assertSame($expected, $options['structure']['size']);
        }
    }

    public function testCardType(): void
    {
        $component = new Skeleton($this->config);
        $component->type = 'card';
        $component->withImage = true;
        $component->withAvatar = true;
        $component->withButton = true;
        $component->mount();
        $options = $component->options();

        $this->assertSame('card', $options['type']);
        $this->assertTrue($options['withImage']);
        $this->assertTrue($options['withAvatar']);
        $this->assertTrue($options['withButton']);
        $this->assertArrayHasKey('title', $options['structure']);
        $this->assertArrayHasKey('text', $options['structure']);
    }

    public function testListType(): void
    {
        $component = new Skeleton($this->config);
        $component->type = 'list';
        $component->lines = 4;
        $component->withAvatar = true;
        $component->mount();
        $options = $component->options();

        $this->assertSame('list', $options['type']);
        $this->assertSame(4, $options['lines']);
        $this->assertTrue($options['withAvatar']);
        $this->assertArrayHasKey('items', $options['structure']);
        $this->assertCount(4, $options['structure']['items']);
    }

    public function testParagraphType(): void
    {
        $component = new Skeleton($this->config);
        $component->type = 'paragraph';
        $component->lines = 5;
        $component->mount();
        $options = $component->options();

        $this->assertSame('paragraph', $options['type']);
        $this->assertSame(5, $options['lines']);
        $this->assertArrayHasKey('lines', $options['structure']);
        $this->assertCount(5, $options['structure']['lines']);
    }

    public function testCustomType(): void
    {
        $component = new Skeleton($this->config);
        $component->type = 'custom';
        $component->width = '200px';
        $component->height = '100px';
        $component->mount();
        $options = $component->options();

        $this->assertSame('custom', $options['type']);
        $this->assertSame('200px', $options['width']);
        $this->assertSame('100px', $options['height']);
        $this->assertArrayHasKey('custom', $options['structure']);
    }

    public function testAnimationWave(): void
    {
        $component = new Skeleton($this->config);
        $component->animation = 'wave';
        $component->mount();
        $options = $component->options();

        $this->assertSame('wave', $options['animation']);
        $this->assertStringContainsString('placeholder-wave', $options['classes']);
    }

    public function testAnimationPulse(): void
    {
        $component = new Skeleton($this->config);
        $component->animation = 'pulse';
        $component->mount();
        $options = $component->options();

        $this->assertSame('pulse', $options['animation']);
        $this->assertStringContainsString('placeholder-glow', $options['classes']);
    }

    public function testAnimationNone(): void
    {
        $component = new Skeleton($this->config);
        $component->animation = 'none';
        $component->mount();
        $options = $component->options();

        $this->assertSame('none', $options['animation']);
        $this->assertStringNotContainsString('placeholder-wave', $options['classes']);
        $this->assertStringNotContainsString('placeholder-glow', $options['classes']);
    }

    public function testCustomWidth(): void
    {
        $component = new Skeleton($this->config);
        $component->width = '75%';
        $component->mount();
        $options = $component->options();

        $this->assertSame('75%', $options['width']);
    }

    public function testCustomHeight(): void
    {
        $component = new Skeleton($this->config);
        $component->height = '50px';
        $component->mount();
        $options = $component->options();

        $this->assertSame('50px', $options['height']);
    }

    public function testRoundedOptions(): void
    {
        $roundedOptions = [
            'none' => 'rounded-0',
            'sm' => 'rounded-1',
            'default' => 'rounded',
            'lg' => 'rounded-3',
            'pill' => 'rounded-pill',
            'circle' => 'rounded-circle',
        ];

        foreach ($roundedOptions as $rounded => $expectedClass) {
            $component = new Skeleton($this->config);
            $component->rounded = $rounded;
            $component->mount();
            $options = $component->options();

            $this->assertSame($rounded, $options['rounded']);
        }
    }

    public function testCustomTag(): void
    {
        $component = new Skeleton($this->config);
        $component->tag = 'section';
        $component->mount();
        $options = $component->options();

        $this->assertSame('section', $options['tag']);
    }

    public function testCustomClasses(): void
    {
        $component = new Skeleton($this->config);
        $component->class = 'custom-skeleton my-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-skeleton', $options['classes']);
        $this->assertStringContainsString('my-class', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new Skeleton($this->config);
        $component->attr = [
            'data-test' => 'skeleton',
            'data-loading' => 'true',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('skeleton', $options['attrs']['data-test']);
        $this->assertArrayHasKey('data-loading', $options['attrs']);
        $this->assertSame('true', $options['attrs']['data-loading']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'skeleton' => [
                'type' => 'card',
                'lines' => 5,
                'animation' => 'pulse',
                'with_avatar' => true,
                'class' => 'default-skeleton-class',
                'attr' => ['data-default' => 'value'],
            ],
        ]);

        $component = new Skeleton($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('card', $options['type']);
        $this->assertSame(5, $options['lines']);
        $this->assertSame('pulse', $options['animation']);
        $this->assertTrue($options['withAvatar']);
        $this->assertStringContainsString('default-skeleton-class', $options['classes']);
    }

    public function testGetComponentName(): void
    {
        $component = new Skeleton($this->config);
        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('skeleton', $method->invoke($component));
    }

    public function testListItemsStructure(): void
    {
        $component = new Skeleton($this->config);
        $component->type = 'list';
        $component->lines = 3;
        $component->mount();
        $options = $component->options();

        foreach ($options['structure']['items'] as $item) {
            $this->assertArrayHasKey('withAvatar', $item);
            $this->assertArrayHasKey('title', $item);
            $this->assertArrayHasKey('subtitle', $item);
            $this->assertArrayHasKey('classes', $item['title']);
            $this->assertArrayHasKey('width', $item['title']);
        }
    }

    public function testCardStructureComponents(): void
    {
        $component = new Skeleton($this->config);
        $component->type = 'card';
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('withImage', $options['structure']);
        $this->assertArrayHasKey('withAvatar', $options['structure']);
        $this->assertArrayHasKey('withButton', $options['structure']);
        $this->assertArrayHasKey('title', $options['structure']);
        $this->assertArrayHasKey('text', $options['structure']);
    }

    public function testParagraphLastLineWidth(): void
    {
        $component = new Skeleton($this->config);
        $component->type = 'paragraph';
        $component->lines = 4;
        $component->mount();
        $options = $component->options();

        $lastLine = end($options['structure']['lines']);
        // Last line should have a width between 60-75%
        $this->assertStringContainsString('%', $lastLine['width']);
    }
}

