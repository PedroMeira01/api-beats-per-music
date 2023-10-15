<?php

namespace App\Http\Requests\Order;

use App\Enums\PaymentTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required',
            'payment_type' => new Enum(PaymentTypes::class),
            'total_order' => 'required|numeric', 
            'tracking_code' => 'nullable',
            'delivery_address_id' => 'numeric',
            'items' => 'required|array',
            'items.*.productId' => 'required|numeric',
            'items.*.quantity' => 'required|numeric',
            'items.*.unitPurchasePrice' => 'required|numeric',
            'items.*.subtotal' => 'required|numeric',
            'items.*.discount' => 'required|numeric',
            'items.*.total' => 'required|numeric'
        ];
    }
}
