<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('numb_people_hotel')->nullable();
            $table->string('room_type_hotel', 20)->nullable();
            $table->date('reservation_date_hotel_checkin')->nullable();
            $table->date('reservation_date_hotel_checkout')->nullable();
            $table->smallInteger('numb_people_activity')->nullable();
            $table->time('hours_activity')->nullable();
            $table->string('train_type', 20)->nullable();
            $table->smallInteger('train_people_count')->nullable();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            $table->boolean('is_active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
