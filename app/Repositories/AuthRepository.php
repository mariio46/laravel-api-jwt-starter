<?php

namespace App\Repositories;

use App\Contracts\AuthContract;
use App\Models\User;

class AuthRepository implements AuthContract
{
    public function __construct(protected User $user)
    {
        //
    }

    public function register(array $data): array
    {
        return [];
    }
}
