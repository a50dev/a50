<?php

declare(strict_types=1);

namespace A50\Database\Repository;

interface ObjectRepository
{
    public function save(array $data): void;

    public function updateBy(array $data, array $criteria): void;

    public function updateOneById(array $data, string $id): void;

    public function deleteBy(array $criteria): void;

    public function deleteOneById(string $id): void;

    public function deleteManyByIds(array $ids): void;
}
