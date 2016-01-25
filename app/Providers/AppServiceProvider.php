<?php

namespace App\Providers;

use App\Contracts\UserContract;
use App\Contracts\TaskContract;
use Illuminate\Support\ServiceProvider;
use App\Repositories\DbUserRepository;
use App\Repositories\DbTaskRepository;
use App\Repositories\TodoistTaskRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        require app_path('helpers.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TaskContract::class, DbTaskRepository::class);
        $this->app->bind(UserContract::class, DbUserRepository::class);

        // $this->app->bind(TaskContract::class, TodoistTaskRepository::class);
    }
}
