<?php

namespace Database\Factories;

use App\Models\Listing;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'tags' => 'trance,1999,UK,vinyl',
            'company' => 'Not on label',
            'location' => $this->faker->country(),
            'description' => $this->faker->paragraph(5),
        ];
    }
}
