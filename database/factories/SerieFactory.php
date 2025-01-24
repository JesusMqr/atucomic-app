<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Serie;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Serie>
 */
class SerieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generar números aleatorios para hacer las imágenes únicas
        $coverNum = fake()->numberBetween(1, 1000);
        $bannerNum = fake()->numberBetween(1, 1000);

        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'type' => fake()->randomElement(['manga', 'manhwa', 'manhua']),
            'status' => fake()->randomElement(['ongoing', 'completed', 'hiatus', 'cancelled']),
            'author' => fake()->name(),
            // Usar servicios de placeholder de imágenes
            'cover_image_url' => "https://picsum.photos/seed/{$coverNum}/400/600",
            'banner_image_url' => "https://picsum.photos/seed/{$bannerNum}/1200/400",
        ];
    }
}
