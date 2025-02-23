<?php

declare(strict_types=1);

namespace A50\Database\Repository;

interface SelectRepository
{
    public function findAll(?array $select = null, ?array $orderBy = null): ?array;

    public function findBy(array $criteria, ?array $select = null, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): ?array;

    public function findOneBy(array $criteria, ?array $select = null): ?array;

    public function findOneById(string $id, ?array $select = null): ?array;

    public function count(?array $criteria = null): int;

    public function getBy(array $criteria, ?array $select = null, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): array;

    public function getOneBy(array $criteria, ?array $select = null, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): array;

    public function getOneById(string $id, ?array $select = null): array;

    public function existsBy(array $criteria): bool;
}
