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
     */
    public static function isAtLeastOneTrue(array $booleans): bool
    {
        $result = 0;
        foreach ($booleans as $boolean) {
            $result |= (int) $boolean;
        }

        return (bool) $result;
    }

    /**
     * Checks if all array values are true.
     *
     * @param bool[] $booleans
     */
    public static function areAllTrue(array $booleans): bool
    {
        $result = 1;
        foreach ($booleans as $boolean) {
            $result &= (int) $boolean;
        }

        return (bool) $result;
    }
}
