<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = User::orderBy('created_at', 'asc')
            ->take(5)
            ->simplePaginate(5);
        
        return $user;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // function already exist
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // function already exist
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // function already exist
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
        $rules = [
            'name' => 'bail|required|string|max:100',
            'role' => 'bail|required|string|max:50',
        ];
        $this->validate($request, $rules);

        $user = User::findOrFail($user->id);
        $user->name = $request->input('name');
        $user->role = $request->input('role');

        $user->save();
        // On renvoie une réponse JSON côté API
        return new JsonResponse($user, JsonResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // delete the user
        $delUser = User::findOrFail($user->id);
        $delUser->delete();
        // On renvoie une réponse JSON côté API
        return new JsonResponse($user, JsonResponse::HTTP_OK);
    }
}
