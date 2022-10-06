<?php

declare(strict_types=1);

namespace BitOps\Tests;

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
    public function testIsAtLeastOneTrueAllTrue(): void
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

    public function testIsAtLeastOneTrueSomeTrue(): void
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

    public function testIsAtLeastOneTrueNoneTrue(): void
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

    public function testAreAllTrueAllTrue(): void
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

    public function testAreAllTrueSomeTrue(): void
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

    public function testAreAllTrueNoneTrue(): void
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
}
