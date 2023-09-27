<?php

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
        Schema::table('addresses', function (Blueprint $table) {
            $table->smallInteger('number')->default(0);
            $table->tinyText('add_on')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('state')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn('number');
            $table->dropColumn('add_on');
            $table->dropColumn('neighborhood');
            $table->dropColumn('state');
        });
    }
};
