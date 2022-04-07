<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->domainWord(),
            'thumbnail' => $this->faker->url(),
            'url' => $this->faker->url(),
            'description' => $this->faker->sentence(),
        ];
    }
}
