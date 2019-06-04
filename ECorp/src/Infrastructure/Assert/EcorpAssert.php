<?php

namespace ECorp\Infrastructure\Assert;

use ECorp\DomainModel\Assert\DomainAssertInterface;
use ECorp\DomainModel\Assert\DomainUserModelException;
use InvalidArgumentException;
use Webmozart\Assert\Assert;

class EcorpAssert implements DomainAssertInterface
{
    /**
     * {@inheritDoc}
     */
    public static function greaterThanEq(int $value, int $limit, string $message): void
    {
        try {
            Assert::greaterThanEq($value, $limit, $message);
        } catch (InvalidArgumentException $argumentException) {
            throw new DomainUserModelException($argumentException->getMessage());
        }
    }

    /**
     * {@inheritDoc}
     */
    public static function lessThan(int $value, int $limit, string $message): void
    {
        try {
            Assert::lessThan($value, $limit, $message);
        } catch (InvalidArgumentException $argumentException) {
            throw new DomainUserModelException($argumentException->getMessage());
        }
    }

    /**
     * {@inheritDoc}
     */
    public static function stringNotEmpty(string $value, string $message): void
    {
        try {
            Assert::stringNotEmpty($value, $message);
        } catch (InvalidArgumentException $argumentException) {
            throw new DomainUserModelException($argumentException->getMessage());
        }
    }

    /**
     * {@inheritDoc}
     */
    public static function uuid(string $uuid, string $message): void
    {
        try {
            Assert::uuid($uuid, $message);
        } catch (InvalidArgumentException $argumentException) {
            throw new DomainUserModelException($argumentException->getMessage());
        }
    }

    /**
     * {@inheritDoc}
     */
    public static function lengthBetween(string $value, int $lengthMin, int $lengthMax, string $message): void
    {
        Assert::lengthBetween(
            $value,
            $lengthMin,
            $lengthMax,
            $message
        );
    }
}
