<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class ThemeSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::REQUEST => 'onRequest'];
    }

    public function onRequest(RequestEvent $event): void
    {
        $req = $event->getRequest();
        $cookie = $req->cookies->get('theme');
        $theme = null;
        if ($cookie === 'dark' || $cookie === 'light') {
            $theme = $cookie;
        }
        $req->attributes->set('theme', $theme);
    }
}
