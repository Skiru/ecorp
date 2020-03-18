<?php

declare(strict_types=1);

namespace ECorp\Application\Query\Client;

interface ClientQueryInterface
{
    /**
     * @return ClientView[]
     */
    public function getAll(): array;
}