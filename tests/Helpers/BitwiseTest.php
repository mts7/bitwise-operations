<?php

declare(strict_types=1);

namespace BitOps\Tests\Helpers;

use BitOps\Helpers\Bitwise;
use PHPUnit\Framework\TestCase;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @psalm-suppress UnusedClass
 * @psalm-suppress MissingThrowsDocblock
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
final class BitwiseTest extends TestCase
{
    /**
     * @dataProvider isSetData
     */
    public function testIsSet(int $config, int $bitValue, bool $expected): void
    {
        $result = Bitwise::isSet($config, $bitValue);

        self::assertSame($expected, $result);
    }

    /**
     * @return iterable<string,array<string,int|bool>>
     */
    public function isSetData(): iterable
    {
        yield 'zero bit value for odd number' => [
            'config' => 3,
            'bitValue' => 0,
            'expected' => false,
        ];

        yield 'zero bit value for even number' => [
            'config' => 4,
            'bitValue' => 0,
            'expected' => false,
        ];

        yield 'one bit value for odd number' => [
            'config' => 3,
            'bitValue' => 1,
            'expected' => true,
        ];

        yield 'one bit value for even number' => [
            'config' => 6,
            'bitValue' => 1,
            'expected' => false,
        ];

        yield 'two bit value for even number' => [
            'config' => 6,
            'bitValue' => 2,
            'expected' => true,
        ];
    }

    /**
     * @dataProvider flipData
     */
    public function testFlip(int $value, int $expected): void
    {
        $result = Bitwise::flip($value);

        self::assertSame($expected, $result);
    }

    /**
     * @return iterable<string,array<int>>
     */
    public function flipData(): iterable
    {
        yield 'one' => [
            'value' => 1,
            'expected' => 0,
        ];

        yield 'zero' => [
            'value' => 0,
            'expected' => 1,
        ];

        yield 'negative one' => [
            'value' => -1,
            'expected' => -1,
        ];

        yield 'two' => [
            'value' => 2,
            'expected' => 2,
        ];
    }
}
