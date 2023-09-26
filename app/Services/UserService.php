<?php

namespace App\Services;

use App\Models\User;
use Core\Domain\Repositories\UserRepositoryInterface;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $repository
    ){}

    public function findAll(string $filter = '', $order = 'DESC'): array
    {
        return $this->repository->findAll($filter, $order);
    }

    public function paginate(string $filter = '', $order = 'DESC', $page = 1, $totalPerPage = 15): object
    {
        return $this->repository->paginate($filter, $order, $page, $totalPerPage);
    }

    public function store(array $input): User
    {
        return $this->repository->store($input);
    }

    public function findById(string $id)
    {
        return $this->repository->findById($id);
    }

    public function update(string $id, array $input): User
    {
        return $this->repository->update($id, $input);
    }

    public function destroy(string $id): bool
    {
        return $this->repository->delete($id);
    }
}