<?php

declare(strict_types=1);

namespace A50\Telegram\Domain\Telegram;

use Webmozart\Assert\Assert;

final class ChatName
{
    private string $name;

    private function __construct(string $name)
    {
        Assert::notEmpty(\trim($name));
        $this->name = \trim($name);
    }

    public static function fromString(string $name): self
    {
        return new self($name);
    }

    public function asString(): string
    {
        return $this->name;
    }
}
