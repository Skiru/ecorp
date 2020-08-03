<?php

namespace ECorp\DomainModel\User;

use ECorp\DomainModel\Assert\AssertException;
use ECorp\DomainModel\Assert\ECorpAssert;

class Password
{
    public const MINIMAL_PASSWORD_LENGTH = 4;
    public const MAXIMAL_PASSWORD_LENGTH = 36;

    private string $password;

    /**
     * @param string $password
     *
     * @throws AssertException
     */
    public function __construct(string $password)
    {
        ECorpAssert::stringNotEmpty($password, 'Password should not be empty');
        ECorpAssert::greaterThanEq(
            strlen($password),
            self::MAXIMAL_PASSWORD_LENGTH,
            sprintf('Password too long. Maximal length is %d', self::MAXIMAL_PASSWORD_LENGTH)
        );
        ECorpAssert::lessThan(
            strlen($password),
            self::MINIMAL_PASSWORD_LENGTH,
            sprintf('Password too short. Minimal length is %d', self::MINIMAL_PASSWORD_LENGTH)

        );

        $this->password = $password;
    }

    public function asString(): string
    {
        return $this->password;
    }

    public function equals(Password $password): bool
    {
        return $password->asString() === $this->password;
    }
}