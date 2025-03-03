<?php

namespace App\Contracts;

interface UserContract
{
    /**
     * Get all users
     *
     * @param  ?array{search:string,role:string,sort:string}  $params
     * @return array{message:string,data:App\Http\Resources\User\UserCollection}
     */
    public function getUsers(string $currentUserId, ?array $params): array;

    /**
     * Create User
     *
     * @param  array{name:string,email:string,password:string,role:string}  $data
     * @return array{message:string}
     */
    public function storeUser(array $data): array;

    /**
     * Get single user by id
     *
     * @return array{message:string,data:array{user:App\Http\Resources\User\UserResource}}
     */
    public function getUser(string $userId): array;

    /**
     * Update User
     *
     * @param  array{name:string,email:string,role:string}  $data
     * @return array{message:string}
     */
    public function updateUser(array $data, string $userId): array;

    /**
     * Delete User
     *
     * @return array{message:string}
     */
    public function deleteUser(string $userId): array;

    /**
     * Revoke User Role
     *
     * @return array{message:string}
     */
    public function revokeUserRole(string $userId): array;
}
