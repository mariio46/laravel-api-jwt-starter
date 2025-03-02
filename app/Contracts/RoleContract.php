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
     * Create role
     *
     * @param  array{name:string}  $data
     * @return array{message:string}
     */
    public function storeRole(array $data): array;

    /**
     * Get single role
     * 
     * @param string $roles
     * @return array{message:string,data:Spatie\Permission\Models\Role::class}
     */
    public function getRole(string $roleId): array;
}
