<?php

namespace App\Repositories\Contracts;

interface RepositoryInterface
{
    public function all();
    public function find(int $id);
    public function findWhere(string $column, string $value);
    public function findWhereFirst(string $column, string $value);
    public function paginate(int $perPage = 10);
    public function create(array $properties);
    public function update(int $id, array $properties);
    public function delete(int $id);
}