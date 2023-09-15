<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $publisher = Publisher::all()
            ->orderByDesc()
            ->take(5)
            ->paginate(5);
        return $publisher;
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
            'name' => 'bail|required|string|max:50',
        ];
        $this->validate($request, $rules);

        $newPublisher = new Publisher();
        $newPublisher->name = $request->input('name');
        $newPublisher->save();
        return new JsonResponse($newPublisher, JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Publisher $publisher)
    {
        return $publisher;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Publisher $publisher)
    {
        $user = auth()->user();
        $editPublisher = Publisher::findOrFail($publisher->id);
        if($user->role === "editor" || $user->role === "admin") {
            return view('edit_publisher', [
                'author' => $editPublisher,
            ]);
        } else {
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Publisher $publisher)
    {
        $rules = [
            'name' => 'bail|required|string|max:50',
        ];
        $this->validate($request, $rules);

        $updatePublisher = Publisher::findOrFail($publisher->id);

        $updatePublisher->name = $request->input('name');
        $updatePublisher->save();

        return new JsonResponse($updatePublisher, JsonResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publisher $publisher)
    {
        $deletePublisher = Publisher::findOrFail($publisher->id);
        $deletePublisher->delete();

        return new JsonResponse($deletePublisher, JsonResponse::HTTP_OK);
    }
}
