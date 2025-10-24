<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Tests\EventSubscriber;

use NeuralGlitch\UxBootstrap\EventSubscriber\ThemeSubscriber;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;

final class ThemeSubscriberTest extends TestCase
{
    private function createRequestEvent(Request $request): RequestEvent
    {
        $kernel = $this->createMock(HttpKernelInterface::class);

        return new RequestEvent(
            $kernel,
            $request,
            HttpKernelInterface::MAIN_REQUEST
        );
    }

    public function testGetSubscribedEvents(): void
    {
        $events = ThemeSubscriber::getSubscribedEvents();

        self::assertIsArray($events);
        self::assertArrayHasKey(KernelEvents::REQUEST, $events);
        self::assertSame('onRequest', $events[KernelEvents::REQUEST]);
    }

    public function testOnRequestWithDarkThemeCookie(): void
    {
        $request = Request::create('/');
        $request->cookies->set('theme', 'dark');

        $subscriber = new ThemeSubscriber();
        $event = $this->createRequestEvent($request);

        $subscriber->onRequest($event);

        self::assertTrue($request->attributes->has('theme'));
        self::assertSame('dark', $request->attributes->get('theme'));
        self::assertSame('dark', $request->attributes->get('color_scheme'));
    }

    public function testOnRequestWithLightThemeCookie(): void
    {
        $request = Request::create('/');
        $request->cookies->set('theme', 'light');

        $subscriber = new ThemeSubscriber();
        $event = $this->createRequestEvent($request);

        $subscriber->onRequest($event);

        self::assertTrue($request->attributes->has('theme'));
        self::assertSame('light', $request->attributes->get('theme'));
        self::assertSame('light', $request->attributes->get('color_scheme'));
    }

    public function testOnRequestWithInvalidThemeCookie(): void
    {
        $request = Request::create('/');
        $request->cookies->set('theme', 'invalid');

        $subscriber = new ThemeSubscriber();
        $event = $this->createRequestEvent($request);

        $subscriber->onRequest($event);

        self::assertTrue($request->attributes->has('theme'));
        self::assertSame('auto', $request->attributes->get('theme')); // Falls back to default
        self::assertSame('light dark', $request->attributes->get('color_scheme'));
    }

    public function testOnRequestWithoutThemeCookie(): void
    {
        $request = Request::create('/');

        $subscriber = new ThemeSubscriber();
        $event = $this->createRequestEvent($request);

        $subscriber->onRequest($event);

        self::assertTrue($request->attributes->has('theme'));
        self::assertSame('auto', $request->attributes->get('theme')); // Defaults to auto
        self::assertSame('light dark', $request->attributes->get('color_scheme'));
    }

    public function testOnRequestWithEmptyThemeCookie(): void
    {
        $request = Request::create('/');
        $request->cookies->set('theme', '');

        $subscriber = new ThemeSubscriber();
        $event = $this->createRequestEvent($request);

        $subscriber->onRequest($event);

        self::assertTrue($request->attributes->has('theme'));
        self::assertSame('auto', $request->attributes->get('theme')); // Falls back to default
        self::assertSame('light dark', $request->attributes->get('color_scheme'));
    }

    public function testOnRequestWithAutoThemeCookie(): void
    {
        $request = Request::create('/');
        $request->cookies->set('theme', 'auto');

        $subscriber = new ThemeSubscriber();
        $event = $this->createRequestEvent($request);

        $subscriber->onRequest($event);

        // 'auto' is now a valid theme value
        self::assertTrue($request->attributes->has('theme'));
        self::assertSame('auto', $request->attributes->get('theme'));
        self::assertSame('light dark', $request->attributes->get('color_scheme'));
    }

    public function testOnRequestDoesNotOverrideExistingAttribute(): void
    {
        $request = Request::create('/');
        $request->cookies->set('theme', 'dark');
        $request->attributes->set('theme', 'light'); // Pre-existing

        $subscriber = new ThemeSubscriber();
        $event = $this->createRequestEvent($request);

        $subscriber->onRequest($event);

        // Should override with cookie value
        self::assertSame('dark', $request->attributes->get('theme'));
    }

    public function testOnRequestWithMultipleCalls(): void
    {
        $request = Request::create('/');
        $request->cookies->set('theme', 'dark');

        $subscriber = new ThemeSubscriber();
        $event = $this->createRequestEvent($request);

        // Call multiple times
        $subscriber->onRequest($event);
        $subscriber->onRequest($event);

        // Should still work correctly
        self::assertSame('dark', $request->attributes->get('theme'));
    }

    public function testOnRequestPreservesOtherAttributes(): void
    {
        $request = Request::create('/');
        $request->cookies->set('theme', 'dark');
        $request->attributes->set('_route', 'test_route');
        $request->attributes->set('_locale', 'en');

        $subscriber = new ThemeSubscriber();
        $event = $this->createRequestEvent($request);

        $subscriber->onRequest($event);

        // Other attributes should remain unchanged
        self::assertSame('test_route', $request->attributes->get('_route'));
        self::assertSame('en', $request->attributes->get('_locale'));
        self::assertSame('dark', $request->attributes->get('theme'));
    }

    public function testOnRequestWithCaseSensitiveThemeValue(): void
    {
        $request = Request::create('/');
        $request->cookies->set('theme', 'Dark'); // Capitalized

        $subscriber = new ThemeSubscriber();
        $event = $this->createRequestEvent($request);

        $subscriber->onRequest($event);

        // Should be case-sensitive, 'Dark' is invalid, falls back to default
        self::assertSame('auto', $request->attributes->get('theme'));
        self::assertSame('light dark', $request->attributes->get('color_scheme'));
    }

    public function testOnRequestWithNumericThemeValue(): void
    {
        $request = Request::create('/');
        $request->cookies->set('theme', '1');

        $subscriber = new ThemeSubscriber();
        $event = $this->createRequestEvent($request);

        $subscriber->onRequest($event);

        // Numeric values should be invalid, falls back to default
        self::assertSame('auto', $request->attributes->get('theme'));
        self::assertSame('light dark', $request->attributes->get('color_scheme'));
    }
}

