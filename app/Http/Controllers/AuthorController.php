<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author::all()
            ->take(5);

        $authors = Author::where('id', '>', 0)->simplePaginate(5);

        return $authors;
    }

    /**
     * Display the specified resource.
     */
    public function index_showauthor($id)
    {
        $author = Author::with('books')
            ->findOrFail($id);
        
        return $author;
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
        $rules = [
            'firstname' => 'bail|required|string|max:50',
            'lastname' => 'bail|required|string|max:50',
        ];

        $this->validate($request, $rules);

        $author = new Author();
        $author->firstname = $request->input('firstname');
        $author->lastname = $request->input('lastname');

        $author->save();
        return new JsonResponse($author, JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        return $author;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        $user = auth()->user();
        $author = Author::findOrFail($author->id);
        if($user->role === "editor" || $user->role === "admin"){
            return view('edit_author', [
                'author' => Author::findOrFail($author->id),
            ]);
        } else {
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        $rules = [
            'firstname' => 'bail|required|string|max:50',
            'lastname' => 'bail|required|string|max:50',
        ];

        $this->validate($request, $rules);

        // $user = auth()->user();
        // if($user->role === "editor" || $user->role === "admin"){

            $author = Author::findOrFail($author->id);
            $author->firstname = $request->get('firstname');
            $author->lastname = $request->get('lastname');
            $author->save();

            return new JsonResponse($author, JsonResponse::HTTP_OK);

        // } else {
        //     return redirect()->back();
        // }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $delAuthor = Author::findOrFail($author->id);
        $delAuthor->delete();
        return new JsonResponse($author, JsonResponse::HTTP_OK);
    }
}
