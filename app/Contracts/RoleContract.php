<?php

namespace App\Contracts;

interface RoleContract
{
    /**
     * Get all roles
     * 
     * @param ?array{search:string,sort:string,size:string} $params
     * @return array{message:string,data:Spatie\Permission\Models\Role::class}
     */
    public function getRoles(?array $params): array;

    /**
     * Get single role
     * 
     * @param string $roles
     * @return array{message:string,data:Spatie\Permission\Models\Role::class}
     */
    public function getRole(string $roleId): array;
}
