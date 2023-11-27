<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\DTO\Factories\UserDtoFactory;
use App\Filters\V1\UserFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class UserController extends Controller
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $filter = new UserFilter();
        $queryItems = $filter->transform($request);

        $users = $this->userRepository->getAll();

        if (empty($queryItems)){
            return response()->json(UserResource::collection($users), Response::HTTP_OK);
        } else {
            $users = $this->userRepository->withQueryItems($queryItems);

            return response()->json(UserResource::collection($users->appends($request->query())), Response::HTTP_OK);
        }
    }

    public function store(StoreUserRequest $request, UserDtoFactory $dtoFactory): JsonResponse
    {
        $dto = $dtoFactory->createFromRequest($request);

        try {
            $user = $this->userRepository->store($dto);
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage());
        }

        return response()->json(new UserResource($user), Response::HTTP_CREATED);
    }

    public function show(User $user): JsonResponse
    {
        return response()->json(new UserResource($user), Response::HTTP_OK);
    }

    public function update(UpdateUserRequest $request, User $user, UserDtoFactory $dtoFactory): JsonResponse
    {
        $dto = $dtoFactory->createFromRequest($request);
        try {
            $user = $this->userRepository->update($user, $dto);
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage());
        }

        return response()->json(new UserResource($user), Response::HTTP_OK);
    }

    public function destroy(User $user): Response
    {
        $user->delete();

        return response()->noContent();
    }
}
