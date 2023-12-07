<?php

declare(strict_types=1);

namespace A50\Container\Tests\Datasets\AutowireInterfaces;

use A50\Container\ServiceProvider;

final class CanAutowireInterfacesServiceProvider implements ServiceProvider
{
    public static function getDefinitions(): array
    {
        return [
            Foo::class => FooUsingBar::class,
        ];
    }

    public static function getExtensions(): array
    {
        return [];
    }
}
