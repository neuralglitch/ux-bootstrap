<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Extra;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\CodeBlock;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class CodeBlockTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'code-block' => [
                'language' => null,
                'code' => null,
                'title' => null,
                'filename' => null,
                'line_numbers' => false,
                'copy_button' => true,
                'highlight_lines' => null,
                'theme' => null,
                'max_height' => 0,
                'wrap_lines' => false,
                'class' => null,
                'attr' => [],
            ],
        ]);
    }

    public function testDefaultOptions(): void
    {
        $component = new CodeBlock($this->config);
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('code-block', $options['classes']);
        $this->assertStringContainsString('code-block-pre', $options['preClasses']);
        $this->assertStringContainsString('code-block-code', $options['codeClasses']);
        $this->assertTrue($options['copyButton']);
        $this->assertFalse($options['lineNumbers']);
        $this->assertFalse($options['wrapLines']);
        $this->assertNull($options['language']);
        $this->assertNull($options['title']);
        $this->assertNull($options['filename']);
    }

    public function testLanguageOption(): void
    {
        $component = new CodeBlock($this->config);
        $component->language = 'php';
        $component->mount();
        $options = $component->options();

        $this->assertSame('php', $options['language']);
        $this->assertStringContainsString('language-php', $options['codeClasses']);
    }

    public function testTitleOption(): void
    {
        $component = new CodeBlock($this->config);
        $component->title = 'Example Code';
        $component->mount();
        $options = $component->options();

        $this->assertSame('Example Code', $options['title']);
    }

    public function testFilenameOption(): void
    {
        $component = new CodeBlock($this->config);
        $component->filename = 'index.php';
        $component->mount();
        $options = $component->options();

        $this->assertSame('index.php', $options['filename']);
    }

    public function testLineNumbersOption(): void
    {
        $component = new CodeBlock($this->config);
        $component->lineNumbers = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['lineNumbers']);
        $this->assertStringContainsString('code-block-line-numbers', $options['classes']);
    }

    public function testCopyButtonOption(): void
    {
        $component = new CodeBlock($this->config);
        $component->copyButton = false;
        $component->mount();
        $options = $component->options();

        $this->assertFalse($options['copyButton']);
    }

    public function testHighlightLinesOption(): void
    {
        $component = new CodeBlock($this->config);
        $component->highlightLines = '1,3-5,8';
        $component->mount();
        $options = $component->options();

        $this->assertSame('1,3-5,8', $options['highlightLines']);
    }

    public function testThemeLightOption(): void
    {
        $component = new CodeBlock($this->config);
        $component->theme = 'light';
        $component->mount();
        $options = $component->options();

        $this->assertSame('light', $options['theme']);
        $this->assertStringContainsString('code-block-light', $options['classes']);
    }

    public function testThemeDarkOption(): void
    {
        $component = new CodeBlock($this->config);
        $component->theme = 'dark';
        $component->mount();
        $options = $component->options();

        $this->assertSame('dark', $options['theme']);
        $this->assertStringContainsString('code-block-dark', $options['classes']);
    }

    public function testMaxHeightOption(): void
    {
        $component = new CodeBlock($this->config);
        $component->maxHeight = 400;
        $component->mount();
        $options = $component->options();

        $this->assertSame(400, $options['maxHeight']);
        $this->assertStringContainsString('code-block-scrollable', $options['preClasses']);
        $this->assertStringContainsString('max-height: 400px', $options['preStyles']);
    }

    public function testMaxHeightZeroNoScroll(): void
    {
        $component = new CodeBlock($this->config);
        $component->maxHeight = 0;
        $component->mount();
        $options = $component->options();

        $this->assertSame(0, $options['maxHeight']);
        $this->assertStringNotContainsString('code-block-scrollable', $options['preClasses']);
        $this->assertNull($options['preStyles']);
    }

    public function testWrapLinesOption(): void
    {
        $component = new CodeBlock($this->config);
        $component->wrapLines = true;
        $component->mount();
        $options = $component->options();

        $this->assertTrue($options['wrapLines']);
        $this->assertStringContainsString('code-block-wrap', $options['classes']);
    }

    public function testCodePropOption(): void
    {
        $component = new CodeBlock($this->config);
        $component->code = 'echo "Hello World";';
        $component->mount();
        $options = $component->options();

        $this->assertSame('echo "Hello World";', $options['code']);
    }

    public function testCombinedOptions(): void
    {
        $component = new CodeBlock($this->config);
        $component->language = 'javascript';
        $component->title = 'ES6 Example';
        $component->lineNumbers = true;
        $component->theme = 'dark';
        $component->maxHeight = 300;
        $component->mount();
        $options = $component->options();

        $this->assertSame('javascript', $options['language']);
        $this->assertSame('ES6 Example', $options['title']);
        $this->assertTrue($options['lineNumbers']);
        $this->assertSame('dark', $options['theme']);
        $this->assertSame(300, $options['maxHeight']);
        $this->assertStringContainsString('code-block-line-numbers', $options['classes']);
        $this->assertStringContainsString('code-block-dark', $options['classes']);
        $this->assertStringContainsString('code-block-scrollable', $options['preClasses']);
        $this->assertStringContainsString('language-javascript', $options['codeClasses']);
    }

    public function testCustomClasses(): void
    {
        $component = new CodeBlock($this->config);
        $component->class = 'custom-class another-class';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('custom-class', $options['classes']);
        $this->assertStringContainsString('another-class', $options['classes']);
    }

    public function testCustomAttributes(): void
    {
        $component = new CodeBlock($this->config);
        $component->attr = [
            'data-test' => 'value',
            'id' => 'my-code-block',
        ];
        $component->mount();
        $options = $component->options();

        $this->assertArrayHasKey('data-test', $options['attrs']);
        $this->assertSame('value', $options['attrs']['data-test']);
        $this->assertArrayHasKey('id', $options['attrs']);
        $this->assertSame('my-code-block', $options['attrs']['id']);
    }

    public function testConfigDefaultsApplied(): void
    {
        $config = new Config([
            'code-block' => [
                'language' => 'php',
                'line_numbers' => true,
                'theme' => 'dark',
                'copy_button' => false,
                'class' => 'default-class',
            ],
        ]);

        $component = new CodeBlock($config);
        $component->mount();
        $options = $component->options();

        $this->assertSame('php', $component->language);
        $this->assertTrue($component->lineNumbers);
        $this->assertSame('dark', $component->theme);
        $this->assertFalse($component->copyButton);
        $this->assertStringContainsString('default-class', $options['classes']);
    }

    public function testGetComponentName(): void
    {
        $component = new CodeBlock($this->config);
        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('getComponentName');

        $this->assertSame('code-block', $method->invoke($component));
    }

    public function testNullValuesHandled(): void
    {
        $component = new CodeBlock($this->config);
        $component->language = null;
        $component->title = null;
        $component->filename = null;
        $component->code = null;
        $component->mount();
        $options = $component->options();

        $this->assertNull($options['language']);
        $this->assertNull($options['title']);
        $this->assertNull($options['filename']);
        $this->assertNull($options['code']);
    }

    public function testEmptyClassHandled(): void
    {
        $component = new CodeBlock($this->config);
        $component->class = '';
        $component->mount();
        $options = $component->options();

        $this->assertStringContainsString('code-block', $options['classes']);
        $this->assertStringNotContainsString('  ', $options['classes']); // No double spaces
    }
}

