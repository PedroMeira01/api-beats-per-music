<?php

namespace Core\Domain\Repositories;

use Illuminate\Database\Eloquent\Model;

interface EntityRepositoryInterface
{
    public function findAll(string $filter = '', $order = 'DESC'): array;
    public function findById(string $id): Model;
    public function paginate(string $filter = '', $order = 'DESC', int $page = 1, int $totalPerPage = 15): object;
    public function store(array $input): object|array;
    public function update(string $id, $input): Model;
    public function delete(string $id): bool;
}
