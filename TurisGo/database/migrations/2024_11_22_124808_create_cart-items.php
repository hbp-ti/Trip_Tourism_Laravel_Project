<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('numb_people_hotel')->nullable();
            $table->string('room_type_hotel', 20)->nullable();
            $table->date('reservation_date_hotel')->nullable();
            $table->smallInteger('numb_people_activity')->nullable();
            $table->time('hours_activity')->nullable();
            $table->string('train_type', 20)->nullable();
            $table->smallInteger('train_people_count')->nullable();
            $table->foreignId('cart_id')->constrained('carts')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
