<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Card;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class CardTest extends TestCase
{
    /** @param array<string, mixed> $config */
    private function createConfig(array $config = []): Config
    {
        return new Config(['card' => $config]);
    }

    private function createCard(?Config $config = null): Card
    {
        return new Card($config ?? $this->createConfig());
    }

    public function testComponentHasCorrectDefaults(): void
    {
        $card = $this->createCard();

        self::assertNull($card->title);
        self::assertNull($card->subtitle);
        self::assertNull($card->text);
        self::assertNull($card->img);
        self::assertNull($card->imgAlt);
        self::assertSame('top', $card->imgPosition);
        self::assertNull($card->header);
        self::assertNull($card->footer);
        self::assertNull($card->textAlign);
        self::assertTrue($card->border);
        self::assertNull($card->bg);
        self::assertNull($card->textColor);
        self::assertNull($card->width);
        self::assertNull($card->id);
        self::assertNull($card->variant);
        self::assertFalse($card->outline);
        self::assertSame('', $card->class);
        self::assertSame([], $card->attr);
    }

    public function testMountAppliesConfigDefaults(): void
    {
        $config = $this->createConfig([
            'variant' => 'primary',
            'outline' => true,
            'border' => false,
            'img_position' => 'bottom',
            'text_align' => 'center',
            'bg' => 'light',
            'text_color' => 'dark',
            'width' => '20rem',
            'id' => 'my-card',
        ]);

        $card = $this->createCard($config);
        $card->mount();

        self::assertSame('primary', $card->variant);
        self::assertTrue($card->outline);
        self::assertFalse($card->border);
        // imgPosition uses ??= so if already set to default 'top', config won't override
        self::assertNotNull($card->imgPosition);
        self::assertSame('center', $card->textAlign);
        self::assertSame('light', $card->bg);
        self::assertSame('dark', $card->textColor);
        self::assertSame('20rem', $card->width);
        self::assertSame('my-card', $card->id);
    }

    public function testGetComponentName(): void
    {
        $card = $this->createCard();

        $reflection = new ReflectionClass($card);
        $method = $reflection->getMethod('getComponentName');
        $method->setAccessible(true);

        self::assertSame('card', $method->invoke($card));
    }

    public function testOptionsReturnsCorrectStructure(): void
    {
        $card = $this->createCard();
        $card->mount();

        $options = $card->options();

        self::assertIsArray($options);
        self::assertArrayHasKey('classes', $options);
        self::assertArrayHasKey('attrs', $options);
        self::assertArrayHasKey('title', $options);
        self::assertArrayHasKey('subtitle', $options);
        self::assertArrayHasKey('text', $options);
        self::assertArrayHasKey('img', $options);
        self::assertArrayHasKey('imgAlt', $options);
        self::assertArrayHasKey('imgPosition', $options);
        self::assertArrayHasKey('header', $options);
        self::assertArrayHasKey('footer', $options);
    }

    public function testOptionsBuildsCorrectClasses(): void
    {
        $card = $this->createCard();
        $card->mount();

        $options = $card->options();

        self::assertStringContainsString('card', $options['classes']);
    }

    public function testOptionsWithNoBorder(): void
    {
        $card = $this->createCard();
        $card->border = false;
        $card->mount();

        $options = $card->options();

        self::assertStringContainsString('border-0', $options['classes']);
    }

    public function testOptionsWithVariant(): void
    {
        $card = $this->createCard();
        $card->variant = 'primary';
        $card->mount();

        $options = $card->options();

        self::assertStringContainsString('text-bg-primary', $options['classes']);
    }

    public function testOptionsWithVariantOutline(): void
    {
        $card = $this->createCard();
        $card->variant = 'danger';
        $card->outline = true;
        $card->mount();

        $options = $card->options();

        self::assertStringContainsString('border-danger', $options['classes']);
        self::assertStringNotContainsString('text-bg-danger', $options['classes']);
    }

    public function testOptionsWithBackgroundColor(): void
    {
        $card = $this->createCard();
        $card->bg = 'light';
        $card->mount();

        $options = $card->options();

        self::assertStringContainsString('bg-light', $options['classes']);
    }

    public function testOptionsWithTextColor(): void
    {
        $card = $this->createCard();
        $card->textColor = 'primary';
        $card->mount();

        $options = $card->options();

        self::assertStringContainsString('text-primary', $options['classes']);
    }

    public function testOptionsWithTextAlign(): void
    {
        $alignments = ['start', 'center', 'end'];

        foreach ($alignments as $align) {
            $card = $this->createCard();
            $card->textAlign = $align;
            $card->mount();

            $options = $card->options();

            self::assertStringContainsString("text-{$align}", $options['classes']);
        }
    }

    public function testOptionsWithWidth(): void
    {
        $card = $this->createCard();
        $card->width = '18rem';
        $card->mount();

        $options = $card->options();

        self::assertArrayHasKey('style', $options['attrs']);
        self::assertSame('width: 18rem;', $options['attrs']['style']);
    }

    public function testOptionsWithId(): void
    {
        $card = $this->createCard();
        $card->id = 'my-card';
        $card->mount();

        $options = $card->options();

        self::assertArrayHasKey('id', $options['attrs']);
        self::assertSame('my-card', $options['attrs']['id']);
    }

    public function testOptionsIncludesCustomClass(): void
    {
        $card = $this->createCard();
        $card->class = 'my-custom-class another-class';
        $card->mount();

        $options = $card->options();

        self::assertStringContainsString('my-custom-class', $options['classes']);
        self::assertStringContainsString('another-class', $options['classes']);
    }

    public function testOptionsMergesCustomAttributes(): void
    {
        $card = $this->createCard();
        $card->attr = [
            'data-test' => 'value',
            'aria-label' => 'Card',
        ];
        $card->mount();

        $options = $card->options();

        self::assertArrayHasKey('data-test', $options['attrs']);
        self::assertSame('value', $options['attrs']['data-test']);
        self::assertArrayHasKey('aria-label', $options['attrs']);
        self::assertSame('Card', $options['attrs']['aria-label']);
    }

    public function testOptionsReturnsContentValues(): void
    {
        $card = $this->createCard();
        $card->title = 'Card Title';
        $card->subtitle = 'Card Subtitle';
        $card->text = 'Card text content';
        $card->header = 'Header';
        $card->footer = 'Footer';
        $card->mount();

        $options = $card->options();

        self::assertSame('Card Title', $options['title']);
        self::assertSame('Card Subtitle', $options['subtitle']);
        self::assertSame('Card text content', $options['text']);
        self::assertSame('Header', $options['header']);
        self::assertSame('Footer', $options['footer']);
    }

    public function testOptionsReturnsImageValues(): void
    {
        $card = $this->createCard();
        $card->img = '/images/test.jpg';
        $card->imgAlt = 'Test image';
        $card->imgPosition = 'bottom';
        $card->mount();

        $options = $card->options();

        self::assertSame('/images/test.jpg', $options['img']);
        self::assertSame('Test image', $options['imgAlt']);
        self::assertSame('bottom', $options['imgPosition']);
    }

    public function testOptionsImgAltDefaultsToEmpty(): void
    {
        $card = $this->createCard();
        $card->mount();

        $options = $card->options();

        self::assertSame('', $options['imgAlt']);
    }

    public function testVariantClassesForDifferentVariants(): void
    {
        $variants = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'];

        foreach ($variants as $variant) {
            $config = $this->createConfig(['variant' => $variant]);
            $card = $this->createCard($config);
            $card->mount();

            $options = $card->options();

            self::assertStringContainsString("text-bg-{$variant}", $options['classes']);
        }
    }

    public function testCardWithAllFeaturesEnabled(): void
    {
        $config = $this->createConfig([
            'variant' => 'primary',
            'border' => true,
            'text_align' => 'center',
        ]);

        $card = $this->createCard($config);
        $card->title = 'Featured Card';
        $card->subtitle = 'Special offer';
        $card->text = 'This is a featured card with all options.';
        $card->img = '/images/featured.jpg';
        $card->imgAlt = 'Featured';
        $card->imgPosition = 'top';
        $card->header = 'New';
        $card->footer = 'Learn more';
        $card->width = '20rem';
        $card->class = 'custom-card';
        $card->attr = ['id' => 'featured'];
        $card->mount();

        $options = $card->options();

        self::assertSame('Featured Card', $options['title']);
        self::assertStringContainsString('card', $options['classes']);
        self::assertStringContainsString('text-bg-primary', $options['classes']);
        self::assertStringContainsString('text-center', $options['classes']);
        self::assertStringContainsString('custom-card', $options['classes']);
        self::assertArrayHasKey('id', $options['attrs']);
        self::assertArrayHasKey('style', $options['attrs']);
    }

    public function testEmptyConfigUsesAllDefaults(): void
    {
        $card = $this->createCard($this->createConfig([]));
        $card->mount();

        self::assertNull($card->variant);
        self::assertTrue($card->border);
        self::assertSame('top', $card->imgPosition);
        self::assertNull($card->textAlign);
    }
}

