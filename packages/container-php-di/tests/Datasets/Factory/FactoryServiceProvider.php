<?php

declare(strict_types=1);

namespace A50\Container\Tests\Datasets\Factory;

use A50\Container\ServiceProvider;

final class FactoryServiceProvider implements ServiceProvider
{
    public static function getDefinitions(): array
    {
        return [
            Foo::class => new FooFactory(),
        ];
    }

    public static function getExtensions(): array
    {
        return [];
    }
}
