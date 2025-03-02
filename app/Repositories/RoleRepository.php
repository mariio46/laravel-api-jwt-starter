<?php

namespace App\Repositories;

use App\Contracts\RoleContract;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;

class RoleRepository implements RoleContract
{
    public function __construct(protected Role $role, protected Builder $baseQuery)
    {
        $this->baseQuery = $role->query();
    }

    public function getRoles(?array $params): array
    {
        $roles = $this->baseQuery
            ->where('id', '!=', 1)
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
            ->withCount(['users'])
            ->fastPaginate($params['size'] ?? 10)
            ->appends($params);

        return sendSuccessData(
            data: $roles,
            message: 'Roles data retrieve successfully.'
        );
    }
}
