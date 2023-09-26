<?php

namespace App\Services;

use Core\Domain\Repositories\ProductRepositoryInterface;

class ProductService {
    public function __construct(
        protected ProductRepositoryInterface $repository
    ){}

    public function paginate(string $filter = '', string $order = 'DESC', int $page = 1, int $totalPerPage = 15)
    {
        return $this->repository->paginate($filter, $order, $page, $totalPerPage);
    }

    public function findById(string $id)
    {
        return $this->repository->findById($id);
    }

    public function store(array $input)
    {
        return $this->repository->store($input);
    }

    public function update(string $id, array $input)
    {
        return $this->repository->update($id, $input);
    }

    public function delete(string $id)
    {
        return $this->repository->delete($id);
    }
}