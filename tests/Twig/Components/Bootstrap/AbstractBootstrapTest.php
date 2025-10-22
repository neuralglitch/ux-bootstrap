<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractBootstrap;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class AbstractBootstrapTest extends TestCase
{
    private function createTestComponent(Config $config): AbstractBootstrap
    {
        return new class($config) extends AbstractBootstrap {
            public string $testProperty = '';

            protected function getComponentName(): string
            {
                return 'test_component';
            }
        };
    }

    public function testConstructorAcceptsConfig(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);

        self::assertInstanceOf(AbstractBootstrap::class, $component);
    }

    public function testClassPropertyDefaultsToEmptyString(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);

        self::assertSame('', $component->class);
    }

    public function testAttrPropertyDefaultsToEmptyArray(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);

        self::assertSame([], $component->attr);
    }

    public function testApplyClassDefaultsWithNoConfigClass(): void
    {
        $config = new Config(['test_component' => []]);
        $component = $this->createTestComponent($config);
        $component->class = 'user-class';

        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('applyClassDefaults');
        $method->setAccessible(true);
        $method->invoke($component, []);

        self::assertSame('user-class', $component->class);
    }

    public function testApplyClassDefaultsWithConfigClass(): void
    {
        $config = new Config(['test_component' => []]);
        $component = $this->createTestComponent($config);
        $component->class = 'user-class';

        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('applyClassDefaults');
        $method->setAccessible(true);
        $method->invoke($component, ['class' => 'config-class']);

        self::assertSame('user-class config-class', $component->class);
    }

    public function testApplyClassDefaultsWithEmptyUserClass(): void
    {
        $config = new Config(['test_component' => []]);
        $component = $this->createTestComponent($config);
        $component->class = '';

        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('applyClassDefaults');
        $method->setAccessible(true);
        $method->invoke($component, ['class' => 'config-class']);

        self::assertSame('config-class', $component->class);
    }

    public function testApplyClassDefaultsWithWhitespaceClass(): void
    {
        $config = new Config(['test_component' => []]);
        $component = $this->createTestComponent($config);
        $component->class = '  ';

        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('applyClassDefaults');
        $method->setAccessible(true);
        $method->invoke($component, ['class' => 'config-class']);

        self::assertStringContainsString('config-class', $component->class);
    }

    public function testApplyClassDefaultsTrimsResult(): void
    {
        $config = new Config(['test_component' => []]);
        $component = $this->createTestComponent($config);
        $component->class = '  user-class  ';

        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('applyClassDefaults');
        $method->setAccessible(true);
        $method->invoke($component, ['class' => '  config-class  ']);

        // Should be trimmed
        self::assertStringStartsNotWith(' ', $component->class);
        self::assertStringEndsNotWith(' ', $component->class);
        self::assertStringContainsString('user-class', $component->class);
        self::assertStringContainsString('config-class', $component->class);
    }

    public function testApplyClassDefaultsIgnoresNonStringClass(): void
    {
        $config = new Config(['test_component' => []]);
        $component = $this->createTestComponent($config);
        $component->class = 'user-class';

        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('applyClassDefaults');
        $method->setAccessible(true);
        $method->invoke($component, ['class' => 123]); // Not a string

        self::assertSame('user-class', $component->class);
    }

    public function testApplyClassDefaultsIgnoresEmptyConfigClass(): void
    {
        $config = new Config(['test_component' => []]);
        $component = $this->createTestComponent($config);
        $component->class = 'user-class';

        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('applyClassDefaults');
        $method->setAccessible(true);
        $method->invoke($component, ['class' => '']);

        self::assertSame('user-class', $component->class);
    }

    public function testBuildClassesWithSingleArray(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);

        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('buildClasses');
        $method->setAccessible(true);

        $result = $method->invoke($component, ['class-a', 'class-b', 'class-c']);

        self::assertSame('class-a class-b class-c', $result);
    }

    public function testBuildClassesWithMultipleArrays(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);

        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('buildClasses');
        $method->setAccessible(true);

        $result = $method->invoke($component, ['class-a'], ['class-b'], ['class-c']);

        self::assertSame('class-a class-b class-c', $result);
    }

    public function testBuildClassesRemovesDuplicates(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);

        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('buildClasses');
        $method->setAccessible(true);

        $result = $method->invoke($component, ['class-a', 'class-b'], ['class-b', 'class-c']);

        self::assertSame('class-a class-b class-c', $result);
    }

    public function testBuildClassesFiltersEmptyStrings(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);

        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('buildClasses');
        $method->setAccessible(true);

        $result = $method->invoke($component, ['class-a', '', 'class-b', null]);

        self::assertSame('class-a class-b', $result);
    }

    public function testBuildClassesWithEmptyArrays(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);

        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('buildClasses');
        $method->setAccessible(true);

        $result = $method->invoke($component, [], [], []);

        self::assertSame('', $result);
    }

    public function testGetComponentNameIsAbstract(): void
    {
        $reflection = new ReflectionClass(AbstractBootstrap::class);
        $method = $reflection->getMethod('getComponentName');

        self::assertTrue($method->isAbstract());
    }

    public function testConfigIsAccessibleToSubclasses(): void
    {
        $config = new Config(['test_component' => ['option' => 'value']]);
        $component = $this->createTestComponent($config);

        // Access protected config property via reflection
        $reflection = new ReflectionClass($component);
        $property = $reflection->getProperty('config');
        $property->setAccessible(true);
        $configValue = $property->getValue($component);

        self::assertInstanceOf(Config::class, $configValue);
        self::assertSame(['option' => 'value'], $configValue->for('test_component'));
    }

    public function testClassPropertyCanBeSetDirectly(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);
        $component->class = 'custom-class another-class';

        self::assertSame('custom-class another-class', $component->class);
    }

    public function testAttrPropertyCanBeSetDirectly(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);
        $component->attr = ['id' => 'test', 'data-value' => '123'];

        self::assertSame(['id' => 'test', 'data-value' => '123'], $component->attr);
    }
}

