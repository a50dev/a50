<?php

declare(strict_types=1);

namespace A50\Database\Repository;

interface DatabaseRepositoryFactory
{
    public function createSelectRepository(TableName $tableName, bool $withCamelCase = false): SelectRepository;

    public function createObjectRepository(TableName $tableName): ObjectRepository;
}
