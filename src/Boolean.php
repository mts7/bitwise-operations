<?php

declare(strict_types=1);

namespace BitOps;

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
     * Checks if the provided integer is odd.
     */
    public static function isOdd(int $value): bool
    {
        return ($value & 1) === 1;
    }

    /**
     * Checks if the provided integer is even.
     */
    public static function isEven(int $value): bool
    {
        return ($value & 1) === 0;
    }
}
