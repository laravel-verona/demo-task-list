<?php

namespace App\Providers;

use App\Contracts\TaskContract;
use Illuminate\Support\ServiceProvider;
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
        // Tasks su DB
        $this->app->bind(TaskContract::class, DbTaskRepository::class);

        // Tasks so Todoist
        // $this->app->bind(TaskContract::class, TodoistTaskRepository::class);
    }
}
