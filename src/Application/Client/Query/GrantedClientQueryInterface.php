<?php

declare(strict_types=1);

namespace ECorp\Application\Client\Query;

interface GrantedClientQueryInterface
{
    /**
     * @return GrantedClientView[]
     */
    public function getAll(): array;
}