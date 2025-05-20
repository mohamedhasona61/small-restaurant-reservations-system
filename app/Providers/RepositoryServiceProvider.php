<?php

namespace App\Providers;

use App\Repositories\MenuRepository;
use App\Repositories\TableRepository;
use App\Repositories\PaymentRepository;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\MenuRepositoryInterface;
use App\Repositories\WaitingListRepository;
use App\Interfaces\TableRepositoryInterface;
use App\Repositories\MenuCategoryRepository;
use App\Repositories\ReseravationRepository;
use App\Interfaces\PaymentRepositoryInterface;
use App\Interfaces\ReservationRepositoryInterface;
use App\Interfaces\WaitingListRepositoryInterface;
use App\Interfaces\MenuCategoryRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TableRepositoryInterface::class, TableRepository::class);
        $this->app->bind(MenuCategoryRepositoryInterface::class, MenuCategoryRepository::class);
        $this->app->bind(MenuRepositoryInterface::class, MenuRepository::class);
        $this->app->bind(ReservationRepositoryInterface::class, ReseravationRepository::class);
        $this->app->bind(WaitingListRepositoryInterface::class, WaitingListRepository::class);
        $this->app->bind(PaymentRepositoryInterface::class, PaymentRepository::class);
    }
    public function boot(): void {}
}
