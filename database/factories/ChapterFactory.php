<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chapter>
 */
class ChapterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imageNum = fake()->numberBetween(1, 1000);
        
        return [
            'order_number' => 1,
            'image_url' => "https://picsum.photos/seed/{$imageNum}/400/600",
        ];
    }
}
