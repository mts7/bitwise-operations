<?php

declare(strict_types=1);

namespace BitOps;

use ReflectionClass;
use ReflectionClassConstant;

/**
 * Handle common constant methods for classes.
 */
trait ClassConstants
{
    /**
     * Gets all the public constants from this class as an array.
     *
     * The indices are the constant names and the values are the constant
     * values.
     *
     * @return array<string, int>
     *
     * @psalm-suppress MixedReturnTypeCoercion
     */
    public static function getConstants(): array
    {
        return (new ReflectionClass(self::class))->getConstants(ReflectionClassConstant::IS_PUBLIC);
    }

    /**
     * Determines if the provided status is acceptable or not.
     *
     * This assumes the constants are only powers of 2 without skipping values.
     *
     * @psalm-suppress ArgumentTypeCoercion
     */
    final public function isValidConstant(int $status): bool
    {
        $constants = self::getConstants();
        if ($status < min($constants) || $status > max($constants)) {
            return false;
        }

        return self::isPowerOfTwo($status);
    }

    /**
     * Checks if the provided integer is a power of two.
     */
    final public static function isPowerOfTwo(int $value): bool
    {
        return ($value & $value - 1) === 0;
    }
}
