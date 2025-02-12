<?php

namespace App\Repositories;

use App\Contracts\AuthContract;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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

    public function login(array $data): array
    {
        if (!$token = Auth::claims(['email' => $data['email']])->attempt($data)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        return sendSuccessData(
            data: [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => Auth::factory()->getTTL() * 300
            ],
            message: 'Login successfully.'
        );
    }
}
