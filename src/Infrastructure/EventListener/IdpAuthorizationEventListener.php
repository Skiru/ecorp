<?php

declare(strict_types=1);

namespace ECorp\Infrastructure\EventListener;

use FOS\OAuthServerBundle\Event\OAuthEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class IdpAuthorizationEventListener
{
    public function onPreAuthorizationProcess(OAuthEvent $event)
    {
        $user = $this->getUser($event);
    }

    protected function getUser(OAuthEvent $event): UserInterface
    {
        return $event->getUser();
    }
}