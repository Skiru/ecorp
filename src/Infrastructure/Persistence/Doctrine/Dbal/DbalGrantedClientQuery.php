<?php

declare(strict_types=1);

namespace ECorp\Infrastructure\Persistence\Doctrine\Dbal;

use ECorp\Application\Client\Query\GrantedClientQueryInterface;
use ECorp\Application\Client\Query\GrantedClientView;
use ECorp\Infrastructure\Persistence\Doctrine\AbstractQuery;

class DbalGrantedClientQuery extends AbstractQuery implements GrantedClientQueryInterface
{
    public function getAll(): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select('*')
            ->from('registered_clients');

        $clients = $this->connection->fetchAll($queryBuilder->getSQL(), $queryBuilder->getParameters());

        if (empty($clients)) {
            return [];
        }

        return array_map(
            fn($client) => GrantedClientView::fromArray($client),
            $clients
        );
    }
}