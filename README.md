# Bitwise Operations

[![Build Status](https://circleci.com/gh/mts7/bitwise-operations/tree/master.svg?style=shield)](https://circleci.com/gh/mts7/bitwise-operations)
![PHPStan](https://img.shields.io/badge/style-level%209-brightgreen.svg?&label=phpstan)

Bitwise Operations provides examples of how to use bitwise operators in 
real-world scenarios.

## Flag Storage Example

One example is of a User with Permissions. Each permission is stored as a class
constant with a value that is a multiple of 2. Since bits are binary, their 
values can be either 0 (off) or 1 (on). With each permission at a different bit,
the entire permissions management can be handled in a single integer. In this
example, there are only 5 permissions, so a 32-bit integer is large enough to 
store the permissions.

```php
<?php

require 'vendor/autoload.php';

namespace BitOps;

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
```

## Boolean Loops

Sometimes we want to find out when a method call returns a boolean, but in a
loop. Two of the approaches to this using bitwise operators would be checking if
any of the results are `true` and checking if all of the results are `true`. In
some situations, throwing an exception, breaking, or returning early would be
good to do if any result was `false`, which would then follow the second
approach.

This example shows how to use the `BitOps\Boolean` class for determining true
values.

```php
<?php

require 'vendor/autoload.php';

namespace BitOps;

$methodResults = [
    true,
    false,
];

$true = Boolean::isAtLeastOneTrue($methodResults);
$false = Boolean::areAllTrue($methodResults);
```
