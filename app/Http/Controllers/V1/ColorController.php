<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\DTO\Factories\ColorDtoFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Color\StoreColorRequest;
use App\Http\Requests\Color\UpdateColorRequest;
use App\Http\Resources\Color\ColorResource;
use App\Models\Color;
use App\Repositories\ColorRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ColorController extends Controller
{
    public function __construct(private ColorRepository $colorRepository)
    {
    }

    public function index(): JsonResponse
    {
        $colors = $this->colorRepository->getAll();

        return response()->json(ColorResource::collection($colors), Response::HTTP_OK);
    }

    public function store(StoreColorRequest $request, ColorDtoFactory $dtoFactory): JsonResponse
    {
        $dto = $dtoFactory->createFromRequest($request->validated());

        $color = Color::create($dto);

        return response()->json(new ColorResource($color), Response::HTTP_CREATED);
    }

    public function show(Color $color): JsonResponse
    {
        return response()->json(new ColorResource($color), Response::HTTP_OK);
    }

    public function update(UpdateColorRequest $request, Color $color, ColorDtoFactory $dtoFactory): JsonResponse
    {
        $dto = $dtoFactory->createFromRequest($request->validated());

        $color->update([$dto->title]);

        return response()->json($this->show($color), Response::HTTP_OK);
    }

    public function destroy(Color $color): Response
    {
        $color->delete();

        return response()->noContent();
    }
}
