<?php

namespace App\Http\Controllers;

use App\Contracts\RoleContract;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
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

    public function store(StoreRoleRequest $request): JsonResponse
    {
        $response = $this->roleContract->storeRole(
            data: $request->only(['name']),
        );

        return $this->respondCreated(
            data: $response
        );
    }

    public function show(string $id): JsonResponse
    {
        $response = $this->roleContract->getRole(roleId: $id);

        return $this->respondWithSuccess(
            contents: $response,
        );
    }

    public function update(UpdateRoleRequest $request, string $id): JsonResponse
    {
        $response = $this->roleContract->updateRole(
            data: $request->only(['name']),
            roleId: $id
        );

        return $this->respondWithSuccess(
            contents: $response,
        );
    }

    public function delete(string $id): JsonResponse
    {
        $response = $this->roleContract->deleteRole(roleId: $id);

        return $this->respondWithSuccess(
            contents: $response,
        );
    }
}
