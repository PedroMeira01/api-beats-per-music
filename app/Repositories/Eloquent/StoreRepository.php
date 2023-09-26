<?php

namespace App\Repositories\Eloquent;

use App\Models\Store;
use Core\Domain\Repositories\StoreRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;

class StoreRepository implements StoreRepositoryInterface
{
    public function __construct(
        protected Store $model
    ){}

    public function findAll(string $filter = '', $order = 'DESC'): array
    {
        $foundStores = $this->model
                        ->where(function ($query) use ($filter) {
                                if ($filter) {
                                    $query->where('name', 'LIKE', "%{$filter}%");
                                }
                        })
                        ->orderBy('name')
                        ->get();
                            
        return $foundStores->toArray();
    }

    public function findById(string $id): Model
    {
        if (!$foundStore = $this->model->find($id)) {
            throw new Exception("Store {$id} not found.");
        }

        return $foundStore;
    }

    public function paginate(string $filter = '', $order = 'DESC', int $page = 1, int $totalPerPage = 15): object
    {
        $foundStores = $this->model
                        ->where(function ($query) use ($filter) {
                            if ($filter) {
                                $query->where('name', 'LIKE', "%{$filter}%");
                            }
                        })
                        ->orderBy('name')
                        ->paginate($totalPerPage);
        
        return $foundStores;
    }

    public function store($input): Model
    {
        $createdStore = $this->model->create([
            'name' => $input['name'],
            'description' => $input['description'],
            'email' => $input['email'],
            'user_id' => $input['user_id']
        ]);

        return $createdStore;
    }

    public function update(string $id, $input): Model
    {
        if (!$foundStore = $this->model->find($id)) {
            throw new Exception("Store {$id} not found.");
        }

        $foundStore->update([
            'name' => $input['name'],
            'description' => $input['description'],
            'email' => $input['email']
        ]);

        return $foundStore->refresh();
    }

    public function delete(string $id): bool
    {
        if (!$foundStore = $this->model->find($id)) {
            throw new Exception("Store {$id} not found.");
        }

        return $foundStore->delete();
    }

}