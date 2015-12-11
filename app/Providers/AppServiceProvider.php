<?php

namespace App\Providers;

use App\Contracts\TaskContract;
use GuzzleHttp\Client as HttpClient;
use App\Repositories\DbTaskRepository;
use Illuminate\Support\ServiceProvider;
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
        // $this->app->bind(TaskContract::class, DbTaskRepository::class);

        // Tasks so Todoist
        $this->app->bind(TaskContract::class, function() {
            return new TodoistTaskRepository(new HttpClient([
                'base_uri' => 'https://todoist.com/API/',
                'query'    => [
                    'token'      => '35c12abec549e42a9dd3931cd218187179075628',
                    'project_id' => '157841409',
                ]
            ]));
        });
    }
}
