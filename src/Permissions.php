<?php

declare(strict_types=1);

namespace BitOps;

use ReflectionClass;
use ReflectionClassConstant;

/**
 * Holder of permissions
 */
class Permissions
{
    public const ACTIVE = 1;
    public const CREATE = 2;
    public const VIEW = 4;
    public const UPDATE = 8;
    public const DELETE = 16;

    /**
     * Gets all the public constants from this class as an array.
     *
     * The indices are the constant names and the values are the constant
     * values.
     *
     * @return array<string, int>
     */
    public static function getConstants(): array
    {
        return (new ReflectionClass(__CLASS__))->getConstants(ReflectionClassConstant::IS_PUBLIC);
    }
}
