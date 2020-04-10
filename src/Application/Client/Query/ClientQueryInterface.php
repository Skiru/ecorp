<?php

declare(strict_types=1);

namespace ECorp\Application\Client\Query;

interface ClientQueryInterface
{
    /**
     * @return ClientView[]
     */
    public function getAll(): array;
}