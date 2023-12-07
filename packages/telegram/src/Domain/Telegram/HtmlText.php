<?php

declare(strict_types=1);

namespace A50\Telegram\Domain\Telegram;

use Webmozart\Assert\Assert;

final class HtmlText
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
        $stripped = \strip_tags($this->text, [
            'b', 'strong', 'i', 'em', 'u', 'ins', 's', 'strike', 'del',
            'a', 'code', 'pre',
        ]);

        return \str_replace('&nbsp;', '', $stripped);
    }
}
