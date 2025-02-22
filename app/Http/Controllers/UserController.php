<?php

namespace App\Http\Controllers;

use App\Contracts\UserContract;
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
}
