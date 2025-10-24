<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Extension;

use NeuralGlitch\UxBootstrap\Twig\Extension\ThemeExtension;
use NeuralGlitch\UxBootstrap\Twig\Runtime\ThemeRuntime;
use PHPUnit\Framework\TestCase;
use Twig\TwigFunction;

final class ThemeExtensionTest extends TestCase
{
    public function testGetFunctionsReturnsExpectedFunctions(): void
    {
        $extension = new ThemeExtension();
        $functions = $extension->getFunctions();

        self::assertIsArray($functions);
        self::assertCount(1, $functions);
        self::assertContainsOnlyInstancesOf(TwigFunction::class, $functions);
    }

    public function testUxBootstrapHtmlAttrsFunction(): void
    {
        $extension = new ThemeExtension();
        $functions = $extension->getFunctions();

        $function = $functions[0];

        self::assertSame('ux_bootstrap_html_attrs', $function->getName());

        // Check callable points to correct runtime
        $callable = $function->getCallable();
        self::assertIsArray($callable);
        self::assertSame(ThemeRuntime::class, $callable[0]);
        self::assertSame('getHtmlThemeAttributes', $callable[1]);

        // Check function is marked as safe for HTML output (using getSafe() method)
        $safeFor = $function->getSafe(new \Twig\Node\Node());
        self::assertSame(['html'], $safeFor);
    }

    public function testExtensionIsInstanceOfAbstractExtension(): void
    {
        $extension = new ThemeExtension();

        self::assertInstanceOf(\Twig\Extension\AbstractExtension::class, $extension);
    }

    public function testExtensionIsFinal(): void
    {
        $reflection = new \ReflectionClass(ThemeExtension::class);

        self::assertTrue($reflection->isFinal());
    }
}

