<?php

namespace ECorp\DomainModel\Assert;

final class ECorpAssert
{
    /**
     * @param int $value
     * @param int $limit
     * @param string $message
     * @throws AssertException
     */
    public static function greaterThanEq(int $value, int $limit, string $message): void
    {
        if ($value < $limit) {
            throw new AssertException($message);
        }
    }

    /**
     * @param int $value
     * @param int $limit
     * @param string $message
     * @throws AssertException
     */
    public static function lessThan(int $value, int $limit, string $message): void
    {
        if ($value >= $limit) {
            throw new AssertException($message);
        }
    }

    /**
     * @param string $value
     * @param string $message
     * @throws AssertException
     */
    public static function stringNotEmpty(string $value, string $message): void
    {
        if ($value === "") {
            throw new AssertException($message);
        }
    }

    /**
     * @param string $uuid
     * @param string $message
     * @throws AssertException
     */
    public static function uuid(string $uuid, string $message): void
    {
        $value = str_replace(array('urn:', 'uuid:', '{', '}'), '', $uuid);

        // The nil UUID is special form of UUID that is specified to have all
        // 128 bits set to zero.
        if ('00000000-0000-0000-0000-000000000000' === $value) {
            return;
        }

        if (!preg_match('/^[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}$/', $value)) {
            throw new AssertException($message);
        }
    }

    /**
     * @param string $value
     * @param int $lengthMin
     * @param int $lengthMax
     * @param string $message
     * @throws AssertException
     */
    public static function lengthBetween(string $value, int $lengthMin, int $lengthMax, string $message): void
    {
        $length = static::strlen($value);

        if ($length < $lengthMin || $length > $lengthMax) {
            throw new AssertException($message);
        }
    }

    /**
     * @param string $value
     * @return string
     */
    private static function strlen(string $value): string
    {
        if (!function_exists('mb_detect_encoding')) {
            return strlen($value);
        }

        if (false === $encoding = mb_detect_encoding($value)) {
            return strlen($value);
        }

        return mb_strwidth($value, $encoding);
    }
}
