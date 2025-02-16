<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\AuthContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use Illuminate\Http\JsonResponse;

class UpdatePasswordController extends Controller
{
    public function __invoke(UpdatePasswordRequest $request, AuthContract $authContract): JsonResponse
    {
        $response = $authContract->updatePassword(
            userId: $request->user()->id,
            data: $request->only(['new_password'])
        );

        return $this->respondWithSuccess(
            contents: $response,
        );
    }
}
