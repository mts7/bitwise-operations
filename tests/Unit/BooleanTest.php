<?php

declare(strict_types=1);

namespace BitOps\Tests\Unit;

use BitOps\Boolean;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for Boolean examples
 * @psalm-suppress PropertyNotSetInConstructor
 * @psalm-suppress UnusedClass
 * @psalm-suppress MissingThrowsDocblock
 */
class BooleanTest extends TestCase
{
    final public function testIsAtLeastOneTrueAllTrue(): void
    {
        $booleans = [
            true,
            true,
            true,
            true,
        ];

        $result = Boolean::isAtLeastOneTrue($booleans);

        self::assertTrue($result, 'None of the boolean values are true.');
    }

    final public function testIsAtLeastOneTrueSomeTrue(): void
    {
        $booleans = [
            true,
            true,
            false,
            true,
        ];

        $result = Boolean::isAtLeastOneTrue($booleans);

        self::assertTrue($result, 'None of the boolean values are true.');
    }

    final public function testIsAtLeastOneTrueSomeTrueFalseLast(): void
    {
        $booleans = [
            true,
            false,
        ];

        $result = Boolean::isAtLeastOneTrue($booleans);

        self::assertTrue($result, 'None of the boolean values are true.');
    }

    final public function testIsAtLeastOneTrueNoneTrue(): void
    {
        $booleans = [
            false,
            false,
            false,
            false,
        ];

        $result = Boolean::isAtLeastOneTrue($booleans);

        self::assertFalse($result, 'At least one of the boolean values is true.');
    }

    final public function testAreAllTrueAllTrue(): void
    {
        $booleans = [
            true,
            true,
            true,
            true,
        ];

        $result = Boolean::areAllTrue($booleans);

        self::assertTrue($result, 'At least one of the boolean values is false.');
    }

    final public function testAreAllTrueSomeTrue(): void
    {
        $booleans = [
            true,
            true,
            false,
            true,
        ];

        $result = Boolean::areAllTrue($booleans);

        self::assertFalse($result, 'At least one of the boolean values is false.');
    }

    final public function testAreAllTrueNoneTrue(): void
    {
        $booleans = [
            false,
            false,
            false,
            false,
        ];

        $result = Boolean::areAllTrue($booleans);

        self::assertFalse($result, 'At least one of the boolean values is false.');
    }

    final public function testIsOddSuccess(): void
    {
        $value = 5;

        $result = Boolean::isOdd($value);

        self::assertTrue($result, 'The value is even.');
    }

    final public function testIsOddFail(): void
    {
        $value = 6;

        $result = Boolean::isOdd($value);

        self::assertFalse($result, 'The value is odd.');
    }

    final public function testIsEvenSuccess(): void
    {
        $value = 6;

        $result = Boolean::isEven($value);

        self::assertTrue($result, 'The value is odd.');
    }

    final public function testIsEvenFail(): void
    {
        $value = 5;

        $result = Boolean::isEven($value);

        self::assertFalse($result, 'The value is even.');
    }
}
