<?php

declare(strict_types=1);

namespace BitOps\Tests;

use BitOps\BinaryClock;
use PHPUnit\Framework\TestCase;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @psalm-suppress UnusedClass
 * @psalm-suppress MissingThrowsDocblock
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
class BinaryClockTest extends TestCase
{
    private BinaryClock $clock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->clock = new BinaryClock();
    }

    /**
     * @dataProvider getTimeData
     * @param array<string,array<string,string>> $expected
     */
    final public function testGetTime(string $initialTime, array $expected): void
    {
        /** @var int $time */
        $time = strtotime($initialTime);

        $this->clock->setTime($time);
        $timings = $this->clock->getTime();

        self::assertSame($expected, $timings);
    }

    /**
     * @return iterable<string,array<string,string|array<string,string>>>
     */
    public function getTimeData(): iterable
    {
        yield 'in between' => [
            'initialTime' => '09:47:33',
            'expected' => [
                'hour' => '1001',
                'minute' => '101111',
                'second' => '100001',
            ],
        ];

        yield 'before eight' => [
            'initialTime' => '07:59:59',
            'expected' => [
                'hour' => '111',
                'minute' => '111011',
                'second' => '111011',
            ],
        ];

        yield 'before the maximum seconds' => [
            'initialTime' => '03:58:58',
            'expected' => [
                'hour' => '11',
                'minute' => '111010',
                'second' => '111010',
            ],
        ];

        yield 'before the maximum minutes' => [
            'initialTime' => '03:58:59',
            'expected' => [
                'hour' => '11',
                'minute' => '111010',
                'second' => '111011',
            ],
        ];

        yield 'before 12:00' => [
            'initialTime' => '11:59:59',
            'expected' => [
                'hour' => '1011',
                'minute' => '111011',
                'second' => '111011',
            ],
        ];

        yield 'at 12:00' => [
            'initialTime' => '12:00:00',
            'expected' => [
                'hour' => '1100',
                'minute' => '0',
                'second' => '0',
            ],
        ];

        yield 'before 1:00' => [
            'initialTime' => '12:59:59',
            'expected' => [
                'hour' => '1100',
                'minute' => '111011',
                'second' => '111011',
            ],
        ];
    }

    /**
     * @dataProvider incrementTimeData
     *
     * @param array<string, string> $expected
     */
    final public function testIncrementTime(string $initialTime, array $expected): void
    {
        /** @var int $time */
        $time = strtotime($initialTime);

        $this->clock->setTime($time);
        $this->clock->incrementTime();
        $timings = $this->clock->getTime();

        self::assertSame($expected, $timings);
    }

    /**
     * @return iterable<string,array<string,string|array<string,string>>>
     */
    final public function incrementTimeData(): iterable
    {
        yield 'in between' => [
            'initialTime' => '09:47:33',
            'expected' => [
                'hour' => '1001',
                'minute' => '101111',
                'second' => '100010',
            ],
        ];

        yield 'change seven to eight' => [
            'initialTime' => '07:59:59',
            'expected' => [
                'hour' => '1000',
                'minute' => '0',
                'second' => '0',
            ],
        ];

        yield 'before the maximum seconds' => [
            'initialTime' => '03:58:58',
            'expected' => [
                'hour' => '11',
                'minute' => '111010',
                'second' => '111011',
            ],
        ];

        yield 'before the maximum minutes' => [
            'initialTime' => '03:58:59',
            'expected' => [
                'hour' => '11',
                'minute' => '111011',
                'second' => '0',
            ],
        ];

        yield 'to 12:00' => [
            'initialTime' => '11:59:59',
            'expected' => [
                'hour' => '1100',
                'minute' => '0',
                'second' => '0',
            ],
        ];

        yield 'from 12:00' => [
            'initialTime' => '12:00:00',
            'expected' => [
                'hour' => '1100',
                'minute' => '0',
                'second' => '1',
            ],
        ];

        yield 'to 1:00' => [
            'initialTime' => '12:59:59',
            'expected' => [
                'hour' => '1',
                'minute' => '0',
                'second' => '0',
            ],
        ];
    }
}
