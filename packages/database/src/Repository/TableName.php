<?php

declare(strict_types=1);

namespace A50\Database\Repository;

interface TableName extends \BackedEnum
{
    public function quoted(): string;
}
