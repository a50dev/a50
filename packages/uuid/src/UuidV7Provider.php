<?php

declare(strict_types=1);

namespace A50\Uuid;

use Ramsey\Uuid\Uuid;

final class UuidV7Provider implements UuidProvider
{
    public static function next(): string
    {
        return Uuid::uuid7()->toString();
    }
}
