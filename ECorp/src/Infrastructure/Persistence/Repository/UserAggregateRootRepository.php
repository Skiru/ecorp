<?php

namespace ECorp\Infrastructure\Persistence\Repository;

use ECorp\Application\Event\AggregateRoot\AggregateRootInterface;
use ECorp\Application\Event\AggregateRoot\AggregateRootRepositoryInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Symfony\Component\Serializer\SerializerInterface;

class UserAggregateRootRepository implements AggregateRootRepositoryInterface
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * UserAggregateRootRepository constructor.
     * @param Connection $connection
     * @param SerializerInterface $serializer
     */
    public function __construct(Connection $connection, SerializerInterface $serializer)
    {
        $this->connection = $connection;
        $this->serializer = $serializer;
    }

    /**
     * @param AggregateRootInterface $aggregateRoot
     * @throws DBALException
     */
    public function persist(AggregateRootInterface $aggregateRoot): void
    {
        $events = $aggregateRoot->releaseEvents();

        foreach ($events as $event) {
//          $serializedEvent = $this->serializer->serialize($event, 'json'); PSUJE SIE COS TEN SERIALIZER SYMFONOWY, NIE MIALEM CZASU ZEBY SIE Z NIM BAWIC :(

            $this->connection->insert(self::USER_AGGREGATE_ROOT_TABLE_NAME, [
                'id' => $aggregateRoot->getAggregateRootUuid()->getString(),
                'event' => json_encode($event),
                'class_name' => get_class($event)
            ]);
        }
    }
}
