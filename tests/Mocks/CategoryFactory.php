<?php

namespace StarfolkSoftware\Pigeonhole\Tests\Mocks;

use Illuminate\Database\Eloquent\Factories\Factory;
use StarfolkSoftware\Pigeonhole\Pigeonhole;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        $defs = [
            'name' => $this->faker->name,
        ];

        if (Pigeonhole::$supportsTeams) {
            $defs['team_id'] = 1;
        }

        return $defs;
    }
}
