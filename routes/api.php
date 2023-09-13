<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FormatController;
use App\Http\Controllers\PublishedBookController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// all unpublished books
Route::get('/scripts', [BookController::class, 'index']);
Route::get('/script/{book}', [BookController::class, 'indexID']);
Route::post('/script/add', [BookController::class, 'store']);
Route::post('/script/edit/{book}', [BookController::class, 'update']);
Route::delete('/script/del/{book}', [BookController::class, 'destroy']);

// livres publiés
Route::get('/', [PublishedBookController::class, 'index']);
Route::get('/book/{book}', [PublishedBookController::class, 'indexB']);
Route::post('/book/add', [PublishedBookController::class, 'store']);
Route::post('/book/edit/{id}', [PublishedBookController::class, 'update']);
Route::delete('/book/del/{id}', [PublishedBookController::class, 'destroy'])->middleware('auth');


// bibliothèques perso
Route::get('/library', [LibraryController::class, 'index']);
Route::post('/library/add', [LibraryController::class, 'store']);
Route::post('/library/edit/{id}', [LibraryController::class, 'update']);
Route::delete('/library/del/{library}', [LibraryController::class, 'destroy']);

// wishlist perso
Route::get('/wishlist', [WishlistController::class, 'index']);
Route::post('/wishlist/add', [WishlistController::class, 'store']);
Route::delete('/wishlist/del/{wishlist}', [WishlistController::class, 'destroy']);


// categories
Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categorie/add', [CategoryController::class, 'store']);
Route::post('/categorie/edit/{category}', [CategoryController::class, 'update']);
Route::delete('/categorie/del/{category}', [CategoryController::class, 'destroy']);

// format
Route::get('/formats', [FormatController::class, 'index']);
Route::post('/format/add', [FormatController::class, 'store']);
Route::post('/format/edit/{format}', [FormatController::class, 'update']);
Route::delete('/format/del/{format}', [FormatController::class, 'destroy']);

// authors
Route::get('/authors', [AuthorController::class, 'index']);
Route::get('/author/{author}', [AuthorController::class, 'index_showauthor']);
Route::post('/author/create', [AuthorController::class, 'store']);
Route::put('/author/edit/{author}', [AuthorController::class, 'update']);
Route::delete('/author/delete/{author}', [AuthorController::class, 'destroy']);

// comments
Route::get('/comments', [CommentController::class, 'index']);
Route::post('/comment/add', [CommentController::class, 'store']);
Route::post('/comment/edit/{comment}', [CommentController::class, 'update']);
Route::delete('/comment/del/{comment}', [CommentController::class, 'destroy']);
