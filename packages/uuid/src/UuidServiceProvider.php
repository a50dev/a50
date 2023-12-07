<?php

declare(strict_types=1);

namespace A50\Uuid;

use A50\Container\ServiceProvider;

final class UuidServiceProvider implements ServiceProvider
{
    public static function getDefinitions(): array
    {
        return [
            UuidProvider::class => static fn () => new UuidV7Provider(),
        ];
    }

    public static function getExtensions(): array
    {
        return [];
    }
}
