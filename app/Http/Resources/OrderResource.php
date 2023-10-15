<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->user_id,
            'status' => $this->status,
            'payment_type' => $this->payment_type,
            'total_order' => $this->total_order,
            'tracking_code' => $this->tracking_code,
            'delivery_address_id' => $this->delivery_address_id,
            'items' => $this->items->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unitPurchasePrice' => $item->unitPurchasePrice,
                    'subtotal' => $item->subtotal,
                    'discount' => $item->discount,
                    'total' => $item->total,
                ];
            }),
        ];
    }
}
