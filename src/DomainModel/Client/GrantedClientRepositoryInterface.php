<?php

declare(strict_types=1);

namespace ECorp\DomainModel\Client;

use ECorp\DomainModel\Uuid;

interface GrantedClientRepositoryInterface
{
    /**
     * @param Uuid $uuid
     * @return GrantedClient
     *
     * @throws GrantedClientNotFoundException
     */
    public function findById(Uuid $uuid): GrantedClient;
}