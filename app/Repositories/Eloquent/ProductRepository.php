<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use Core\Domain\Exceptions\NotFoundException;
use Core\Domain\Repositories\ProductRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;

class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(
        protected Product $model
    ){}
    
    public function findAll(string $filter = '', $order = 'DESC'): array
    {
        $foundProducts = $this->model
                            ->where(function ($query) use ($filter) {
                                if ($filter) {
                                    $query->where('name', 'LIKE', "%{$filter}%");
                                }
                            })
                            ->orderBy('name')
                            ->get();

        return $foundProducts->toArray();
    }

    public function findById(string $id): Model
    {
        if (!$foundProduct = $this->model->find($id)) {
            throw new NotFoundException("Product {$id} not found.");
        }

        return $foundProduct;
    }

    public function paginate(string $filter = '', $order = 'DESC', int $page = 1, int $totalPerPage = 15): object
    {
        $foundProducts = $this->model
                                ->where(function ($query) use ($filter) {
                                    if ($filter) {
                                        $query->where('name', 'LIKE', "%{$filter}%");
                                    }
                                })
                                ->orderBy('name')
                                ->paginate($totalPerPage);

        return $foundProducts;
    }

    public function store($input): Model
    {
        $createdProduct = $this->model->create([
            'name' => $input['name'],
            'description' => $input['description'],
            'price' => $input['price'],
            'sale_price' => $input['salePrice'],
            'available_quantity' => $input['availableQuantity'],
            'store_id' => $input['storeId']
        ]);

        return $createdProduct;
    }

    public function update(string $id, $input): Model
    {
        if (!$foundProduct = $this->model->find($id)) {
            throw new NotFoundException("Product {$id} not found.");
        }

        $foundProduct->update([
            'name' => $input['name'],
            'description' => $input['description'],
            'price' => $input['price'],
            'sale_price' => $input['salePrice'],
            'available_quantity' => $input['availableQuantity'],
        ]);

        return $foundProduct->refresh();
    }

    public function delete(string $id): bool
    {
        if (!$foundProduct = $this->model->find($id)) {
            throw new NotFoundException("Product {$id} not found.");
        }

        return $foundProduct->delete();
    }

}