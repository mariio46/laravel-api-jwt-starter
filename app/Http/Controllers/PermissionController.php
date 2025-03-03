<?php

namespace App\Http\Controllers;

use App\Contracts\PermissionContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct(protected PermissionContract $permissionContract)
    {
        //
    }

    public function index(Request $request): JsonResponse
    {
        $response = $this->permissionContract->getPermissions(
            params: $request->only(['search', 'size', 'sort'])
        );

        return $this->respondWithSuccess(
            contents: $response,
        );
    }
}
