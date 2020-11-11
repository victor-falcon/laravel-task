<?php

namespace VictorFalcon\LaravelTask;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    const CONFIG_PATH = __DIR__ . '/../config/laravel-task.php';

    public function boot()
    {
        $this->publishes([
            self::CONFIG_PATH => config_path('laravel-task.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            self::CONFIG_PATH,
            'laravel-task'
        );

        $this->app->bind('laravel-task', function () {
            return new LaravelTask();
        });
    }
}
