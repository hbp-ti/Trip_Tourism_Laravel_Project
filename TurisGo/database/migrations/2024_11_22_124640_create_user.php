<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 20);
            $table->string('last_name', 20);
            $table->date('birth_date');
            $table->string('email', 50)->unique();
            $table->string('username', 20)->unique();
            $table->string('phone');
            $table->text('password');
            $table->text('image');
            $table->timestamps();
            $table->rememberToken();
        });

        DB::statement('ALTER TABLE users ADD CONSTRAINT birth_date_check CHECK (DATE_PART(\'year\', AGE(birth_date)) >= 16)');
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
