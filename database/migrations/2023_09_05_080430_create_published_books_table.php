<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('published_books', function (Blueprint $table) {
            $table->id();
            $table->integer('price')->unsigned();
            $table->timestamps();
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            $table->foreignId('publisher_id')->cascadeOnDelete();
            $table->foreignId('format_id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('published_books');
    }
};
