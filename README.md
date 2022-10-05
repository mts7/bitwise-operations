# Bitwise Operations

Bitwise Operations provides examples of how to use bitwise operators in 
real-world scenarios.

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
$user->addPermission(Permissions::CREATE | Permissions::VIEW | Permissions::UPDATE);
// permissions should now be 01111 because of turning on the bits for these others

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

