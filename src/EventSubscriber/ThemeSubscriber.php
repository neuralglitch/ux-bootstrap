<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class ThemeSubscriber implements EventSubscriberInterface
{
    private const DEFAULT_THEME = 'auto'; // or 'light' if you prefer

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::REQUEST => 'onRequest'];
    }

    public function onRequest(RequestEvent $event): void
    {
        $req = $event->getRequest();
        $cookie = $req->cookies->get('theme');
        
        // Default to 'auto' if no valid theme cookie is set
        $theme = self::DEFAULT_THEME;
        
        if ($cookie === 'dark' || $cookie === 'light' || $cookie === 'auto') {
            $theme = $cookie;
        }
        
        $req->attributes->set('theme', $theme);
        $req->attributes->set('color_scheme', $theme === 'auto' ? 'light dark' : $theme);
    }
}
