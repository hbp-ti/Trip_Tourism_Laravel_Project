<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->foreignId('id_item')->primary()->constrained('items')->onDelete('cascade');
            $table->string('name', 50);
            $table->string('description', 1000);
            $table->smallInteger('stars');
            $table->float('average_guest_rating')->default(0);
            $table->boolean('free_wifi');
            $table->boolean('parking');
            $table->boolean('gym');
            $table->boolean('pool');
            $table->boolean('spa_wellness');
            $table->boolean('hotel_restaurant');
            $table->boolean('bar');
            $table->boolean('refundable_reservations');
            $table->string('country', 30);
            $table->string('zip_code', 10);
            $table->string('city', 30);
            $table->string('street', 60);
            $table->timestamps();
        });

        DB::statement('ALTER TABLE hotels ADD CONSTRAINT stars_check CHECK (stars BETWEEN 0 AND 5)');
        DB::statement('ALTER TABLE hotels ADD CONSTRAINT average_guest_rating_check CHECK (average_guest_rating BETWEEN 0 AND 5)');
    }

    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
