<?php

namespace App\Http\Controllers;

use App\Contracts\UserContract;
use App\Http\Requests\User\StoreUserRequest;
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

        return $this->respondWithSuccess(
            contents: $response
        );
    }
}
