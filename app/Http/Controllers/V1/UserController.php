<?php

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

class UserController extends Controller
{

    public function __construct(private UserRepository $userRepository)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new UserFilter();
        $queryItems = $filter->transform($request);

        if (empty($queryItems)){
            return UserResource::collection(User::paginate());
        } else {
            $users = User::where($queryItems)->paginate();
            return UserResource::collection($users->appends($request->query()));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request, UserDtoFactory $dtoFactory)
    {
        $dto = $dtoFactory->createFromRequest($request);

        $user = $this->userRepository->store($dto);

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user, UserDtoFactory $dtoFactory)
    {
        $dto = $dtoFactory->createFromRequest($request);
        $user = $this->userRepository->update($user, $dto);
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
    }
}
