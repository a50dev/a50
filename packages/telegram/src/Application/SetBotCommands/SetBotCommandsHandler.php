<?php

declare(strict_types=1);

namespace A50\Telegram\Application\SetBotCommands;

use A50\Telegram\Application\Bot\Telegram;
use A50\Telegram\Domain\Telegram\BotCommand;

final class SetBotCommandsHandler
{
    public function __construct(private Telegram $telegram)
    {
    }

    public function __invoke(SetBotCommandsCommand $command): void
    {
        $commands = [];

        foreach ($command->list as $name => $description) {
            $commands[] = BotCommand::create($name, $description);
        }

        $this->telegram->setMyCommands($commands);
    }
}
