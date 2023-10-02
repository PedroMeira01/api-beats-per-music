<?php

namespace App\Repositories\Eloquent;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Core\Domain\Exceptions\NotFoundException;
use Core\Domain\Repositories\OrderRepositoryInterface;
use Core\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class OrderRepository implements OrderRepositoryInterface {
    public function __construct(
        protected Order $model,
        protected Address $addressModel,
        protected UserRepositoryInterface $userRepository,
        protected OrderItem $modelOrderItems
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

    public function store($input): object|array
    {
        $address = $this->validateOrderAddress($input['delivery_address'], $input['user_id']);

        $createdOrder = $this->model->create([
            'user_id' => $input['user_id'],
            'payment_type' => $input['payment_type'],
            'total_order' => $input['total_order'],
            'tracking_code' => $input['tracking_code'],
            'delivery_address_id' => $address['id']
        ]);

        $this->storeOrderItems($createdOrder, $input['items']);

        return $createdOrder
                ->with('items', 'user.addresses')
                ->get();
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

    public function validateOrderAddress($address, $userId): array
    {

        if (!$foundUser = $this->userRepository->findById($userId)) {
            throw new NotFoundException("User {$userId} not found.");
        }
        
        if (!isset($address['id'])) {
            $address = $foundUser->addresses()->create([
                'street' => $address['street'],
                'number' => $address['number'],
                'add_on' => $address['addOn'],
                'zip_code' => $address['zipCode'],
                'neighborhood' => $address['neighborhood'],
                'city' => $address['city'],
                'state' => $address['state']
            ])->toArray();
        }

        return $address;
    }

    public function storeOrderItems($order, $items)
    {
        $orderItems = [];
        foreach ($items as $item) {
            $orderItems[] = $order->items()->create([
                'product_id' => $item['productId'],
                'order_id' => $order['id'],
                'quantity' => $item['quantity'],
                'unitPurchasePrice' => $item['unitPurchasePrice'],
                'subtotal' => $item['subtotal'],
                'discount' => $item['discount'],
                'total' => $item['total']
            ]);
        }

        return $orderItems;
    }

}   