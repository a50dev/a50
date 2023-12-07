<?php

declare(strict_types=1);

namespace A50\Uuid;

interface UuidProvider
{
    /**
     * Return UUID string.
     */
    public static function next(): string;
}
