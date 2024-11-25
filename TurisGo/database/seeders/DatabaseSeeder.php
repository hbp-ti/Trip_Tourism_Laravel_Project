<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Review;
use App\Models\Item;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

		/*
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
		*/
		
		$this->call(UserSeeder::class);
		$this->call(ItemSeeder::class);
		$this->call(ReviewSeeder::class);
    }
}
