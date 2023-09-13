<?php

namespace App\Http\Controllers;

use App\Models\PublishedBook;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublishedBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $published_books = PublishedBook::with('book', 'publisher', 'format')
            ->orderBy('created_at', 'asc')
            // ->orderByDesc('created_at')
            // ->latest()
            ->take(5)
            ->simplePaginate(5);

        //return view('welcome', compact('published_books'));
        return $published_books;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexB($id)
    {
        $published_books = PublishedBook::with('book', 'publisher', 'format')
            ->findOrFail($id);

        //return view('welcome', compact('published_books'));
        return $published_books;
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
            'price' => 'bail|required|integer',
            'book_id' => 'bail|required|integer',
            'publisher_id' => 'bail|required|integer',
            'format_id' => 'bail|required|integer',
        ];
        $this->validate($request, $rules);

        $book = new PublishedBook();
        $book->price = $request->input('price');
        $book->book_id = $request->input('book_id');
        $book->publisher_id = $request->input('publisher_id');
        $book->format_id = $request->input('format_id');

        $book->save();

        return redirect("api/");
    }

    /**
     * Display the specified resource.
     */
    public function show(PublishedBook $publishedBook)
    {
        return $publishedBook;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, PublishedBook $publishedBook)
    {
        //
        $rules = [
            'price' => 'bail|required|integer',
            'book_id' => 'bail|required|integer',
            'publisher_id' => 'bail|required|integer',
            'format_id' => 'bail|required|integer',
        ];
        $this->validate($request, $rules);


        $book = PublishedBook::findOrFail($publishedBook->id);
        $book->price = $request->input('price');
        $book->book_id = $request->input('book_id');
        $book->publisher_id = $request->input('publisher_id');
        $book->format_id = $request->input('format_id');

        $book->save();

        return redirect("api/");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request, PublishedBook $publishedBook)
    {
        //
        $rules = [
            'price' => 'bail|required|integer',
            'book_id' => 'bail|required|integer',
            'publisher_id' => 'bail|required|integer',
            'format_id' => 'bail|required|integer',
        ];

        $this->validate($request, $rules);

        $selectBook = PublishedBook::findOrFail($id);
        $selectBook->price = $request->get('price');
        $selectBook->book_id = $request->get('book_id');
        $selectBook->publisher_id = $request->get('publisher_id');
        $selectBook->format_id = $request->get('format_id');

        $selectBook->save();
        return redirect("api/");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, PublishedBook $publishedBook)
    {
        $theBook = PublishedBook::findOrFail($id);
        $theBook->delete();
        
        //return redirect("api/");
        return new JsonResponse([], JsonResponse::HTTP_OK);
    }
}
