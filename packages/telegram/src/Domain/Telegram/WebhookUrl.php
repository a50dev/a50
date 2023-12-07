<?php

declare(strict_types=1);

namespace A50\Telegram\Domain\Telegram;

use Webmozart\Assert\Assert;

final class WebhookUrl
{
    private string $url;

    private function __construct(string $url)
    {
        Assert::notEmpty(\trim($url));
        $this->url = \trim($url);
    }

    public static function fromString(string $url): self
    {
        return new self($url);
    }

    public function asString(): string
    {
        return $this->url;
    }
}
