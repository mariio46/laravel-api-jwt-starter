<?php

namespace App\Contracts;

interface UserContract
{
    /**
     * Get all users
     * @param string $currentUserId
     * @param ?array{search:string,role:string} $params
     * @return array{message:string}
     */
    public function getUsers(string $currentUserId, ?array $params): array;

    /**
     * Create User
     * @param array{name:string,email:string,password:string,role:string} $data
     * @return array{message:string}
     */
    public function storeUser(array $data): array;
}
