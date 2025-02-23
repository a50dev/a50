<?php

declare(strict_types=1);

namespace A50\Mapper\Yii;

use A50\Database\Repository\DatabaseRepositoryFactory;
use A50\Database\Repository\MapperRepository;
use A50\Database\Repository\MapperRepositoryFactory;
use A50\Database\Repository\TableName;
use A50\Mapper\Hydrator;
use A50\Mapper\Serializer;

final readonly class YiiDBMapperRepositoryFactory implements MapperRepositoryFactory
{
    public function __construct(
        private Serializer $serializer,
        private Hydrator $hydrator,
        private DatabaseRepositoryFactory $repositoryFactory,
    )
    {
    }

    public function createMapperRepository(string $entityClassName, TableName $tableName): MapperRepository
    {
        return new YiiDBMapperRepository(
            $this->serializer,
            $this->repositoryFactory->createObjectRepository($tableName),
            $this->hydrator,
            $this->repositoryFactory->createSelectRepository($tableName),
            $entityClassName,
        );
    }
}
