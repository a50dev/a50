<?php

declare(strict_types=1);

namespace A50\Database\Repository;

interface MapperRepositoryFactory
{
    public function createMapperRepository(string $entityClassName, TableName $tableName): MapperRepository;
}
