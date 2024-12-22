<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->float('subtotal');
            $table->integer('taxes');
            $table->float('total');
            $table->date('date');
            $table->string('payment_method');
            $table->string('billing_country');
            $table->string('billing_city');
            $table->string('billing_address');
            $table->string('billing_postal_code');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
