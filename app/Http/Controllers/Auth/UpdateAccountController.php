<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\AuthContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateAccountRequest;
use Illuminate\Http\JsonResponse;

class UpdateAccountController extends Controller
{
    public function __invoke(UpdateAccountRequest $request, AuthContract $authContract): JsonResponse
    {
        $response = $authContract->updateAccount($request->user()->id, $request->only(['name', 'email']));

        return $this->respondWithSuccess(
            contents: $response,
        );
    }
}
