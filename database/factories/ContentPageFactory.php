<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

use function fake;
use function now;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContentPage>
 */
class ContentPageFactory extends Factory
{
    /**
     * Définir l'état par défaut du modèle.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'slug' => fake()->unique()->slug(),
            'title' => fake()->sentence(),
            'content' => fake()->paragraphs(3, true),
            'is_published' => false,
            'published_at' => null,
            'created_by' => User::factory()->admin(),
        ];
    }

    /**
     * Indiquer que la page est publiée.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_published' => true,
            'published_at' => now(),
        ]);
    }
}
