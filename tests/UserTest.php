<?php

declare(strict_types=1);

namespace BitOps\Tests;

use BitOps\Permissions;
use BitOps\User;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for User accessing Permissions
 * @psalm-suppress PropertyNotSetInConstructor
 * @psalm-suppress UnusedClass
 * @psalm-suppress MissingThrowsDocblock
 */
class UserTest extends TestCase
{
    private User $fixture;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fixture = new User();
    }

    public function testAddPermissionSingle(): void
    {
        $permission = Permissions::ACTIVE;

        $this->fixture->addPermission($permission);
        $userPermission = $this->fixture->getPermission();

        self::assertSame($permission, $userPermission, 'The permission was not applied.');
    }

    public function testAddPermissionMultiple(): void
    {
        $permission = Permissions::ACTIVE | Permissions::VIEW;

        $this->fixture->addPermission($permission);
        $userPermission = $this->fixture->getPermission();

        self::assertSame($permission, $userPermission, 'The permissions were not applied.');
    }

    public function testRemovePermissionSingle(): void
    {
        $permission = Permissions::ACTIVE;
        $this->fixture->addPermission($permission);

        $this->fixture->removePermission($permission);
        $userPermission = $this->fixture->getPermission();

        self::assertSame(0, $userPermission, 'User permission is not 0.');
    }

    public function testRemovePermissionMultiple(): void
    {
        $permission = Permissions::ACTIVE | Permissions::VIEW;
        $this->fixture->addPermission($permission);

        $this->fixture->removePermission($permission);
        $userPermission = $this->fixture->getPermission();

        self::assertSame(0, $userPermission, 'User permission is not 0.');
    }

    public function testRemovePermissionOneOfMany(): void
    {
        $permissions = Permissions::ACTIVE | Permissions::VIEW | Permissions::CREATE | Permissions::UPDATE;
        $removePermission = Permissions::UPDATE;
        $this->fixture->addPermission($permissions);

        $this->fixture->removePermission($removePermission);
        $userPermission = $this->fixture->getPermission();

        self::assertSame(
            $permissions - $removePermission,
            $userPermission,
            'User permission was not removed.'
        );
    }

    public function testCheckPermissionSingle(): void
    {
        $permission = Permissions::CREATE;
        $this->fixture->addPermission($permission);

        $hasPermission = $this->fixture->checkPermission($permission);

        self::assertTrue($hasPermission, 'The permission does not exist for the user.');
    }

    public function testCheckPermissionMultipleSuccess(): void
    {
        $permissions = Permissions::ACTIVE | Permissions::CREATE | Permissions::VIEW;
        $checkPermissions = Permissions::ACTIVE | Permissions::CREATE;
        $this->fixture->addPermission($permissions);

        $hasPermission = $this->fixture->checkPermission($checkPermissions);

        self::assertTrue($hasPermission, 'The user is not active and does not have permission to create.');
    }

    public function testCheckPermissionMultipleFail(): void
    {
        $permissions = Permissions::ACTIVE | Permissions::CREATE | Permissions::VIEW;
        $checkPermissions = Permissions::ACTIVE | Permissions::DELETE;
        $this->fixture->addPermission($permissions);

        $hasPermission = $this->fixture->checkPermission($checkPermissions);

        self::assertFalse($hasPermission, 'The user does not have both active and delete permissions.');
    }

    public function testGetPermissionsAll(): void
    {
        $permissions = Permissions::ACTIVE
            | Permissions::CREATE
            | Permissions::VIEW
            | Permissions::UPDATE
            | Permissions::DELETE;
        $expected = [
            'Active',
            'Create',
            'View',
            'Update',
            'Delete',
        ];
        $this->fixture->addPermission($permissions);

        $permissionList = $this->fixture->getPermissions();

        self::assertSame($expected, $permissionList, 'The permissions returned do not match.');
    }
}
