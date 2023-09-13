<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        Auth::loginUsingId(1);
        /** @var User $user */
        $user = auth()->user();
        return $user
            ->comments()
            ->orderBy('created_at', 'asc')
            ->take(5)
            ->simplePaginate(5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // insert from comments
        $rules = [
            'user_id' => 'bail|required|integer',
            'book_id' => 'bail|required|integer',
            'comment' => 'bail|required|',
            'note' => 'bail|required|in:1,2,3,4,5',
        ];
        $this->validate($request, $rules);

        $newComment = new Comment();
        $newComment->user_id = $request->input('user_id');
        $newComment->book_id = $request->input('book_id');
        $newComment->comment = $request->input('comment');
        $newComment->note = $request->input('note');

        $newComment->save();
        return new JsonResponse($newComment, JsonResponse::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
        return $comment;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        // update comment from comments
        $rules = [
            'comment' => 'bail|required|',
            'note' => 'bail|required|in:1,2,3,4,5',
        ];
        $this->validate($request, $rules);

        $updateComment = Comment::findOrFail($comment->id);
        $updateComment->comment = $request->input('comment');
        $updateComment->note = $request->input('note');
        $updateComment->save();

        return new JsonResponse($updateComment, JsonResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        // delete comment from comment table
        $delComment = Comment::findOrFail($comment->id);
        $delComment->delete();
        return new JsonResponse($comment, JsonResponse::HTTP_OK);
    }
}
