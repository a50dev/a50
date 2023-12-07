<?php

declare(strict_types=1);

namespace A50\Clock;

use DateTimeZone;
use Exception;
use Webmozart\Assert\Assert;

final class ClockConfig
{
    private DateTimeZone $timezone;

    /**
     * @throws Exception
     */
    private function __construct(string $timezone)
    {
        Assert::inArray($timezone, DateTimeZone::listIdentifiers(DateTimeZone::ALL));
        $this->timezone = new DateTimeZone($timezone);
    }

    /**
     * @throws Exception
     */
    public static function withDefaults(
        string $timezone = 'UTC',
    ): self {
        return new self($timezone);
    }

    /**
     * @throws Exception
     */
    public function withTimezoneChanged(string $timezone): self
    {
        return new self($timezone);
    }

    public function timezone(): DateTimeZone
    {
        return $this->timezone;
    }
}
