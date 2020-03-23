<?php

declare(strict_types=1);

namespace ECorp\Infrastructure\Persistence\Doctrine\Dbal;

use ECorp\Application\Query\Client\ClientQueryInterface;
use ECorp\Application\Query\Client\ClientView;
use ECorp\DomainModel\Uuid;
use ECorp\Infrastructure\Persistence\Doctrine\AbstractQuery;

class DbalClientQuery extends AbstractQuery implements ClientQueryInterface
{
    public function getAll(): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select('*')
            ->from('client');

        $clients = $this->connection->fetchAll($queryBuilder->getSQL(), $queryBuilder->getParameters());

        if (empty($clients)) {
            return [];
        }

        return array_map(fn($client) => new ClientView(
            new Uuid($client['uuid']),
            $client['scopes'],
            sprintf('%s_%s', $client['id'], $client['random_id']),
            $client['secret'],
            unserialize($client['redirect_uris']),
            unserialize($client['allowed_grant_types']),
            $client['name']
        ), $clients);
    }
}
