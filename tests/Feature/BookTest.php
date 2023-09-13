<?php

use App\Models\Book;
use App\Models\Category;
use App\Models\Format;
use App\Models\PublishedBook;
use App\Models\Publisher;

use function Pest\Laravel\delete;
use function Pest\Laravel\deleteJson;

it('show published books')->get('api/')->assertStatus(200);

test('create random published books', function() {
    $publishedCount = mt_rand(1, 3);
    $response = Book::factory(10)
        ->has(PublishedBook::factory($publishedCount), 'published_books')
        ->create();

    Category::factory(2)
        ->hasAttached($response)
        ->create();

    expect($response)->not()->toBeNull();
});


test('create specific published book', function(){
    $book = Book::factory()->create();
    $publisher = Publisher::factory()->create();
    $format = Format::factory()->create();

    $response = $this->post('/api/book/add', [
        'price' => '30',
        'book_id' => $book->id,
        'publisher_id' => $publisher->id,
        'format_id' => $format->id,
    ]);

    $response->assertRedirect("api/");
});

test('select published book by id', function() {
    $selectBook = PublishedBook::factory()->create();
    $id = $selectBook->id;

    expect($id)->not()->toBeNull();

    $response = $this->get('api/book/'. $id);
    $response->assertStatus(200);
});

test('update published book by id', function(){
    $book = Book::factory()->create();
    $publisher = Publisher::factory()->create();
    $format = Format::factory()->create();

    $response = $this->post('/api/book/add', [
        'price' => '30',
        'book_id' => $book->id,
        'publisher_id' => $publisher->id,
        'format_id' => $format->id,
    ]);

    expect($book)->not()->toBeNull();
    $response->assertRedirect("api/");
});

// test('', function(){

// });

test('guest cannot delete books', function() {
    deleteJson('api/book/del/1')->assertUnauthorized();
});

test('delete published book by id', function(){
    $deleteBook = PublishedBook::factory()->create();
    $id = $deleteBook->id;

   
    $response = deleteJson('api/book/del/'. $id);
    // $response->assertRedirect("api/");
    $response->assertOk();

    expect(PublishedBook::count())->toEqual(0);
});

// test('example', function () {
//     $response = $this->get('/');

//     $response->assertStatus(200);
// });

// it('show all books', function(){
//     $response = $this->get('/api/books');

//     expect($response->status())->toBe(200);
// });
