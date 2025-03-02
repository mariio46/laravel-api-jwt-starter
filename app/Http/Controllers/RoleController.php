<?php

namespace App\Http\Controllers;

use App\Contracts\RoleContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct(protected RoleContract $roleContract)
    {
        //
    }

    public function index(Request $request): JsonResponse
    {
        $response = $this->roleContract->getRoles(
            params: $request->only(['search', 'sort', 'size']),
        );

        return $this->respondWithSuccess(
            contents: $response,
        );
    }
}
