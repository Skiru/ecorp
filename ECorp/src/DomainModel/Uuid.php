<?php

namespace ECorp\DomainModel;

use ECorp\DomainModel\Assert\AssertException;
use ECorp\DomainModel\Assert\ECorpAssert;

final class Uuid
{
    /**
     * @var string
     */
    private $string;

    /**
     * Uuid constructor.
     * @param string $uuid
     * @throws AssertException
     */
    public function __construct(string $uuid)
    {
        ECorpAssert::stringNotEmpty($uuid, 'Uuid value cannot be empty!');
        ECorpAssert::uuid($uuid, 'Uuid is wrong!');

        $this->string = $uuid;
    }

    /**
     * @return string
     */
    public function getString(): string
    {
        return $this->string;
    }
}
