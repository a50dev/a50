<?php

declare(strict_types=1);

namespace A50\Telegram\Domain\Telegram;

use Webmozart\Assert\Assert;

final class Text
{
    private function __construct(private string $text)
    {
        Assert::notEmpty($text);
    }

    public static function fromString(string $text): self
    {
        return new self($text);
    }

    public function asString(): string
    {
        return $this->text;
    }
}
