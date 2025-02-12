<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\AuthContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class RefreshTokenController extends Controller
{
    public function __invoke(AuthContract $authContract): JsonResponse
    {
        $response = $authContract->refreshToken();

        return $this->respondWithSuccess(
            contents: $response,
        );
    }
}
