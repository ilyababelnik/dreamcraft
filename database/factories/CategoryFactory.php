<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->word,
            'description_en' => $this->faker->sentence,
            'description_uk' => 'Рандомний текст українською мовою',
            'image' => $this->faker->imageUrl(),
        ];
    }
}
