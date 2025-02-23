<?php

declare(strict_types=1);

namespace A50\Database\Repository;

use A50\Database\Id;

interface MapperRepository
{
    public function save(object $entity): void;

    public function updateBy(object $entity, array $criteria, ?array $fields = null): void;

    public function updateOneById(object $entity, Id $id, ?array $fields = null): void;

    public function deleteBy(array $criteria): void;

    public function deleteOneById(Id $id): void;

    public function deleteManyByIds(array $ids): void;

    public function findAll(?array $select = null, ?array $orderBy = null): ?array;

    public function findBy(array $criteria, ?array $select = null, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): ?array;

    public function findOneBy(array $criteria, ?array $select = null): ?object;

    public function findOneById(Id $id, ?array $select = null): ?object;

    public function count(?array $criteria = null): int;

    public function getBy(array $criteria, ?array $select = null, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): array;

    public function getOneBy(array $criteria, ?array $select = null, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): object;

    public function getOneById(Id $id, ?array $select = null): object;

    public function existsBy(array $criteria): bool;
}
