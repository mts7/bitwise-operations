<?php

declare(strict_types=1);

namespace BitOps;

use BitOps\Constants\Permissions;
use BitOps\Constants\UserStatus;

/**
 * Example class of how to interact with permissions at various bits.
 */
class User
{
    /**
     * @var int Permission manager
     */
    private int $permissions = 0;

    /**
     * @var int Current user status
     */
    private int $status = UserStatus::ANONYMOUS;

    /**
     * Adds a permission to the permission manager.
     */
    final public function addPermission(int $permission): void
    {
        $this->permissions |= $permission;
    }

    /**
     * Removes permissions from the permissions manager.
     */
    final public function removePermission(int $permission): void
    {
        $this->permissions ^= $permission;
    }

    /**
     * Verifies the provided permission is part of the permission manager.
     *
     * Example: $user->checkPermission(Permissions::VIEW)
     * Example: $user->checkPermission(Permissions::ACTIVE | Permissions::CREATE)
     */
    final public function checkPermission(int $permission): bool
    {
        return ($this->permissions & $permission) === $permission;
    }

    /**
     * Gets the raw value of the permission manager.
     */
    final public function getPermission(): int
    {
        return $this->permissions;
    }

    /**
     * Gets the names of each permission this user has.
     *
     * @return string[]
     */
    final public function getPermissions(): array
    {
        $output = [];
        foreach (Permissions::getConstants() as $name => $value) {
            if ($this->checkPermission($value)) {
                $output[] = ucfirst(strtolower($name));
            }
        }

        return $output;
    }

    /**
     * Gets the current status as an integer.
     */
    final public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * Gets the status name of the constant for the current status value.
     */
    final public function getStatusName(): string
    {
        $constants = UserStatus::getConstants();
        $flipped = array_flip($constants);

        return $flipped[$this->status];
    }

    /**
     * Sets the status to the provided value, if valid.
     */
    final public function setStatus(int $status): void
    {
        if (!(new UserStatus())->isValidConstant($status)) {
            $this->status = UserStatus::ANONYMOUS;

            return;
        }

        $this->status = $status;
    }

    /**
     * Increases the user status by one increment.
     */
    final public function increaseStatus(): void
    {
        $this->status <<= 1;
    }

    /**
     * Decreases the user status by one increment.
     */
    final public function decreaseStatus(): void
    {
        $this->status >>= 1;
    }
}
