<?php

declare(strict_types=1);

namespace A50\Database;

interface Id
{
    public static function fromString(string $value): self;

    public function asString(): string;
}
