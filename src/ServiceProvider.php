<?php

namespace VictorFalcon\LaravelTask;

use VictorFalcon\LaravelTask\Console\Commands\IdeHelpCommand;
use VictorFalcon\LaravelTask\Console\Commands\MakeTaskCommand;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    const CONFIG_PATH = __DIR__ . '/../config/laravel-task.php';

    public function boot()
    {
        $this->publishes([
            self::CONFIG_PATH => config_path('laravel-task.php'),
        ], ['config', 'laravel-task']);

        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeTaskCommand::class,
                IdeHelpCommand::class,
            ]);
        }
    }
}
