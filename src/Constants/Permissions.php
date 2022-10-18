<?php

declare(strict_types=1);

namespace BitOps\Constants;

/**
 * Holder of permissions
 *
 * The bit shifting is used to demonstrate how much more easily programmers can
 * add powers of 2 to constants without doing math. The values below start at 1
 * and currently go up to 2^4.
 */
class Permissions
{
    use ClassConstants;

    public const ACTIVE = 2 >> 1;
    public const CREATE = 2 << 0;
    public const VIEW = 2 << 1;
    public const UPDATE = 2 << 2;
    public const DELETE = 2 << 3;
}
