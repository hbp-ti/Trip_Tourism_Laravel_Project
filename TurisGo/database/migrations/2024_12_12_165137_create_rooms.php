<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Execute as migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained('hotels', 'id_item')->onDelete('cascade');
            $table->string('type');
            $table->string('bed_type');
            $table->integer('bed_count');
            $table->decimal('price_night', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverter as migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
};
