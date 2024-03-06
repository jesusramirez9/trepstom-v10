<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Posts>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *sas
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $published = $this->faker->randomElement([true, false]);
        $published_at = $published ? now() : null ;

        return [
            'title' => $this->faker->sentence(),
            'slug' => $this->faker->slug(),
            'excerpt' => $this->faker->text(200),
            'body' => $this->faker->text(2000),
            'image_path' => 'posts/'.$this->faker->image('public/storage/posts', 640, 480, null, false),
            'published' => $published,
            'subcategory_id' => $this->faker->numberBetween(1, 632),
            'user_id' => rand(1, 20),
            'published_at' => $published_at,
        ];
    }
}
