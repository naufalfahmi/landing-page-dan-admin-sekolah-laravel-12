<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'body' => $this->faker->sentence(50),
            'user_id' => 1,
            'title' => $this->faker->sentence(10),
            'slug' => $this->faker->slug(),
            'publish_date' => $this->faker->dateTimeBetween('- 1 month', 'now'),
        ];
    }
}
