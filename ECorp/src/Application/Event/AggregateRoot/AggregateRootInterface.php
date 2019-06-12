<?php

namespace ECorp\Application\Event\AggregateRoot;

use ECorp\DomainModel\Uuid;

interface AggregateRootInterface
{
    /**
     * @return Uuid
     */
    public function getAggregateRootUuid(): Uuid;

    /**
     * @return object[]
     */
    public function releaseEvents(): array;

    /**
     * Consider using generators!
     *
     * @param Uuid $aggregateRootUuid
     * @param array $events
     * @return AggregateRootInterface
     */
    public function reconstituteFromEvents(Uuid $aggregateRootUuid, array $events): AggregateRootInterface;
}
