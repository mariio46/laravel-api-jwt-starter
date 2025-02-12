<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\AuthContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request, AuthContract $authContract): JsonResponse
    {
        $response = $authContract->login($request->only([
            'email', 'password',
        ]));

        return $this->respondWithSuccess(
            contents: $response
        );
    }
}
