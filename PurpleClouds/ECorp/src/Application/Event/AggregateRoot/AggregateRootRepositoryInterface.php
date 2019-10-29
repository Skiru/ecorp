<?php

namespace ECorp\Application\Event\AggregateRoot;

interface AggregateRootRepositoryInterface
{
    const USER_AGGREGATE_ROOT_TABLE_NAME = 'users_aggregate_roots';

    public function persist(AggregateRootInterface $aggregateRoot): void;
}
