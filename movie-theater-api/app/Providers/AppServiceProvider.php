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
use App\Repositories\Schedule\ScheduleRepositoryInterface;
use App\Repositories\Schedule\ScheduleRepository;
use App\Repositories\Showtime\ShowtimeRepositoryInterface;
use App\Repositories\Showtime\ShowtimeRepository;
use App\Repositories\Seat\SeatRepositoryInterface;
use App\Repositories\Seat\SeatRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\User\UserRepository;

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

        $this->app->singleton(
            ScheduleRepositoryInterface::class,
            ScheduleRepository::class
        );

        $this->app->singleton(
            ShowtimeRepositoryInterface::class,
            ShowtimeRepository::class
        );

        $this->app->singleton(
            SeatRepositoryInterface::class,
            SeatRepository::class
        );

        $this->app->singleton(
            UserRepositoryInterface::class,
            UserRepository::class
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
