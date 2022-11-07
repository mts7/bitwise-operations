<?php

declare(strict_types=1);

namespace BitOps;

use BitOps\Helper\Bitwise;

/**
 * Boolean bitwise examples with loops
 */
class Boolean
{
    /**
     * Checks if at least one array value is true.
     *
     * @param bool[] $booleans
     *
     * @psalm-suppress InvalidOperand
     */
    public static function isAtLeastOneTrue(array $booleans): bool
    {
        $result = 0;
        foreach ($booleans as $boolean) {
            $result |= $boolean;
        }

        return (bool) $result;
    }

    /**
     * Checks if all array values are true.
     *
     * @param bool[] $booleans
     *
     * @psalm-suppress InvalidOperand
     */
    public static function areAllTrue(array $booleans): bool
    {
        $result = 1;
        foreach ($booleans as $boolean) {
            $result &= $boolean;
        }

        return (bool) $result;
    }

    /**
     * Checks if the provided integer is odd by having the 1 bit as set.
     */
    public static function isOdd(int $value): bool
    {
        return Bitwise::isSet($value, 1);
    }

    /**
     * Checks if the provided integer is even by having the 1 bit as unset.
     */
    public static function isEven(int $value): bool
    {
        return Bitwise::isSet($value, 1) === false;
    }
}
