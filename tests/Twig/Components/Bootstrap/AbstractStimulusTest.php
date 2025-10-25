<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\AbstractComponent;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class AbstractStimulusTest extends TestCase
{
    private function createTestComponent(Config $config): AbstractStimulus
    {
        return new class($config) extends AbstractStimulus {
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

        self::assertInstanceOf(AbstractStimulus::class, $component);
    }

    public function testControllerPropertyExists(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);

        self::assertObjectHasProperty('controller', $component);
    }

    public function testControllerEnabledPropertyExists(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);

        self::assertObjectHasProperty('controllerEnabled', $component);
        self::assertTrue($component->controllerEnabled);
    }

    public function testApplyStimulusDefaultsWithEmptyDefaults(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);
        $component->controller = 'original-controller';

        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('applyStimulusDefaults');
        $method->setAccessible(true);
        $method->invoke($component, []);

        self::assertSame('original-controller', $component->controller);
    }

    public function testApplyStimulusDefaultsWithController(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);

        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('applyStimulusDefaults');
        $method->setAccessible(true);
        $method->invoke($component, [
            'controller' => 'custom-controller',
        ]);

        self::assertSame('custom-controller', $component->controller);
    }

    public function testApplyStimulusDefaultsIgnoresEmptyController(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);
        $component->controller = 'original-controller';

        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('applyStimulusDefaults');
        $method->setAccessible(true);
        $method->invoke($component, [
            'controller' => '',
        ]);

        self::assertSame('original-controller', $component->controller);
    }

    public function testApplyStimulusDefaultsIgnoresNullController(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);
        $component->controller = 'original-controller';

        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('applyStimulusDefaults');
        $method->setAccessible(true);
        $method->invoke($component, [
            'controller' => null,
        ]);

        self::assertSame('original-controller', $component->controller);
    }

    public function testApplyStimulusDefaultsWithControllerEnabled(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);

        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('applyStimulusDefaults');
        $method->setAccessible(true);
        $method->invoke($component, [
            'controller_enabled' => false,
        ]);

        self::assertFalse($component->controllerEnabled);
    }

    public function testExtendsAbstractComponent(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);

        self::assertInstanceOf(
            AbstractComponent::class,
            $component
        );
    }

    public function testInitializeControllerSetsDefault(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);

        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('initializeController');
        $method->setAccessible(true);
        $method->invoke($component);

        self::assertSame('bs-test_component', $component->controller);
    }

    public function testInitializeControllerPreservesExplicitValue(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);
        $component->controller = 'custom-controller';

        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('initializeController');
        $method->setAccessible(true);
        $method->invoke($component);

        self::assertSame('custom-controller', $component->controller);
    }

    public function testGetDefaultControllerReturnsExpectedFormat(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);

        $reflection = new ReflectionClass($component);
        $method = $reflection->getMethod('getDefaultController');
        $method->setAccessible(true);
        $result = $method->invoke($component);

        self::assertSame('bs-test_component', $result);
    }
}

