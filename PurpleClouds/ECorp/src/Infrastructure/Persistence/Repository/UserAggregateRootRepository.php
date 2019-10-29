<?php

namespace ECorp\Infrastructure\Persistence\Repository;

use ECorp\Application\Event\AggregateRoot\AggregateRootInterface;
use ECorp\Application\Event\AggregateRoot\AggregateRootRepositoryInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

class UserAggregateRootRepository implements AggregateRootRepositoryInterface
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param AggregateRootInterface $aggregateRoot
     * @throws DBALException
     */
    public function persist(AggregateRootInterface $aggregateRoot): void
    {
        $events = $aggregateRoot->getEvents();

        foreach ($events as $event) {
            $this->connection->insert(self::USER_AGGREGATE_ROOT_TABLE_NAME, [
                'id' => $aggregateRoot->getAggregateRootUuid()->asString(),
                'event' => json_encode($event),
                'class_name' => get_class($event)
            ]);
        }

        $aggregateRoot->removeEvents();
    }
}
