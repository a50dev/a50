<?php

declare(strict_types=1);

namespace A50\Telegram\UI\Bot\Command;

use TelegramBot\Api\Types\Message;

interface BotCommand
{
    public function __invoke(Message $message): void;

    public static function name(): string;

    public static function description(): string;
}
