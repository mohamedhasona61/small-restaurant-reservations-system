<?php

namespace App\Providers;

use App\Repositories\MenuRepository;
use App\Repositories\TableRepository;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\MenuRepositoryInterface;
use App\Interfaces\TableRepositoryInterface;
use App\Repositories\MenuCategoryRepository;
use App\Repositories\ReseravationRepository;
use App\Interfaces\ReservationRepositoryInterface;
use App\Interfaces\MenuCategoryRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TableRepositoryInterface::class, TableRepository::class);
        $this->app->bind(MenuCategoryRepositoryInterface::class, MenuCategoryRepository::class);
        $this->app->bind(MenuRepositoryInterface::class, MenuRepository::class);
        $this->app->bind(ReservationRepositoryInterface::class, ReseravationRepository::class);
    }
    public function boot(): void {}
}
