<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->foreignId('id_item')->primary()->constrained('items')->onDelete('cascade');
            $table->string('transport_type', 15);
            $table->string('train_class', 15)->nullable();
            $table->timestamp('departure_hour');
            $table->smallInteger('quantity');
            $table->float('total_price');
            $table->string('origin', 30);
            $table->string('destination', 30);
            $table->boolean('is_used');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE tickets ADD CONSTRAINT transport_type_check CHECK (transport_type IN ('Train', 'Bus'))");
        DB::statement("ALTER TABLE tickets ADD CONSTRAINT train_class_check CHECK (train_class IS NULL OR train_class IN ('Comfort', 'Tourist'))");
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
