<?php

namespace App\Repositories;

use App\Contracts\AuthContract;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements AuthContract
{
    public function __construct(protected User $user)
    {
        // 
    }

    public function register(array $data): array
    {
        $user = $this->user->query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole('registrant');

        return sendSuccessData(
            data: null,
            message: 'User has been created successfully.',
        );
    }
}
