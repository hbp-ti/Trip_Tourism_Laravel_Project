<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->foreignId('id_item')->primary()->constrained('items')->onDelete('cascade');
            $table->string('name', 50);
            $table->string('description', 1000);
            $table->float('price_hour');
            $table->boolean('cancel_anytime');
            $table->boolean('reserve_now_pay_later');
            $table->boolean('guide');
            $table->boolean('small_groups');
            $table->string('language', 20);
            $table->string('country', 30);
            $table->string('zip_code', 10);
            $table->string('city', 30);
            $table->string('street', 60);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
