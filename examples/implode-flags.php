<?php

declare(strict_types=1);

use BitOps\Helpers\ArrayHelper;

/** @psalm-suppress MissingFile */
require __DIR__ . '/../vendor/autoload.php';

$arrayHelper = new ArrayHelper();

$foodColors = [
    'apple' => 'golden',
    'banana' => 'yellow',
    'cherry' => 'red',
    'date' => 'tan',
    'eggplant' => 'purple',
    'fig' => 'white',
    'grape' => 'black',
    'honeydew' => 'green',
];

echo 'array: ' . print_r($foodColors, true) . PHP_EOL;

echo 'implode (default): ' . $arrayHelper->implode(', ', $foodColors) . PHP_EOL;
echo 'implode (and): ' . $arrayHelper->implode(', ', $foodColors, ArrayHelper::IMPLODE_AND) . PHP_EOL;
echo 'implode (assoc): ' . $arrayHelper->implode(', ', $foodColors, ArrayHelper::IMPLODE_ASSOC, ' is ') . PHP_EOL;
echo 'implode (and with assoc): ' . $arrayHelper->implode(', ', $foodColors, ArrayHelper::IMPLODE_AND | ArrayHelper::IMPLODE_ASSOC, ' is ') . PHP_EOL;
