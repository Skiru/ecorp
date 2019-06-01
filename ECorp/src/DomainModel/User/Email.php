<?php

namespace ECorp\DomainModel\User;

use ECorp\DomainModel\BusinessRequirementsConstants;
use InvalidArgumentException;
use Webmozart\Assert\Assert;

final class Email
{
    /**
     * @var string
     */
    private $email;

    /**
     * Email constructor.
     * @param string $email
     * @throws InvalidArgumentException
     */
    public function __construct(string $email)
    {
        Assert::stringNotEmpty($email, 'Email cannot be empty');

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email address.');
        }

        $domain = explode('@', $email)[1];

        if (BusinessRequirementsConstants::DOMAIN_NAME !== $domain) {
            throw new InvalidArgumentException(
                sprintf('Email has to be from %s domain.', BusinessRequirementsConstants::DOMAIN_NAME)
            );
        }

        if (in_array($domain, BusinessRequirementsConstants::EXCLUDED_DOMAINS)) {
            throw new InvalidArgumentException(
                sprintf('Email could\t be from %s domain.', implode(',', BusinessRequirementsConstants::EXCLUDED_DOMAINS) )
            );
        }

        $this->email = $email;
    }
}