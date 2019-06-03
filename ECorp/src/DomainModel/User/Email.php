<?php

namespace ECorp\DomainModel\User;

use ECorp\DomainModel\Assert\DomainUserModelException;
use ECorp\DomainModel\BusinessRequirementsConstants;
use ECorp\Infrastructure\Assert\EcorpAssert;
use InvalidArgumentException;

final class Email
{
    /**
     * @var string
     */
    private $email;

    /**
     * Email constructor.
     * @param string $email
     * @throws DomainUserModelException
     */
    public function __construct(string $email)
    {
        EcorpAssert::stringNotEmpty($email, 'Email cannot be empty');

        if (false === filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email address.');
        }

        $domain = explode('@', $email)[1];

        if (in_array($domain, BusinessRequirementsConstants::EXCLUDED_DOMAINS)) {
            throw new InvalidArgumentException(
                sprintf('Email could not be from %s domain.', implode(',', BusinessRequirementsConstants::EXCLUDED_DOMAINS) )
            );
        }

        if (BusinessRequirementsConstants::DOMAIN_NAME !== $domain) {
            throw new InvalidArgumentException(
                sprintf('Email has to be from %s domain.', BusinessRequirementsConstants::DOMAIN_NAME)
            );
        }

        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}
