<?php

declare(strict_types=1);

namespace A50\Telegram\Domain\Telegram;

use Webmozart\Assert\Assert;

final class MemberLimit
{
    private int $limit;

    private function __construct(int $limit)
    {
        Assert::greaterThanEq($limit, 1);
        Assert::lessThanEq($limit, 99999);
        $this->limit = $limit;
    }

    public static function fromInt(int $limit): self
    {
        return new self($limit);
    }

    public function asInt(): int
    {
        return $this->limit;
    }

    public function __toString(): string
    {
        return (string)$this->asInt();
    }
}
