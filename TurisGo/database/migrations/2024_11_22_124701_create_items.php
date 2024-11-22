<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('item_type', 30);
            $table->timestamps();
        });

        DB::statement("ALTER TABLE items ADD CONSTRAINT item_type_check CHECK (item_type IN ('Hotel', 'Activity', 'Ticket'))");
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
