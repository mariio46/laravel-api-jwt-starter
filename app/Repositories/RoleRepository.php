<?php

namespace App\Repositories;

use App\Contracts\RoleContract;
use App\Http\Resources\Role\RoleCollection;
use App\Http\Resources\Role\RoleResource;
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
                callback: fn (Builder $query, string $value) => $query->where('name', 'like', "%{$value}%")
            )
            ->when(
                value: $params['sort'] ?? null,
                callback: function (Builder $query, string $value) {
                    $operator = str($value)->explode('-');
                    $query->orderBy($operator[0], $operator[1]);
                },
                default: fn (Builder $query) => $query->orderBy('id', 'desc')
            )
            ->withCount(['users'])
            ->fastPaginate($params['size'] ?? 10)
            ->appends($params);

        return sendSuccessData(
            data: new RoleCollection($roles),
            message: 'Roles data retrieve successfully.'

        );
    }

    public function storeRole(array $data): array
    {
        $this->baseQuery->create([
            'name' => $data['name'],
        ]);

        return sendSuccessData(
            message: 'Role has been created successfully.'
        );
    }

    public function getRole(string $roleId): array
    {
        $role = $this->fetchById($roleId)->firstOrFail()->loadCount(['users']);

        return sendSuccessData(
            data: ['role' => new RoleResource($role)],
            message: 'Role data retrieve successfully',
        );
    }

    public function updateRole(array $data, string $roleId): array
    {
        $role = $this->fetchById(id: $roleId)->firstOrFail();

        $role->update([
            'name' => $data['name'],
        ]);

        return sendSuccessData(
            message: 'Role has been updated successfully.'
        );
    }

    public function deleteRole(string $roleId): array
    {
        $role = $this->fetchById(id: $roleId)->firstOrFail();

        $role->delete();

        return sendSuccessData(
            message: 'Role has been deleted successfully.'
        );
    }

    protected function fetchById(string $id): Builder
    {
        return $this->baseQuery
            ->where('id', '!=', 1)
            ->where('id', '=', $id);
    }
}
