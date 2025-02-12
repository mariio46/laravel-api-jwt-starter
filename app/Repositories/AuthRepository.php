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
        if (!$token = Auth::attempt($data)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        return sendSuccessData(
            data: $this->getTokenConfig($token),
            message: 'Login successfully.'
        );
    }

    public function logout(): array
    {
        Auth::logout();

        return sendSuccessData(
            data: null,
            message: 'Logout successfully.'
        );
    }

    public function refreshToken(): array
    {
        $token = Auth::refresh();

        return sendSuccessData(
            data: $this->getTokenConfig($token)
        );
    }

    protected function getTokenConfig(string $token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 300,
        ];
    }
}
