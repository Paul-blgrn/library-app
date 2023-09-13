<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Format;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PublishedBook>
 */
class PublishedBookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'price' => fake()->biasedNumberBetween(10, 100),
            'book_id' => Book::factory(),
            'publisher_id' => Publisher::factory(),
            'format_id' => Format::factory(),
        ];
    }
}
