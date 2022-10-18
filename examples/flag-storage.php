<?php

declare(strict_types=1);

use BitOps\Constants\Permissions;
use BitOps\User;

/** @psalm-suppress MissingFile */
require __DIR__ . '/../vendor/autoload.php';

$user = new User();
// set the ACTIVE (1) permission
$user->addPermission(Permissions::ACTIVE);
// permissions should now be 00001
// set three other permissions
$user->addPermission(
    Permissions::CREATE
    | Permissions::VIEW
    | Permissions::UPDATE
);
// permissions should now be 01111 because of turning on these bits

// check permission can compare with any of the permissions available
if ($user->checkPermission(Permissions::DELETE)) {
    echo 'User can delete' . PHP_EOL;
} else {
    echo 'User cannot delete' . PHP_EOL;
}

// removing the update permission will yield permissions of 00111
$user->removePermission(Permissions::UPDATE);

$allPermissions = $user->getPermissions();
print_r($allPermissions);
