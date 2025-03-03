<?php

namespace App\Repositories;

use App\Contracts\PermissionContract;
use App\Http\Resources\Permission\PermissionCollection;
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
}
