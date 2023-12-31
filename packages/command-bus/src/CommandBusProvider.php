<?php

declare(strict_types=1);

namespace A50\CommandBus;

use League\Tactician\CommandBus as LeagueTacticianCommandBus;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\Locator\InMemoryLocator;
use League\Tactician\Handler\MethodNameInflector\InvokeInflector;
use League\Tactician\Middleware;
use League\Tactician\Plugins\LockingMiddleware;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use A50\CommandBus\Tactician\Middleware\LoggingMiddleware;
use A50\CommandBus\Tactician\TacticianCommandBus;
use A50\Container\ServiceProvider;
use A50\Environment\CurrentEnvironment;
use A50\Environment\EnvironmentName;

final class CommandBusProvider implements ServiceProvider
{
    public static function getDefinitions(): array
    {
        return [
            CommandBusConfig::class => static fn (ContainerInterface $container)
                => CommandBusConfig::withDefaults(),
            LoggingMiddleware::class => static function (ContainerInterface $container) {
                /** @var LoggerInterface $logger */
                $logger = $container->get(LoggerInterface::class);

                return new LoggingMiddleware($logger);
            },
            CommandBus::class => static function (ContainerInterface $container) {
                /** @var CommandBusConfig $config */
                $config = $container->get(CommandBusConfig::class);
                $handlers = $config->handlersMap();

                // Choose our method name
                $inflector = new InvokeInflector();

                // Choose our locator and register our command
                $locator = new InMemoryLocator();
                foreach ($handlers as $commandClassName => $handlerClassName) {
                    /** @var object $handler */
                    $handler = $container->get($handlerClassName);
                    $locator->addHandler($handler, $commandClassName);
                }

                // Choose our Handler naming strategy
                $nameExtractor = new ClassNameExtractor();

                // Create the middleware that executes commands with Handlers
                $commandHandlerMiddleware = new CommandHandlerMiddleware($nameExtractor, $locator, $inflector);

                /** @var Middleware[] $middlewares */
                $middlewares = \array_map(static fn ($middlewareClassName) => $container->get($middlewareClassName), $config->middlewares());
                $tacticianCommandBus = new LeagueTacticianCommandBus(
                    \array_merge($middlewares, [
                        $commandHandlerMiddleware,
                    ])
                );

                return new TacticianCommandBus($tacticianCommandBus);
            },
        ];
    }

    public static function getExtensions(): array
    {
        return [];
    }
}
