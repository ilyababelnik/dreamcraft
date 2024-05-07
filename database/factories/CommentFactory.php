<?php

namespace Database\Factories;

use App\Models;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Models\Comment::class;

    public function definition(): array
    {
        $users = Models\User::inRandomOrder()->get();
        $categories = Models\Category::inRandomOrder()->get();

        $user = $users->random();
        $category = $categories->random();

        return [
            'text' => $this->faker->paragraph,
            'category_id' => $category->id,
            'user_id' => $user->id,
        ];
    }
}
