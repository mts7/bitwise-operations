<?php

declare(strict_types=1);

namespace BitOps;

use BitOps\Helpers\Binary;
use BitOps\Helpers\Convert;

/**
 * A simple binary clock class.
 */
class BinaryClock
{
    public const MAXIMUM_SECONDS = 59;
    public const MAXIMUM_MINUTES = 59;
    public const MAXIMUM_HOURS = 12;

    /**
     * @var string[]|array<string,string>
     */
    private array $binaryTime = [];

    /**
     * Sets the binary time based on the integer provided or current time.
     */
    public function setTime(?int $time = null): void
    {
        [$hours, $minutes, $seconds] = explode(':', date('h:i:s', $time ?? time()));
        $this->binaryTime = [
            'hour' => Convert::stringIntegerToBinary($hours),
            'minute' => Convert::stringIntegerToBinary($minutes),
            'second' => Convert::stringIntegerToBinary($seconds),
        ];
    }

    /**
     * Gets the binary time.
     *
     * @return array<array-key, string>
     */
    public function getTime(): array
    {
        return $this->binaryTime;
    }

    /**
     * Increments time by one second, including minutes and hours.
     */
    public function incrementTime(): void
    {
        $seconds = Convert::binaryToInteger(Binary::increment($this->binaryTime['second']));
        $minutes = Convert::binaryToInteger($this->binaryTime['minute']);
        $hours = Convert::binaryToInteger($this->binaryTime['hour']);
        [$hours, $minutes, $seconds] = $this->incrementMaximums($hours, $minutes, $seconds);
        /** @var int $time */
        $time = strtotime("{$hours}:{$minutes}:{$seconds}");
        $this->setTime($time);
    }

    /**
     * Checks for maximum values, based on constants, and returns values.
     *
     * Since there are three parts of time (hours, minutes, and seconds), each
     * part has a check for greater than the maximum (as defined in the
     * constants). If the check passes, any smaller time parts are reset to 0
     * and that part increments. This could cause a chain reaction if something
     * like 11:59:59 was passed, which would cause seconds to increment minutes,
     * which then leads minutes to increment hours. Maximum hours should be 12
     * since there is no handling for 24-hour clocks at this point.
     *
     * @return int[]
     */
    private function incrementMaximums(int $hours, int $minutes, int $seconds): array
    {
        if ($seconds > self::MAXIMUM_SECONDS) {
            $seconds = 0;
            $minutes = Convert::binaryToInteger(Binary::increment($this->binaryTime['minute']));
        }
        if ($minutes > self::MAXIMUM_MINUTES) {
            $seconds = 0;
            $minutes = 0;
            $hours = Convert::binaryToInteger(Binary::increment($this->binaryTime['hour']));
        }
        if ($hours > self::MAXIMUM_HOURS) {
            $seconds = 0;
            $minutes = 0;
            $hours = Convert::binaryToInteger(Binary::increment('0'));
        }

        return [$hours, $minutes, $seconds];
    }
}
