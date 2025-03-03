<?php

namespace App\Contracts;

interface PermissionContract
{
    /**
     * Get all permissions
     *
     * @param  ?array{search:string,sort:string,size:string}  $params
     * @return array{message:string,data:Spatie\Permission\Models\Permission::class}
     */
    public function getPermissions(?array $params): array;
}
