<?php

namespace App\Repositories;

use App\Contracts\UserContract;
use App\Http\Resources\User\UserCollection;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
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
                callback: fn(Builder $query, string $value) => $query->where('name', 'like', '%' . $value . '%')
            )
            ->when(
                value: $params['role'] ?? null,
                callback: fn(Builder $query, string $value) => $query->whereHas('roles', function ($q) use ($value) {
                    $q->where('name', '=', $value);
                }),
            )
            ->with(['roles:id,name'])
            ->orderBy('id', 'desc')
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

    protected function fetchById(string $id): Builder
    {
        return $this->baseQuery->where('id', '=', $id);
    }
}
