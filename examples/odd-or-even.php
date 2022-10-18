<?php

declare(strict_types=1);

use BitOps\Boolean;

/** @psalm-suppress MissingFile */
require __DIR__ . '/../vendor/autoload.php';

$value = 6;

$even = Boolean::isEven($value);
$odd = Boolean::isOdd($value);

echo "{$value} is even: " . ($even ? 'true' : 'false');
echo PHP_EOL;

echo "{$value} is even: " . ($odd ? 'true' : 'false');
echo PHP_EOL;
