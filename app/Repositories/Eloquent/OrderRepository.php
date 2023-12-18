<?php

namespace App\Repositories\Eloquent;

use App\Enums\OrderStatus;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use Core\Domain\Exceptions\NotFoundException;
use Core\Domain\Repositories\OrderRepositoryInterface;
use Core\Domain\Repositories\UserRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderRepositoryInterface {
    public function __construct(
        protected Order $model,
        protected Address $addressModel,
        protected UserRepositoryInterface $userRepository,
        protected OrderItem $modelOrderItems
    ){}
    
    public function findAllByUser(string $userId, string $filter = '', $order = 'DESC'): array
    {
        $userId = 1;
        $foundProducts = $this->model
                            ->where('userId', $userId)
                            ->get();

        return $foundProducts->toArray();
    }

    public function findById(string $id): Model
    {
        if (!$foundOrder = $this->model->find($id)) {
            throw new NotFoundException("Product {$id} not found.");
        }

        return $foundOrder;
    }

    public function paginateByUser(string $filter = '', $order = 'DESC', int $page = 1, int $totalPerPage = 15): object
    {
        $userId = 1;

        $foundOrders = $this->model->where('user_id', $userId)
                                    ->paginate($totalPerPage);

        return $foundOrders;
    }

    public function register(array $input): object|array
    {
        if (!$this->userRepository->findById($input['user_id'])) {
            throw new NotFoundException("User {$input['user_id']} not found.");
        }

        try {
            DB::beginTransaction();

            $createdOrder = $this->model->create([
                'user_id' => $input['user_id'],
                'status' => OrderStatus::PENDING_PAYMENT,
                'payment_type' => $input['payment_type'],
                'total_order' => $input['total_order'],
                'tracking_code' => $input['tracking_code']
            ]);
    
            $this->storeOrderItems($createdOrder, $input['items']);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new Exception($th->getMessage());   
        }

        return $createdOrder->load('items');
    }

    public function cancel(string $id, string $userId): Model
    {
        if (!$foundOrder = $this->model->find($id)) {
            throw new NotFoundException("Order {$id} not found.");
        }

        $foundOrder->update([
            'status' => OrderStatus::CANCELED->value
        ]);

        return $foundOrder->refresh();
    }

    public function storeOrderItems($order, $items)
    {
        $orderItems = [];
        foreach ($items as $item) {
            $orderItems[] = $order->items()->create([
                'product_id' => $item['product_id'],
                'order_id' => $order['id'],
                'quantity' => $item['quantity'],
                'unitPurchasePrice' => $item['unit_purchase_price'],
                'subtotal' => $item['subtotal'],
                'discount' => $item['discount'],
                'total' => $item['total']
            ]);
        }

        return $orderItems;
    }

}   