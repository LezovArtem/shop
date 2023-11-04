<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\DTO\Factories\TagDtoFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\StoreTagRequest;
use App\Http\Requests\Tag\UpdateTagRequest;
use App\Http\Resources\Tag\TagResource;
use App\Models\Tag;
use App\Repositories\TagRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class TagController extends Controller
{
    public function __construct(private TagRepository $tagRepository)
    {
    }

    public function index(): JsonResponse
    {
        $tags = $this->tagRepository->getAll();

        return response()->json(TagResource::collection($tags), Response::HTTP_OK);
    }

    public function store(StoreTagRequest $request, TagDtoFactory $dtoFactory): JsonResponse
    {
        $dto = $dtoFactory->createFromRequest($request->validated());

        $tag = Tag::create($dto->title);

        return response()->json(new TagResource($tag), Response::HTTP_CREATED);
    }

    public function show(Tag $tag): JsonResponse
    {
        return response()->json(new TagResource($tag), Response::HTTP_OK);
    }

    public function update(UpdateTagRequest $request, Tag $tag, TagDtoFactory $dtoFactory): JsonResponse
    {
        $dto = $dtoFactory->createFromRequest($request->validated());

        $tag->update([$dto->title]);

        return response()->json($this->show($tag), Response::HTTP_OK);
    }

    public function destroy(Tag $tag): Response
    {
        $tag->delete();

        return response()->noContent();
    }
}
