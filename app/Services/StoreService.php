<?php

namespace App\Services;

use Core\Domain\Repositories\StoreRepositoryInterface;

class StoreService {
    public function __construct(
        protected StoreRepositoryInterface $repository
    ){}

    public function paginate(string $filter = '', string $order = 'DESC', int $page = 1, int $totalPerPage = 15)
    {
        return $this->repository->paginate($filter, $order, $page, $totalPerPage);
    }

    public function store(array $input)
    {
        return $this->repository->store($input);
    }

    public function delete(string $id)
    {
        return $this->repository->delete($id);
    }
}