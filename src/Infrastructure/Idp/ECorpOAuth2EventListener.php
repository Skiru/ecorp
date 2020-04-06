<?php

declare(strict_types=1);

namespace ECorp\Infrastructure\Idp;

use DateTimeImmutable;
use ECorp\Infrastructure\Persistence\Doctrine\Dbal\GrantedClientQuery;
use ECorp\Application\Query\User\UserQueryInterface;
use ECorp\Infrastructure\Facade\UserFacade;
use ECorp\Infrastructure\Persistence\Idp\Entity\RegisteredClient;
use ECorp\Infrastructure\Persistence\Repository\RegisteredClientRepository;
use ECorp\Infrastructure\Persistence\Repository\UserDbRepository;
use FOS\OAuthServerBundle\Event\OAuthEvent;
use Ramsey\Uuid\Uuid;

class ECorpOAuth2EventListener
{
    private UserQueryInterface $userQuery;

    private GrantedClientQuery $grantedClientQuery;

    private RegisteredClientRepository $registeredClientRepository;

    private UserDbRepository $userRepository;

    public function __construct(
        UserQueryInterface $userQuery,
        GrantedClientQuery $grantedClientQuery,
        RegisteredClientRepository $registeredClientRepository,
        UserDbRepository $userRepository
    ) {
        $this->userQuery = $userQuery;
        $this->grantedClientQuery = $grantedClientQuery;
        $this->registeredClientRepository = $registeredClientRepository;
        $this->userRepository = $userRepository;
    }

    public function onPreAuthorizationProcess(OAuthEvent $event)
    {
        if ($user = $this->getUser($event)) {
            $isAuthorized = $this->grantedClientQuery->isClientAuthorized(
                $this->getUser($event),
                $event->getClient()
            );

            $event->setAuthorizedClient($isAuthorized);
        }
    }

    public function onPostAuthorizationProcess(OAuthEvent $event)
    {
        $authorizedClient = new RegisteredClient();
        if ($event->isAuthorizedClient()) {
            $this->registeredClientRepository->authorizeClient(
                $authorizedClient
                    ->setUuid(Uuid::uuid4())
                    ->setClient($event->getClient())
                    ->setUser($this->userRepository->getUser($event->getUser()->getUserUuid()))
                    ->setGrantDate(new DateTimeImmutable())
                    ->setIsGranted(true)
                    ->setIsRevoked(false)
                    ->setRevokeDate(null)
            );
        }
    }

    protected function getUser(OAuthEvent $event)
    {
        return UserFacade::toPurplecloudsUser(
            $this->userQuery->getAllByEmail($event->getUser()->getUsername())
        );
    }
}