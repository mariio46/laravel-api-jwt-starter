<?php

namespace App\Repositories;

use App\Contracts\AuthContract;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements AuthContract
{
    public function __construct(protected User $user, protected Builder $baseQuery)
    {
        $this->baseQuery = $this->user;
    }

    public function register(array $data): array
    {
        $this->baseQuery->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return sendSuccessData(
            data: null,
            message: 'User has been created successfully.',
        );
    }
}
