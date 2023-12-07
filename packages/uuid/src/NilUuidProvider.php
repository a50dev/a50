<?php

declare(strict_types=1);

namespace A50\Uuid;

use Ramsey\Uuid\Uuid;

final class NilUuidProvider implements UuidProvider
{
    public static function next(): string
    {
        return Uuid::NIL;
    }
}
