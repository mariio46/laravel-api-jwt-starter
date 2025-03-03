<?php

namespace App\Http\Controllers;

use App\Contracts\PermissionContract;
use App\Http\Requests\Permission\StorePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
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

    public function store(StorePermissionRequest $request): JsonResponse
    {
        $response = $this->permissionContract->storePermission(
            data: $request->only(['name'])
        );

        return $this->respondCreated(
            data: $response,
        );
    }

    public function show(string $id): JsonResponse
    {
        $response = $this->permissionContract->getPermission(permissionId: $id);

        return $this->respondWithSuccess(
            contents: $response,
        );
    }

    public function update(UpdatePermissionRequest $request, string $id): JsonResponse
    {
        $response = $this->permissionContract->updatePermission(
            data: $request->only(['name']),
            permissionId: $id,
        );

        return $this->respondWithSuccess(
            contents: $response,
        );
    }
}
