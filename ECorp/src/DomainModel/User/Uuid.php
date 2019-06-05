<?php

namespace ECorp\DomainModel\User;

use ECorp\DomainModel\Assert\AssertException;
use ECorp\DomainModel\Assert\ECorpAssert;

final class Uuid
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
        ECorpAssert::stringNotEmpty($uuid, 'Uuid value cannot be empty!');
        ECorpAssert::uuid($uuid, 'Uuid is wrong!');

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
