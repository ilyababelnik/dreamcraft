<?php

namespace Database\Seeders;

use App\Models as Models;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $num = 30;
        $users = Models\User::inRandomOrder()->get();
        $categories = Models\Category::inRandomOrder()->get();

        for ($i = 0; $i < $num; $i++) {
            $user = $users->random();
            $category = $categories->random();

            Models\Comment::factory()->create([
                'user_id' => $user->id,
                'category_id' => $category->id,
            ]);
        }
    }
}
