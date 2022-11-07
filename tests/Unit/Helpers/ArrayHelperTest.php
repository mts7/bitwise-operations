<?php

declare(strict_types=1);

namespace BitOps\Tests\Unit\Helpers;

use BitOps\Helper\ArrayHelper;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @psalm-suppress UnusedClass
 * @psalm-suppress MissingThrowsDocblock
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
 */
final class ArrayHelperTest extends TestCase
{
    private ArrayHelper $fixture;

    protected function setUp(): void
    {
        parent::setUp();
        $this->fixture = new ArrayHelper();
    }

    /**
     * @dataProvider implodeData
     *
     * @param array<string,mixed> $array
     */
    public function testImplode(
        string $separator,
        array $array,
        int $options,
        string $arraySeparator,
        string $expected,
    ): void {
        $result = $this->fixture->implode($separator, $array, $options, $arraySeparator);

        self::assertSame($expected, $result, 'The imploded array does not match the expected string.');
    }

    /**
     * @return iterable<string, array<string,mixed>>
     */
    public function implodeData(): iterable
    {
        yield 'values with default functionality' => [
            'separator' => ', ',
            'array' => ['apple', 'banana', 'cucumber', 'date', 'eggplant', 'fig', 'grape', 'honeydew'],
            'options' => 0,
            'arraySeparator' => ' => ',
            'expected' => 'apple, banana, cucumber, date, eggplant, fig, grape, honeydew',
        ];

        yield 'keys and values with default functionality' => [
            'separator' => ', ',
            'array' => [
                'apple' => 'red',
                'banana' => 'yellow',
                'cucumber' => 'green',
                'date' => 'tan',
                'eggplant' => 'purple',
                'fig' => 'white',
                'grape' => 'red',
            ],
            'options' => 0,
            'arraySeparator' => ' => ',
            'expected' => 'red, yellow, green, tan, purple, white, red',
        ];

        yield 'values with AND functionality' => [
            'separator' => ', ',
            'array' => ['apple', 'banana', 'cucumber', 'date', 'eggplant', 'fig', 'grape', 'honeydew'],
            'options' => ArrayHelper::IMPLODE_AND,
            'arraySeparator' => ' => ',
            'expected' => 'apple, banana, cucumber, date, eggplant, fig, grape, and honeydew',
        ];

        yield 'keys and values with AND functionality' => [
            'separator' => ', ',
            'array' => [
                'apple' => 'red',
                'banana' => 'yellow',
                'cucumber' => 'green',
                'date' => 'tan',
                'eggplant' => 'purple',
                'fig' => 'white',
                'grape' => 'red',
            ],
            'options' => ArrayHelper::IMPLODE_AND,
            'arraySeparator' => ' => ',
            'expected' => 'red, yellow, green, tan, purple, white, and red',
        ];

        yield 'values with ASSOC functionality' => [
            'separator' => ', ',
            'array' => ['apple', 'banana', 'cucumber', 'date', 'eggplant', 'fig', 'grape', 'honeydew'],
            'options' => ArrayHelper::IMPLODE_ASSOC,
            'arraySeparator' => ' => ',
            'expected' =>
                '0 => apple, 1 => banana, 2 => cucumber, 3 => date, 4 => eggplant, 5 => fig, 6 => grape, 7 => honeydew',
        ];

        yield 'keys and values with ASSOC functionality' => [
            'separator' => ', ',
            'array' => [
                'apple' => 'red',
                'banana' => 'yellow',
                'cucumber' => 'green',
                'date' => 'tan',
                'eggplant' => 'purple',
                'fig' => 'white',
            ],
            'options' => ArrayHelper::IMPLODE_ASSOC,
            'arraySeparator' => ' is ',
            'expected' =>
                'apple is red, banana is yellow, cucumber is green, date is tan, eggplant is purple, fig is white',
        ];

        yield 'values with AND and ASSOC functionality' => [
            'separator' => ', ',
            'array' => ['apple', 'banana', 'cucumber', 'date', 'eggplant', 'fig', 'grape'],
            'options' => ArrayHelper::IMPLODE_AND | ArrayHelper::IMPLODE_ASSOC,
            'arraySeparator' => ' => ',
            'expected' =>
                '0 => apple, 1 => banana, 2 => cucumber, 3 => date, 4 => eggplant, 5 => fig, and 6 => grape',
        ];

        yield 'keys and values with AND and ASSOC functionality' => [
            'separator' => ', ',
            'array' => [
                'apple' => 'red',
                'banana' => 'yellow',
                'cucumber' => 'green',
                'date' => 'tan',
                'eggplant' => 'purple',
                'fig' => 'white',
            ],
            'options' => ArrayHelper::IMPLODE_AND | ArrayHelper::IMPLODE_ASSOC,
            'arraySeparator' => ' is ',
            'expected' =>
                'apple is red, banana is yellow, cucumber is green, date is tan, eggplant is purple, and fig is white',
        ];

        yield 'values with an array and default functionality' => [
            'separator' => ', ',
            'array' => ['apple', 'banana', ['cucumber', 'date', 'eggplant'], 'fig', 'grape'],
            'options' => 0,
            'arraySeparator' => ' => ',
            'expected' =>
                'apple, banana, cucumber, date, eggplant, fig, grape',
        ];

        yield 'values with an object and default functionality' => [
            'separator' => ', ',
            'array' => ['apple', 'banana', new stdClass(), 'fig', 'grape'],
            'options' => 0,
            'arraySeparator' => ' => ',
            'expected' =>
                'apple, banana, fig, grape',
        ];
    }

    public function testImplodeDefaultOptions(): void
    {
        $array = ['apple', 'banana', 'cucumber', 'date', 'eggplant', 'fig', 'grape', 'honeydew'];
        $separator = ', ';

        $result = $this->fixture->implode($separator, $array);

        self::assertSame(implode($separator, $array), $result);
    }
}
