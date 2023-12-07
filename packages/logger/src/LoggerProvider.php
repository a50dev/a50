<?php

declare(strict_types=1);

namespace A50\Logger;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use A50\Container\ServiceProvider;

final class LoggerProvider implements ServiceProvider
{
    public static function getDefinitions(): array
    {
        return [
            LoggerConfig::class => static fn () => LoggerConfig::withDefaults(),
            LoggerInterface::class => static function (ContainerInterface $container) {
                /** @var LoggerConfig $config */
                $config = $container->get(LoggerConfig::class);

                $level = $config->debug() ? Level::Debug : Level::Info;

                $monolog = new Logger($config->name());

                if ($config->stderr()) {
                    $monolog->pushHandler(new StreamHandler('php://stderr', $level));
                }

                if (!empty($config->file())) {
                    $monolog->pushHandler(new StreamHandler($config->file(), $level));
                }

                return $monolog;
            },
        ];
    }

    public static function getExtensions(): array
    {
        return [];
    }
}
