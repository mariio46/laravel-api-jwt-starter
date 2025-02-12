<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Auth\AuthenticatedUserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthenticatedUserController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        return $this->respondWithSuccess(
            contents: sendSuccessData(
                data: [
                    'user' => new AuthenticatedUserResource($request->user()),
                ],
                message: 'User data retrieve successfully',
            )
        );
    }
}
