<?php

use App\Enums\OrderStatus;
use App\Enums\PaymentTypes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('status', array_keys(OrderStatus::cases()))
                    ->default(OrderStatus::PENDING_PAYMENT->value);
            $table->enum('payment_type', array_keys(PaymentTypes::cases()));
            $table->decimal('total_order');
            $table->string('tracking_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
