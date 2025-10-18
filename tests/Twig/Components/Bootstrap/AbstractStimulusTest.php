<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractStimulus;
use PHPUnit\Framework\TestCase;

final class AbstractStimulusTest extends TestCase
{
    private function createTestComponent(Config $config): AbstractStimulus
    {
        return new class($config) extends AbstractStimulus {
            public string $stimulusController = 'default-controller';
            
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

    public function testStimulusControllerPropertyExists(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);

        self::assertObjectHasProperty('stimulusController', $component);
    }

    public function testApplyStimulusDefaultsWithEmptyDefaults(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);
        $component->stimulusController = 'original-controller';

        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('applyStimulusDefaults');
        $method->setAccessible(true);
        $method->invoke($component, []);

        self::assertSame('original-controller', $component->stimulusController);
    }

    public function testApplyStimulusDefaultsWithController(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);

        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('applyStimulusDefaults');
        $method->setAccessible(true);
        $method->invoke($component, [
            'stimulus_controller' => 'custom-controller',
        ]);

        self::assertSame('custom-controller', $component->stimulusController);
    }

    public function testApplyStimulusDefaultsIgnoresEmptyController(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);
        $component->stimulusController = 'original-controller';

        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('applyStimulusDefaults');
        $method->setAccessible(true);
        $method->invoke($component, [
            'stimulus_controller' => '',
        ]);

        self::assertSame('original-controller', $component->stimulusController);
    }

    public function testApplyStimulusDefaultsIgnoresNullController(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);
        $component->stimulusController = 'original-controller';

        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('applyStimulusDefaults');
        $method->setAccessible(true);
        $method->invoke($component, [
            'stimulus_controller' => null,
        ]);

        self::assertSame('original-controller', $component->stimulusController);
    }

    public function testApplyStimulusDefaultsConvertsToString(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);

        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('applyStimulusDefaults');
        $method->setAccessible(true);
        $method->invoke($component, [
            'stimulus_controller' => 123, // Numeric value
        ]);

        self::assertSame('123', $component->stimulusController);
    }

    public function testExtendsAbstractBootstrap(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);

        self::assertInstanceOf(\NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\AbstractBootstrap::class, $component);
    }

    public function testHasStimulusTrait(): void
    {
        $config = new Config([]);
        $component = $this->createTestComponent($config);

        $reflection = new \ReflectionClass($component);
        
        // Get all traits including those from parent classes
        $allTraits = [];
        $class = $reflection;
        while ($class) {
            $allTraits = array_merge($allTraits, $class->getTraitNames());
            $class = $class->getParentClass();
        }

        self::assertContains('NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits\StimulusTrait', $allTraits);
    }
}

