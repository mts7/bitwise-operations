# Bitwise Operations

[![Build Status](https://circleci.com/gh/mts7/bitwise-operations/tree/master.svg?style=shield)](https://circleci.com/gh/mts7/bitwise-operations)
![PHPStan](https://img.shields.io/badge/style-level%209-brightgreen.svg?&label=phpstan)

Bitwise Operations provides [examples](examples) of how to use bitwise operators
in real-world scenarios. The most basic usage examples are included in the
[tests](tests) directory, while the actual bitwise code is in the [src](src)
directory.

## Contents

* [Bitwise Operator Basics](#bitwise-operator-basics)
* [Flag Storage](#flag-storage)
* [Boolean Loops](#boolean-loops)
* [Odd or Even](#odd-or-even)
* [Tracking Status](#tracking-status)
* [Binary Clock](#binary-clock)
* [Array Helper: implode](#array-helper-implode)

---

## Bitwise Operator Basics

### And

And (`&`) checks for any common set bits and returns them.

[Odd or Even example code](examples/odd-or-even.php)

```
1 & 1 == 1
1 & 0 == 0
0 & 0 == 0
```

### Or

Or (`|`) checks for any set bits and returns whether either operand is set.

[addPermission](src/User.php#LC30)

```
1 | 1 == 1
1 | 0 == 1
0 | 0 == 0
```

### Xor

Exclusive or (`^`) checks for differences between set values.

[removePermission](src/User.php#LC38)

```
1 ^ 1 == 0
1 ^ 0 == 1
0 ^ 0 == 0
101 ^ 010 == 111
001 ^ 011 == 010
```

### Not

Not (`~`) is a complement. Flipping bits is done using both And and Not where one
operand is the number of desired set bits to use and the other is the value to
flip.

[Flip a bit](src/Helper/Binary.php#LC27)

```
1 & ~0 == 1
1 & ~1 == 0
11 & ~ 10 == 01
111 & ~ 101 == 010
```

### Shift Left

Shift left (`<<`) shifts the set bits to the left by the right operand. This
results in a multiplication of the set bits' value by 2 to the power of the
right operand.

[increaseStatus](src/User.php#LC115)

```
1010 << 1 == 10100
100 << 2 == 10000
```

### Shift Right

Shift right (`>>`) shifts the set bits to the right by the right operand. This
results in a division of the set bits' value by 2 to the power of the right
operand.

[decreaseStatus](src/User.php#LC123)

```
1010 >> 1 == 101
100 >> 2 == 1
```

---

## Flag Storage

One usage for bitwise operations is of a User with Permissions. Each permission
is stored as a class constant with a value that is a multiple of 2. Since bits
are binary, their values can be either 0 (off) or 1 (on). With each permission
at a different bit, the entire permissions management can be handled in a single
integer. In this example, there are only 5 permissions, so a 32-bit integer is
large enough to store the permissions.

[Example Code](examples/flag-storage.php)

---

## Boolean Loops

Sometimes we want to find out when a method call returns a boolean, but in a
loop. Two of the approaches to this using bitwise operators would be checking if
any of the results are `true` and checking if all the results are `true`. In
some situations, throwing an exception, breaking, or returning early would be
good to do if any result was `false`, which would then follow the second
approach.

This example shows how to use the `BitOps\Boolean` class for determining true
values.

[Example Code](examples/boolean-loops.php)

---

## Odd or Even

Checking for even can be done like `($value % 2) === 0`. A faster way to do it,
as `BitOps\Boolean` demonstrates, is with `($value & 1) === 0`. The differences
include an operator change as well as an operand change. Since the last bit in a
number is for `1`, all odd numbers will have the last bit on and all even
numbers will have the last bit off.

[Example Code](examples/odd-or-even.php)

[Benchmark](https://github.com/mts7/Benchmarks/blob/master/benchmarks/is-even.php)

---

## Tracking Status

When a user (as an example) exists, it should only have a single status at any
given time. To track this, we can use a `UserStatus` class to hold all the
necessary status names in their specific order. The user would initially have a
status of `Anonymous`, then can be changed to a `Repeat Visitor` if the user has
visited an application multiple times, and then changed to `Registered` after
signing up. This status progression can be done by shifting the bit to the left.
Since the user status has only a single value, this allows for quick and easy
modification of the user status, as handled by the `User` class.

[Example Code](examples/tracking-status.php)

---

## Binary Clock

A binary clock algorithm is nothing new. This clock increments the time using
the And (&) and Not (~) bitwise operators inside a for loop that iterates
from the end of the binary value (1-position) to the beginning of the binary
value. The example below indicates how this clock could be used. Something to
add would be a display mechanism to illuminate LEDs or replace the output on a
screen.

The fun part about the increment method is flipping a single bit using
`1 & ~ $value` where `$value` is a string containing `1` or `0`.

[Example Code](examples/binary-clock.php)

---

## Array Helper: implode

Implode is a very useful PHP function. To make implode more useful, a
reimplementation can accept options as bitwise flags to include `and ` before the
final value and display the keys with the values.

[Example Code](examples/implode-flags.php)
