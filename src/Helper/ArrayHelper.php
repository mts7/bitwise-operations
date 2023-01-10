<?php

declare(strict_types=1);

namespace BitOps\Helper;

/**
 * Helper class for array functions.
 */
class ArrayHelper
{
    public const CONJUNCTION = 'and ';
    public const IMPLODE_ASSOC = 2 >> 1;
    public const IMPLODE_AND = 2 << 0;

    /**
     * Implodes an array to a string using the provided separator.
     *
     * This reimplements the built-in PHP function `implode`, yet it differs
     * in that it can also add the word `and` before the last element and/or
     * include keys with the values by providing configuration options.
     *
     * @param array<string|int,mixed> $array
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function implode(string $separator, array $array, int $options = 0, string $arraySeparator = ' => '): string
    {
        $output = '';
        $lastKey = array_key_last($array);
        foreach ($array as $key => $value) {
            if (!is_scalar($value)) {
                if (is_array($value)) {
                    $output .= $this->implode($separator, $value, $options, $arraySeparator) . $separator;
                }
                continue;
            }
            $output .= ($key === $lastKey) && Bitwise::isSet($options, self::IMPLODE_AND) ? self::CONJUNCTION : '';
            $output .= Bitwise::isSet($options, self::IMPLODE_ASSOC) ? $key . $arraySeparator : '';
            $output .= $value . $separator;
        }

        return rtrim($output, $separator);
    }
}
