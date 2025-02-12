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
    }

    public function boot(): void
    {
        //
    }
}
