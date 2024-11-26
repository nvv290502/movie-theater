<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Movie\MovieRepositoryInterface;
use App\Repositories\Movie\MovieRepository;
use App\Repositories\Cinema\CinemaRepositoryInterface;
use App\Repositories\Cinema\CinemaRepository;
use App\Repositories\Room\RoomRepositoryInterface;
use App\Repositories\Room\RoomRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );

        $this->app->singleton(
            MovieRepositoryInterface::class,
            MovieRepository::class
        );

        $this->app->singleton(
            CinemaRepositoryInterface::class,
            CinemaRepository::class
        );

        $this->app->singleton(
            RoomRepositoryInterface::class,
            RoomRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
