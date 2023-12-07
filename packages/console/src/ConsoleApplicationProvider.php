<?php

declare(strict_types=1);

namespace A50\Console;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use A50\Container\ServiceProvider;

final class ConsoleApplicationProvider implements ServiceProvider
{
    public static function getDefinitions(): array
    {
        return [
            ConsoleConfig::class => static fn () => ConsoleConfig::withDefaults(),
            Application::class => static function (ContainerInterface $container): Application {
                /** @var ConsoleConfig $config */
                $config = $container->get(ConsoleConfig::class);
                $commands = [];

                foreach ($config->commands() as $commandClassName) {
                    /** @var Command $command */
                    $command = $container->get($commandClassName);
                    $commands[] = $command;
                }

                return new ConsoleApplication(
                    $config->appName(),
                    $config->catchExceptions(),
                    $commands,
                );
            },
        ];
    }

    public static function getExtensions(): array
    {
        return [];
    }
}
