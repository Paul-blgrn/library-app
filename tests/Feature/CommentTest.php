<?php

use App\Models\Book;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

test("Voir les commentaire d'un utilisateur", function() {

    actingAs(User::factory()->create())
        ->get('/api/comments')
        ->assertStatus(200);
});

test("un utilisateur peut créer des commentaires", function() {

    actingAs(User::factory()->make())
        ->post('/api/comment/add', [
            Comment::factory()->make(),
        ]);

    expect(Comment::count())->not()->toBeNull();
});

test("un utilisateur ne peut pas commenter pour quelqu'un d'autre", function() {

    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $comment = Comment::factory()->create([
        'user_id' => $user1->id
    ]);

    actingAs($user1)
        ->post("/api/comment/add", [
            $comment
        ]);
    expect($comment->user_id)->not()->toEqual($user2->id);

});