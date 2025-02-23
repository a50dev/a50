<?php

declare(strict_types=1);

namespace A50\Mapper;

use A50\Database\Repository\TableName;

enum Table: string implements TableName
{
    case USERS = 'users';

    public function quoted(): string
    {
        return '';
    }
}
