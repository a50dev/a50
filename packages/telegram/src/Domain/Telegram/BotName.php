<?php

declare(strict_types=1);

namespace A50\Telegram\Domain\Telegram;

use Webmozart\Assert\Assert;

final class BotName
{
    private string $botName;

    private function __construct(string $botName)
    {
        Assert::notEmpty(\trim($botName));
        $this->botName = \trim($botName);
    }

    public static function fromString(string $botName): self
    {
        return new self($botName);
    }

    public function asString(): string
    {
        return $this->botName;
    }
}
