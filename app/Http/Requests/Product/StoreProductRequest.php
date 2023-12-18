<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:3',
                'max:255'
            ], 
            'description' => [
                'max:255',
                'string'
            ],
            'price' => [
                'required',
                'numeric'
            ],
            'salePrice' => [
                'required',
                'numeric'
            ],
            'availableQuantity' => [
                'required',
                'numeric'
            ],
            'storeId' => [
                'required',
            ]
        ];
    }
}
