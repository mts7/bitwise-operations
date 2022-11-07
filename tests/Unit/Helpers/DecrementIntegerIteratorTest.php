<?php

declare(strict_types=1);

namespace BitOps\Tests\Unit\Helpers;

use BitOps\Helper\DecrementIntegerIterator;
use PHPUnit\Framework\TestCase;

/**
 * @group helper
 *
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
final class DecrementIntegerIteratorTest extends TestCase
{
    public function testCurrent(): void
    {
        $iterations = 10;
        $fixture = $this->getIterator($iterations);
        $expected = $iterations;

        $actual = $fixture->current();

        $this->assertSame($expected, $actual, 'Current value does not match the number of iterations.');
    }

    public function testKey(): void
    {
        $iterations = 10;
        $fixture = $this->getIterator($iterations);
        $expected = $iterations;

        $actual = $fixture->key();

        $this->assertSame($expected, $actual, 'Key value does not match the number of iterations.');
    }

    public function testNext(): void
    {
        $iterations = 10;
        $fixture = $this->getIterator($iterations);
        $expected = $iterations - 1;

        $fixture->next();
        $actual = $fixture->key();

        $this->assertSame($expected, $actual, 'Next value does not match the number of iterations less one.');
    }

    public function testRewind(): void
    {
        $iterations = 5;
        $fixture = $this->getIterator($iterations);
        $expected = $iterations;

        $values = [];
        foreach ($fixture as $key => $value) {
            $values[$key] = $value;
        }
        $lastKey = $fixture->key();
        $fixture->rewind();
        $actual = $fixture->key();

        $this->assertSame($expected, $actual, 'Rewinding did not yield the number of iterations.');
        $this->assertCount($iterations, $values, "The loop did not iterate over {$iterations} values.");
        $this->assertSame(0, $lastKey, 'The last key is not zero.');
        $this->assertSame(
            array_values($values),
            array_keys($values),
            'There are differences between the keys and values.'
        );
    }

    public function testValid(): void
    {
        $iterations = 3;
        $fixture = $this->getIterator($iterations);

        $fixture->next();
        $fixture->next();
        $fixture->next();
        $fixture->next();
        $actual = $fixture->valid();

        $this->assertFalse($actual);
    }

    private function getIterator(int $iterations): DecrementIntegerIterator
    {
        return new DecrementIntegerIterator($iterations);
    }
}
