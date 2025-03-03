<?php

namespace App\Repositories;

use App\Contracts\PermissionContract;
use App\Http\Resources\Permission\PermissionCollection;
use App\Http\Resources\Permission\PermissionResource;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Permission;

class PermissionRepository implements PermissionContract
{
    public function __construct(protected Permission $permission, protected Builder $baseQuery)
    {
        $this->baseQuery = $permission->query();
    }

    public function getPermissions(?array $params): array
    {
        $permissions = $this->baseQuery
            ->when(
                value: $params['search'] ?? null,
                callback: fn(Builder $query, string $value) => $query->where('name', 'like', "%{$value}%")
            )
            ->when(
                value: $params['sort'] ?? null,
                callback: function (Builder $query, string $value) {
                    $operator = str($value)->explode('-');
                    $query->orderBy($operator[0], $operator[1]);
                },
                default: fn(Builder $query) => $query->orderBy('id', 'desc')
            )
            ->fastPaginate($params['size'] ?? 10)
            ->appends($params);

        return sendSuccessData(
            message: 'Permissions data retrieve successfully.',
            data: new PermissionCollection($permissions),
        );
    }

    public function storePermission(array $data): array
    {
        $this->baseQuery->create([
            'name' => $data['name']
        ]);

        return sendSuccessData(
            message: 'Permission has been created successfully.'
        );
    }

    public function getPermission(string $permissionId): array
    {
        $permission = $this->fetchById(id: $permissionId)->firstOrFail();

        return sendSuccessData(
            message: 'Permission data retrieve successfully.',
            data: new PermissionResource($permission),
        );
    }

    public function updatePermission(array $data, string $permissionId): array
    {
        $permission = $this->fetchById(id: $permissionId)->firstOrFail();

        $permission->update([
            'name' => $data['name'],
        ]);

        return sendSuccessData(
            message: 'Permission has been updated successfully.',
        );
    }

    public function deletePermission(string $permissionId): array
    {
        $permission = $this->fetchById(id: $permissionId)->firstOrFail();

        $permission->delete();

        return sendSuccessData(
            message: 'Permission has been deleted successfully.'
        );
    }

    protected function fetchById(string $id): Builder
    {
        return $this->baseQuery->where('id', '=', $id);
    }
}
