<?php

declare(strict_types=1);

namespace ECorp\Infrastructure\Persistence\Doctrine\Dbal;

use ECorp\Infrastructure\Persistence\Doctrine\AbstractQuery;
use FOS\OAuthServerBundle\Model\ClientInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class GrantedClientQuery extends AbstractQuery
{
    public function isClientAuthorized(UserInterface $user, ClientInterface $client)
    {
        $qb = $this->connection->createQueryBuilder();
        $qb
            ->select('*')
            ->from('registered_clients', 'rc')
            ->where('rc.client_id = :clientId')
            ->andWhere('rc.user_id = :userId')
            ->andWhere('rc.is_granted = :isGranted')
            ->setParameters([
                'clientId' => $client->getId(),
                'userId' => $user->getInternalId(),
                'isGranted' => true
            ])
            ->setMaxResults(1);

        $grantedApplications = $this->connection->fetchColumn($qb->getSQL(), $qb->getParameters());
        if (!$grantedApplications) return false;

        return true;
    }
}