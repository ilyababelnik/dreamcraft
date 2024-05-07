<?php

namespace Database\Seeders;

use App\Models\Mark;
use Illuminate\Database\Seeder;

class MarkSeeder extends Seeder
{
    public function run()
    {
        $userCategoryPairs = [];

        for ($i = 0; $i < 20; $i++) {
            $userId = rand(1, 10);
            $categoryId = rand(1, 5);

            if (! isset($userCategoryPairs[$userId][$categoryId])) {
                Mark::factory()->create([
                    'user_id' => $userId,
                    'category_id' => $categoryId,
                ]);

                $userCategoryPairs[$userId][$categoryId] = true;
            }
        }
    }
}
