<?php

namespace ECorp\DomainModel\User;

use ECorp\DomainModel\Assert\AssertException;
use ECorp\DomainModel\Assert\ECorpAssert;

final class Email
{
    /**
     * @var string
     */
    private $email;

    /**
     * Email constructor.
     * @param string $email
     * @throws AssertException
     */
    public function __construct(string $email)
    {
        ECorpAssert::stringNotEmpty($email, 'Email cannot be empty');

        if (false === filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new AssertException('Invalid email address.');
        }
        $domain = explode('@', $email)[1];

        ECorpAssert::checkMicrosoftDomain($domain);
        ECorpAssert::checkEcorpDomain($domain);

        $this->email = $email;
    }

    /**
     * @return string
     */
    public function asString(): string
    {
        return $this->email;
    }
}
