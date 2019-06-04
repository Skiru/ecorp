<?php

namespace ECorp\DomainModel\User;

use ECorp\DomainModel\Assert\AssertException;
use ECorp\DomainModel\Assert\ECorpAssertAbstract;

final class Uuid extends ECorpAssertAbstract
{
    /**
     * @var string
     */
    private $uuid;

    /**
     * Uuid constructor.
     * @param string $uuid
     * @throws AssertException
     */
    public function __construct(string $uuid)
    {
        $this->assert->stringNotEmpty($uuid, 'Uuid value cannot be empty!');
        $this->assert->uuid($uuid, 'Uuid is wrong!');

        $this->uuid = $uuid;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }
}
