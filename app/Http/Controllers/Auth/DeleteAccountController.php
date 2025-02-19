<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\AuthContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeleteAccountController extends Controller
{
    public function __invoke(Request $request, AuthContract $authContract): JsonResponse
    {
        $data = $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $response = $authContract->deleteAccount(
            userId: $request->user()->id,
            data: $data
        );

        return $this->respondWithSuccess(
            contents: $response
        );
    }
}
