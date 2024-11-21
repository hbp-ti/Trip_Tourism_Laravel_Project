<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 20);
            $table->string('last_name', 20);
            $table->date('birth_date');
            $table->string('email', 50)->unique();
            $table->string('username', 20)->unique();
            $table->integer('phone');
            $table->text('password');
            $table->text('image');
            $table->timestamps();
            $table->rememberToken();
        });

        // Adicionar a constraint de CHECK usando SQL bruto
        DB::statement('ALTER TABLE users ADD CONSTRAINT birth_date_check CHECK (DATE_PART(\'year\', AGE(birth_date)) >= 16)');

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('item_type', 30);
            $table->timestamps();
        });

        // Adicionar a constraint de CHECK para 'item_type' usando SQL bruto
        DB::statement("ALTER TABLE items ADD CONSTRAINT item_type_check CHECK (item_type IN ('Hotel', 'Activity', 'Ticket'))");

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title', 20);
            $table->string('description', 100);
            $table->boolean('is_read');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('title', 30);
            $table->string('description', 200);
            $table->integer('rating');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('items');
            $table->timestamps();
        });

        // Adicionar a constraint de CHECK para 'rating' usando SQL bruto
        DB::statement('ALTER TABLE reviews ADD CONSTRAINT rating_check CHECK (rating BETWEEN 1 AND 5)');

        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->text('url');
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            $table->timestamps();
        });

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

        // Adicionar a constraint de CHECK para 'transport_type' e 'train_class' usando SQL bruto
        DB::statement("ALTER TABLE tickets ADD CONSTRAINT transport_type_check CHECK (transport_type IN ('Train', 'Bus'))");
        DB::statement("ALTER TABLE tickets ADD CONSTRAINT train_class_check CHECK (train_class IS NULL OR train_class IN ('first', 'second'))");

        Schema::create('hotels', function (Blueprint $table) {
            $table->foreignId('id_item')->primary()->constrained('items')->onDelete('cascade');
            $table->string('name', 50);
            $table->string('description', 1000);
            $table->float('price_night');
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

        // Adicionar a constraint de CHECK para 'stars' e 'average_guest_rating' usando SQL bruto
        DB::statement('ALTER TABLE hotels ADD CONSTRAINT stars_check CHECK (stars BETWEEN 0 AND 5)');
        DB::statement('ALTER TABLE hotels ADD CONSTRAINT average_guest_rating_check CHECK (average_guest_rating BETWEEN 0 AND 5)');

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

        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->float('subtotal');
            $table->integer('taxes');
            $table->float('total');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

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

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->float('subtotal');
            $table->integer('taxes');
            $table->float('total');
            $table->date('date');
            $table->string('payment_method', 20);
            $table->string('billing_country', 20);
            $table->string('billing_city', 20);
            $table->string('billing_address', 50);
            $table->string('billing_postal_code', 10);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('numb_people_hotel')->nullable();
            $table->string('room_type_hotel', 20)->nullable();
            $table->date('reservation_date_hotel')->nullable();
            $table->smallInteger('numb_people_activity')->nullable();
            $table->time('hours_activity')->nullable();
            $table->string('train_type', 20)->nullable();
            $table->smallInteger('train_people_count')->nullable();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            $table->boolean('is_active')->default('true');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('carts');
        Schema::dropIfExists('activities');
        Schema::dropIfExists('hotels');
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('images');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('items');
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
    }
};
