<?php

namespace Database\Factories;

use App\Enums\Role;
use App\Models as Models;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = Models\User::class;

    protected static ?string $password = 'seCret1';

    public function definition(): array
    {
        $category = Models\Category::inRandomOrder()->get()->random();

        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'nickname' => $this->faker->unique()->userName,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => Role::user,
            'category_id' => $category->id,
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
