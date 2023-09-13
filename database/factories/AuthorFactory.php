<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\User;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // $book = Book::factory()->create();
        return [
            //'book_id' => Book::factory()
            'firstname' => fake()->firstName(),
            'lastname' => fake()->lastName(),
        ];
    }
}
