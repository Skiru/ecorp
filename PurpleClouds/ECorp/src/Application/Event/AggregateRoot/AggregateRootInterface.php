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
    public function getEvents(): array;

    /**
     * Removes registered events from aggregate root
     */
    public function removeEvents(): void;

    /**
     * Consider using generators!
     *
     * @param Uuid $aggregateRootUuid
     * @param array $events
     * @return AggregateRootInterface
     */
    public function reconstituteFromEvents(Uuid $aggregateRootUuid, array $events): AggregateRootInterface;
}
