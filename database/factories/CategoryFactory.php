<?php

namespace StarfolkSoftware\Pigeonhole\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use StarfolkSoftware\Pigeonhole\Category;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
        ];
    }
}

