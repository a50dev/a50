<?php

declare(strict_types=1);

namespace A50\Telegram;

use Closure;
use Psr\Container\ContainerInterface;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Client;
use A50\Console\ConsoleConfig;
use A50\Container\ServiceProvider;
use A50\Http\Router\Route;
use A50\Http\Router\RouterConfig;
use A50\Telegram\Application\Bot\Telegram;
use A50\Telegram\Application\SetBotCommands\SetBotCommandsHandler;
use A50\Telegram\Application\SetBotWebhook\SetBotWebhookHandler;
use A50\Telegram\Infrastructure\Telegram\TelegramBot;
use A50\Telegram\UI\Bot\Command\BotCommand;
use A50\Telegram\UI\Console\Telegram\SetCommands;
use A50\Telegram\UI\Console\Telegram\SetWebhookCommand;
use A50\Telegram\UI\Http\ListenTelegramBotAction;

final class TelegramServiceProvider implements ServiceProvider
{
    public static function getDefinitions(): array
    {
        return [
            Client::class => static function (ContainerInterface $container) {
                /** @var TelegramConfig $config */
                $config = $container->get(TelegramConfig::class);

                $bot = new Client($config->token());

                $commands = $config->commands();

                foreach ($commands as $callable) {
                    /** @var BotCommand $command */
                    $command = $container->get($callable);
                    $name = $command::name();

                    //Handle /$name command
                    $bot->command($name, Closure::fromCallable($command));
                }

                foreach ($config->listeners() as $listener) {
                    // Handle any messages
                    $bot->on(Closure::fromCallable($container->get($listener)), static fn () => true);
                }

                return $bot;
            },
            BotApi::class => static function (ContainerInterface $container) {
                /** @var TelegramConfig $config */
                $config = $container->get(TelegramConfig::class);

                return new BotApi($config->token());
            },
            SetCommands::class => static function (ContainerInterface $container) {
                /** @var TelegramConfig $config */
                $config = $container->get(TelegramConfig::class);
                $list = [];

                /** @var BotCommand $command */
                foreach ($config->commands() as $command) {
                    $name = $command::name();
                    $description = $command::description();

                    $list[$name] = $description;
                }

                /** @var SetBotCommandsHandler $config */
                $handler = $container->get(SetBotCommandsHandler::class);

                return new SetCommands($list, $handler);
            },
            SetWebhookCommand::class => static function (ContainerInterface $container) {
                /** @var SetBotWebhookHandler $config */
                $handler = $container->get(SetBotWebhookHandler::class);

                return new SetWebhookCommand($handler);
            },
            Telegram::class => static function (ContainerInterface $container) {
                $bot = $container->get(BotApi::class);

                return new TelegramBot($bot);
            },
            TelegramConfig::class => static fn () => TelegramConfig::withDefaults(),
        ];
    }

    public static function getExtensions(): array
    {
        return [
            ConsoleConfig::class => static function (ConsoleConfig $config) {
                return $config
                    ->withCommand(SetCommands::class)
                    ->withCommand(SetWebhookCommand::class);
            },
            RouterConfig::class => static function (RouterConfig $config, ContainerInterface $container) {
                /** @var TelegramConfig $telegramConfig */
                $telegramConfig = $container->get(TelegramConfig::class);

                return $config
                    ->withRoute(
                        Route::post('/bot/' . $telegramConfig->token() . '/listen', ListenTelegramBotAction::class)
                    );
            },
        ];
    }
}
