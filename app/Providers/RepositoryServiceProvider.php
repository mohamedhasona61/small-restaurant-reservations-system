<?php

namespace App\Providers;

use App\Repositories\TableRepository;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\TableRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            TableRepositoryInterface::class,
            TableRepository::class
        );

    }
    public function boot(): void
    {
        
    }
}
