<?php

declare(strict_types=1);

namespace BitOps\Constants;

/**
 * Holder of user statuses
 *
 * The bit shifting is used to demonstrate how much more easily programmers can
 * add powers of 2 to constants without doing math. The values below start at 1
 * and currently go up to 2^7.
 */
class UserStatus
{
    use ClassConstants;

    public const ANONYMOUS = 2 >> 1;
    public const REPEAT_VISITOR = 2 << 0;
    public const REGISTERED = 2 << 1;
    public const INACTIVE = 2 << 2;
    public const ACTIVE = 2 << 3;
    public const REGULAR = 2 << 4;
    public const POWER = 2 << 5;
    public const SUPER = 2 << 6;
}
