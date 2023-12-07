<?php

declare(strict_types=1);

namespace A50\Clock;

use DateTimeImmutable;
use Psr\Clock\ClockInterface;

final class FrozenClock implements ClockInterface
{
    private DateTimeImmutable $now;

    public function __construct(DateTimeImmutable $now)
    {
        $this->now = $now;
    }

    public function now(): DateTimeImmutable
    {
        return $this->now;
    }
}
