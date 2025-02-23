<?php

namespace App\Http\Controllers;

use App\Contracts\UserContract;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(protected UserContract $userContract)
    {
        //
    }

    public function index(Request $request): JsonResponse
    {
        $response = $this->userContract->getUsers(
            currentUserId: $request->user()->id,
            params: $request->only(['search', 'role'])
        );

        return $this->respondWithSuccess(
            contents: $response,
        );
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $response = $this->userContract->storeUser(
            data: $request->only(['name', 'email', 'password', 'role']),
        );

        return $this->respondCreated(
            data: $response
        );
    }

    public function show(string $id): JsonResponse
    {
        $response = $this->userContract->getUser(userId: $id);

        return $this->respondWithSuccess(
            contents: $response
        );
    }

    public function update(UpdateUserRequest $request, string $id): JsonResponse
    {
        $response = $this->userContract->updateUser(
            data: $request->only(['name', 'email', 'role']),
            userId: $id
        );

        return $this->respondWithSuccess(
            contents: $response
        );
    }

    public function delete(string $id): JsonResponse
    {
        $response = $this->userContract->deleteUser(userId: $id);

        return $this->respondWithSuccess(
            contents: $response
        );
    }
}
