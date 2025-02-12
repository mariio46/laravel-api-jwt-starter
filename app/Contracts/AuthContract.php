<?php

namespace App\Contracts;

interface AuthContract
{
    public function register(array $data): array;
}
