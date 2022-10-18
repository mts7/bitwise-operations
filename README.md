# Bitwise Operations

[![Build Status](https://circleci.com/gh/mts7/bitwise-operations/tree/master.svg?style=shield)](https://circleci.com/gh/mts7/bitwise-operations)
![PHPStan](https://img.shields.io/badge/style-level%209-brightgreen.svg?&label=phpstan)

Bitwise Operations provides examples of how to use bitwise operators in
real-world scenarios. The most basic usage examples are included in the `tests`
directory, while the actual bitwise code is in the `src` directory. The below
examples use the classes with the bitwise operations rather than display how the
bitwise operations work.

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

## Odd or Even

Checking for even can be done like `($value % 2) === 0`. Another way to do it, as
`BitOps\Boolean` demonstrates, is with `($value & 1) === 0`. The differences
include an operator change as well as an operand change. Since the last bit in a
number is for `1`, all odd numbers will have the last bit on and all even
numbers will have the last bit off.

```php
<?php

require 'vendor/autoload.php';

namespace BitOps;

$value = 6;

$true = Boolean::isEven($value);
$false = Boolean::isFalse($value);
```

## Tracking Status

When a user (as an example) exists, it should only have a single status at any
given time. To track this, we can use a `UserStatus` class to hold all of the
necessary status names in their specific order. The user would initially have a
status of `Anonymous`, then can be changed to a `Repeat Visitor` if the user has
visited an application multiple times, and then changed to `Registered` after
signing up. This status progression can be done by shifting the bit to the left.
Since the user status has only a single value, this allows for quick and easy
modification of the user status, as handled by the `User` class.

```php
<?php

require 'vendor/autoload.php';

namespace BitOps;

$user = new User();
$status = $user->getStatusName();
echo $status; // ANONYMOUS

$user->increaseStatus();
$status = $user->getStatusName();
echo $status; // REPEAT_VISITOR

$user->setStatus(UserStatus::REGULAR);
$status = $user->getStatusName();
echo $status; // REGULAR

$user->decreaseStatus();
$status = $user->getStatusName();
echo $status; // ACTIVE
```

## Binary Clock

A binary clock algorithm is nothing new. This clock increments the time using
the And (&) and Not (~) bitwise operators inside of a for loop that iterates
from the end of the binary value (1-position) to the beginning of the binary
value. The example below indicates how this clock could be used. Something to
add would be a display mechanism to illuminate LEDs or replace the output on a
screen.

The fun part about the increment method is flipping a single bit using
`1 & ~ $value` where `$value` is a string containing `1` or `0`.

```php
<?php

require 'vendor/autoload.php';

namespace BitOps;

$clock = new BinaryClock();
$clock->setTime();

// WARNING! The below code will execute forever unless manually stopped or an error occurs.
while (1) {
    sleep(1);
    $time = $clock->getTime();
    echo $time . PHP_EOL;
}
```
