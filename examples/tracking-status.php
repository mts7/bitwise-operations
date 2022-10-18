<?php

declare(strict_types=1);

use BitOps\Constants\UserStatus;
use BitOps\User;

/** @psalm-suppress MissingFile */
require __DIR__ . '/../vendor/autoload.php';

$constants = UserStatus::getConstants();
echo 'all status values: ' . PHP_EOL;
print_r($constants);
echo PHP_EOL;

$user = new User();
$status = $user->getStatusName();
echo "initial status: {$status}" . PHP_EOL;

$user->increaseStatus();
$status = $user->getStatusName();
echo "increase status: {$status}" . PHP_EOL;

$user->setStatus(UserStatus::REGULAR);
$status = $user->getStatusName();
echo "set status to regular: {$status}" . PHP_EOL;

$user->decreaseStatus();
$status = $user->getStatusName();
echo "decrease status: {$status}" . PHP_EOL;
