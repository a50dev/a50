<?php

declare(strict_types=1);

namespace A50\Telegram\Application\SetBotWebhook;

use A50\Telegram\Application\Bot\Telegram;
use A50\Telegram\Domain\Telegram\WebhookUrl;

final class SetBotWebhookHandler
{
    public function __construct(private Telegram $telegram)
    {
    }

    public function __invoke(SetBotWebhookCommand $command): void
    {
        $this->telegram->setWebhook(
            WebhookUrl::fromString($command->url)
        );
    }
}
