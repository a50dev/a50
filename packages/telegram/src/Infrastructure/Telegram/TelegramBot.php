<?php

declare(strict_types=1);

namespace A50\Telegram\Infrastructure\Telegram;

use TelegramBot\Api\BotApi;
use TelegramBot\Api\Exception;
use TelegramBot\Api\HttpException;
use TelegramBot\Api\InvalidJsonException;
use A50\Telegram\Application\Bot\Telegram;
use A50\Telegram\Domain\Telegram\BotCommand;
use A50\Telegram\Domain\Telegram\Message;
use A50\Telegram\Domain\Telegram\WebhookUrl;

final class TelegramBot implements Telegram
{
    public function __construct(private BotApi $bot)
    {
    }

    public function sendMessage(Message $message): void
    {
        $this->bot->sendMessage(
            $message->chatId()->asString(),
            $message->text()->asString(),
            $message->parseMode(),
            false,
            null,
            null,
            $message->isSilent(),
        );
    }

    /**
     * @throws Exception
     */
    public function setWebhook(WebhookUrl $url): void
    {
        $this->bot->setWebhook($url->asString());
    }

    /**
     * @param BotCommand[] $commands
     * @throws Exception
     * @throws HttpException
     * @throws InvalidJsonException
     */
    public function setMyCommands(array $commands): void
    {
        $list = [];
        foreach ($commands as $command) {
            $list[] = $command->asArray();
        }
        $this->bot->setMyCommands($list);
    }
}
