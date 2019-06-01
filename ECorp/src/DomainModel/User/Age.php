<?php

namespace ECorp\DomainModel\User;

use InvalidArgumentException;
use Webmozart\Assert\Assert;

final class Age
{
    /**
     * @var int
     */
    private $age;

    /**
     * Age constructor.
     * @param int $age
     * @throws InvalidArgumentException
     */
    public function __construct(int $age)
    {
        Assert::greaterThanEq($age, 18, 'Age caanot be a negative value.');

        $this->age = $age;
    }
}
