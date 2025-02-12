<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\AuthContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    use ApiResponseHelpers;

    public function __invoke(RegisterRequest $request, AuthContract $authContract): JsonResponse
    {
        $response = $authContract->register($request->only([
            'name', 'email', 'password'
        ]));

        return $this->respondWithSuccess(
            contents: $response
        );
    }
}
