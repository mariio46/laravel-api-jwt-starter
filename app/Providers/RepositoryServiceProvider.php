<?php

namespace App\Providers;

use App\Contracts;
use App\Repositories;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Auth
        $this->app->bind(
            abstract: Contracts\AuthContract::class,
            concrete: Repositories\AuthRepository::class,
        );

        // User
        $this->app->bind(
            abstract: Contracts\UserContract::class,
            concrete: Repositories\UserRepository::class,
        );

        // Role
        $this->app->bind(
            abstract: Contracts\RoleContract::class,
            concrete: Repositories\RoleRepository::class,
        );

        // Permission
        $this->app->bind(
            abstract: Contracts\PermissionContract::class,
            concrete: Repositories\PermissionRepository::class,
        );
    }

    public function boot(): void
    {
        //
    }
}
