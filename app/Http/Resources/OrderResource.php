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
            'payment_type' => $this->payment_type,
            'total_order' => $this->total_order,
            'tracking_code' => $this->tracking_code,
            "delivery_address" => [
                "street" => $this->delivery_address->street,
                "number" => $this->delivery_address->number,
                "add_on" => $this->delivery_address->add_on,
                "zip_code" => $this->delivery_adress->zip_code,
                "neighborhood" => $this->delivery_address->neighborhood,
                "state" => $this->delivery_adress->state
            ],
            'items' => [
                'product_id' => $this->product_id,
                'quantity' => $this->quantity,
                'unitPurchasePrice' => $this->unitPurchasePrice,
                'subtotal' => $this->subtotal,
                'discount' => $this->discount,
                'total' => $this->total
            ]
        ];
    }
}
