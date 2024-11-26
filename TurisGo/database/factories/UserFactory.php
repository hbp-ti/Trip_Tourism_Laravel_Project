<?php
namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'birth_date' => $this->faker->date('Y-m-d', '2004-12-31'), // apenas nascidos antes de 2005
            'email' => $this->faker->unique()->safeEmail(),
            'username' => $this->faker->unique()->userName(),
            'phone' => $this->faker->e164PhoneNumber(),
            'password' => Hash::make('password'),
            'image' => 0, // 0 é o id da foto predefenida
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
