<?php

namespace Core\Domain\Repositories;

use Illuminate\Database\Eloquent\Model;

interface OrderRepositoryInterface {
    public function findAllByUser(string $userId, string $filter = '', $order = 'DESC'): array;
    public function findById(string $id): Model;
    public function paginateByUser(string $filter = '', $order = 'DESC', int $page = 1, int $totalPerPage = 15): object;
    public function register(array $input): object|array;
    public function cancel(string $id, string $userId): Model;
}