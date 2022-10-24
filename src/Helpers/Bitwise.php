<?php

declare(strict_types=1);

namespace BitOps\Helpers;

/**
 * Helpers including one or more bitwise operators.
 */
class Bitwise
{
    /**
     * Flips a bit in the provided value to either set (1) or unset (0).
     */
    public static function flip(int $value): int
    {
        if ($value < 0 || $value > 1) {
            return $value;
        }

        return 1 & ~ $value;
    }

    /**
     * Determines if the bitValue is set in the config.
     *
     * When the config is 6 (binary 110), bits 4 and 2 are set. Passing a
     * bitValue of 1 would return false, while passing 4 or 2 would return true.
     * Any time a bitValue of 0 is passed, the result is false since there is no
     * 0 bit in binary.
     */
    public static function isSet(int $config, int $bitValue): bool
    {
        if ($bitValue === 0) {
            return false;
        }

        return ($config & $bitValue) === $bitValue;
    }
}
