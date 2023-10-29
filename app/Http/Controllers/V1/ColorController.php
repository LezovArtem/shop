<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Color\StoreColorRequest;
use App\Http\Requests\Color\UpdateColorRequest;
use App\Http\Resources\Color\ColorResource;
use App\Models\Color;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json(ColorResource::collection(Color::all()), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreColorRequest $request): JsonResponse
    {
        $color = Color::create($request->validated());

        return response()->json(new ColorResource($color), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Color $color): JsonResponse
    {
        return response()->json(new ColorResource($color), Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateColorRequest $request, Color $color): JsonResponse
    {
        $color->update($request->validated());

        return response()->json($this->show($color), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Color $color): Response
    {
        $color->delete();

        return response()->noContent();
    }
}
