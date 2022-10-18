<?php

declare(strict_types=1);

use BitOps\Boolean;

/** @psalm-suppress MissingFile */
require __DIR__ . '/../vendor/autoload.php';

$methodResults = [
    true,
    false,
];

$true = Boolean::isAtLeastOneTrue($methodResults);
$false = Boolean::areAllTrue($methodResults);

echo 'Test values' . PHP_EOL;
print_r($methodResults);
echo PHP_EOL;

echo 'Is at least one true? ';
echo $true ? 'true' : 'false';
echo PHP_EOL;

echo 'Are all true? ';
echo $false ? 'true' : 'false';
echo PHP_EOL;
