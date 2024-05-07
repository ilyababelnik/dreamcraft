<?php

namespace Database\Factories;

use App\Models\Mark;
use Illuminate\Database\Eloquent\Factories\Factory;

class MarkFactory extends Factory
{
    protected $model = Mark::class;

    public function definition()
    {
        return [
            'mark' => $this->faker->numberBetween(1, 5),
            'user_id' => \App\Models\User::factory(),
            'category_id' => \App\Models\Category::factory(),
        ];
    }
}
