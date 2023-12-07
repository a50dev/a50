<?php

declare(strict_types=1);

namespace A50\Telegram\Domain\Telegram;

use Webmozart\Assert\Assert;

final class ParseMode
{
    private const MARKDOWN = 'MarkdownV2';
    private const HTML = 'HTML';

    /**
     * @var string[]
     */
    private static array $possible = [
        self::MARKDOWN => 'Markdown',
        self::HTML => 'HTML',
    ];

    private string $name;
    private string $description;

    private function __construct(string $name, string $description)
    {
        Assert::notEmpty($name);
        Assert::inArray($name, \array_keys(self::$possible));
        Assert::notEmpty($description);
        $this->name = $name;
        $this->description = $description;
    }

    public static function markdown(): self
    {
        return self::fromString(self::MARKDOWN);
    }

    public static function html(): self
    {
        return self::fromString(self::HTML);
    }

    public static function fromString(string $name): self
    {
        $description = self::$possible[$name];

        return new self($name, $description);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }
}
