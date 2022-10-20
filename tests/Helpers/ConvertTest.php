<?php

declare(strict_types=1);

namespace BitOps\Tests\Helpers;

use BitOps\Helpers\Convert;
use PHPUnit\Framework\TestCase;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @psalm-suppress UnusedClass
 * @psalm-suppress MissingThrowsDocblock
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
class ConvertTest extends TestCase
{
    /**
     * @dataProvider binaryToIntegerData
     */
    final public function testBinaryToInteger(string $value, mixed $expected): void
    {
        $result = Convert::binaryToInteger($value);

        self::assertSame($expected, $result, 'The conversion failed.');
    }

    /**
     * @return iterable<string,array<string,string|int>>
     */
    public function binaryToIntegerData(): iterable
    {
        yield 'binary value' => [
            'value' => '1100',
            'expected' => 12,
        ];

        yield 'long binary value' => [
            'value' => '111111111111111111111111111111111111111111111111111111111111110',
            'expected' => 9223372036854775806,
        ];

        yield 'longer binary value' => [
            'value' => '1111111111111111111111111111111111111111111111111111111111111111',
            'expected' => 0,
        ];

        yield 'smallest unsigned binary value' => [
            'value' => '0',
            'expected' => 0,
        ];
    }
}
