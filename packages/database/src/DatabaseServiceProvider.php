<?php

declare(strict_types=1);

namespace A50\Database;

use A50\Container\ServiceProvider;
use A50\Database\Event\AfterMigrate;
use A50\Database\Event\BeforeMigrate;
use A50\EventDispatcher\EventDispatcherConfig;
use A50\EventDispatcher\NullableEventListener;

final class DatabaseServiceProvider implements ServiceProvider
{
    public static function getDefinitions(): array
    {
        return [
            DatabaseConfig::class => static fn () => DatabaseConfig::withDefaults(),
            MigrationsConfig::class => static fn () => MigrationsConfig::withDefaults(),
        ];
    }

    public static function getExtensions(): array
    {
        return [
            EventDispatcherConfig::class => static function (
                EventDispatcherConfig $config
            ) {
                return $config
                    ->withEventListener(
                        BeforeMigrate::class,
                        NullableEventListener::class
                    )
                    ->withEventListener(
                        AfterMigrate::class,
                        NullableEventListener::class
                    );
            },
        ];
    }
}
