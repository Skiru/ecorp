<?php

namespace ECorp\DomainModel\Assert;

interface DomainAssertInterface
{
    /**
     * @param int $value
     * @param int $limit
     * @param string $message
     * @throws DomainUserModelException
     */
    public static function greaterThanEq(int $value, int $limit, string $message): void;

    /**
     * @param int $value
     * @param int $limit
     * @param string $message
     * @throws DomainUserModelException
     */
    public static function lessThan(int $value, int $limit, string $message): void;

    /**
     * @param string $value
     * @param string $message
     * @throws DomainUserModelException
     */
    public static function stringNotEmpty(string $value, string $message): void;

    /**
     * @param string $uuid
     * @param string $message
     * @throws DomainUserModelException
     */
    public static function uuid(string $uuid, string $message): void;

    /**
     * @param string $value
     * @param int $lengthMin
     * @param int $lengthMax
     * @param string $message
     * @throws DomainUserModelException
     */
    public static function lengthBetween(string $value, int $lengthMin, int $lengthMax, string $message): void;
}
