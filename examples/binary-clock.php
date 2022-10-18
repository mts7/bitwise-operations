<?php

declare(strict_types=1);

use BitOps\BinaryClock;

/** @psalm-suppress MissingFile */
require __DIR__ . '/../vendor/autoload.php';

$clock = new BinaryClock();
$clock->setTime();

// WARNING! The below code will execute forever unless manually stopped or an error occurs.
while (1) {
    sleep(1);
    $clock->incrementTime();
    $time = $clock->getTime();
    echo implode(':', $time) . PHP_EOL;
}
