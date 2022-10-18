<?php

declare(strict_types=1);

namespace BitOps\Helpers;

/**
 * Binary operations
 */
class Binary
{
    /**
     * Gets the incremented binary value.
     *
     * The loop starts at 2 exp 0 (1) and moves to the left. The current bit
     * flips. A check breaks out of the loop as soon as a 0 flips to a 1. If the
     * flipped result is equivalent to 0, prepend a set bit to the value
     * (indicating the size increased by one and the value contained only set
     * bits at the start).
     */
    public static function increment(string $input): string
    {
        $value = $input;

        $inputLength = strlen($input);
        for ($i = $inputLength - 1; $i >= 0; --$i) {
            $flipped = 1 & ~ (int) $input[$i];
            $value[$i] = $flipped;
            if ($flipped === 1) {
                break;
            }
        }

        if (bindec($value) === 0) {
            $value = '1' . $value;
        }

        return $value;
    }
}
