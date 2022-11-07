<?php

declare(strict_types=1);

namespace BitOps\Helper;

/**
 * Converter of things
 */
class Convert
{
    public static function binaryToInteger(string $value): int
    {
        return (int) bindec($value);
    }

    public static function stringIntegerToBinary(string $integer): string
    {
        return decbin((int) $integer);
    }
}
