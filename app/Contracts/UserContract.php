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
}
