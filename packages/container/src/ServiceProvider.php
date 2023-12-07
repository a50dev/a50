<?php

declare(strict_types=1);

namespace A50\Container;

interface ServiceProvider
{
    /**
     * @return array<class-string|string, callable|string>
     */
    public static function getDefinitions(): array;

    /**
     * @return array<class-string|string, callable>
     */
    public static function getExtensions(): array;
}
