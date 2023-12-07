<?php

declare(strict_types=1);

namespace A50\Telegram\Application\Bot;

use A50\Telegram\Domain\Telegram\Message;
use A50\Telegram\Domain\Telegram\WebhookUrl;
use A50\Telegram\UI\Bot\Command\BotCommand;

interface Telegram
{
    public function sendMessage(Message $message): void;

    /**
     * @param BotCommand[] $commands
     */
    public function setMyCommands(array $commands): void;

    public function setWebhook(WebhookUrl $url): void;
}
