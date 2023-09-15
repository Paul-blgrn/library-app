<?php

namespace App\Http\Controllers;

use App\Models\Library;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        //Auth::loginUsingId(1);

        /** @var User $user */
        $user = auth()->user(); 
        return $user
            ->librarie()
            ->with('book.author', 'book.categories', 'publisher', 'format')
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
        $rules = [
            'user_id' => 'bail|required|integer',
            'published_book_id' => 'bail|required|integer',
            'status' => 'bail|required|in:lu,en_cours,non_lu',
        ];
        $this->validate($request, $rules);

        $library = new Library();
        $library->user_id = $request->input('user_id');
        $library->published_book_id = $request->input('published_book_id');
        $library->status = 'non_lu';

        $library->save();

        return new JsonResponse($library, JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Library $library)
    {
        //
        return $library;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Library $library)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, User $user, Request $request, Library $library)
    {
        //
        $rules = [
            'status' => 'bail|required|in:lu,en_cours,non_lu',
        ];
        $this->validate($request, $rules);

        $library = Library::findOrFail($library->id);
        $library->status = $request->input('status');;

        $library->save();

        return new JsonResponse($library, JsonResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Library $library)
    {
        // EXPLOSION !!!!! ... non serieusement, on supprime le livre
        // de la librarie du lecteur
        $delLibrary = Library::findOrFail($library->id);
        $delLibrary->delete();
        return new JsonResponse($library, JsonResponse::HTTP_OK);
    }
}
