<?php

declare(strict_types=1);

namespace BitOps;

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
            $output[] = $this->checkPermission($value) ? ucfirst(strtolower($name)) : '';
        }

        return array_filter($output, static function ($value) {
            return !empty($value);
        });
    }
}
