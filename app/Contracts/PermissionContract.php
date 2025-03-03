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

    /**
     * Create permission
     *
     * @param  array{name:string}  $data
     * @return array{message:string}
     */
    public function storePermission(array $data): array;

    /**
     * Get single permission
     *
     * @param  string  $permissions
     * @return array{message:string,data:Spatie\Permission\Models\Permission::class}
     */
    public function getPermission(string $permissionId): array;

    /**
     * Update permission
     *
     * @param  array{name:string}  $data
     * @return array{message:string}
     */
    public function updatePermission(array $data, string $permissionId): array;

    /**
     * Delete permission
     *
     *
     * @return array{message:string}
     */
    public function deletePermission(string $permissionId): array;
}
