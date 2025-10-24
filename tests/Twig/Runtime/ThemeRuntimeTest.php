<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Runtime;

use NeuralGlitch\UxBootstrap\Twig\Runtime\ThemeRuntime;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class ThemeRuntimeTest extends TestCase
{
    private function createRuntime(?Request $request = null): ThemeRuntime
    {
        $requestStack = new RequestStack();
        if ($request !== null) {
            $requestStack->push($request);
        }

        return new ThemeRuntime($requestStack);
    }

    public function testGetHtmlThemeAttributesWithLightTheme(): void
    {
        $request = Request::create('/');
        $request->attributes->set('theme', 'light');
        $request->attributes->set('color_scheme', 'light');

        $runtime = $this->createRuntime($request);
        $result = $runtime->getHtmlThemeAttributes();

        self::assertSame('data-bs-theme="light" style="color-scheme: light;"', $result);
    }

    public function testGetHtmlThemeAttributesWithDarkTheme(): void
    {
        $request = Request::create('/');
        $request->attributes->set('theme', 'dark');
        $request->attributes->set('color_scheme', 'dark');

        $runtime = $this->createRuntime($request);
        $result = $runtime->getHtmlThemeAttributes();

        self::assertSame('data-bs-theme="dark" style="color-scheme: dark;"', $result);
    }

    public function testGetHtmlThemeAttributesWithAutoTheme(): void
    {
        $request = Request::create('/');
        $request->attributes->set('theme', 'auto');
        $request->attributes->set('color_scheme', 'light dark');

        $runtime = $this->createRuntime($request);
        $result = $runtime->getHtmlThemeAttributes();

        self::assertSame('data-bs-theme="auto" style="color-scheme: light dark;"', $result);
    }

    public function testGetHtmlThemeAttributesWithoutRequest(): void
    {
        $runtime = $this->createRuntime(null);
        $result = $runtime->getHtmlThemeAttributes();

        // Should fallback to auto theme
        self::assertSame('data-bs-theme="auto" style="color-scheme: light dark;"', $result);
    }

    public function testGetHtmlThemeAttributesWithMissingThemeAttribute(): void
    {
        $request = Request::create('/');
        // Don't set theme attribute - should use default

        $runtime = $this->createRuntime($request);
        $result = $runtime->getHtmlThemeAttributes();

        self::assertSame('data-bs-theme="auto" style="color-scheme: light dark;"', $result);
    }

    public function testGetHtmlThemeAttributesEscapesSpecialCharacters(): void
    {
        $request = Request::create('/');
        $request->attributes->set('theme', '<script>alert("xss")</script>');
        $request->attributes->set('color_scheme', '"><script>alert("xss")</script>');

        $runtime = $this->createRuntime($request);
        $result = $runtime->getHtmlThemeAttributes();

        // Should escape HTML special characters
        self::assertStringContainsString('&lt;script&gt;', $result);
        self::assertStringNotContainsString('<script>', $result);
        self::assertStringNotContainsString('alert("xss")', $result);
    }

    public function testGetHtmlThemeAttributesHandlesQuotes(): void
    {
        $request = Request::create('/');
        $request->attributes->set('theme', 'test"value');
        $request->attributes->set('color_scheme', "test'value");

        $runtime = $this->createRuntime($request);
        $result = $runtime->getHtmlThemeAttributes();

        // Should escape quotes
        self::assertStringContainsString('&quot;', $result);
        self::assertStringNotContainsString('test"value', $result);
    }

    public function testGetHtmlThemeAttributesWithEmptyRequest(): void
    {
        $request = Request::create('/');
        // Empty request, no attributes set

        $runtime = $this->createRuntime($request);
        $result = $runtime->getHtmlThemeAttributes();

        self::assertSame('data-bs-theme="auto" style="color-scheme: light dark;"', $result);
    }

    public function testGetHtmlThemeAttributesReturnsStringWithCorrectFormat(): void
    {
        $request = Request::create('/');
        $request->attributes->set('theme', 'light');
        $request->attributes->set('color_scheme', 'light');

        $runtime = $this->createRuntime($request);
        $result = $runtime->getHtmlThemeAttributes();

        // Verify format
        self::assertStringStartsWith('data-bs-theme="', $result);
        self::assertStringContainsString('" style="color-scheme:', $result);
        self::assertStringEndsWith(';"', $result);
    }

    public function testGetHtmlThemeAttributesIsSafeForHtmlOutput(): void
    {
        $request = Request::create('/');
        $request->attributes->set('theme', 'light');
        $request->attributes->set('color_scheme', 'light');

        $runtime = $this->createRuntime($request);
        $result = $runtime->getHtmlThemeAttributes();

        // Should be safe to output directly in HTML
        self::assertMatchesRegularExpression('/^data-bs-theme="[^"]*" style="color-scheme: [^"]*;"$/', $result);
    }

    public function testGetHtmlThemeAttributesWithNullThemeValue(): void
    {
        $request = Request::create('/');
        $request->attributes->set('theme', null);
        $request->attributes->set('color_scheme', null);

        $runtime = $this->createRuntime($request);
        $result = $runtime->getHtmlThemeAttributes();

        // Should handle null gracefully with defaults
        self::assertSame('data-bs-theme="auto" style="color-scheme: light dark;"', $result);
    }

    public function testGetHtmlThemeAttributesWithNumericThemeValue(): void
    {
        $request = Request::create('/');
        $request->attributes->set('theme', 123);
        $request->attributes->set('color_scheme', 456);

        $runtime = $this->createRuntime($request);
        $result = $runtime->getHtmlThemeAttributes();

        // Should convert to string
        self::assertSame('data-bs-theme="123" style="color-scheme: 456;"', $result);
    }

    public function testGetHtmlThemeAttributesMultipleCalls(): void
    {
        $request = Request::create('/');
        $request->attributes->set('theme', 'dark');
        $request->attributes->set('color_scheme', 'dark');

        $runtime = $this->createRuntime($request);

        // Call multiple times - should be consistent
        $result1 = $runtime->getHtmlThemeAttributes();
        $result2 = $runtime->getHtmlThemeAttributes();
        $result3 = $runtime->getHtmlThemeAttributes();

        self::assertSame($result1, $result2);
        self::assertSame($result2, $result3);
    }
}




