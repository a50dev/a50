<?php

declare(strict_types=1);

namespace A50\Container\Tests\Datasets;

use A50\Container\ServiceProvider;

final class EmptyServiceProvider implements ServiceProvider
{
    public static function getDefinitions(): array
    {
        return [];
    }

    public static function getExtensions(): array
    {
        return [];
    }
}
