<?php

namespace App\Repositories\Eloquent;

use App\Models\User as UserModel;
use Core\Domain\Repositories\UserRepositoryInterface;
use Exception;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        protected UserModel $model
    ){}

    public function findAll(string $filter = '', $order = 'DESC'): array
    {
        $foundUsers = $this->model
                        ->where(function ($query) use ($filter) {
                            if ($filter) {
                                $query->where('name', 'LIKE', "%{$filter}%");
                            }
                        })
                        ->orderBy('name', $order)
                        ->get();

        return $foundUsers->toArray();
    }

    public function findById(string $id): UserModel
    {
        if (!$foundUser = $this->model->find($id)) {
            throw new Exception("User {$id} not found");
        }
        
        return $foundUser;
    }

    public function paginate(string $filter = '', $order = 'DESC', int $page = 1, int $totalPerPage = 15): object
    {
        $foundUsers = $this->model
                        ->where(function ($query) use ($filter) {
                            if ($filter) {
                                $query->where('name', 'LIKE', "%{$filter}%");
                            }
                        })
                        ->orderBy('name', $order)
                        ->paginate($totalPerPage);

        return $foundUsers;
    }

    public function store($input): UserModel
    {

        $createdUser = $this->model->create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password']
        ]);

        return $createdUser;
    }

    public function update(string $id, $input): UserModel
    {
        if (!$foundUser = $this->model->find($id)) {
            throw new Exception("User {$id} not found.");
        }

        $foundUser->update([
            'name' => $input['name'],
            'email' => $input['email']
        ]);

        return $foundUser->refresh();
    }

    public function delete(string $id): bool
    {
        if (!$foundUser = $this->model->find($id)) {
            throw new Exception("User {$id} not found.");
        }

        return $foundUser->delete();
    }
}