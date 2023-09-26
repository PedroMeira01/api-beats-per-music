<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'salePrice' => $this->sale_price,
            'availableQuantity' => $this->available_quantity,
            'storeId' => $this->store_id,
            'isActive' => $this->is_active
        ];
    }
}
