<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

class WishlistController extends Controller
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
        ->wishlists()
        ->with('author', 'categories')
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
        //
        $rules = [
            'user_id' => 'bail|required|integer',
            'book_id' => 'bail|required|integer',
        ];
        $this->validate($request, $rules);

        $wishlist = new Wishlist();
        $wishlist->user_id = $request->input('user_id');
        $wishlist->book_id = $request->input('book_id');
        $wishlist->save();
        // On renvoie une réponse JSON côté API
        return new JsonResponse($wishlist, JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Wishlist $wishlist)
    {
        //
        return $wishlist;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wishlist $wishlist)
    {
        //
        // On renvoie une réponse JSON côté API
        return new JsonResponse($wishlist, JsonResponse::HTTP_FORBIDDEN);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wishlist $wishlist)
    {
        //
        // On renvoie une réponse JSON côté API
        return new JsonResponse($wishlist, JsonResponse::HTTP_FORBIDDEN);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wishlist $wishlist)
    {
        // delete book from wishlist
        $delList = Wishlist::findOrFail($wishlist->id);
        $delList->delete();
        return new JsonResponse($wishlist, JsonResponse::HTTP_OK);
    }
}
