<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Book;
use Illuminate\Database\Seeder;

use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $publishedCount = mt_rand(1, 3);
        $books = \App\Models\Book::factory(10)
            ->has(\App\Models\PublishedBook::factory($publishedCount), 'published_books')
            ->create();

        \App\Models\Category::factory(2)
            ->hasAttached($books)
            ->create();
        
        // ----------------------------------
        // ------------ USERS ---------------
        // ----------------------------------


        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'test@example.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Test Editor',
            'email' => 'test2@example.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'role' => 'Editor',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test3@example.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'role' => 'user',
        ]);
        
        User::factory()->count(3)->create();        
    }
}
