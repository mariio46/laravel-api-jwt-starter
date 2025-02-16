<?php

namespace App\Repositories;

use App\Contracts\AuthContract;
use App\Http\Resources\Auth\AuthenticatedUserResource;
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

        $token = Auth::tokenById($user->id);

        return sendSuccessData(
            data: $this->getTokenConfig($token),
            message: 'User has been created successfully.',
        );
    }

    public function login(array $data): array
    {
        if (! $token = Auth::attempt($data)) {
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

    public function updateAccount(string $userId, array $data): array
    {
        $user = $this->user->query()->where('id', '=', $userId)->firstOrFail();

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        Auth::invalidate();

        $newToken = Auth::tokenById($user->id);

        return sendSuccessData(
            data: [
                'user' => new AuthenticatedUserResource($user),
                'authorization' => $this->getTokenConfig($newToken)
            ],
            message: 'Your account has been updated successfully.'
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
