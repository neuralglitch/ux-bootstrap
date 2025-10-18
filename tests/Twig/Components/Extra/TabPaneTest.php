<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\TabPane;
use PHPUnit\Framework\TestCase;

final class TabPaneTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'tab_pane' => [
                'active' => false,
                'fade' => true,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new TabPane($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('tab-pane', $options['classes']);
        $this->assertStringContainsString('fade', $options['classes']);
        $this->assertStringNotContainsString('show', $options['classes']);
        $this->assertStringNotContainsString('active', $options['classes']);
    }

    public function testActivePane(): void
    {
        $component = new TabPane($this->config);
        $component->active = true;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('active', $options['classes']);
        $this->assertStringContainsString('show', $options['classes']);
    }

    public function testWithoutFade(): void
    {
        $component = new TabPane($this->config);
        $component->fade = false;
        $component->mount();
        $options = $component->options();

        $this->assertStringNotContainsString('fade', $options['classes']);
    }

    public function testActiveWithoutFade(): void
    {
        $component = new TabPane($this->config);
        $component->active = true;
        $component->fade = false;
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('active', $options['classes']);
        $this->assertStringNotContainsString('fade', $options['classes']);
        $this->assertStringContainsString('show', $options['classes']);
    }

    public function testCustomId(): void
    {
        $component = new TabPane($this->config);
        $component->id = 'custom-pane';
        $component->mount();
        $options = $component->options();

        $this->assertSame('custom-pane', $options['id']);
    }

    public function testAutoGenerateIdFromTitle(): void
    {
        $component = new TabPane($this->config);
        $component->title = 'Profile Settings';
        $component->mount();
        $options = $component->options();

        $this->assertSame('tab-profile-settings', $options['id']);
    }

    public function testCustomLabelledBy(): void
    {
        $component = new TabPane($this->config);
        $component->labelledBy = 'my-tab';
        $component->mount();
        $options = $component->options();

        $this->assertSame('my-tab', $options['attrs']['aria-labelledby']);
    }

    public function testAutoGenerateLabelledBy(): void
    {
        $component = new TabPane($this->config);
        $component->id = 'profile';
        $component->mount();
        $options = $component->options();

        $this->assertSame('profile-tab', $options['attrs']['aria-labelledby']);
    }

    public function testAriaRole(): void
    {
        $component = new TabPane($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('tabpanel', $options['attrs']['role']);
    }

    public function testCustomClasses(): void
    {
        $component = new TabPane($this->config);
        $component->class = 'custom-class another-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('tab-pane', $options['classes']);
        $this->assertStringContainsString('custom-class', $options['classes']);
        $this->assertStringContainsString('another-class', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new TabPane($this->config);
        $component->attr = [
            'data-test' => 'value',
            'data-controller' => 'my-controller',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('value', $options['attrs']['data-test']);
        $this->assertArrayHasKey('data-controller', $options['attrs']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'tab_pane' => [
                'active' => false,
                'fade' => false,
                'class' => 'default-class',
                'attr' => [],
            ],
        ]);

        $component = new TabPane($config);
        $component->mount();
        $options = $component->options();

        $this->assertFalse($component->fade);
        $this->assertStringNotContainsString('fade', $options['classes']);
        $this->assertStringContainsString('default-class', $options['classes']);
    }

    public function testTitleIsPassedToOptions(): void
    {
        $component = new TabPane($this->config);
        $component->title = 'Settings';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Settings', $options['title']);
    }

    public function testGetComponentName(): void
    {
        $component = new TabPane($this->config);
        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('tab_pane', $method->invoke($component));
    }

    public function testIdGenerationWithSpecialCharacters(): void
    {
        $component = new TabPane($this->config);
        $component->title = 'User & Profile Settings!';
        $component->mount();
        $options = $component->options();

        $this->assertSame('tab-user-profile-settings-', $options['id']);
    }

    public function testConfigEnablesActive(): void
    {
        $config = new Config([
            'tab_pane' => [
                'active' => true,
                'fade' => true,
            ],
        ]);

        $component = new TabPane($config);
        // Don't set active - let config default apply
        $component->mount();
        $options = $component->options();

        // Config can enable active via || operator
        $this->assertTrue($component->active);
        $this->assertStringContainsString('active', $options['classes']);
    }

    public function testConfigDisablesFade(): void
    {
        $config = new Config([
            'tab_pane' => [
                'active' => false,
                'fade' => false,
            ],
        ]);

        $component = new TabPane($config);
        // Component tries to enable fade, but config disables it
        $component->fade = true;
        $component->mount();
        $options = $component->options();

        // Config can disable fade via && operator
        $this->assertFalse($component->fade);
        $this->assertStringNotContainsString('fade', $options['classes']);
    }
}

