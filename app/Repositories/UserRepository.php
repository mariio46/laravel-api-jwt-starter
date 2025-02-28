<?php

namespace App\Repositories;

use App\Contracts\UserContract;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserContract
{
    public function __construct(protected User $user, protected Builder $baseQuery)
    {
        $this->baseQuery = $user->query();
    }

    public function getUsers(string $currentUserId, ?array $params): array
    {
        $users = $this->baseQuery
            ->where('id', '!=', $currentUserId)
            ->when(
                value: $params['search'] ?? null,
                callback: fn (Builder $query, string $value) => $query->where('name', 'like', '%' . $value . '%')
            )
            ->when(
                value: $params['role'] ?? null,
                callback: fn (Builder $query, string $value) => $query->whereHas('roles', function ($q) use ($value) {
                    $q->where('name', '=', $value);
                }),
            )
            ->when(
                value: $params['sort'] ?? null,
                callback: function (Builder $query, string $value) {
                    $operator = str($value)->explode('-');
                    $query->orderBy($operator[0], $operator[1]);
                },
                default: fn (Builder $query) => $query->orderBy('id', 'desc')
            )
            ->with(['roles:id,name'])
            ->fastPaginate(10)
            ->appends($params);

        return sendSuccessData(
            data: new UserCollection($users),
            message: 'Users data retrieve successfully.'
        );
    }

    public function storeUser(array $data): array
    {
        $user = $this->baseQuery->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->markEmailAsVerified();

        $user->assignRole($data['role']);

        return sendSuccessData(
            message: 'User has been created successfully.'
        );
    }

    public function getUser(string $userId): array
    {
        $user = $this->fetchById(id: $userId)->firstOrFail();

        return sendSuccessData(
            data: ['user' => new UserResource($user->load(['roles:id,name']))],
            message: 'User data retrieve successfully.'
        );
    }

    public function updateUser(array $data, string $userId): array
    {
        $user = $this->fetchById(id: $userId)->firstOrFail();

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        $user->syncRoles($data['role']);

        return sendSuccessData(
            message: 'User has been updated successfully.'
        );
    }

    public function deleteUser(string $userId): array
    {
        $user = $this->fetchById(id: $userId)->firstOrFail();

        $temporaryUserName = firstWord(value: $user->name, capitalize: true);

        $user->roles()->detach();
        $user->delete();

        return sendSuccessData(
            message: "User with name {$temporaryUserName} has been deleted successfully."
        );
    }

    protected function fetchById(string $id): Builder
    {
        return $this->baseQuery->where('id', '=', $id);
    }
}
