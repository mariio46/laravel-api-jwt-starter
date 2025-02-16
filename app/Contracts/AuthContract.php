<?php

namespace App\Contracts;

interface AuthContract
{
    /**
     * Register new User
     *
     * @param  array{name:string,email:string,password:string}  $data
     * @return array{message:string}
     */
    public function register(array $data): array;

    /**
     * Login User
     *
     * @param  array{email:string,password:string}  $data
     * @return array{data:array{access_token:string,token_type:string,expires_in:int},message:string}
     */
    public function login(array $data): array;

    /**
     * Refresh Auth User Token
     */
    public function refreshToken(): array;

    /**
     * Logout User
     */
    public function logout(): array;

    /**
     * Update Account Authenticated User
     *
     * @param  array{name:string,email:string}  $data
     * @return array{data:array{user:array{App\Models\User},authorization:array{access_token:string,token_type:string,expires_in:int}},message:string}
     */
    public function updateAccount(string $userId, array $data): array;

    /**
     * Update Password Authenticated User
     *
     * @param  array{new_password:string}  $data
     * @return array{message:string}
     */
    public function updatePassword(string $userId, array $data): array;
}
