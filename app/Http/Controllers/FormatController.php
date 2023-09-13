<?php

namespace App\Http\Controllers;

use App\Models\Format;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FormatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $format = Format::orderByDesc('id')
            ->take(5)
            ->simplePaginate(5);
        return $format;
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
        // Insert from formats
        $rules = [
            'type' => 'bail|required|string|max:50',
        ];
        $this->validate($request, $rules);

        $newFormat = new Format();
        $newFormat->type = $request->input('type');
        $newFormat->save();
        return new JsonResponse($newFormat, JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Format $format)
    {
        //
        return $format;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Format $format)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Format $format)
    {
        // Update format from formats
        $rules = [
            'type' => 'bail|required|string|max:50',
        ];
        $this->validate($request, $rules);

        $updateFormat = Format::findOrFail($format->id);
        $updateFormat->type = $request->input('type');
        $updateFormat->save();
        return new JsonResponse($updateFormat, JsonResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Format $format)
    {
        // delete format from format

        $delFormat = Format::findOrFail($format->id);
        $delFormat->delete();
        return new JsonResponse($format, JsonResponse::HTTP_OK);
    }
}
