<?php

declare(strict_types=1);

namespace A50\Telegram\UI\Bot\Command;

use TelegramBot\Api\BotApi;
use TelegramBot\Api\Exception;
use TelegramBot\Api\InvalidArgumentException;
use TelegramBot\Api\Types\Message;

final class PingBotCommand implements BotCommand
{
    public const NAME = 'ping';
    public const DESCRIPTION = 'Чтобы убедиться, что бот работает';

    private BotApi $bot;

    public function __construct(BotApi $bot)
    {
        $this->bot = $bot;
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function __invoke(Message $message): void
    {
        $chatId = $message->getChat()->getId();
        $this->bot->sendMessage($chatId, 'pong!');
    }

    public static function name(): string
    {
        return self::NAME;
    }

    public static function description(): string
    {
        return self::DESCRIPTION;
    }
}
