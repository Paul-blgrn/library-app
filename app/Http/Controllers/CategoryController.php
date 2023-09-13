<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderByDesc('id')
            ->take(5)
            ->simplePaginate(5);
        return $categories;
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
        // Create category drom categories
        $rules = [
            'name' => 'bail|required|string|max:40',
        ];
        $this->validate($request, $rules);

        $category = new Category();
        $category->name = $request->input('name');
        $category->save();
        return new JsonResponse($category, JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
        return $category;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        // Update catégory from categories
        $rules = [
            'name' => 'bail|required|string|max:60',
        ];
        $this->validate($request, $rules);

        $updateCategory = Category::findOrFail($category->id);
        $updateCategory->name = $request->input('name');
        $updateCategory->save();
        return new JsonResponse($updateCategory, JsonResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // delete category from category
        $delCategory = Category::findOrFail($category->id);
        $delCategory->delete();
        return new JsonResponse($category, JsonResponse::HTTP_OK);
    }
}
