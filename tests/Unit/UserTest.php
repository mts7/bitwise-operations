<?php

declare(strict_types=1);

namespace BitOps\Tests\Unit;

use BitOps\Constants\Permissions;
use BitOps\Constants\UserStatus;
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

    final protected function setUp(): void
    {
        parent::setUp();

        $this->fixture = new User();
    }

    final public function testAddPermissionSingle(): void
    {
        $permission = Permissions::ACTIVE;

        $this->fixture->addPermission($permission);
        $userPermission = $this->fixture->getPermission();

        self::assertSame($permission, $userPermission, 'The permission was not applied.');
    }

    final public function testAddPermissionMultiple(): void
    {
        $permission = Permissions::ACTIVE | Permissions::VIEW;

        $this->fixture->addPermission($permission);
        $userPermission = $this->fixture->getPermission();

        self::assertSame($permission, $userPermission, 'The permissions were not applied.');
    }

    final public function testAddPermissionTwice(): void
    {
        $permissions = Permissions::ACTIVE | Permissions::VIEW;

        $this->fixture->addPermission(Permissions::ACTIVE);
        $this->fixture->addPermission(Permissions::VIEW);
        $userPermission = $this->fixture->getPermission();

        self::assertSame($permissions, $userPermission, 'The permissions were not applied.');
    }

    final public function testRemovePermissionSingle(): void
    {
        $permission = Permissions::ACTIVE;
        $this->fixture->addPermission($permission);

        $this->fixture->removePermission($permission);
        $userPermission = $this->fixture->getPermission();

        self::assertSame(0, $userPermission, 'User permission is not 0.');
    }

    final public function testRemovePermissionMultiple(): void
    {
        $permission = Permissions::ACTIVE | Permissions::VIEW;
        $this->fixture->addPermission($permission);

        $this->fixture->removePermission($permission);
        $userPermission = $this->fixture->getPermission();

        self::assertSame(0, $userPermission, 'User permission is not 0.');
    }

    final public function testRemovePermissionOneOfMany(): void
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

    final public function testCheckPermissionSingle(): void
    {
        $permission = Permissions::CREATE;
        $this->fixture->addPermission($permission);

        $hasPermission = $this->fixture->checkPermission($permission);

        self::assertTrue($hasPermission, 'The permission does not exist for the user.');
    }

    final public function testCheckPermissionMultipleSuccess(): void
    {
        $permissions = Permissions::ACTIVE | Permissions::CREATE | Permissions::VIEW;
        $checkPermissions = Permissions::ACTIVE | Permissions::CREATE;
        $this->fixture->addPermission($permissions);

        $hasPermission = $this->fixture->checkPermission($checkPermissions);

        self::assertTrue($hasPermission, 'The user is not active and does not have permission to create.');
    }

    final public function testCheckPermissionMultipleFail(): void
    {
        $permissions = Permissions::ACTIVE | Permissions::CREATE | Permissions::VIEW;
        $checkPermissions = Permissions::ACTIVE | Permissions::DELETE;
        $this->fixture->addPermission($permissions);

        $hasPermission = $this->fixture->checkPermission($checkPermissions);

        self::assertFalse($hasPermission, 'The user does not have both active and delete permissions.');
    }

    final public function testGetPermissionsAll(): void
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

    final public function testGetStatusBasic(): void
    {
        $expected = 1;

        $status = $this->fixture->getStatus();

        self::assertSame($expected, $status, 'Status does not match expected starting value of 1.');
    }

    final public function testSetStatusSuccess(): void
    {
        $expected = UserStatus::REGULAR;

        $this->fixture->setStatus($expected);
        $status = $this->fixture->getStatus();

        self::assertSame($expected, $status, 'Status is not what was set.');
    }

    final public function testSetStatusFailOdd(): void
    {
        $newStatus = UserStatus::REPEAT_VISITOR + 7;
        $expected = UserStatus::ANONYMOUS;

        $this->fixture->setStatus($newStatus);
        $status = $this->fixture->getStatus();

        self::assertSame($expected, $status, 'Status is not the initial value.');
    }

    final public function testSetStatusFailExcessive(): void
    {
        $newStatus = UserStatus::SUPER << 7;
        $expected = UserStatus::ANONYMOUS;

        $this->fixture->setStatus($newStatus);
        $status = $this->fixture->getStatus();

        self::assertSame($expected, $status, 'Status is not the initial value.');
    }

    final public function testGetStatusName(): void
    {
        $expected = 'REGISTERED';

        $this->fixture->setStatus(UserStatus::REGISTERED);
        $name = $this->fixture->getStatusName();

        self::assertSame($expected, $name, 'The name does not match the expected name.');
    }

    final public function testIncreaseStatus(): void
    {
        $expected = UserStatus::INACTIVE;

        $this->fixture->increaseStatus();
        $this->fixture->increaseStatus();
        $this->fixture->increaseStatus();
        $status = $this->fixture->getStatus();

        self::assertSame($expected, $status, 'Status is not the fourth user status.');
    }

    final public function testDecreaseStatus(): void
    {
        $expected = UserStatus::ACTIVE;

        $this->fixture->setStatus(UserStatus::POWER);
        $this->fixture->decreaseStatus();
        $this->fixture->decreaseStatus();
        $status = $this->fixture->getStatus();

        self::assertSame($expected, $status, 'Status is not the fifth user status.');
    }

    /**
     * @psalm-suppress ArgumentTypeCoercion
     * @psalm-suppress RedundantCastGivenDocblockType
     */
    final public function testIsValidConstantMinimum(): void
    {
        $value = (int) min(UserStatus::getConstants());

        $valid = (new UserStatus())->isValidConstant($value);

        self::assertTrue($valid, 'The minimum value is not a valid constant.');
    }

    /**
     * @psalm-suppress ArgumentTypeCoercion
     * @psalm-suppress RedundantCastGivenDocblockType
     */
    final public function testIsValidConstantMaximum(): void
    {
        $value = (int) max(UserStatus::getConstants());

        $valid = (new UserStatus())->isValidConstant($value);

        self::assertTrue($valid, 'The maximum value is not a valid constant.');
    }

    final public function testIsPowerOfTwoSuccess(): void
    {
        $value = UserStatus::INACTIVE;

        $valid = UserStatus::isPowerOfTwo($value);

        self::assertTrue($valid, 'The inactive status is not a power of two.');
    }
}
