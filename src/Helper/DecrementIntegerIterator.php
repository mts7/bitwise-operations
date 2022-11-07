<?php

declare(strict_types=1);

namespace BitOps\Helper;

use Iterator;

/**
 * This iterator replaces the standard decrementing for loop.
 *
 * The key and current (value) are the same.
 * Example usage:
 *      $iterator = new DecrementIntegerIterator($iterations);
 *      foreach ($iterator as $key => $value) {
 *          echo "{$key} => {$value}" . PHP_EOL;
 *      }
 *
 * @implements \Iterator<int>
 */
class DecrementIntegerIterator implements Iterator
{
    private int $iterations;

    private int $pointer;

    public function __construct(int $iterations)
    {
        $this->iterations = $iterations;
        $this->pointer = $iterations;
    }

    public function current(): int
    {
        return $this->pointer;
    }

    public function key(): int
    {
        return $this->pointer;
    }

    public function next(): void
    {
        --$this->pointer;
    }

    public function rewind(): void
    {
        $this->pointer = $this->iterations;
    }

    public function valid(): bool
    {
        return $this->pointer > 0;
    }
}
